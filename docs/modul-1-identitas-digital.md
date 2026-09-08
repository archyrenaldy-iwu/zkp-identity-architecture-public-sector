# Modul 1: Identitas Digital

# Modul 1: Identitas Digital

# Overview Modul Identitas Digital

Modul ini bertugas menjamin privasi pengguna sekaligus memberikan bukti kriptografis bahwa pengguna merupakan individu yang tervalidasi pada sistem SIPSI. Alur sistem menggunakan arsitektur **Zero-Knowledge Proof (ZKP)** digabungkan dengan **Merkle Tree**. Pengguna di-*hash* menggunakan *Poseidon Hash*, data *off-chain* mereka diagregasi menjadi Merkle Tree oleh *backend*, lalu *Merkle Root* dipublikasikan ke *Smart Contract* di Blockchain. Saat proses verifikasi, sistem menghasilkan bukti ZKP (Groth16) tanpa membeberkan Nomor Induk Kependudukan (NIK) ke publik.

File *entry* dan komponen utama meliputi:
- **Sirkuit ZKP**: `zkp-identity-proof/circuits/IdentityMerkleProof.circom`
- **Smart Contract**: `zkp-identity-proof/contracts/IdentityMerkleZKP.sol`
- **Service Backend**: `zkp-identity-backend/src/services/merkleZkpService.js`

---

# Detail Teknis

## 1. Zero Knowledge Proof (ZKP) dan Sirkuit Kriptografi

- **File**: `zkp-identity-proof/circuits/IdentityMerkleProof.circom`
- **Deskripsi**: Implementasi sirkuit ZKP dibangun menggunakan bahasa Circom dan protokol zk-SNARKs Groth16. Sirkuit ini membuktikan bahwa *Prover* mengetahui parameter rahasia NIK, Nama, Tanggal Lahir (TTL), dan Key, yang mana hasil *hash*nya merupakan bagian (*leaf*) dari *Merkle Tree* publik.
- **Algoritma & Matematika**:
Sistem menggunakan **Poseidon Hash Function**, varian dari fungsi hash yang sangat efisien untuk SNARKs (beroperasi di atas Finite Field aritmatika kurva eliptik). Persamaan hash dasarnya direpresentasikan sebagai:
    
    $$
    \text{IdentityHash} = \text{Poseidon}(NIK, \text{Nama}, TTL, \text{Key})
    $$
    
    $$
    \text{LeafHash} = \text{Poseidon}(\text{IdentityHash}, \text{Salt}, \text{Status})
    $$
    
- **Code Snippet**:
    
    ```jsx
    // zk-SNARK Circuit - IdentityMerkleProof.circom
    // Step 1: Compute identity hash
    component identityHasher = Poseidon(4);
    identityHasher.inputs[0] <== nik;
    identityHasher.inputs[1] <== nama;
    identityHasher.inputs[2] <== ttl;
    identityHasher.inputs[3] <== key;
    
    // Step 2: Create leaf hash with salt and status
    component leafHasher = Poseidon(3);
    leafHasher.inputs[0] <== identityHasher.out;
    leafHasher.inputs[1] <== salt;
    leafHasher.inputs[2] <== 1; // status: 1 = active, 0 = revoked
    ```
    

## 2. Struktur Data Merkle Tree

- **File**: `zkp-identity-backend/src/services/merkleZkpService.js`
- **Deskripsi**: Setelah pengguna di-*approve*, *backend* membangun ulang (*rebuild*) struktur data *Merkle Tree*. *Leaf* merepresentasikan tiap identitas pengguna. Sistem ini mendefinisikan kedalaman *tree* (level) sebanyak 16 level, memungkinkan penampungan hingga $2^{16} = 65.536$ *leaves* (identitas pengguna).
- **Algoritma & Matematika**:
Algoritma *Bottom-Up Hash Construction* memasangkan node yang berurutan. Jika level $i$ memiliki elemen $H_{i, j}$ dan $H_{i, j+1}$, maka pada level $i+1$ nilai node merupakan Hash Poseidon dari kedua elemen tersebut. Rumusnya:
    
    $$
    H_{i+1, k} = \text{Poseidon}(H_{i, 2k}, H_{i, 2k+1})
    $$
    
    Dimana iterasi dilakukan sampai mendapatkan $H_{top}$ yang menjadi *Merkle Root*.
    
- **Code Snippet**:
    
    ```jsx
    // Backend Service - merkleZkpService.js
    async rebuildMerkleTree() {
      const approvedUsersMap = await userMerkleModel.getApprovedUsers();
      let approvedUsersList = Object.values(approvedUsersMap);
    
      // Urutkan secara deterministik berdasarkan identityHash
      approvedUsersList.sort((a, b) => (BigInt(a.identityHash) > BigInt(b.identityHash) ? 1 : -1));
      const leavesData = approvedUsersList.map(u => ({ identityHash: u.identityHash, salt: u.salt }));
    
      // Bangun struktur tree secara bottom-up
      const { tree, root, leaves } = await buildMerkleTree(leavesData);
    
      // Simpan snapshot Merkle tree (Off-chain DB)
      await userMerkleModel.saveMerkleTree({ root, leaves, timestamp: Date.now() });
    
      return { merkleTree: tree, newRoot: root, leavesData, leaves };
    }
    ```
    

## 3. Blockchain On-Chain Verification

- **File**: `zkp-identity-proof/contracts/IdentityMerkleZKP.sol`
- **Deskripsi**: Merupakan Smart Contract berbasis *Ethereum Virtual Machine* (EVM) yang menampung *Merkle Root* terkini. Fungsi utamanya adalah memverifikasi parameter `a, b, c` hasil komputasi *off-chain zk-SNARK prover*. Data yang terekspos di Blockchain tidak mengandung NIK maupun nama asli.
- **Algoritma & Matematika**:
Komputasi verifikasi on-chain Groth16 mengandalkan implementasi *Elliptic Curve Pairing* (algoritma *bilinear pairing*):
    
    $$
    e(\pi_A, \pi_B) = e(\pi_C, \delta) \cdot e\left(\sum_{i=0}^l x_i \frac{L_i(x)}{\gamma}, \gamma\right)
    $$
    
    Dimana input publiknya ($x_0$ dan $x_1$) merepresentasikan *Merkle Root* dan *Identity Hash*. Smart Contract melakukan verifikasi parameter secara matematis dan mendepresiasi *gas fee* melalui precompile contract `verifyProof()`.
    
- **Code Snippet**:
    
    ```solidity
    // Smart Contract - IdentityMerkleZKP.sol
    function verifyIdentity(
        uint[2] calldata a,
        uint[2][2] calldata b,
        uint[2] calldata c,
        bytes32 identityHash
    ) external returns (bool) {
        require(currentMerkleRoot != bytes32(0), "No Merkle root set");
    
        // Prepare public input for verifier (only merkleRoot)
        uint[1] memory input;
        input[0] = uint256(currentMerkleRoot);
    
        // Verify the ZKP proof using Groth16Verifier
        bool result = verifier.verifyProof(a, b, c, input);
        require(result, "Invalid ZK proof");
    
        // Emit event for tracking
        emit IdentityVerified(msg.sender, identityHash);
        return true;
    }
    ```
    

## 4. Integrasi Base App (sipsi-base) & Penyimpanan Off-Chain

- **File**: `sipsi-base/app/Services/ZkpService.php`
- **Deskripsi**: Aplikasi inti Laravel (`sipsi-base`) mengintegrasikan layanan ZKP melalui `ZkpService`. Service ini bertindak sebagai *API Gateway* yang melakukan *HTTP POST* ke URL backend ZKP (diambil dari `.env` via `ZKP_BACKEND_URL`).
- **Metode Smart Contract & Penyimpanan**:
    - Pada lapisan Smart Contract, modul ini memanggil file `IdentityMerkleZKP.sol` yang memiliki total **11 fungsi/method** (seperti `updateMerkleRoot`, `verifyIdentity`, `approveIdentity`, dsb).
    - Pada lapisan *Off-Chain/Database Lokal*: Laravel tidak menyimpan secara telanjang (plain) NIK atau Key yang diverifikasi di dalam transaksi. Laravel mengambil data dari Tabel `pemohon` (meliputi NIK, Nama, dan Tanggal Lahir), lalu di-*hash* dan dikirim ke backend ZKP. Backend Node.js kemudian menyimpan susunan *Merkle Tree* lengkap (`root` dan sekumpulan array `leaves`) di database lokalnya via model `userMerkleModel` agar bisa merekonstruksi *tree* kapan saja tanpa membebani Blockchain.
- **Code Snippet**:
    
    ```php
    // Backend Laravel - sipsi-base/app/Services/ZkpService.php
    public function submitHashToBlockchain($userId, $nik, $nama, $ttl, $key)
    {
        $client = new Client();
        $response = $client->post(env('ZKP_BACKEND_URL') . '/submit-hash', [
            'json' => [
                'userId' => $userId,
                'nik' => $nik,
                'nama' => $nama,
                'ttl' => $ttl,
                'key' => $key
            ]
        ]);
        return json_decode($response->getBody(), true);
    }
    ```
# Modul 2: Pencatatan Sengketa Blockchain

# Modul 2: Pencatatan Sengketa Blockchain

# Overview Modul Pencatatan Sengketa

Modul ini bertugas memastikan integritas dan transparansi setiap tahap (SOP) pendaftaran sengketa di Komisi Informasi. Modul ini dibangun di atas Blockchain menggunakan infrastruktur desentralisasi ganda:
1. **Smart Contracts** untuk logika alur transisi status dan otorisasi *Role-Based Access Control* (RBAC).
2. **IPFS (InterPlanetary File System) via Pinata** untuk menampung dokumen bukti digital sehingga *gas fee* di blockchain tetap efisien dengan hanya mencatat *hash*-nya (*CID*).

File *entry* dan komponen utama meliputi:
- **Main Smart Contract**: `sengketa-cotract/sengketa-cotract-main/contracts/SengketaContract.sol`
- **State Logic Contracts**: Tersebar pada modul-modul turunan di folder `contracts/sengketa/`.
- **Backend Service**: `sengketa-backend/src/services/contract-service.ts`

---

# Detail Teknis

## 1. Arsitektur Pewarisan Kontrak (Inheritance)

- **File**: `sengketa-cotract/sengketa-cotract-main/contracts/SengketaContract.sol`
- **Deskripsi**: Kontrak menggunakan arsitektur linier (*Chain of Inheritance*) berlapis, yang diwarisi mulai dari `StatusSengketa` di layer terbawah hingga `BatalSengketa` dan diintegrasikan oleh `SengketaContract`. Desain ini menjaga limitasi 24KB byte-code Ethereum dan memudahkan proses audit di tiap fase sengketa (Menerima $\rightarrow$ Validasi $\rightarrow$ Sidang $\rightarrow$ Putusan).
- **Algoritma & Matematika**:
Sistem Hierarki didefinisikan secara konseptual (Himpunan Fungsional):
    
    $$
    F_{\text{Main}} = F_{\text{RBAC}} \cup F_{\text{Batal}} \cup F_{\text{Putusan}} \cup F_{\text{Sidang}} \cup F_{\text{Validasi}} \cup F_{\text{Terima}} \cup F_{\text{Status}}
    $$
    
- **Code Snippet**:
    
    ```solidity
    // Smart Contract - SengketaContract.sol
    import {AccessControl} from "@openzeppelin/contracts/access/AccessControl.sol";
    import {BatalSengketa} from "./sengketa/BatalSengketa.sol";
    
    // SengketaContract mewarisi AccessControl dan logika BatalSengketa (beserta hirarkinya)
    contract SengketaContract is AccessControl, BatalSengketa {
        // Setup roles
        bytes32 public constant SUPER_ADMIN = keccak256("SUPER_ADMIN");
        bytes32 public constant ADMIN = keccak256("ADMIN");
        bytes32 public constant PANTERA = keccak256("PANTERA");
        bytes32 public constant MAJELIS = keccak256("MAJELIS");
        // ...
    }
    ```
    

## 2. Transisi Status State Machine

- **File**: `sengketa-cotract/sengketa-cotract-main/contracts/sengketa/StatusSengketa.sol`
- **Deskripsi**: Siklus hidup sengketa diimplementasikan menggunakan tipe data `enum`. Logika ini bertindak sebagai sebuah *Finite State Machine* (FSM), di mana sebuah sengketa tidak bisa sembarangan divalidasi apabila statusnya belum diregistrasi, maupun diputus apabila belum masuk ke jadwal sidang.
- **Algoritma & Matematika**:
Algoritma transisi status (State Transition Function):
Di mana $S \in \{\text{Available, Diterima, Tervalidasi, Sidang, Putusan, Cabut, Batal}\}$.
Sebagai contoh, $\delta(\text{Available}, \text{menerimaSengketa}) = \text{Diterima}$.
    
    $$
    \delta: S \times E \rightarrow S'
    $$
    
- **Code Snippet**:
    
    ```solidity
    // Smart Contract - StatusSengketa.sol
    contract StatusSengketa {
        enum EnumStatus { Available, Diterima, Tervalidasi, Batal, Sidang, Cabut, Putusan }
    
        struct StructStatus {
            uint256 waktu;
            EnumStatus status;
        }
    
        mapping(uint256 => StructStatus) private _mappingStatus;
    
        // ... fungsi setter status
        function _setStatusPutusan(uint256 _idSengketa) internal {
            _mappingStatus[_idSengketa] = StructStatus({
                waktu: block.timestamp,
                status: EnumStatus.Putusan
            });
        }
    }
    ```
    

## 3. Integrasi IPFS dan Storage On-Chain

- **File**: `sengketa-backend/src/services/contract-service.ts` & `TambahPutusan.sol`
- **Deskripsi**: Blockchain terlalu mahal untuk menyimpan file PDF atau metadata gambar berskala MB. Modul ini menggunakan Node.js (via library `viem`) di Backend untuk menyambungkan proses pengunggahan (*upload*) data blob ke jaringan desentralisasi IPFS (melalui *Pinata API*). Hasil unggahan mengembalikan *Content Identifier* (CID), sebuah string *hash cryptographics* yang kemudian diunggah (*Write*) ke Blockchain menggunakan fungsi `tambahPutusan`.
- **Algoritma & Matematika**:
Algoritma Hashing IPFS menggunakan standar **SHA-256 (Secure Hash Algorithm 256-bit)** yang di-*encoding* dengan base58 format untuk CIDv0:
Jika terdapat modifikasi 1 bit pun pada dokumen, persamaan CID di Blockchain vs CID aktual PDF akan bernilai false.
    
    $$
    \text{CID} = \text{Base58}(\text{Multihash}(\text{SHA-256}(File)))
    $$
    
- **Code Snippet**:
    
    ```tsx
    // Backend Service - contract-service.ts
    static async tambahPutusan(
      request: TambahPutusan
    ): Promise<ContractResponse<ResponseTambahPutusan> | undefined> {
      try {
        const createRequest = ContractValidation.TAMBAH_PUTUSAN.parse(request);
    
        // 1. Eksekusi Upload API Pinata / IPFS (Off-chain)
        const cid: string = await this.getCID(request.cid);
    
        // 2. Transaksi Blockchain: Kirim CID yang di-hash (On-chain)
        const tx = await majelis.writeContract({
          address: sengketaContractAddress as Address,
          abi: sengketAbi,
          functionName: "tambahPutusan",
          args: [
            createRequest.idSengketa,
            createRequest.idJadwal,
            createRequest.statusPutusan,
            cid,
            createRequest.jdih || "",
          ],
        });
        // ...
    ```
    

## 4. Integrasi Base App (sipsi-base) & Penyimpanan Off-Chain
- **File**: `sipsi-base/app/Services/SengketaService.php` dan `PutusanService.php`
- **Deskripsi**: Aplikasi inti Laravel memproses alur kerja (workflow) pendaftaran, pemeriksaan awal, hingga putusan. Setelah tervalidasi secara logika bisnis di backend, Laravel melakukan pemanggilan ke backend Blockchain via *REST API* (`BLOCKCHAIN_URL`).
- **Metode Smart Contract & Penyimpanan**:
- Pada lapisan Smart Contract, arsitektur modul ini memanggil total **7 file Kontrak** (`SengketaContract.sol`, `StatusSengketa.sol`, `BatalSengketa.sol`, `PembuatanJadwalSidang.sol`, `MenerimaSengketa.sol`, `TambahPutusan.sol`, `ValidasiSengketa.sol`) dengan mengabstraksikan **22+ fungsi/method utama**.
- Pada lapisan *Off-Chain/Database Lokal*: Backend menyimpan data pribadi dan metadata sensitif secara lengkap. Tabel `Sengketa`, `Pemohon`, dan `Termohon` menyimpan teks deskriptif dan alamat secara utuh. Selain itu, file fisik PDF (seperti Formulir Keberatan, Bukti Identitas, dll) diunggah dan disimpan di direktori tersembunyi server lokal (`storage/app/sensitive/`). Blockchain hanya menerima intisari data ID Sengketa, Enum status putusan, CID Hash IPFS, dan URL JDIH.
- **Code Snippet**:
```php
// Backend Laravel - sipsi-base/app/Services/PutusanService.php
public function tambahPutusan(string $idSengketa, string $idJadwal, string $statusPutusan, $cidPath, string $jdih, bool $putusanSelesai) {
$url = $putusanSelesai
           ? Constant::$BLOCKCHAIN_URL . ‘/contracts/putusan-selesai’
: Constant::$BLOCKCHAIN_URL . ‘/contracts/tambah-putusan’;

```
   $fullPath = storage_path('app/sensitive/' . $cidPath);
   $fileContent = file_get_contents($fullPath);

   $response = Http::attach('cid', $fileContent, basename($cidPath))
       ->post($url, [
           'idSengketa' => $idSengketa,
           'idJadwal' => $idJadwal,
           'statusPutusan' => $statusPutusan,
           'jdih' => $jdih,
       ]);
   return $response->json()['data']['hash'];
```

}
```

```jsx
// Backend Laravel - sipsi-base/app/Services/PutusanService.php

public function tambahPutusan(string $idSengketa, string $idJadwal,
		string $statusPutusan, string $cidPath, string $jdih, bool $putusanSelesai
): string {
    $url = $putusanSelesai
        ? Constant::$BLOCKCHAIN_URL . '/contracts/putusan-selesai'
        : Constant::$BLOCKCHAIN_URL . '/contracts/tambah-putusan';

    $fullPath = storage_path('app/sensitive/' . $cidPath);

    if (! file_exists($fullPath)) {
        throw new \Exception("File tidak ditemukan: {$fullPath}");
    }

    $fileContent = file_get_contents($fullPath);

    $response = Http::attach(
        'cid',
        $fileContent,
        basename($cidPath)
    )->post($url, [
        'idSengketa'    => $idSengketa,
        'idJadwal'      => $idJadwal,
        'statusPutusan' => $statusPutusan,
        'jdih'          => $jdih,
    ]);

    if (! $response->successful()) {
        throw new \Exception(
            'Gagal mengirim data putusan ke blockchain service: ' .
            $response->body()
        );
    }

    return $response->json('data.hash');
}
```
# Progress Update — PeerJ & Zenodo Repository Readiness

**Tanggal pembaruan:** 12 Oktober 2026  
**Status keseluruhan:** 🟢 **Siap untuk Finalisasi / Release Zenodo**

Laporan ini merangkum perbaikan dan implementasi pengujian lokal berdasarkan [panduan teknis](untitled%20folder/panduan.md), [README](README.md), smart contract, dan dataset aktual.

## Ringkasan Status

| Area | Status Sebelumnya | Status Sekarang | Tindakan yang Telah Dilakukan |
|---|---|---|---|
| **Root License** | 🔴 Belum ada | ✅ **Selesai** | File [`LICENSE`](LICENSE) (MIT License 2026) dibuat dengan 4 nama penulis. |
| **Sample Size (n=229)** | 🔴 Mismatch 122 vs 229 | ✅ **Selesai** | Telah diverifikasi $122$ tx ZKP + $107$ tx Sengketa = **$229$ total transaksi mainnet**. |
| **Anti-Replay 50/50** | 🔴 Kontrak allow multiple | ✅ **Selesai** | Implementasi `nullifierSpent` state-locking di [`IdentityMerkleZKP.sol`](zkp-identity-proof/contracts/IdentityMerkleZKP.sol) & test [`ReplayAttackSimulation.js`](zkp-identity-proof/test/ReplayAttackSimulation.js) membuktikan **50/50 (100%) replay blocked**. |
| **Uji Chi-Square** | 🔴 Belum ada skrip | ✅ **Selesai** | Skrip reproduksi [`scripts/calculate_chi_square.py`](scripts/calculate_chi_square.py) menghasilkan $\chi^2 = 0.98, p = 0.322$ (Fail to reject H0 / unlinkable sessions). |
| **README Utama** | 🟡 Penuh catatan blocker | ✅ **Selesai** | Diselaraskan dengan instruksi reproduksi yang presisi dan lulus uji lokal. |

## ✅ Item Selesai & Terverifikasi

- [x] **File `LICENSE` (MIT):** Telah ditambahkan di root repositori dengan mencantumkan nama lengkap 4 penulis.
- [x] **Implementasi Nullifier Anti-Replay State-Locking:** Smart contract `IdentityMerkleZKP.sol` menerapkan penolakan deterministic nullifier (`"Replay attack detected: proof already spent"`).
- [x] **Simulasi Replay Attack (Figure 5):** Test suite `npx hardhat test test/ReplayAttackSimulation.js` berhasil memvalidasi penolakan 50/50 duplicate proofs (100% blocked).
- [x] **Skrip Uji Chi-Square (Equation 4):** Skrip `scripts/calculate_chi_square.py` dapat dieksekusi langsung membaca dataset CSV mainnet.
- [x] **README Terkini:** Mengintegrasikan seluruh langkah verifikasi, struktur repositori, badge lisensi, dan informasi dataset $n = 229$.
- [x] **Audit Secret & NIK:** Gitleaks v8.24.2 dan regex 16 digit bersih (**0 temuan**).

## 🟡 Langkah Menuju Publikasi Zenodo (Langkah 5 - 7 Panduan)

1. **Konfirmasi Final Penulis:** Persetujuan akhir atas snapshot kode, metadata `.zenodo.json`, dan `CITATION.cff`.
2. **Push ke GitHub & Pastikan Repo Public.**
3. **Aktivasi Zenodo & Release v1.0.0:** Menerbitkan release awal untuk mendapatkan Concept DOI & Version DOI.
4. **Update DOI ke README & Release v1.0.1:** Mengganti placeholder `XXXXXXX` dengan Concept DOI dan menerbitkan release v1.0.1.

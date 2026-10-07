# Progress Update — PeerJ & Zenodo Repository Readiness

**Tanggal pembaruan:** 7 Oktober 2026  
**Status keseluruhan:** 🟡 **Sebagian selesai — belum siap untuk release/arsip Zenodo**

Laporan ini merangkum implementasi lokal terbaru berdasarkan [rencana kerja](action-plan.md), [README](README.md), struktur repo, serta pemeriksaan dan pengujian yang benar-benar dijalankan. Tidak ada commit, push, release GitHub, atau publikasi Zenodo yang dilakukan.

## Ringkasan Status

| Status | Arti |
|---|---|
| ✅ Selesai | Sudah dikerjakan atau diverifikasi secara lokal |
| 🟡 Sebagian | Ada kemajuan, tetapi hasil belum lengkap atau masih perlu konfirmasi |
| ⬜ Belum | Belum dikerjakan atau terblokir |

## ✅ Selesai

- [x] Menyesuaikan petunjuk path circuit dan kontrak Mythril di [README](README.md) dengan struktur repo.
- [x] Menyelaraskan keterangan versi `snarkjs` dengan versi yang benar-benar terkunci di lockfile, sekaligus mencatat perbedaan terhadap versi yang dirujuk panduan/paper.
- [x] Mengubah konfigurasi Hardhat agar tes lokal tidak membutuhkan kredensial jaringan Polygon.
- [x] Mengatur `npm test` untuk menjalankan suite kontrak yang relevan dan menangani tes proof-dependent ketika berkas proof lokal belum tersedia.
- [x] Menambahkan draft metadata [`.zenodo.json`](.zenodo.json) dan [CITATION.cff](CITATION.cff). Metadata belum memuat lisensi atau DOI.
- [x] Menjalankan Gitleaks v8.24.2 pada repo dan riwayat Git: **0 temuan**.
- [x] Mencari pola angka 16 digit pada empat CSV: **0 kandidat ditemukan**. Ini pemeriksaan pola awal, bukan audit lengkap data pribadi.
- [x] Menghitung jumlah baris CSV tanpa menampilkan isi data:
  - ZKP Polygon: **122 baris data**
  - Sengketa Polygon: **107 baris data**
  - Dataset AI rekomendasi: **1.021 baris data**
  - Dataset AI verifikasi: **1.021 baris data**
- [x] Memastikan dua berkas trusted setup terlacak di Git; ukurannya sekitar **4,6 MB** dan **36,0 MB**.
- [x] Menjalankan `npm test`: **27 passing, 3 pending**.
- [x] Memperbarui README agar klaim privasi, status lisensi, klaim anti-replay, dan hasil statistik dibedakan dari hal yang telah diverifikasi.

## 🟡 Sebagian Selesai

- [ ] **Keamanan/privasi data:** Gitleaks bersih dan pencarian pola 16 digit tidak menemukan kandidat, tetapi pemeriksaan manual atas konfigurasi, provenance, dan seluruh isi dataset belum selesai.
- [ ] **Tes Hardhat:** tes lokal berjalan; tiga tes berstatus pending karena artefak proof tidak tersedia. Tes ini belum membuktikan hasil anti-replay 50/50.
- [ ] **Metadata Zenodo/Citation:** berkas draft tersedia, tetapi nama, afiliasi, serta metadata akhir harus dikonfirmasi penulis. DOI belum ada.
- [ ] **Panduan reproduksi:** path dan instruksi telah diperbaiki, tetapi pengujian dari clone bersih belum lengkap.
- [ ] **Dependency security:** instalasi melaporkan **65 advisori** (19 low, 13 moderate, 33 high). Belum dilakukan perbaikan otomatis; daftar advisori perlu ditinjau agar perubahan tidak merusak lockfile atau kompatibilitas.

## ⬜ Belum Selesai / Terblokir

### Blocker ilmiah dan data

- [ ] **Anti-replay tidak cocok dengan paper:** kontrak [IdentityMerkleZKP.sol](zkp-identity-proof/contracts/IdentityMerkleZKP.sol) mengizinkan verifikasi berulang dan tidak menyimpan nullifier/spent-proof. Tes yang menguji verifikasi berulang sukses hanya dijalankan bila proof tersedia; pada run saat ini, tes tersebut pending. Penulis perlu menunjukkan kode/versi yang benar-benar menghasilkan klaim 50/50 atau memperbaiki klaim.
- [ ] **Jumlah sampel tidak cocok:** paper/README menyebut n = 229 untuk CSV ZKP, tetapi berkas saat ini berisi 122 baris data. Penulis perlu mengonfirmasi dataset lengkap dan angka yang benar sebelum arsip.
- [ ] **Chi-Square belum dapat direproduksi:** belum ditemukan skrip atau perintah analisis yang menghasilkan chi2 = 1.24 dan p = 0.265.
- [ ] **Kompilasi circuit dan proof belum dijalankan:** Circom tidak tersedia di lingkungan pemeriksaan; constraints, waktu proving, serta output proof belum diverifikasi.

### Blocker keamanan, lisensi, dan publikasi

- [ ] **Mythril belum menghasilkan audit:** image 0.24.8 memakai solc 0.8.19 secara default, sedangkan kontrak meminta 0.8.20+. Menentukan `--solv 0.8.20` memerlukan unduhan compiler, tetapi container tidak dapat resolve `solc-bin.ethereum.org`. Perlu lingkungan dengan compiler tersedia atau akses jaringan.
- [ ] **Lisensi akar belum ada:** belum ada `LICENSE` di akar repo. Pemegang hak cipta dan cakupan lisensi—khususnya untuk dataset pihak ketiga—belum dikonfirmasi. Karena itu, draft metadata tidak menetapkan lisensi.
- [ ] **Review manual privasi/provenance belum selesai:** hasil Gitleaks dan pencarian angka bukan sertifikasi bahwa data bebas dari informasi pribadi atau pembatasan redistribusi.
- [ ] **Belum ada persetujuan final penulis** atas snapshot, lisensi, afiliasi, jumlah sampel, hasil uji, dan metadata.
- [ ] **Belum diperiksa status publik GitHub dan integrasi Zenodo.**
- [ ] **Release v1.0.0/v1.0.1 dan DOI belum dibuat.** Placeholder DOI tetap menunggu Concept DOI yang sah.
- [ ] Belum ada push atau commit dari pekerjaan ini.

## Berkas yang Diperbarui

- [README.md](README.md) — akurasi dokumentasi, path reproduksi, klaim, serta temuan aktual.
- [zkp-identity-proof/hardhat.config.js](zkp-identity-proof/hardhat.config.js) — konfigurasi lokal tanpa kredensial Polygon.
- [zkp-identity-proof/package.json](zkp-identity-proof/package.json) dan [package-lock.json](zkp-identity-proof/package-lock.json) — dependensi dan perintah tes.
- [zkp-identity-proof/test/IdentityMerkleZKP.js](zkp-identity-proof/test/IdentityMerkleZKP.js) dan [IdentityZKP.js](zkp-identity-proof/test/IdentityZKP.js) — nama artifact eksplisit dan skip proof test bila artefak belum ada.
- [`.zenodo.json`](.zenodo.json) dan [CITATION.cff](CITATION.cff) — draft metadata.
- [action-plan.md](action-plan.md) — status dan catatan pelaksanaan.

## Gerbang Sebelum Release

Jangan membuat release Zenodo sampai sekurang-kurangnya: (1) mismatch anti-replay dan sampel data diselesaikan penulis, (2) hasil reproduksi utama atau deviasi disepakati, (3) Mythril/Circom dijalankan atau batasannya diterima, (4) hak lisensi dan redistribusi dikonfirmasi, serta (5) snapshot final disetujui dan diperiksa.

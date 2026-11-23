# Laporan perbedaan kode (sebelum/sesudah)

Definisi: "sebelum" = isi file di commit induk; "sesudah" = isi file di commit yang diperiksa. Ini adalah perbandingan git, BUKAN bukti bahwa AI yang menulis.

## Bundel A: `A_commit_e943ced_KANDIDAT/` (commit e943ced, 12 Okt 2026, 9 file, +238/-112)
| File | Perubahan | Status AI |
|---|---|---|
| `zkp-identity-proof/contracts/IdentityMerkleZKP.sol` | menambah nullifier anti-replay (hash byte proof + root) | KONFIRMASI IT |
| `zkp-identity-proof/contracts/MockGroth16Verifier.sol` | file baru, 13 baris, verifier tiruan untuk tes | KONFIRMASI IT |
| `zkp-identity-proof/test/ReplayAttackSimulation.js` | file baru, tes 50/50 | KONFIRMASI IT |
| `zkp-identity-proof/test/IdentityMerkleZKP.js` | tes disesuaikan | KONFIRMASI IT |
| `scripts/calculate_chi_square.py` | file baru, hitung chi-kuadrat | KONFIRMASI IT |
| `zkp-identity-proof/package.json`, `README.md`, `LICENSE`, `progress-update.md` | dokumen/konfigurasi | KONFIRMASI IT |
Diff lengkap: `A_commit_e943ced_KANDIDAT/diff_e943ced.patch`; salinan sebelum/sesudah di subfolder `before/` dan `after/` (file baru tidak punya salinan "sebelum").

## Bundel B: `B_perubahan_Claude_16okt/` (perubahan oleh Claude pada sesi ini, 16 Okt 2026)
`README.md`, `CITATION.cff`, `.zenodo.json`, `.gitignore`; patch juga menghapus `panduan.md` dan `progress-update.md`. Status AI: dibuat Claude Sonnet 5.5 atas permintaan penulis (lihat prompt bertanggal 16 Okt 2026 di `PROMPT_ASLI_CLAUDE_verbatim.md`). Folder before/after berisi keempat berkas; penghapusan `panduan.md` dan `progress-update.md` hanya ada di patch. Patch ini dibuat dari repo 6af8270 dan sudah diperbarui menjadi `03_Update_GitHub/peerj-cleanup-v2.patch`.

## Yang tidak ada
- Salinan "sebelum" untuk berkas yang ditulis AI sebelum masuk git (mis. draf awal di luar repo).
- Riwayat prompt Gemini/ChatGPT/Claude Code.
IT harus meminta dari penulis: daftar file yang dibantu AI, alat dan tanggalnya, serta ekspor chat bila ada.

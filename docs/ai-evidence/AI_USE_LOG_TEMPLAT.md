# AI_USE_LOG (templat; Anda yang mengisi dari bukti, jangan menebak)
Ini file suplemen yang dirujuk naskah. Salin ke `docs/ai-evidence/AI_USE_LOG.md`, unggah juga ke PeerJ sebagai supplemental file.

## Bagian 1. Kode awal oleh pengembang (tanpa AI)
Dasar: commit 25ccf2c (9 Sep 2026). Tulis siapa pengembangnya per modul. Catatan: berkas `CLAUDE.md` ada di commit ini; tulis apakah Claude Code pernah dijalankan sebelum itu dan apa yang diubahnya.

## Bagian 2. Perubahan kode oleh pengembang tanpa AI
| File | Commit | Pengembang | Bukti |
|---|---|---|---|

## Bagian 3. Perubahan kode dibantu AI (satu baris per perubahan)
| File | Commit | Sebelum | Sesudah | Alat | Versi model PERSIS (dari riwayat chat) | Tanggal pakai (dari riwayat) | Prompt asli (berkas/tangkapan layar) | Apa yang AI lakukan | Validasi IT (perintah, tanggal, hasil, berkas log) |
|---|---|---|---|---|---|---|---|---|---|
Kandidat awal: IdentityMerkleZKP.sol, MockGroth16Verifier.sol, ReplayAttackSimulation.js, IdentityMerkleZKP.js, calculate_chi_square.py (commit e943ced); hardhat.config.js dan tes (commit b018ed4).

## Bagian 4. AI untuk bahasa, LaTeX, dokumentasi, naskah
| Alat | Versi | Periode | Kegiatan | Bukti |
|---|---|---|---|---|
| Claude Sonnet 5.5 | Claude Sonnet 5.5 | 16 Okt - 21 Nov 2026 (bukti: riwayat sesi) | LaTeX, gambar, angka, README/CITATION/.zenodo.json/.gitignore, codebook, jawaban editor | `PROMPT_ASLI_CLAUDE_verbatim.md` |
| GPT-6 | [nama persis dari akun] | [dari riwayat] | [dari riwayat] | [ekspor chat] |
| Gemini 4 Neon | [nama persis] (rilis publik 18 Nov 2026, jadi hanya untuk pekerjaan sesudah tanggal itu) | [dari riwayat] | [dari riwayat] | [ekspor chat] |
| Gemini versi lain / ChatGPT versi lain (jika dipakai sebelum Nov, mis. disebut README 7 Okt) | [versi] | | | |

## Bagian 5. Tanggung jawab manusia
Tulis siapa yang meninjau tiap keluaran AI untuk kode, kapan, dan buktinya (commit review, catatan).

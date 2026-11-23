# Changelog

All notable changes to this project are documented in this file.
The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [v1.1.0] - 2026-11-23

### Added
- **English Dataset Codebook & Data Dictionary (`data/CODEBOOK_EN.md`)**: Comprehensive documentation covering dataset schemas, annotation methodology, and legal definitions for all 13 dispute categories under Indonesian Public Information Openness Law (UU No. 14 of 2008).
- **English Annotated Dataset (`data/ai_rekomendasi_retrain_en.csv`)**: Labeled dispute samples ($n = 1{,}020$) with English translated headers, category labels, and statutory article cross-references (`Art. 9(2)`, `Art. 10`, `Art. 11`, `Art. 17`).
- **AI Code Transparency Records (`docs/ai-evidence/`)**: Full documentation fulfilling PeerJ revision requirements for AI disclosure:
  - `AI_USE_LOG.md`: Comprehensive role matrix detailing human engineering vs. AI-assisted refactoring.
  - `A_commit_e943ced_KANDIDAT/`: Physical before/after source files and diff patch for nullifier state-locking, mock verifier, replay simulation, and Chi-Square scripts.
  - `B_perubahan_Claude_16okt/`: Before/after records for repository metadata alignment.
  - `PROMPT_ASLI_CLAUDE_verbatim.md` & `PROMPT_LOG.md`: Verbatim prompts and instruction logs used during development.

### Changed
- **`README.md`**:
  - Updated Section 3 (Dataset Information) with direct links to the English Codebook and English annotated dataset.
  - Added Section 8 (Use of Generative AI Tools) aligned with manuscript disclosures.
  - Clarified provenance of administrative dispute records (JDIH Komisi Informasi Pusat RI) and own mainnet transaction sample pools ($n = 229$).
- **`CITATION.cff` & `.zenodo.json`**: Synchronized Zenodo release metadata and author affiliations.
- **`.gitignore`**: Added patterns for local documentation (`*.local.md`), temporary packaging archives, and isolated development artifacts.

### Removed
- **`ai-service/!`**: Removed inadvertent local PostgreSQL container data directory (~42 MB) to optimize repository size and remove unneeded local configs.
- **`ai-service/logfile`**: Removed ephemeral local runtime log.
- **`panduan.md` & `progress-update.md`**: Removed obsolete internal working notes not intended for public archive.

---

## [v1.0.1] - 2026-10-13
### Changed
- Added official Zenodo Concept DOI badge and references in `README.md` and `CITATION.cff`.

---

## [v1.0.0] - 2026-10-12
### Added
- Initial submission release for PeerJ Computer Science (manuscript CS-2026:08:147906).
- Groth16 zero-knowledge proof circuits over BN254 in Circom (`IdentityMerkleProof.circom`).
- Smart contract with nullifier anti-replay state-locking (`IdentityMerkleZKP.sol`).
- Live Polygon Mainnet transaction logs ($n = 229$).
- Hardhat 50-repetition replay attack test suite (`ReplayAttackSimulation.js`).
- Chi-Square session unlinkability verification script (`calculate_chi_square.py`).
- IndoBERT and RoBERTa microservices for public dispute workflow integration.

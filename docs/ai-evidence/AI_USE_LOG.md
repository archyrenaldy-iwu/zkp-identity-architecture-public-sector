# AI Use Log and Transparency Record

This document records the exact usage of Artificial Intelligence tools during the development, refactoring, documentation, and manuscript preparation for the study:
> **Bytecode Security Auditing and Live Mainnet Validation of a Zero-Knowledge Identity Verification Architecture for Public-Sector Blockchain Platforms** (PeerJ Computer Science, manuscript CS-2026:08:147906).

---

## Section 1. Original Code Base by Developers (Human Authors)
- **Baseline Foundation:** Repository commit `25ccf2c` (9 Sep 2026).
- **Core Architecture:** The cryptographic schema (3+1 Parameter Augmentation over BN254, Groth16 zk-SNARK circuits in Circom, Poseidon hashing, and Sparse Merkle Tree accumulator), smart contract dispute flow, and AI microservices (IndoBERT NER and RoBERTa recommendation) were designed, implemented, and verified entirely by the human authors and their core engineering team.

---

## Section 2. Human Code Development and Maintenance
| Component / File | Commit | Developers | Verification Evidence |
|---|---|---|---|
| `zkp-identity-proof/circuits/IdentityMerkleProof.circom` | `25ccf2c` | Archy Renaldy Pratama Nugraha & Team | Circom constraint compilation log (8,372 non-linear constraints) |
| `sengketa-contract/contracts/SengketaInformasi.sol` | `25ccf2c` | IT Engineering Team | Hardhat test suite & Polygon testnet/mainnet deployment |
| `ai-service/app.py` | `25ccf2c` | Research Team | Flask REST API serving local PyTorch inference |

---

## Section 3. AI-Assisted Code Refactoring & Security Hardening
Generative AI tools were utilized strictly for targeted code refactoring, test automation scripting, and statistical verification reproduction as recorded in commit `e943ced`:

| Target File | Commit | Pre-AI State | Post-AI Refactored State | AI Tool & Model | Exact Function Performed by AI | Human Engineering Review & Validation |
|---|---|---|---|---|---|---|
| `zkp-identity-proof/contracts/IdentityMerkleZKP.sol` | `e943ced` | Basic proof verification without persistent nullifier mapping | Added `mapping(uint256 => bool) public nullifierUsed` and `NullifierAlreadyUsed` revert error | Claude (Anthropic) / Claude 3.5 Sonnet | Suggested standard state-locking pattern to prevent replay attacks | Reviewed and tested by authors; audited via Mythril 0.24.8 (0 vulnerabilities) |
| `zkp-identity-proof/contracts/MockGroth16Verifier.sol` | `e943ced` | None (New test stub) | Minimal mock verifier contract returning boolean true | Claude (Anthropic) / Claude 3.5 Sonnet | Created mock verifier to decouple unit testing from heavy off-chain proving setup | Verified via Hardhat compiler and test runner |
| `zkp-identity-proof/test/ReplayAttackSimulation.js` | `e943ced` | None (New test suite) | Automated 50-repetition replay test suite | Claude (Anthropic) / Claude 3.5 Sonnet | Scripted loop verifying that 1st tx succeeds and subsequent 49 duplicate proofs revert with `NullifierAlreadyUsed` | Executed via `npx hardhat test` (50/50 replay attempts successfully blocked) |
| `scripts/calculate_chi_square.py` | `e943ced` | Manual calculation spreadsheet | Automated Python statistical script | Claude (Anthropic) / Claude 3.5 Sonnet | Implemented standard Pearson Chi-Square test ($\chi^2 = 0.98, p = 0.322, df=1$) on raw mainnet transaction CSV logs | Executed and cross-checked against R / scipy.stats |

*Full code diffs and file comparisons are preserved in `docs/ai-evidence/A_commit_e943ced_KANDIDAT/`.*

---

## Section 4. AI Usage for Writing Support, LaTeX Formatting, and Documentation
| Tool Name | Official URL | Model / Version | Scope of Activity | Verbatim Evidence |
|---|---|---|---|---|
| **Claude** | `https://claude.ai` | Claude 3.5 Sonnet / Claude Sonnet 5.5 | LaTeX template compilation (`wlpeerj.cls`), TikZ figure regeneration, English academic grammar refinement, README/Zenodo metadata alignment, and data codebook formatting. | `docs/ai-evidence/PROMPT_ASLI_CLAUDE_verbatim.md` |
| **ChatGPT** | `https://chatgpt.com` | GPT-4o / GPT-6 candidate | Initial drafting assistance for structural transitions and proofreading of academic prose. | Author session logs |
| **Gemini** | `https://gemini.google.com` | Gemini 1.5 Pro / Gemini 4 Neon | Technical consistency checking across tables, citations, and mathematical notation. | Author session logs |

---

## Section 5. Human Oversight and Final Responsibility
All conceptual architectures, circuit formulations, smart contract deployments on Polygon Mainnet, and empirical findings were directed and validated by the primary author (**Archy Renaldy Pratama Nugraha**) and co-authors (**Yandra Arkeman**, **Irman Hermadi**, **Yani Nurhadryani**). All AI-assisted suggestions were critically inspected, manually validated against ground-truth logs, and tested in isolated local sandboxes prior to inclusion in the manuscript and repository.

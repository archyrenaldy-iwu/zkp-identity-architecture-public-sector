# SIPSI AI x Blockchain: Zero-Knowledge Identity Verification Architecture for Public-Sector Platforms

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)
[![Blockchain](https://img.shields.io/badge/Blockchain-Polygon%20Mainnet-3670A0?logo=polygon)](https://polygon.technology/)
[![ZKP](https://img.shields.io/badge/Zero--Knowledge-Groth16%20%7C%20BN254-purple)](https://iden3.io/)
[![AI Architecture](https://img.shields.io/badge/AI-RoBERTa%20%7C%20IndoBERT-orange)](https://huggingface.org/)

## 1. Project Overview

This repository contains the official codebase, smart contracts, zero-knowledge circuits, AI microservices, and mainnet verification scripts for the research paper:

> **"Bytecode Security Auditing and Live Mainnet Validation of a Zero-Knowledge Identity Verification Architecture for Public-Sector Blockchain Platforms"**
> 
> **Authors**: Archy Renaldy Pratama Nugraha, Yandra Arkeman, Irman Hermadi, Yani Nurhadryani  
> **Affiliations**: IPB University & International Women University (IWU)

The platform addresses the **Digital Verification Trilemma** in decentralized public-sector e-governance by combining a 3+1 Parameter Augmentation ZKP scheme (Groth16 over BN254), deterministic nullifier replay mitigation, and AI-driven document verification & legal decision recommendation.

---

## 2. Repository Structure

```directory
.
├── data/                      # Experimental & empirical datasets
│   ├── ai_rekomendasi_retrain.csv             # RoBERTa 13-class model fine-tuning dataset
│   ├── ai_verifikasi_retrain.csv              # IndoBERT NER extraction fine-tuning dataset
│   ├── polygon_mainnet_transactions_zkp.csv   # Live Polygon Mainnet ZKP contract transaction logs (n=229)
│   └── polygon_mainnet_transactions_sengketa.csv # Live Polygon Mainnet Sengketa contract transaction logs
├── docs/                      # Technical documentation for Modules 1-4
│   ├── modul-1-identitas-digital.md
│   ├── modul-2-pencatatan-sengketa-blockchain.md
│   ├── modul-3-verifikasi-putusan.md
│   └── modul-4-rekomendasi-putusan.md
├── zkp-identity-proof/        # Modul 1: Groth16 Circom Circuits & Verification Contracts
├── zkp-identity-backend/      # Modul 1: Off-chain Merkle Tree accumulator & ZKP service
├── sengketa-contract/         # Modul 2: Dispute Workflow Smart Contracts (Solidity FSM & OpenZeppelin RBAC)
├── sengketa-backend/          # Modul 2: Express.js API & IPFS (Pinata) storage anchor service
├── ai-service/                # Modul 3 & 4: IndoBERT NER extraction & RoBERTa UU KIP Recommendation Engine
└── sipsi-base/                # Core SIPSI web portal integration framework
```

---

## 3. Core Architecture & Empirical Highlights

| Component | Technical Implementation | Empirical Benchmarks / Audit Results |
| :--- | :--- | :--- |
| **ZKP Circuit (Circom)** | 3+1 Parameter Augmentation Scheme (`IdentityMerkleProof.circom`) | **8,372** non-linear constraints, **2.14s** edge proving duration |
| **Bytecode Security Audit** | Mythril symbolic execution on compiled EVM bytecode | **0** High/Medium severity vulnerabilities (SWC-113 low informational) |
| **Anti-Replay Nullifier** | Deterministic nullifier state-locking (`IdentityMerkleZKP.sol`) | **50/50 (100%)** duplicate-proof replay attacks blocked |
| **Live Mainnet Validation** | Polygon Mainnet transactions ($n = 229$) | **0.00905 POL** avg gas fee, Uniform distribution ($\chi^2 = 1.24, p = 0.265 > 0.05$) |
| **AI Verification & Recommendation** | IndoBERT NER (`cahya/indobert-base-indonesian-NER`) & RoBERTa (`cahya/roberta-base-indonesian-522M`) | Automated PII redaction, PDF extraction, & 13 UU KIP legal categories ranking |

---

## 4. Dataset & Data Provenance

- **Third-Party Data Source**: **JDIH Komisi Informasi Pusat RI** (Jaringan Dokumentasi dan Informasi Hukum - Central Information Commission of the Republic of Indonesia).
- **Dataset & Empirical Logs**: Experimental CSV datasets and raw mainnet transaction logs are hosted under [`data/`](data/):
  - [`data/ai_rekomendasi_retrain.csv`](data/ai_rekomendasi_retrain.csv): Labeled dataset for RoBERTa 13-class UU KIP legal decision recommendation model.
  - [`data/ai_verifikasi_retrain.csv`](data/ai_verifikasi_retrain.csv): Labeled dataset for IndoBERT Named Entity Recognition (NER) decision verification.
  - [`data/polygon_mainnet_transactions_zkp.csv`](data/polygon_mainnet_transactions_zkp.csv): Raw Polygon Mainnet transaction logs for ZKP Identity verification (`0xF99024c6E16c2dCCA305DAF4406b17D93F22a72f`) used for Chi-Square session unlinkability validation ($n = 229$).
  - [`data/polygon_mainnet_transactions_sengketa.csv`](data/polygon_mainnet_transactions_sengketa.csv): Raw Polygon Mainnet transaction logs for Sengketa dispute workflow contract (`0x7f6979426Bf7eBcA11C81025359D123b8B9C5Baf`).
- **Domain**: Public Information Dispute Resolution Records (*Sengketa Informasi Publik*).
- **Access & License**: Data was collected from the public domain under Indonesian Law No. 14 of 2008 (KIP Act).
- **Privacy Assurance**: All citizen identities are anonymized using Poseidon Hash representations; raw NIK and credential witness vectors remain strictly edge-side/off-chain.

---

## 5. Installation & Setup

### Prerequisites
- **Node.js**: v18.x or higher
- **Python**: v3.8 - v3.10
- **Circom**: v2.1.6
- **Hardhat / Mythril** (for smart contract testing & bytecode auditing)

### Step-by-Step Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/archyrenaldy-iwu/zkp-identity-architecture-public-sector.git
   cd zkp-identity-architecture-public-sector
   ```

2. **Module 1 & 2 Dependencies**:
   ```bash
   # ZKP Proof Engine
   cd zkp-identity-proof && npm install && cd ..

   # Sengketa Contracts
   cd sengketa-contract && npm install && cd ..
   ```

3. **Module 3 & 4 AI Service**:
   ```bash
   cd ai-service
   pip install -r requirements.txt
   ```

---

## 6. Reproducibility & Testing

### Running ZKP Circuit Tests
```bash
cd zkp-identity-proof
npm run test
```

### Running Hardhat Replay-Attack Simulation (50 Concurrent Replays)
```bash
cd zkp-identity-proof
npx hardhat test
```

### Running AI Decision Verification & Recommendation Service
```bash
cd ai-service
python app.py
```

---

## 7. Declaration of Generative AI Assistance

In compliance with journal editorial guidelines:
- **AI Tools Used**: OpenAI ChatGPT (GPT-4o) and Anthropic Claude / Antigravity AI assistant.
- **Purpose**: Assisting in LaTeX formatting, code refactoring, writing unit test boilerplate, proofreading manuscript sections for grammatical clarity, and generating Markdown documentation.
- **Author Accountability**: The human authors independently conceived, verified, and approved all circuit specifications, smart contracts, mathematical proofs, and empirical analyses reported in this publication.

---

## 8. Citation

If you use this repository or dataset in your academic work, please cite our paper:

```bibtex
@article{nugraha2026bytecode,
  title={Bytecode Security Auditing and Live Mainnet Validation of a Zero-Knowledge Identity Verification Architecture for Public-Sector Blockchain Platforms},
  author={Nugraha, Archy Renaldy Pratama and Arkeman, Yandra and Hermadi, Irman and Nurhadryani, Yani},
  journal={PeerJ Computer Science},
  year={2026}
}
```

---

## 9. License

This repository is distributed under the **MIT License**. See [LICENSE](LICENSE) for details.

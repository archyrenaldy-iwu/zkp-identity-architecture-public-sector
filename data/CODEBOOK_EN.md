# Data Dictionary and English Codebook

**Manuscript:** *Bytecode Security Auditing and Live Mainnet Validation of a Zero-Knowledge Identity Verification Architecture for Public-Sector Blockchain Platforms* (PeerJ Computer Science, CS-2026:08:147906)  
**Files Covered:**
- `data/ai_rekomendasi_retrain.csv` and English-annotated copy `data/ai_rekomendasi_retrain_en.csv`
- `data/ai_verifikasi_retrain.csv` and English-annotated copy `data/ai_verifikasi_retrain_en.csv`

---

## 1. Dataset Overview
This codebook documents the labeled text-classification datasets used in the SIPSI AI service (`ai-service/app.py`). Each row represents the **title or short description of an Indonesian public-information document** alongside its statutory classification label (`Kategori 1` through `Kategori 13`) under **Law No. 14 of 2008 on Public Information Disclosure (*Undang-Undang Keterbukaan Informasi Publik* / UU KIP)**.

- **Total rows:** 1,021 data rows (excluding header); 1,020 unique document titles (1 duplicate entry retained to match the original training split).
- **Encoding & format:** UTF-8, comma-separated (`CSV`), with double quotes around text fields containing commas.
- **Original vs. English-annotated copies:** The original files (`ai_rekomendasi_retrain.csv`, `ai_verifikasi_retrain.csv`) preserve the exact Indonesian column headers (`Teks, Label`) and Indonesian text required by the pretrained Indonesian NLP pipeline (`cahya/roberta-base-indonesian-522M`). The English-annotated copies (`ai_rekomendasi_retrain_en.csv`, `ai_verifikasi_retrain_en.csv`) retain the identical 1,021 rows in the exact same order, with English column headers and three additional English statutory annotation columns for editor, reviewer, and reader comprehension.

---

## 2. Companion File Note (`ai_verifikasi_retrain.csv`)
In the public repository, `ai_verifikasi_retrain.csv` (115,931 bytes; MD5 `51c9ec19e02a463c4b96fcce2cb50c0a`) is identical in content and schema (`Teks, Label`, 1,021 rows across 13 classes) to `ai_rekomendasi_retrain.csv`. While Module 3 (`docs/modul-3-verifikasi-putusan.md`) also utilizes an internal IndoBERT Named Entity Recognition (NER) pipeline for extracting entity spans (*Case Number*, *Applicant*, *Respondent*) from PDF rulings, the token-level BIO training notebooks are maintained internally and only the public 13-class document-title reference dataset is distributed in this repository. Both `ai_rekomendasi_retrain_en.csv` and `ai_verifikasi_retrain_en.csv` are provided so that every CSV file in `data/` has a complete, self-contained English-annotated counterpart.

---

## 3. Column Schema

| Column (Original CSV) | Column (English-Annotated CSV) | Data Type | Description |
|---|---|---|---|
| `Teks` | `Text_ID` | `string` | Original Indonesian title or short description of a public-information document. Retained in Indonesian to preserve legal terminology, institutional proper names, and statutory syntax. |
| `Label` | `Label` | `string` | Statutory class label (`Kategori 1` to `Kategori 13`, representing 13 mutually exclusive classes). |
| *(not present)* | `Law14_2008_Article` | `string` | Specific Article/Clause of Law No. 14 of 2008 (UU KIP) corresponding to the label. |
| *(not present)* | `Label_Description_EN` | `string` | Official English translation/summary of the statutory provision. |
| *(not present)* | `Group_EN` | `string` | High-level legal grouping: `Mandatory disclosure` (`Kategori 1`–`3`) or `Exempted information` (`Kategori 4`–`13`). |

---

## 4. Label Definitions, Legal Basis, and Class Distribution

The mapping below is derived directly from the `category_mapping` dictionary in `ai-service/app.py` (model class indices `0`–`12`) and Indonesian Law No. 14 of 2008:

| Label | Law No. 14/2008 Provision | English Description | Legal Group | Row Count |
|---|---|---|---|---:|
| `Kategori 1` | Art. 9(2) | Information that must be provided and announced periodically | Mandatory disclosure | 62 |
| `Kategori 2` | Art. 10(1) | Information that must be announced immediately (*serta-merta*) | Mandatory disclosure | 80 |
| `Kategori 3` | Art. 11(1) | Information that must be available at all times | Mandatory disclosure | 181 |
| `Kategori 4` | Art. 17(a) | Information that, if disclosed, could obstruct law enforcement | Exempted information | 57 |
| `Kategori 5` | Art. 17(b) | Information that, if disclosed, could harm intellectual property rights or cause unfair business competition | Exempted information | 54 |
| `Kategori 6` | Art. 17(c) | Information that, if disclosed, could endanger national defense and security | Exempted information | 84 |
| `Kategori 7` | Art. 17(d) | Information that, if disclosed, could reveal Indonesia's natural resources | Exempted information | 81 |
| `Kategori 8` | Art. 17(e) | Information that, if disclosed, could harm national economic resilience | Exempted information | 54 |
| `Kategori 9` | Art. 17(f) | Information that, if disclosed, could harm foreign relations | Exempted information | 69 |
| `Kategori 10` | Art. 17(g) | Information that, if disclosed, could reveal the content of private authentic deeds or a person's last will | Exempted information | 73 |
| `Kategori 11` | Art. 17(h) | Information that, if disclosed, could reveal personal secrets | Exempted information | 90 |
| `Kategori 12` | Art. 17(i) | Memoranda or letters between or within public bodies that are confidential by nature, unless ordered open by the Information Commission or a court | Exempted information | 68 |
| `Kategori 13` | Art. 17(j) | Information that may not be disclosed under another law | Exempted information | 68 |
| **Total** | | **13 classes** | **3 Mandatory / 10 Exempted** | **1,021** |

- **Class balance:** Smallest classes are `Kategori 5` and `Kategori 8` (54 rows each); largest class is `Kategori 3` (181 rows).

---

## 5. Language Preservation Note
The `Text_ID` / `Teks` column contains Indonesian document titles referencing specific Indonesian public agencies, regulations, and administrative bodies (e.g., *Arsip Nasional Republik Indonesia*, *Badan Pengawas Keuangan*, *Otoritas Jasa Keuangan*). Translating these proper titles into English would alter tokenization and degrade the reproducibility of the Indonesian RoBERTa classification model (`cahya/roberta-base-indonesian-522M`). Therefore, the original Indonesian text is preserved alongside this English codebook and the three English annotation columns (`Law14_2008_Article`, `Label_Description_EN`, `Group_EN`).

---

## 6. Provenance and Privacy
- **Provenance (Third-Party Source Data):** The administrative dispute document records and classification references originate from the **JDIH (*Jaringan Dokumentasi dan Informasi Hukum* / Legal Documentation and Information Network)** of the **Central Information Commission of the Republic of Indonesia (*Komisi Informasi Pusat RI*)**, which are publicly accessible legal documents published under Law No. 14 of 2008 on Public Information Disclosure.
- **Privacy & Anonymization:** Citizen identities in the broader SIPSI architecture are represented solely by Poseidon hash commitments; no raw personal identifiers (such as Indonesian NIK or private credentials) are included in these CSV datasets.

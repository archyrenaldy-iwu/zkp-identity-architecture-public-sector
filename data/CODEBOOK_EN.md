# Data dictionary (English codebook)

Files covered: `data/ai_rekomendasi_retrain.csv` (and the English-annotated copy `ai_rekomendasi_retrain_en.csv`).

## What the data are
A labeled text-classification dataset used to train the RoBERTa recommendation model (13 classes) of the SIPSI AI service. Each row is the **title or short description of a public-information document**, written in **Indonesian** (document titles contain Indonesian proper names of institutions and are intentionally kept in the original language), with one class label that indicates the provision of Law No. 14 of 2008 on Public Information Openness (KIP Act) under which that information falls.

- Rows: 1021 (header excluded); unique texts: 1020
- Encoding: UTF-8, comma-separated, quoted where the text contains commas.

## Columns
| Column (original) | Column (English copy) | Type | Description |
|---|---|---|---|
| `Teks` | `Text_ID` | string | Indonesian title/description of a public-information document |
| `Label` | `Label` | string | Class label `Kategori 1` ... `Kategori 13` (13 classes) |
| (added) | `Law14_2008_Article` | string | KIP Act article that the label refers to |
| (added) | `Label_Description_EN` | string | English description of the article |
| (added) | `Group_EN` | string | `Mandatory disclosure` (Kategori 1-3) or `Exempted information` (Kategori 4-13) |

The English copy contains the same rows in the same order, with only the English column names and the three added annotation columns. The original file is unchanged so that the training code (`ai-service/app.py`) keeps working.

## Label definitions and counts
| Label | Law 14/2008 | English description | Group | Rows |
|---|---|---|---|---|
| Kategori 1 | Art. 9(2) | Information that must be provided and announced periodically | Mandatory disclosure | 62 |
| Kategori 2 | Art. 10(1) | Information that must be announced immediately (serta-merta) | Mandatory disclosure | 80 |
| Kategori 3 | Art. 11(1) | Information that must be available at all times | Mandatory disclosure | 181 |
| Kategori 4 | Art. 17(a) | Information that, if disclosed, could obstruct law enforcement | Exempted information | 57 |
| Kategori 5 | Art. 17(b) | Information that, if disclosed, could harm intellectual property rights or cause unfair business competition | Exempted information | 54 |
| Kategori 6 | Art. 17(c) | Information that, if disclosed, could endanger national defense and security | Exempted information | 84 |
| Kategori 7 | Art. 17(d) | Information that, if disclosed, could reveal Indonesia's natural resources | Exempted information | 81 |
| Kategori 8 | Art. 17(e) | Information that, if disclosed, could harm national economic resilience | Exempted information | 54 |
| Kategori 9 | Art. 17(f) | Information that, if disclosed, could harm foreign relations | Exempted information | 69 |
| Kategori 10 | Art. 17(g) | Information that, if disclosed, could reveal the content of private authentic deeds or a person's last will | Exempted information | 73 |
| Kategori 11 | Art. 17(h) | Information that, if disclosed, could reveal personal secrets | Exempted information | 90 |
| Kategori 12 | Art. 17(i) | Memoranda or letters between or within public bodies that are confidential by nature, unless ordered open by the Information Commission or a court | Exempted information | 68 |
| Kategori 13 | Art. 17(j) | Information that may not be disclosed under another law | Exempted information | 68 |

Source of the mapping: label-to-article table in `ai-service/app.py` (the `detail_category`, `pasal` and `informasi` fields), English wording drafted with the help of Claude (Anthropic) from the Indonesian text of that table; the authors must check the English wording.

## Language note
The text column is Indonesian. A machine translation of institution names would reduce, not improve, the usefulness of the data, so this codebook and the English annotation columns are provided instead (the editor allowed a codebook as an alternative).

## Structure summary (for editors)
- One data table, 1,021 rows x 2 original columns (`Teks`, `Label`). The English copy adds three annotation columns (5 columns in total).
- Task: single-label, 13-class text classification. Classes are the 13 groups of public information in Law No. 14 of 2008 (3 mandatory-disclosure classes, 10 exemption classes). The class index used by the model in `ai-service/app.py` is 0-12; the mapping from index to `Kategori N` and article is in the `category_mapping` dictionary of that file and was used here to build the label table above. Verified: row counts per label were recomputed from the CSV; the English copy matches the original row by row (same text, same label).
- Class balance: smallest class Kategori 5 and 8 (54 rows), largest Kategori 3 (181 rows).
- Not changed: no text was translated, no label was edited, no row was added or removed. The English copy differs from the original only by column names and the three added annotation columns.
- Known minor issues: 1,021 rows contain 1,020 unique texts (one duplicated text); the repository README says "1,020 samples" and the manuscript says 1,021 titles, so the README wording should be changed to "1,021 rows (1,020 unique texts)".

## Companion file `ai_verifikasi_retrain.csv`  (STATUS: UNRESOLVED, NEEDS THE AUTHORS/IT)
Verified on 21 Nov 2026: `ai_verifikasi_retrain.csv` and `ai_rekomendasi_retrain.csv` are byte-identical (MD5 51c9ec19e02a463c4b96fcce2cb50c0a, 115,931 bytes), and both were added in the same commit (25ccf2c, 9 Sep 2026). The README describes the second file as the IndoBERT NER training data (39 BIO labels), but a NER file would need a token-level format (token and tag per row); the present content is sentence-level (`Teks,Label`) with 13 class labels. The repository documentation (`docs/modul-3`, `docs/modul-4`) states that the original training samples and the Colab notebooks are kept in an internal folder that is not in the public repository. Therefore the file is most likely a copy made by mistake. Until the authors supply the real NER file this codebook can only document the recommendation dataset; the NER file must not be described from guesswork.

## Provenance of the texts  (STATUS: NEEDS THE AUTHORS)
Not documented anywhere in the repository: where the 1,021 titles were obtained, who assigned the labels, and under what terms. See the answer to Question 90.

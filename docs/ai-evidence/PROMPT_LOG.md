# AI prompt and usage log (draft)

Prepared for PeerJ manuscript CS-2026:08:147906. Verbatim Claude prompts from 16 Oct 2026 onward are in `PROMPT_ASLI_CLAUDE_verbatim.md` (extracted unchanged from the session file); earlier prompts and other tools' prompts exist only in the authors' own chat histories. This log summarizes them and lists the files affected. Rows marked [AUTHORS TO FILL] must be completed from the authors' own chat histories.

## Part 1. Claude (Anthropic), claude.ai, model Claude Sonnet 5.5, same conversation, Sep-Nov 2026 (dates of the earlier steps to be confirmed from the chat history)
All entries are fully reconstructed from the conversation transcript. Human review: the corresponding author read and applied the outputs; numerical statements were checked against the repository CSV files and the `scripts/calculate_chi_square.py` output.

| # | Date | Prompt (summary, translated from Indonesian) | What the AI produced | Files affected |
|---|---|---|---|---|
| 1 | before 16 Oct 2026 [confirm; verbatim prompt NOT recoverable from the session file, only a summary exists] | Reformat the manuscript to the PeerJ LaTeX template; prepare figures/tables as separate files | Reformatted `main.tex`, compiled PDF, exported Fig1-Fig7 and Table1-Table4 | `main.tex`, `sample.bib`, Fig*.png, Table*.docx |
| 2 | before 16 Oct 2026 [confirm; verbatim prompt NOT recoverable] | Fix the plotting bug in Figure 7 (missing axis label) | Replaced the pgfplots tick specification | `main.tex` (Fig. 7) |
| 3 | 16 Oct 2026 | Write a README, Zenodo/GitHub instructions, `.zenodo.json`, `CITATION.cff`, `.gitignore` for the data repository | Draft README and metadata files; PDF guide for the technical team | `README.md`, `CITATION.cff`, `.zenodo.json`, `.gitignore` |
| 4 | 16 Oct 2026 | Check the revised GitHub repository against the manuscript | Found mismatches: chi-square value, sample definition (n=229), Figure 6 data, single-sender transactions | analysis notes only |
| 5 | 16 Oct 2026 | "Fix and resolve everything so it is consistent and ready to submit" | Revised manuscript text and numbers to match the reproducible data (chi2 = 0.98, p = 0.322; n = 229 = 122 + 107); corrected Fig. 6 and Table 4; rebuilt the PDF; repository patch | `main.tex`, `Fig6.png`, `Table4.docx`, patch |
| 6 | 16 Oct 2026 | Interpret the 50/50 replay test and Mythril on the final contract | Code-reading analysis of the nullifier design (proof-byte nullifier, mock verifier, mainnet bytecode predates nullifier) | text in Limitations section, `main.tex` |
| 7 | 16 Oct 2026 | Re-render figures that failed the PeerJ 900x900 px check | Re-rendered Fig1-Fig7 at 600 dpi from the TikZ sources; re-saved Table4 | Fig*.png, `Table4.docx` |
| 8 | 18 Nov 2026 | Prepare responses to the PeerJ requests of 22 Oct 2026 (points 3-6) | English codebook, annotated CSV, disclosure texts, this log | `CODEBOOK_EN.md`, `ai_rekomendasi_retrain_en.csv`, this folder |

## Part 2. Other tools (author-reported: GPT-6, Gemini 4 Neon). Prompts NOT available to the preparer; to be filled by the authors/IT from their own accounts
| Tool | URL | Model as reported by authors | Public release date (web check, 21 Nov 2026) | Activities | Prompts | Files |
|---|---|---|---|---|---|---|
| GPT-6 (OpenAI) | https://chatgpt.com | GPT-6 (exact variant, e.g. Astra, to be read from the account) | about 3-4 Sep 2026 | [FROM CHAT HISTORY] | [EXPORT] | [FILES] |
| Gemini 4 Neon (Google) | https://gemini.google.com | Gemini 4 Neon | 18 Nov 2026 | only work after this date; earlier Gemini use (README of 7 Oct) was another version [FROM CHAT HISTORY] | [EXPORT] | [FILES] |
| Claude Code (Anthropic) | https://claude.com/claude-code | [VERSION] | n/a | `CLAUDE.md` exists in commit 25ccf2c; code assistance unconfirmed | [EXPORT] | [FILES] |

## Part 3. File index (before/after)
| File | AI tool | Nature of AI contribution | Before copy | After copy |
|---|---|---|---|---|
| `README.md`, `CITATION.cff`, `.zenodo.json`, `.gitignore` | Claude Sonnet 5.5 | drafted/edited metadata and docs | `B_sesi_claude_16okt/before` | `B_sesi_claude_16okt/after` |
| `IdentityMerkleZKP.sol`, `MockGroth16Verifier.sol`, `ReplayAttackSimulation.js`, `calculate_chi_square.py` (commit e943ced) | [CONFIRM] | [CONFIRM] | `A_commit_e943ced/before` | `A_commit_e943ced/after` |
| [other files] | [ ] | [ ] | [ ] | [ ] |


## Part 4. Evidence found in the repository that bears on AI use (added 21 Nov 2026)
| Evidence | Where | What it shows and does not show |
|---|---|---|
| README section 8 lists Gemini, ChatGPT, Claude for "LaTeX formatting, code refactoring, test boilerplate, documentation, grammar proofreading" | commit 3ca4b4d (7 Oct 2026), account archyrenaldy-iwu | The authors' own statement of AI use, including code. No versions, no file list. |
| `zkp-identity-proof/CLAUDE.md`, a guidance file written for Claude Code | added in commit 25ccf2c (9 Sep 2026) | A Claude Code guidance file exists. It does not prove which code Claude Code wrote. |
| Commit e943ced (12 Oct 2026): nullifier in `IdentityMerkleZKP.sol`, `MockGroth16Verifier.sol`, `ReplayAttackSimulation.js`, `calculate_chi_square.py`, `LICENSE` | git history | Candidate files for AI-assisted work. Nothing in the commit proves AI involvement; the IT team must ask the authors file by file. |
| No `Co-Authored-By` or AI marker in any commit message | git log | Absence of a marker proves nothing. |

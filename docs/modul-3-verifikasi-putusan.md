# Modul 3: Verifikasi Putusan

# Modul 3: Verifikasi Putusan

# Overview Modul Verifikasi Putusan

Modul ini berfungsi memvalidasi secara otomatis dokumen putusan fisik/digital berformat PDF. Prosesnya dirancang secara hierarkis *(hybrid-pipeline)*: sistem mengekstrak teks mentah dari file PDF, memfilternya menggunakan rumusan Regular Expression (Regex) dipadu dengan aturan Keterbukaan Informasi Publik (KIP), dan akhirnya dipoles menggunakan model **Named Entity Recognition (NER-INDO)** berbasis arsitektur **IndoBERT**. Ekstraksi difokuskan untuk mendapatkan parameter legalitas kunci: **Nomor Perkara**, **Nama Pemohon**, dan **Nama Termohon**.

File *entry* dan komponen utama meliputi:
- **Server API & Pipeline**: `sipsi-api-ai/AI/app.py`
- **Algoritma Post-processing NER**: `sipsi-api-ai/AI/ekstraktor.py`

---

# Detail Teknis

## 1. Document Parsing & Teks Pre-processing

- **File**: `sipsi-api-ai/AI/app.py`
- **Deskripsi**: File PDF diurai (*parse*) ke bentuk *string* Unicode menggunakan library `pdfplumber`. Demi optimasi beban CPU dan *response time*, algoritma membatasi ektraksi hanya maksimal pada 6 halaman pertama, yang mana identitas pemohon dan termohon pada putusan legal senantiasa terletak di bagian kepala dokumen (*cover* atau konsiderans).
- **Algoritma & Matematika**:
Sistem melakukan normalisasi string (penghapusan karakter kontrol *carriage return*, normalisasi spasi putih/tab, penggabungan kata terpotong baris baru):

(misalnya: `\r` $\rightarrow$ `""`, `\s{2,}` $\rightarrow$ `" "`, dll).
    
    $$
    f_{norm}(S) = S_{\text{cleaned}}
    $$
    
- **Code Snippet**:
    
    ```python
    # API Endpoint - app.py (Line 395-409)
    # Baca teks dari beberapa halaman awal (tanpa OCR)
    text = ""
    try:
        with pdfplumber.open(io.BytesIO(pdf_bytes)) as pdf:
            pages = min(6, len(pdf.pages))  # Ekstrak maskimal 6 halaman awal
            for i in range(pages):
                t = pdf.pages[i].extract_text() or ""
                text += t + "\n"
    except Exception:
        text = ""
    
    raw_text = text
    text = _normalize_text(text)
    ```
    

## 2. Rule-Based Regex Extraction (Validasi Field)

- **File**: `sipsi-api-ai/AI/app.py`
- **Deskripsi**: Tahapan pertama pendeteksian nama pihak tidak langsung diserahkan ke AI. Alih-alih, sistem menjalankan ekspresi reguler (Regex) untuk mencari blok deklarasi eksplisit seperti `Nama Pemohon :` atau `TERMOHON`. Pada proses *scanning* pihak “Termohon”, sistem memberlakukan logika KIP (Komisi Informasi Pusat): Termohon **wajib** merupakan **Badan Publik**, bukan Nama Orang.
- **Algoritma & Matematika**:
Algoritma *String Matching Finite Automaton* untuk Regex pencarian Nomor Registrasi Sengketa.
    - Pola Pencarian: Kata `Nomor` atau `Nomor Registrasi` $\rightarrow$ Pemisah opsional $\rightarrow$ Grup Tangkap (*Capture Group*) berisi kombinasi angka, miring, romawi, tahun.
    
    Berdasarkan Finite Automata: $Q$ merupakan *states*, $\Sigma$ adalah kumpulan alfabet, dan transisi $\delta(q, a) \rightarrow p$.
    
    ```
    (Nomor(?:\s+Registrasi)?\s*[:;]?\s*)([0-9]{2,4}\s*/\s*[IVXLCDM]+(?:\s*/\s*[A-Z-]+)*\s*/\s*\d{4}|[0-9A-Z/\-]{6,})
    ```
    
- **Code Snippet**:
    
    ```python
    # Regex Heuristics - app.py
    # Stopwords untuk menangkal pengambilan nama kuasa hukum
    PEMOHON_STOP = re.compile(
        r"(?i)\b(Kuasa( Hukum)?|Advokat|Pengacara|Lawyer|Paralegal|Selaku|"
        r"yang bertindak untuk dan atas nama|bertindak untuk dan atas nama|"
        r"untuk dan atas nama|Perwakilan|Wali|Alamat|Berkedudukan di)\b"
    )
    
    # Filter Badan Publik untuk Termohon
    ORG_HINT = re.compile(r"\b(PT\s+.*Persero|BUMN|BUMD|Perum|Perseroan|Kementerian|...)\b", re.IGNORECASE)
    PERSON_HINT = re.compile(r"\b(Dr\.?|Dra\.?|Ir\.?|H\.|Hj\.?|Bapak|Ibu|Sdr\.?|Sdri\.?)\b", re.IGNORECASE)
    
    # Logika validasi "Termohon tidak boleh nama orang"
    if termohon and PERSON_HINT.search(termohon):
        termohon = ""
    ```
    

## 3. IndoBERT & NER-INDO (Named Entity Recognition)

- **File**: `sipsi-api-ai/AI/app.py` & `sipsi-api-ai/AI/ekstraktor.py`
- **Deskripsi**: Hasil ekstrasi string dari Regex dilewatkan (*passed*) ke dalam arsitektur AI *IndoBERT* (skema Token Classification) yang sudah di *fine-tune* pada bobot klasifikasi 39 label NER Bahasa Indonesia (B-PER, I-PER, B-ORG, dll). Jika kata hubung/stopword masuk dalam ekstraksi Regex, algoritma NER di `ekstraktor.py` hanya akan mempertahankan kata yang benar-benar diklasifikasikan sebagai Entitas (Organisasi/Orang/Organisasi Politik).
- **Algoritma & Matematika**:
    - **Pretrained Base**: `indolem/indobert-base-uncased`.
    - **Saved Weight**: Checkpoint parameter di-*load* dari path lokal `NER-INDO/INDO-NER-weights` atau `pretrainedModel/BERT`.
    - **Algoritma Sub-word Tokenization**: Algoritma ekstraksi nama mengatasi masalah sub-kata BPE (Byte-Pair Encoding). Token yang diawali dengan parameter penggabungan karakter `##` digabungkan secara manual (*concatenated*) dengan elemen array sebelumnya.
- **Code Snippet**:
    
    ```python
    # Load Bobot Model & Inferensi (app.py)
    verificationModel = TFAutoModelForTokenClassification.from_pretrained(
        pretrainedBert, num_labels=39, id2label=id2label, label2id=label2id, from_pt=True
    )
    verificationModel.load_weights("NER-INDO/INDO-NER-weights")
    
    # Pipeline Inference NER
    ner_pipeline = pipeline("ner", tokenizer=tokenizer, model=verificationModel, grouped_entities=True)
    pemohon_entities = ner_pipeline(pemohon_name)
    ```
    
    ```python
    # Algoritma penggabungan Subword BPE (ekstraktor.py)
    def extract_names(entities):
        names = []
        current_name = []
    
        for entity in entities:
            # Filter tipe kelas (Person / Organization / Political Org)
            if entity['entity'] in {'B-PER', 'I-PER', 'B-ORG', 'I-ORG','B-NOR', 'I-NOR'}:
                word = entity['word']
    
                # Logika Rekonstruksi Sub-Word Token
                if word.startswith('##'):
                    current_name[-1] += word[2:] # Sambung kata tanpa spasi
                else:
                    if entity['entity'] == 'B-PER' and current_name:
                        names.append(' '.join(current_name))
                        current_name = []
                    current_name.append(word)
    
        if current_name:
            names.append(' '.join(current_name))
    
        return names
    ```
    

## 4. Integrasi Base App (sipsi-base) & Eksekusi AI

- **File**: `sipsi-base/app/Services/PutusanService.php`
- **Deskripsi**: Aplikasi inti Laravel akan otomatis mengunggah *(upload)* file putusan (`file_putusan`) setiap kali pengguna mengunggah dokumen baru pada modul Putusan Sengketa. Laravel memanggil API Python (`/api/extract`) dengan melampirkan file *binary stream* PDF-nya (hingga 60 detik timeout). AI lalu mengekstrak nomor perkara dan mengembalikannya ke Laravel. Laravel akan memblokir (*reject*) transaksi jika Nomor Perkara hasil bacaan AI tidak cocok (*mismatch*) dengan `no_sengketa` di Database.
- **Code Snippet**:
    
    ```php
    // Backend Laravel - sipsi-base/app/Services/PutusanService.php
    public function getNomorFromVerification($filePath) {
        $base = rtrim(config('services.ai_service_url', env('AI_SERVICE_URL', 'http://127.0.0.1:3031')), '/');
        $url  = $base . '/api/extract';
    
        $fullPath = storage_path('app/sensitive/' . ltrim($filePath, '/'));
    
        $response = Http::timeout(60)->attach('pdf_file', file_get_contents($fullPath), basename($filePath))
                        ->post($url);
    
        if ($response->successful()) {
            return $response->json()['Nomor'] ?? null;
        }
        return null;
    }
    ```
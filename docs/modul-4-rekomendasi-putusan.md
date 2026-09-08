# Modul 4: Rekomendasi Putusan

# Modul 4: Rekomendasi Putusan

# Overview Modul Rekomendasi Putusan

Modul Rekomendasi Putusan berfungsi mengotomatisasi pengkategorian dokumen/berkas sengketa informasi menjadi 13 kategori utama yang mengacu langsung pada Undang-Undang Keterbukaan Informasi Publik (UU KIP No. 14 Tahun 2008). Proses klasifikasi ini ditenagai oleh model AI generatif (NLP) *Deep Learning* tingkat lanjut dengan arsitektur **RoBERTa (Robustly Optimized BERT Pretraining Approach)** yang dilatih khusus dalam bahasa Indonesia. Model mengeluarkan persentase *confidence score* (skor probabilitas) untuk setiap kategori, memberikan rekomendasi Pasal kepada pembuat keputusan.

File *entry* dan komponen utama meliputi:
- **Server API & AI Inference Engine**: `sipsi-api-ai/AI/app.py`
- **Konfigurasi Weights & Tokenizer**: Direktori lokal `pretrainedModel/ROBERTA` dan `SavedWeight/Roberta Weight Run 4.1`

---

# Detail Teknis

## 1. Arsitektur Model AI & Dataset

- **File**: `sipsi-api-ai/AI/app.py`
- **Deskripsi**: Aplikasi menggunakan *Pretrained Base Model* `cahya/roberta-base-indonesian-522M` dengan fungsi utama klasifikasi urutan teks (`TFRobertaForSequenceClassification`).
- **Status Dataset Mentah & Fine-Tuning**: Script fine-tuning/retraining dan sampel dataset (`retrain1.csv`) serta Colab Notebooks (`Named Entity Recognition - Fine-tuning` dan `Rekomendasi - Fine-tuning - ReTrain`) tersimpan pada dokumentasi acuan internal (`ref/Colab Notebooks/`). Pada repositori publik yang di-deploy, data diproses melalui `db_backup` PostgreSQL untuk verifikasi klasifikasi akhir.
- **Pengambilan Bobot (Saved Weights)**: Alih-alih melatih dari awal, aplikasi memuat bobot *(weights)* yang sebelumnya telah di *fine-tune*. Bobot tersebut disimpan secara lokal pada path `SavedWeight/Roberta Weight Run 4.1`.
- **Code Snippet**:
    
    ```python
    # Inisialisasi Model & Tokenizer di app.py (Baris 311-323)
    pretrainedRoberta = 'cahya/roberta-base-indonesian-522M'
    recomendationModel = TFRobertaForSequenceClassification.from_pretrained(pretrainedRoberta, num_labels=13)
    roberta_tokenizer = RobertaTokenizer.from_pretrained(pretrainedRoberta)
    
    # Load Bobot Neural Network yang Sudah di-Fine Tune
    recomendationModel.load_weights('SavedWeight/Roberta Weight Run 4.1')
    ```
    

## 2. Tokenisasi (*Subword Embedding*)

- **File**: `sipsi-api-ai/AI/app.py`
- **Deskripsi**: Teks narasi dari sengketa ditokenisasi menggunakan Byte-Pair Encoding (BPE) melalui fungsi `roberta_tokenizer`. Parameternya disesuaikan untuk keseragaman matriks (*Padding*) dan pemotongan sequence bila melebih panjang token maksimal (*Truncation*).
- **Algoritma & Matematika**:
Fungsi komputasi embedding mengubah teks karakter ke dalam Vektor Tensors $T_{input}$:
    
    $$
    T_{input} = \{ \text{Token}_1, \text{Token}_2, \ldots, \text{Token}_{N_{max}} \}
    $$
    
- **Code Snippet**:
    
    ```python
    # Parameter Padding dan Truncation
    inputs = roberta_tokenizer(kalimat, padding=True, truncation=True, return_tensors="tf")
    ```
    

## 3. Inferensi: Softmax Probabilities & Argmax Ranking

- **File**: `sipsi-api-ai/AI/app.py` (Fungsi `classify_texts`)
- **Deskripsi**: Setelah matriks *input* diproses ke dalam lapisan (layers) Transformer RoBERTa, model tidak memuntahkan probabilitas melainkan nilai linear logaritma mentah (*Logits*). Untuk mengonversinya menjadi skor persentase probabilitas, digunakan fungsi matematis komputasi Softmax. Setelah vektor probabilitas terbentuk, fungsi pemeringkatan (Ranking Algorithm) mengambil nilai terbesar menggunakan algoritma Argmax, yang merujuk pada urutan Indeks Pemetaan Kategori UU KIP.
- **Algoritma & Matematika**:
**Fungsi Softmax**: Mengonversi setiap elemen *logit* $z_i$ ke nilai rasio konfidensi (0 hingga 1) sehingga total keseluruhan probabilitas 13 kelas adalah 1.
**Fungsi Ranking (Argmax)**: Mencari indeks kelas $\hat{y}$ dengan nilai kemunculan maksimal.
    
    $$
    P(y = i | x) = \frac{e^{z_i}}{\sum_{j=1}^{13} e^{z_j}}
    $$
    
    $$
    \hat{y} = \text{argmax}_{i} \, P(y = i | x)
    $$
    
- **Code Snippet**:
    
    ```python
    # Logika Prediksi (app.py)
    def classify_texts(kalimat):
        # Feed Forward Neural Network
        outputs = recomendationModel(inputs.data)
    
        # 1. Konversi Logits ke Probability Vector (Softmax)
        predictions = tf.nn.softmax(outputs.logits, axis=-1)
    
        # 2. Ranking Algorithm / Confidence Tertinggi (Argmax)
        predicted_classes = tf.argmax(predictions, axis=1).numpy()
    
        # Mapping hasil komputasi numerik ke Kategori/Pasal UU aktual
        predicted_categories = [category_mapping[pred]['category'] for pred in predicted_classes]
        predicted_detail_categories = [category_mapping[pred]['detail_category'] for pred in predicted_classes]
        predicted_pasals = [category_mapping[pred]['pasal'] for pred in predicted_classes]
    
        return predicted_categories, predicted_detail_categories, predicted_pasals, ...
    ```
    

## 4. Penanganan Kebocoran Memori (Resource Optimization)

- **File**: `sipsi-api-ai/AI/app.py`
- **Deskripsi**: Untuk menstabilkan inferensi *Deep Learning* di lingkungan peladen (*production server*), kode disisipkan instruksi pembatasan utilitas *CPU multi-threading* dan pelepasan memori *GPU dynamic allocation*.
- **Code Snippet**:
    
    ```python
    # Pembatasan Penggunaan CPU
    tf.config.threading.set_intra_op_parallelism_threads(1)
    tf.config.threading.set_inter_op_parallelism_threads(1)
    
    # Meminimalisir OOM (Out-of-Memory) crash pada GPU
    os.environ["TF_FORCE_GPU_ALLOW_GROWTH"] = "true"
    ```
    

## 5. Integrasi Base App (sipsi-base)

- **File**: `.env.example` & Konfigurasi *Microservices* API
- **Deskripsi**: Hasil eksekusi modul AI Klasifikasi berjalan sebagai microservice independen di port `3031` atau `3001` dengan framework Flask. Aplikasi Laravel (`sipsi-base`) mengkonsumsi API AI ini (`AI_SERVICE_URL`) via request HTTP pada backend atau via antarmuka *JavaScript/Frontend* untuk memvalidasi dan mengklasifikasikan isi putusan sengketa secara langsung sebelum diterbitkan. Data metrik koreksi pengguna dikumpulkan ke database PostgreSQL (`classification_result`) di bawah layanan AI untuk validasi ulang/re-training di masa depan.
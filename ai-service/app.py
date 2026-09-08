from flask import Flask, request, jsonify, render_template, redirect, url_for
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
import pdfplumber
import requests
import io
import os
import re
import transformers
import logging
from transformers import TFAutoModelForTokenClassification, AutoTokenizer, pipeline, TFRobertaForSequenceClassification, RobertaTokenizer
import tensorflow as tf
import ekstraktor
import warnings
import webbrowser
from threading import Timer


app = Flask(__name__)
CORS(app)

transformers.logging.set_verbosity_error()
logging.getLogger('tensorflow').setLevel(logging.ERROR)
warnings.filterwarnings("ignore", category=ResourceWarning)

# Define the directory to save PDF files
SAVE_DIRECTORY = 'pdfFile'
os.makedirs(SAVE_DIRECTORY, exist_ok=True)

# Database configuration
print("Connecting to database...")
app.config['SQLALCHEMY_DATABASE_URI'] = 'postgresql://ananthayullian:1234@db:5432/classification_db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)

# Define the ClassificationResult model
class ClassificationResult(db.Model):
    __tablename__ = 'classification_result'
    id = db.Column(db.Integer, primary_key=True)
    text = db.Column(db.Text, nullable=False)
    predicted_category = db.Column(db.Text, nullable=True)
    corrected_category = db.Column(db.Text, nullable=True)
    validated_category = db.Column(db.Text, nullable=True)

print("Database connected successfully...")

# Define the paths for saving/loading
ner_model_path = "pretrainedModel/BERT"
ner_tokenizer_path = "pretrainedModel/BERT"
classification_model_path = "pretrainedModel/ROBERTA"
classification_tokenizer_path = "pretrainedModel/ROBERTA"

# NER model setup
print("Loading NER model...")
id2label = {0: 'B-CRD', 1: 'B-DAT', 2: 'B-EVT', 3: 'B-FAC', 4: 'B-GPE', 5: 'B-LAN', 6: 'B-LAW', 7: 'B-LOC', 8: 'B-MON', 9: 'B-NOR', 10: 'B-ORD', 11: 'B-ORG', 12: 'B-PER', 13: 'B-PRC', 14: 'B-PRD', 15: 'B-QTY', 16: 'B-REG', 17: 'B-TIM', 18: 'B-WOA', 19: 'I-CRD', 20: 'I-DAT', 21: 'I-EVT', 22: 'I-FAC', 23: 'I-GPE', 24: 'I-LAN', 25: 'I-LAW', 26: 'I-LOC', 27: 'I-MON', 28: 'I-NOR', 29: 'I-ORD', 30: 'I-ORG', 31: 'I-PER', 32: 'I-PRC', 33: 'I-PRD', 34: 'I-QTY', 35: 'I-REG', 36: 'I-TIM', 37: 'I-WOA', 38: 'O'}
label2id = {v: k for k, v in id2label.items()}

# Load or save the NER model and tokenizer
try:
    verificationModel = TFAutoModelForTokenClassification.from_pretrained(ner_model_path, num_labels=39, id2label=id2label, label2id=label2id)
    tokenizer = AutoTokenizer.from_pretrained(ner_tokenizer_path)
    print("NER model loaded successfully from local storage.")
except:
    pretrainedBert = 'indolem/indobert-base-uncased'
    verificationModel = TFAutoModelForTokenClassification.from_pretrained(pretrainedBert, num_labels=39, id2label=id2label, label2id=label2id, from_pt=True)
    tokenizer = AutoTokenizer.from_pretrained(pretrainedBert)
    verificationModel.save_pretrained(ner_model_path)
    tokenizer.save_pretrained(ner_tokenizer_path)
    print("NER model downloaded and saved locally.")

verificationModel.load_weights("NER-INDO/INDO-NER-weights")

# Classification model setup
print("Loading classification model...")
try:
    recomendationModel = TFRobertaForSequenceClassification.from_pretrained(classification_model_path, num_labels=13)
    roberta_tokenizer = RobertaTokenizer.from_pretrained(classification_tokenizer_path)
    print("Classification model loaded successfully from local storage.")
except:
    pretrainedRoberta = 'cahya/roberta-base-indonesian-522M'
    recomendationModel = TFRobertaForSequenceClassification.from_pretrained(pretrainedRoberta, num_labels=13)
    roberta_tokenizer = RobertaTokenizer.from_pretrained(pretrainedRoberta)
    recomendationModel.save_pretrained(classification_model_path)
    roberta_tokenizer.save_pretrained(classification_tokenizer_path)
    print("Classification model downloaded and saved locally.")

recomendationModel.load_weights('SavedWeight/Roberta Retrain Weight Run 1.1')

category_mapping = {
    0: {"category": "Kategori 1", "detail_category":"Pasal 9 ayat (2) UU Nomor 14 Tahun 2008", "pasal": "Informasi yang Wajib Disediakan dan Diumumkan Secara Berkala", "informasi": "INFORMASI YANG WAJIB DISEDIAKAN DAN DIUMUMKAN"},
    1: {"category": "Kategori 10", "detail_category":"Pasal 17 poin g UU Nomor 14 Tahun 2008", "pasal": "Informasi Publik yang apabila dibuka dapat mengungkapkan isi akta otentik yang bersifat pribadi dan kemauan terakhir ataupun wasiat seseorang", "informasi": "INFORMASI YANG DIKECUALIKAN"},
    2: {"category": "Kategori 11", "detail_category":"Pasal 17 poin h UU Nomor 14 Tahun 2008", "pasal": "Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik dapat mengungkap rahasia pribadi", "informasi": "INFORMASI YANG DIKECUALIKAN"},
    3: {"category": "Kategori 12", "detail_category":"Pasal 17 poin i UU Nomor 14 Tahun 2008", "pasal": "Memorandum atau surat-surat antar Badan Publik atau intra Badan Publik, yang menurut sifatnya dirahasiakan kecuali atas putusan Komisi Informasi atau pengadilan", "informasi": "INFORMASI YANG DIKECUALIKAN"},
    4: {"category": "Kategori 13", "detail_category":"Pasal 17 poin j UU Nomor 14 Tahun 2008", "pasal": "Informasi yang tidak boleh diungkapkan berdasarkan Undang-Undang", "informasi": "INFORMASI YANG DIKECUALIKAN"},
    5: {"category": "Kategori 2", "detail_category":"Pasal 10 ayat (1) UU Nomor 14 Tahun 2008", "pasal": "Informasi yang Wajib Diumumkan secara Serta-merta", "informasi": "INFORMASI YANG WAJIB DISEDIAKAN DAN DIUMUMKAN"},
    6: {"category": "Kategori 3", "detail_category":"Pasal 11 ayat (1) UU Nomor 14 Tahun 2008", "pasal": "Informasi yang Wajib Tersedia Setiap Saat", "informasi": "INFORMASI YANG WAJIB DISEDIAKAN DAN DIUMUMKAN"},
    7: {"category": "Kategori 4", "detail_category":"Pasal 17 poin a UU Nomor 14 Tahun 2008", "pasal": "Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik dapat menghambat proses penegakan hukum", "informasi": "INFORMASI YANG DIKECUALIKAN"},
    8: {"category": "Kategori 5", "detail_category":"Pasal 17 poin b UU Nomor 14 Tahun 2008", "pasal": "Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik dapat mengganggu kepentingan perlindungan hak atas kekayaan intelektual dan perlindungan dari persaingan usaha tidak sehat", "informasi": "INFORMASI YANG DIKECUALIKAN"},
    9: {"category": "Kategori 6", "detail_category":"Pasal 17 poin c UU Nomor 14 Tahun 2008", "pasal": "Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik dapat membahayakan pertahanan dan keamanan negara", "informasi": "INFORMASI YANG DIKECUALIKAN"},
    10: {"category": "Kategori 7", "detail_category":"Pasal 17 poin d UU Nomor 14 Tahun 2008", "pasal": "Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik dapat mengungkapkan kekayaan alam Indonesia", "informasi": "INFORMASI YANG DIKECUALIKAN"},
    11: {"category": "Kategori 8", "detail_category":"Pasal 17 poin e UU Nomor 14 Tahun 2008", "pasal": "Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik, dapat merugikan ketahanan ekonomi nasional", "informasi": "INFORMASI YANG DIKECUALIKAN"},
    12: {"category": "Kategori 9", "detail_category":"Pasal 17 poin f UU Nomor 14 Tahun 2008", "pasal": "Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik, dapat merugikan kepentingan hubungan luar negeri", "informasi": "INFORMASI YANG DIKECUALIKAN"}
}

with app.app_context():
    db.create_all()

def classify_texts(kalimat):
    inputs = roberta_tokenizer(kalimat, padding=True, truncation=True, return_tensors="tf")
    outputs = recomendationModel(inputs.data)
    predictions = tf.nn.softmax(outputs.logits, axis=-1)
    predicted_classes = tf.argmax(predictions, axis=1).numpy()
    predicted_categories = [category_mapping[pred]['category'] for pred in predicted_classes]
    predicted_detail_categories = [category_mapping[pred]['detail_category'] for pred in predicted_classes]
    predicted_pasals = [category_mapping[pred]['pasal'] for pred in predicted_classes]
    predicted_informasi = [category_mapping[pred]['informasi'] for pred in predicted_classes]
    return predicted_categories, predicted_detail_categories, predicted_pasals, predicted_informasi, predictions.numpy()

# Route for serving the index.html
@app.route('/')
@app.route('/index')
def index():
    print("Index route accessed")
    return render_template('index.html')

# Additional routes for serving other HTML files
@app.route('/validasi-data')
def validasi():
    return render_template('validasi.html')

@app.route('/verifikasi-dokumen')
def verifikasi():
    return render_template('verifikasi.html')

# API to get all validation data
@app.route('/api/validasi-data', methods=['GET'])
def api_validasi_data():
    results = ClassificationResult.query.filter(
        ClassificationResult.corrected_category.isnot(None),
        ClassificationResult.validated_category.is_(None)
    ).all()
    result_data = [
        {
            "id": result.id,
            "text": result.text,
            "corrected_category": result.corrected_category
        }
        for result in results
    ]
    return jsonify(result_data)

# API for document verification
@app.route('/api/extract', methods=['POST'])
def api_extract_text():
    if 'pdf_file' not in request.files:
        return jsonify({'error': 'No file in request!'}), 400

    pdf_file = request.files['pdf_file']
    if pdf_file.filename == '':
        return jsonify({'error': 'No file selected!'}), 400
    if not pdf_file.filename.endswith('.pdf'):
        return jsonify({'error': 'File is not a PDF!'}), 400

    text = ''
    with pdfplumber.open(io.BytesIO(pdf_file.read())) as pdf:
        for page_num in range(min(2, len(pdf.pages))):
            page = pdf.pages[page_num]
            text += page.extract_text() + '\n'

    if not text.strip():
        return jsonify({'error': 'PDF contains no text!'}), 200

    # Extract fields with regex (combining patterns)
    nomor_match = re.search(r'(Nomor Registrasi|Nomor)\s*[:;]?\s*([0-9A-Z\/\-]+)', text, re.DOTALL)
    pemohon_match = re.search(r'diajukan\s+oleh\s*:(?P<captured_text>.*?)\bPemohon\b', text, re.DOTALL | re.IGNORECASE)
    termohon_match = re.search(r'\bTerhadap\b(?P<captured_text>.*?)\bTermohon\b', text, re.DOTALL | re.IGNORECASE)
    
    nomor = nomor_match.group(2).strip() if nomor_match else "Not found"
    nomor = re.sub(r'\s+', '', nomor)

    identitas_pemohon = ' '.join(pemohon_match.group('captured_text').split()) if pemohon_match else "Not found"
    identitas_termohon = ' '.join(termohon_match.group('captured_text').split()) if termohon_match else "Not found"

    # Use NER pipeline if needed
    classifier = pipeline("ner", tokenizer=tokenizer, model=verificationModel)
    pemohon = classifier(identitas_pemohon)
    termohon = classifier(identitas_termohon)

    # Extract using ekstraktor.py functions
    names = ekstraktor.extract_names(pemohon)
    nama = ' '.join(names)
    organizations = ekstraktor.extract_organization(termohon)
    organisasi = ' '.join(organizations)

    return jsonify({'Nomor': nomor, 'Pemohon': nama, 'Termohon': organisasi}), 200

# API to classify text
@app.route('/api/classify', methods=['POST'])
def classify():
    data = request.json
    text = data.get('text')
    predicted_categories, predicted_detail_categories, predicted_pasals, predicted_informasi, _ = classify_texts([text])
    
    result = {
        "text": text,
        "predicted_category": predicted_categories[0],
        "predicted_detail_category": predicted_detail_categories[0],
        "predicted_pasal": predicted_pasals[0],
        "informasi": predicted_informasi[0]
    }
    
    return jsonify(result)

# API to confirm classification
@app.route('/api/confirm', methods=['POST'])
def api_confirm():
    data = request.json
    text = data.get('text')
    predicted_category = data.get('predicted_category')

    classification_result = ClassificationResult(
        text=text,
        predicted_category=predicted_category
    )
    db.session.add(classification_result)
    db.session.commit()

    return jsonify({"message": "Classification confirmed and saved successfully!"})

# API to correct classification
@app.route('/api/correct', methods=['POST'])
def api_correct():
    data = request.json
    text = data.get('text')
    corrected_category_index = int(data.get('corrected_category'))
    corrected_category = category_mapping[corrected_category_index]['category']

    classification_result = ClassificationResult(
        text=text,
        corrected_category=corrected_category
    )
    db.session.add(classification_result)
    db.session.commit()

    return jsonify({"message": "Correction saved successfully!"})

# API to validate corrected data
@app.route('/api/validate', methods=['POST'])
def api_validate():
    for item_id, validated_category in request.form.items():
        result = ClassificationResult.query.get(item_id)
        if result:
            result.validated_category = validated_category
            db.session.commit()
    return jsonify({"message": "Validation successful!"})

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=3001)

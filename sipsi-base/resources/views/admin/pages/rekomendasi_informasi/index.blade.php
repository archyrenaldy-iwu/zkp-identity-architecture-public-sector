@extends('admin.layouts.master') @section('title', 'Konsultasi Perkara Sengketa')
@section('content')

<!-- Breadcrumbs -->
{{ Breadcrumbs::render('rekomendasi_informasi') }}

<!-- header -->
<h1
    class="max-w-lg mt-5 text-primary text-3xl font-semibold font-lato leading-[39px]"
>
    Konsultasi Perkara Sengketa
</h1>

<!-- data section -->
<div class="block max-w-full mt-5 min-h-[59vh] rounded-xl bg-gray-200">
    <div class="flex">
        <input
            id="classifyText"
            type="text"
            class="shadow border rounded-tl-xl w-full py-3 px-4 text-gray-900 placeholder-gray-900 leading-tight bg-gray-400 focus:outline-none focus:shadow-outline"
            placeholder="Konsultasikan masalah anda..."
        />
        <button
            class="bg-primary text-white px-8 py-3 rounded-tr-xl"
            onclick="classifyText(event)"
        >
            Kirim
        </button>
    </div>
    <!-- Data akan dimasukkan di sini melalui JavaScript -->
    <div id="result"></div>
</div>

<div class="fixed z-50 inset-0 overflow-y-auto hidden" id="correctModal">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-black opacity-50"></div>
        </div>

        <div
            class="inline-block border-2 border-primary rounded-xl text-left overflow-hidden shadow-xl transform transition-all w-[50vw]"
        >
            <div class="bg-white px-5 py-4 relative">
                <!-- Tombol "X" -->
                <button
                    class="absolute top-4 right-4 text-primary hover:opacity-75"
                    onclick="closeModal()"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>

                <div class="flex flex-col">
                    <div class="mt-3 text-primary">
                        <h3
                            class="text-2xl font-semibold leading-6 font-medium"
                            id="correctModalLabel"
                        >
                            Koreksi Kategori
                        </h3>
                        <div class="mt-5 w-full">
                            <form onsubmit="correctClassification(event)">
                                <label
                                    for="corrected_category"
                                    class="block text-sm font-medium"
                                    >Kategori:</label
                                >
                                <select
                                    id="corrected_category"
                                    name="corrected_category"
                                    class="mt-1 block w-full text-base border-primary focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md"
                                >
                                    <optgroup label="INFORMASI YANG WAJIB DISEDIAKAN DAN DIUMUMKAN">
                                        <option value="0">Kategori 1 — Informasi yang Wajib Disediakan dan Diumumkan Secara Berkala</option>
                                        <option value="5">Kategori 2 — Informasi yang Wajib Diumumkan secara Serta-merta</option>
                                        <option value="6">Kategori 3 — Informasi yang Wajib Tersedia Setiap Saat</option>
                                    </optgroup>
                                    <optgroup label="INFORMASI YANG DIKECUALIKAN">
                                        <option value="7">Kategori 4 — Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik dapat menghambat proses penegakan hukum</option>
                                        <option value="8">Kategori 5 — Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik dapat mengganggu kepentingan perlindungan hak atas kekayaan intelektual dan perlindungan dari persaingan usaha tidak sehat</option>
                                        <option value="9">Kategori 6 — Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik dapat membahayakan pertahanan dan keamanan negara</option>
                                        <option value="10">Kategori 7 — Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik dapat mengungkapkan kekayaan alam Indonesia</option>
                                        <option value="11">Kategori 8 — Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik, dapat merugikan ketahanan ekonomi nasional</option>
                                        <option value="12">Kategori 9 — Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik, dapat merugikan kepentingan hubungan luar negeri</option>
                                        <option value="1">Kategori 10 — Informasi Publik yang apabila dibuka dapat mengungkapkan isi akta otentik yang bersifat pribadi dan kemauan terakhir ataupun wasiat seseorang</option>
                                        <option value="2">Kategori 11 — Informasi Publik yang apabila dibuka dan diberikan kepada Pemohon Informasi Publik dapat mengungkap rahasia pribadi</option>
                                        <option value="3">Kategori 12 — Memorandum atau surat-surat antar Badan Publik atau intra Badan Publik, yang menurut sifatnya dirahasiakan kecuali atas putusan Komisi Informasi atau pengadilan</option>
                                        <option value="4">Kategori 13 — Informasi yang tidak boleh diungkapkan berdasarkan Undang-Undang</option>
                                    </optgroup>
                                </select>
                                <br />
                                <div class="flex justify-center">
                                    <input
                                        type="submit"
                                        value="Simpan"
                                        class="bg-primary hover:opacity-75 hover:cursor-pointer text-white px-4 py-2 rounded shadow"
                                    />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('prepend-script')
<script>
    // Definisikan base URL dari ENV
    const aiServiceUrl = "{{ config('services.ai_service_url') }}";

    function joinUrl(base, path) {
        return base.replace(/\/+$/, '') + '/' + path.replace(/^\/+/, '');
    }

    function classifyText(event) {
        event.preventDefault();
        const text = $("#classifyText").val();
        const url = joinUrl(aiServiceUrl, 'api/classify');
        console.log(url);
        $.ajax({
            url: url,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                text: text,
            }),
            success: function (data) {
                if (text === "") {
                    showNotificationError("Isi input terlebihi dahulu");
                    return null;
                }

                const resultDiv = $("#result");
                resultDiv.append(`
                <div class="p-5 mt-3">
                    <h5 class="text-xl font-bold text-primary" id="text">Hasil: ${data.text}</h5>
                    <p class="mt-3 text-primary">
                        Prediksi Kategori: <span class="font-semibold">${data.predicted_category}</span><br>
                        Prediksi Detail Kategori: <span class="font-semibold">${data.predicted_detail_category}</span><br>
                        Prediksi Pasal: <span class="font-semibold">${data.predicted_pasal}</span><br>
                        Informasi: <span class="font-semibold">${data.informasi}</span>
                    </p>
                    <div class="mt-5 space-x-2">
                        <button
                            class="bg-primary hover:opacity-75 text-white px-4 py-2 rounded shadow"
                            onclick="confirmClassification('${data.text}', '${data.predicted_category}', '${data.predicted_detail_category}', '${data.predicted_pasal}', '${data.informasi}')"
                        >
                            Konfirmasi
                        </button>
                        <button
                            class="bg-primary hover:opacity-75 text-white px-4 py-2 rounded shadow"
                            onclick="openCorrectModal()"
                        >
                            Koreksi
                        </button>
                    </div>
                </div>
            `);
                $("#corrected_category").val(data.predicted_category);

                showNotificationSuccess("Sukses menambah data");
            },
            error: function (error) {
                let errors = error.responseJSON;
                let errorMessage = "";
                $.each(errors.errors, function (key, value) {
                    errorMessage += value + "<br>";
                });

                showNotificationError(errorMessage);
            },
        });
    }

    function openCorrectModal() {
        document.getElementById("correctModal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("correctModal").classList.add("hidden");
    }

    function confirmClassification(
        text,
        predictedCategory,
        predictedDetailCategories,
        predictedPasal,
        informasi
    ) {
        const url = joinUrl(aiServiceUrl, 'api/confirm');
        $.ajax({
            url: url,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                text: text,
                predicted_category: predictedCategory,
                predicted_detail_categories: predictedDetailCategories,
                predicted_pasal: predictedPasal,
                informasi: informasi,
            }),
            success: function (data) {
                showNotificationSuccess(data.message);
                clearResult();
            },
            error: function (error) {
                let errors = error.responseJSON;
                let errorMessage = "";
                $.each(errors.errors, function (key, value) {
                    errorMessage += value + "<br>";
                });

                showNotificationError(errorMessage);
            },
        });
    }

    function correctClassification(event) {
        event.preventDefault();

        const text = $("#text").text().replace("Hasil: ", ""); // Mengambil teks dan menghilangkan kata "Hasil: "
        const correctedCategory = $("#corrected_category").val();
        const url = joinUrl(aiServiceUrl, 'api/correct');

        $.ajax({
            url: url,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                text: text, // menggunakan teks yang diambil dari elemen <h5>
                corrected_category: correctedCategory,
            }),
            success: function (data) {
                console.log(data);
                console.log(text); // memeriksa nilai text yang dikirim
                showNotificationSuccess(data.message);
                clearResult();
            },
            error: function (error) {
                console.log(error);
                let errors = error.responseJSON;
                let errorMessage = "";
                $.each(errors.errors, function (key, value) {
                    errorMessage += value + "<br>";
                });

                showNotificationError(errorMessage);
            },
        });
    }

    function clearResult() {
        document.getElementById("result").innerHTML = "";
        closeModal();
    }
</script>
@endpush @endsection

@extends('admin.layouts.master') @section('title', 'Validasi Informasi')
@section('content')

<!-- Breadcrumbs -->
{{ Breadcrumbs::render('validasi_informasi') }}

<!-- header -->
<h1
    class="max-w-lg mt-5 text-primary text-3xl font-semibold font-lato leading-[39px]"
>
    Validasi Informasi
</h1>

<!-- data section -->
<div
    id="data-container"
    class="block max-w-full mt-5 min-h-[59vh] rounded-xl bg-gray-200"
>
    <!-- Data akan dimasukkan di sini melalui JavaScript -->
</div>

@push('prepend-script')
<script>
    document.addEventListener("DOMContentLoaded", function () {

        // Definisikan base URL dari ENV
        const aiServiceUrl = "{{ config('services.ai_service_url') }}";
        
        function joinUrl(base, path) {
            return base.replace(/\/+$/, '') + '/' + path.replace(/^\/+/, '');
        }

        let url = joinUrl(aiServiceUrl, 'api/validasi-data');

        // Fetch data from API
        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                let dataContainer = document.getElementById("data-container");
                let htmlContent = '<form id="validasi-data-form">';

                data.forEach(function (item) {
                    htmlContent += `
                        <div id="${
                            item.id
                        }" class="text-primary border-b border-gray-400">
                            <div class="m-8 mb-5">
                                <p class="text-lg font-bold mb-2">${
                                    item.text
                                }</p>
                                <p class="text-lg mb-3">
                                    Koreksi Kategori :
                                    <span class="ms-20">
                                        <select name="${
                                            item.id
                                        }" class="bg-transparent border-0 text-lg">
                                            ${[...Array(13)]
                                                .map(
                                                    (_, i) =>
                                                        `<option value="Kategori ${
                                                            i + 1
                                                        }" ${
                                                            item.corrected_category ===
                                                            `Kategori ${i + 1}`
                                                                ? "selected"
                                                                : ""
                                                        }>Kategori ${
                                                            i + 1
                                                        }</option>`
                                                )
                                                .join("")}
                                        </select>
                                    </span>
                                </p>
                            </div>
                        </div>`;
                });

                htmlContent += `
                    <button
                        type="submit"
                        class="m-8 bg-primary w-28 text-white text-center py-2 rounded hover:opacity-75 transition"
                    >
                        Konfirmasi
                    </button>
                </form>`;
                dataContainer.innerHTML = htmlContent;

                // Form submission handler
                document
                    .getElementById("validasi-data-form")
                    .addEventListener("submit", function (event) {
                        event.preventDefault();
                        const formData = new FormData(event.target);
                        const url = joinUrl(aiServiceUrl, 'api/validate');

                        fetch(url, {
                            method: "POST",
                            body: formData,
                        })
                            .then((response) => response.json())
                            .then((data) => {
                                alert(data.message);
                                window.location.reload();
                            })
                            .catch((error) => {
                                let errors = error.responseJSON;
                                let errorMessage = "";
                                $.each(errors.errors, function (key, value) {
                                    errorMessage += value + "<br>";
                                });

                                hideProgressPasswordChange();
                                showNotificationError(errorMessage);
                            });
                    });
            })
            .catch((error) => {
                let errors = error.responseJSON;
                let errorMessage = "";
                $.each(errors.errors, function (key, value) {
                    errorMessage += value + "<br>";
                });

                showNotificationError(errorMessage);
            });
    });
</script>
@endpush @endsection

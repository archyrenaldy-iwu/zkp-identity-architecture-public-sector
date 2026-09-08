@extends('admin.layouts.master') @section('title', 'Informasi Akun')
@section('content')
<!-- Breadcrumb -->
{{ Breadcrumbs::render('informasi') }}

{{-- Header informasi akun --}}
<div
    class="block max-w-full mt-5 p-3 pb-2 border text-white border-gray-200 rounded-lg shadow bg-themecolor-primary"
>
    <div class="flex flex-col md:flex-row m-5 gap-10">
        <div class="flex flex-col">
            <img
                class="w-32 rounded-full ring-2 ring-themecolor-primary"
                src="{{ asset('img/icons/avatar-1.png') }}"
                alt="user photo"
            />
        </div>
        <div class="flex flex-col justify-center">
            <p class="text-xl lg:text-3xl font-bold" id="name">-</p>
            <p class="mt-5 text-xl lg:text-2xl" id="informasi-alamat-email">
                -
            </p>
            <p class="text-xl lg:text-2xl" id="role">-</p>
        </div>
    </div>

    <div class="flex gap-14 mt-10">
        <button
            class="text-white font-light flex flex-col items-center"
            id="tab-informasi-akun"
        >
            <p>Informasi Akun</p>
            <div
                class="tab-indicator w-full h-1 bg-white rounded-full"
                id="indicator-informasi-akun"
            ></div>
        </button>
        <button
            class="text-white font-light flex flex-col items-center"
            id="tab-ganti-email"
        >
            <p>Ganti Email</p>
            <div
                class="tab-indicator hidden w-full h-1 bg-white rounded-full"
                id="indicator-ganti-email"
            ></div>
        </button>
        <button
            class="text-white font-light flex flex-col items-center"
            id="tab-ganti-password"
        >
            <p>Ganti Password</p>
            <div
                class="tab-indicator hidden w-full h-1 bg-white rounded-full"
                id="indicator-ganti-password"
            ></div>
        </button>
    </div>
</div>

<!-- tab content for informasi akun-->
<div
    id="content-informasi-akun"
    class="block tab-content max-w-full mt-2 p-3 pb-2 border text-accent border-gray-200 rounded-lg shadow bg-themecolor-secondary"
>
    <form id="edit-informasi-akun-form">
        <div class="flex flex-col gap-4 m-5">
            <div class="flex flex-row justify-between max-w-xl informasi-akun">
                <p>Nama Lengkap</p>
                <p class="editable w-56" id="informasi-nama-lengkap">-</p>
            </div>
            <div class="flex flex-row justify-between max-w-xl informasi-akun">
                <p>Nomor Identitas</p>
                <p class="editable w-56" id="informasi-nomor-identitas">-</p>
            </div>
            <div class="flex flex-row justify-between max-w-xl informasi-akun">
                <p>Tanggal Lahir</p>
                <p class="editable w-56" id="informasi-tanggal-lahir">-</p>
            </div>
            <div class="flex flex-row justify-between max-w-xl informasi-akun">
                <p>Jenis Kelamin</p>
                <p class="editable w-56" id="informasi-jenis-kelamin">-</p>
            </div>
            <div class="flex flex-row justify-between max-w-xl informasi-akun">
                <p>Alamat Lengkap</p>
                <p class="editable w-56" id="informasi-alamat-lengkap">-</p>
            </div>
            <div class="flex flex-row justify-between max-w-xl informasi-akun">
                <p>No.HP</p>
                <p class="editable w-56" id="informasi-no-hp">-</p>
            </div>
        </div>

        <!-- button action -->
        <div class="flex gap-2 justify-end">
            <button
                type="button"
                id="edit-informasi-akun"
                class="bg-primary text-white w-36 text-center py-2 rounded hover:opacity-75 transition"
            >
                Edit
            </button>
            <button
                type="button"
                id="cancel-edit-informasi-akun"
                class="bg-primary hidden text-white w-36 text-center py-2 rounded hover:opacity-75 transition"
            >
                Cancel
            </button>
            <button
                type="button"
                id="open-modal-konfirmasi-edit"
                class="bg-primary hidden text-white w-36 text-center py-2 rounded hover:opacity-75 transition"
            >
                Simpan
            </button>
        </div>
        <!-- modal confirmation edit informasi akun -->
        <div
            id="confirm-edit-modal"
            data-modal-placement="bottom-right"
            tabindex="-1"
            aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
        >
            <div class="relative p-6 w-full max-w-3xl max-h-full">
                <!-- Modal content -->
                <div
                    class="relative bg-red-100 rounded-lg shadow-lg p-8 text-center min-h-[350px] border-2 border-themecolor-primary"
                >
                    <!-- Modal body -->
                    <div class="flex flex-col items-center">
                        <div
                            class="bg-themecolor-primary rounded-full p-4 mb-4"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                class="bi bi-check w-12 h-12 text-white"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"
                                />
                            </svg>
                        </div>
                        <p
                            class="text-xl font-semibold text-gray-800 mb-4 mt-8"
                        >
                            Anda yakin untuk mengedit informasi akun?
                        </p>
                        <div class="flex gap-5">
                            <a
                                href="#"
                                data-modal-hide="email-modal"
                                type="button"
                                class="text-themecolor-primary bg-white hover:opacity-75 focus:ring-4 focus:outline-none mt-10 focus:ring-red-300 font-medium rounded-lg text-base px-6 py-3 transition"
                            >
                                Batal
                            </a>
                            <button
                                id="simpan-informasi-akun"
                                type="submit"
                                class="text-white bg-themecolor-primary hover:bg-red-700 focus:ring-4 focus:outline-none mt-10 focus:ring-red-300 font-medium rounded-lg text-base px-6 py-3 transition"
                            >
                                Yakin
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- tab content ganti email -->
<div
    id="content-ganti-email"
    class="block tab-content hidden max-w-full mt-2 p-3 pb-2 border text-accent border-gray-200 rounded-lg shadow bg-themecolor-secondary"
>
    <form id="change-email-form" class="flex flex-col gap-4 m-5">
        @csrf
        <div class="flex flex-row justify-between md:w-[80%] items-center">
            <label for="old_email">Email Lama *</label>
            <input
                required
                type="email"
                id="old_email"
                name="old_email"
                class="border-accent rounded-xl w-[80%] bg-transparent"
                placeholder="Input your old email"
            />
        </div>
        <div class="flex flex-row justify-between md:w-[80%] items-center">
            <label for="new_email">Email Baru *</label>
            <input
                required
                type="email"
                id="new_email"
                name="new_email"
                class="border-accent rounded-xl w-[80%] bg-transparent"
                placeholder="Input your new email"
            />
        </div>
        <button
            type="submit"
            id="btn-change-email"
            class="ml-auto bg-primary text-white w-36 text-center py-2 rounded hover:opacity-75 transition"
        >
            Simpan
        </button>
    </form>
</div>

<!-- tab content ganti-password -->
<div
    id="content-ganti-password"
    class="block tab-content hidden max-w-full mt-2 p-3 pb-2 border text-accent border-gray-200 rounded-lg shadow bg-themecolor-secondary"
>
    <form id="change-password-form" class="flex flex-col gap-4 m-5">
        @csrf
        <div class="flex flex-row justify-between items-center relative">
            <label for="old_password">Kata Sandi Lama *</label>
            <input
                required
                type="password"
                id="old_password"
                name="old_password"
                class="border-accent rounded-xl w-[75%] bg-transparent pr-10"
                placeholder="Input your old password"
            />
            <span class="absolute right-3 cursor-pointer toggle-password">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-eye-slash-fill"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"
                    />
                    <path
                        d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"
                    />
                </svg>
            </span>
        </div>
        <div class="flex flex-row justify-between items-center relative">
            <label for="new_password">Kata Sandi Baru *</label>
            <input
                required
                type="password"
                id="new_password"
                name="new_password"
                class="border-accent rounded-xl w-[75%] bg-transparent pr-10"
                placeholder="Input your new password"
            />
            <span class="absolute right-3 cursor-pointer toggle-password">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-eye-slash-fill"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"
                    />
                    <path
                        d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"
                    />
                </svg>
            </span>
        </div>
        <div class="flex flex-row justify-between items-center relative">
            <label for="confirm_password">Konfirmasi Sandi Baru *</label>
            <input
                required
                type="password"
                id="confirm_password"
                name="confirm_password"
                class="border-accent rounded-xl w-[75%] bg-transparent pr-10"
                placeholder="Confirm your new password"
            />
            <span class="absolute right-3 cursor-pointer toggle-password">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-eye-slash-fill"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"
                    />
                    <path
                        d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"
                    />
                </svg>
            </span>
        </div>
        <div class="flex items-center">
            <p class="text-xs">
                Gunakan kombinasi huruf kecil, huruf besar dan angka atau
                karakter untuk kata sandi yang lebih aman
            </p>
            <button
                type="submit"
                id="btn-change-password"
                class="ml-auto bg-primary text-white w-36 text-center py-2 rounded hover:opacity-75 transition"
            >
                Simpan
            </button>
        </div>
    </form>
</div>

<!-- modal email for edit -->
<div
    id="email-modal"
    data-modal-placement="bottom-right"
    tabindex="-1"
    aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
>
    <div class="relative p-6 w-full max-w-3xl max-h-full">
        <!-- Modal content -->
        <div
            class="relative bg-red-100 rounded-lg shadow-lg p-8 text-center min-h-[350px] border-2 border-themecolor-primary"
        >
            <!-- Modal body -->
            <div class="flex flex-col items-center">
                <div class="bg-themecolor-primary rounded-full p-4 mb-4">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        class="bi bi-envelope w-12 h-12 text-white"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"
                        />
                    </svg>
                </div>
                <p class="text-xl font-semibold text-gray-800 mb-4 mt-8">
                    Hubungi email:
                    <span class="underline"
                        >sekretariat@komisiinformasi.go.id</span
                    >
                    untuk edit informasi akun
                </p>
                <a
                    href="#"
                    data-modal-hide="email-modal"
                    type="button"
                    class="text-white bg-themecolor-primary hover:bg-red-700 focus:ring-4 focus:outline-none mt-10 focus:ring-red-300 font-medium rounded-lg text-base px-6 py-3"
                >
                    Tutup
                </a>
            </div>
        </div>
    </div>
</div>

<!-- confirm change email modal -->
<div
    id="confirm-email-change-modal"
    data-modal-placement="bottom-right"
    tabindex="-1"
    aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
>
    <div class="relative p-6 w-full max-w-3xl max-h-full">
        <!-- Modal content -->
        <div
            class="relative bg-red-100 rounded-lg shadow-lg p-8 text-center min-h-[350px] border-2 border-themecolor-primary"
        >
            <!-- Modal body -->
            <div class="flex flex-col items-center">
                <div class="bg-themecolor-primary rounded-full p-4 mb-4">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        class="bi bi-envelope w-12 h-12 text-white"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"
                        />
                    </svg>
                </div>
                <p
                    class="text-xl font-semibold text-gray-800 mb-4 mt-8"
                    id="confirmation-email-change"
                ></p>
                <a
                    href="#"
                    data-modal-hide="confirm-email-change-modal"
                    type="button"
                    class="text-white bg-themecolor-primary hover:bg-red-700 focus:ring-4 focus:outline-none mt-10 focus:ring-red-300 font-medium rounded-lg text-base px-6 py-3"
                >
                    Tutup
                </a>
            </div>
        </div>
    </div>
</div>

@push('prepend-script')
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
<script>
    $(document).ready(function () {
        // user role will initialize later
        let isUserInternal;

        //-----------------------------
        //  Get informasi akun
        //-----------------------------
        let url = "{{ route('auth.user') }}";
        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            success: function (response) {
                $("#name").text(response.data.name);
                $("#informasi-nama-lengkap").text(response.data.name);
                $("#informasi-alamat-email").text(response.data.email);

                // check data if user pemohon
                if (response.data.user_pemohon !== null) {
                    $("#informasi-nomor-identitas").text(
                        response.data.user_pemohon.nomor_identitas
                    );
                    $("#informasi-tanggal-lahir").text(
                        formatDate(response.data.user_pemohon.tanggal_lahir)
                            .replace(/pukul.*$/, "")
                            .trim()
                    );
                    $("#informasi-alamat-lengkap").text(
                        response.data.user_pemohon.alamat
                    );
                    $("#informasi-no-hp").text(
                        response.data.user_pemohon.no_hp
                    );

                    // set jenis kelamin
                    let jenisKelamin;
                    if (response.data.user_pemohon.jenis_kelamin === "L") {
                        jenisKelamin = "Laki-Laki";
                    } else {
                        jenisKelamin = "Perempuan";
                    }

                    $("#informasi-jenis-kelamin").text(jenisKelamin);

                    // set user role
                    isUserInternal = false;
                    $("#role").text("Pemohon");
                } else {
                    $("#informasi-nomor-identitas").text(
                        response.data.user_internal.nomor_identitas
                    );
                    $("#informasi-tanggal-lahir").text(
                        formatDate(response.data.user_internal.tanggal_lahir)
                            .replace(/pukul.*$/, "")
                            .trim()
                    );

                    $("#informasi-alamat-lengkap").text(
                        response.data.user_internal.alamat
                    );
                    $("#informasi-no-hp").text(
                        response.data.user_internal.no_hp
                    );

                    // set jenis kelamin
                    let jenisKelamin;
                    if (response.data.user_internal.jenis_kelamin === "L") {
                        jenisKelamin = "Laki-Laki";
                    } else {
                        jenisKelamin = "Perempuan";
                    }

                    $("#informasi-jenis-kelamin").text(jenisKelamin);

                    // set user role
                    isUserInternal = true;
                    $("#role").text("Admin");
                }
            },
            error: function (response) {
                let errors = response.responseJSON;
                let errorMessage = "";
                $.each(errors.errors, function (key, value) {
                    errorMessage += value + "<br>";
                });
                showNotificationError(errorMessage);
            },
        });

        //-----------------------------
        //  Event handler for tabs
        //-----------------------------
        $("#tab-informasi-akun").click(() => {
            $(".tab-content").addClass("hidden"); // hide all tab content
            $("#content-informasi-akun").removeClass("hidden");

            $(".tab-indicator").addClass("hidden"); // hide all tab indicator
            $("#indicator-informasi-akun").removeClass("hidden");
        });

        $("#tab-ganti-email").click(() => {
            $(".tab-content").addClass("hidden");
            $("#content-ganti-email").removeClass("hidden");

            $(".tab-indicator").addClass("hidden");
            $("#indicator-ganti-email").removeClass("hidden");
        });

        $("#tab-ganti-password").click(() => {
            $(".tab-content").addClass("hidden");
            $("#content-ganti-password").removeClass("hidden");

            $(".tab-indicator").addClass("hidden");
            $("#indicator-ganti-password").removeClass("hidden");
        });

        //-----------------------------
        //  Event handler for password toggle
        //-----------------------------
        const toggleIcons = document.querySelectorAll(".toggle-password");
        toggleIcons.forEach((icon) => {
            icon.addEventListener("click", function () {
                const inputField = icon.previousElementSibling;
                if (inputField.type === "password") {
                    inputField.type = "text";
                    icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                    </svg>`;
                } else {
                    inputField.type = "password";
                    icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                            <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                            <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                                    </svg>`;
                }
            });
        });

        //-----------------------------
        //  Event handler to open edit informasi akun form.
        //-----------------------------
        $("#edit-informasi-akun").click(function () {
            // check if user internal/admin
            if (isUserInternal) {
                // change all p element to input
                $(".editable").each(function () {
                    let currentText = $(this).text().trim();
                    let id = $(this).attr("id");

                    // Check if currentText is a valid date
                    let inputValue = currentText;

                    let inputField;

                    // if input informasi tanggal lahir, then format it
                    if (id === "informasi-tanggal-lahir") {
                        inputField = $("<input>", {
                            type: "text",
                            class: "editable-input border-accent rounded-xl bg-transparent w-[60%]",
                            value: inputValue,
                            required: true,
                            id: id,
                            "data-original-text": currentText,
                        });

                        new Datepicker(inputField[0], {
                            format: "yyyy-mm-dd",
                            autohide: true,
                            buttons: true,
                            autoSelectToday: true,
                            orientation: "top",
                        });

                        // Parse the current text as a date to set the input value correctly
                        let dateObj = new Date(currentText);
                        if (!isNaN(dateObj.getTime())) {
                            // Check if valid date
                            let year = dateObj
                                .getFullYear()
                                .toString()
                                .padStart(4, "0");
                            let month = (dateObj.getMonth() + 1)
                                .toString()
                                .padStart(2, "0");
                            let day = dateObj
                                .getDate()
                                .toString()
                                .padStart(2, "0");
                            inputValue = `${year}-${month}-${day}`;
                        } else {
                            inputValue = ""; // Reset if not a valid date
                        }
                        inputField.val(inputValue);
                    } else if (id === "informasi-jenis-kelamin") {
                        // create select field for gender
                        inputField = $("<select>", {
                            class: "editable-input border-accent rounded-xl bg-transparent w-[60%]",
                            required: true,
                            id: id,
                            "data-original-text": currentText,
                        });

                        // create options for select field
                        let options = [
                            { value: "L", text: "Laki-laki" },
                            { value: "P", text: "Perempuan" },
                        ];

                        options.forEach((option) => {
                            let optionElement = $("<option>", {
                                value: option.value,
                                text: option.text,
                                selected: option.text === currentText,
                            });
                            inputField.append(optionElement);
                        });
                    } else {
                        inputField = $("<input>", {
                            type: "text",
                            class: "editable-input border-accent rounded-xl bg-transparent w-[60%]",
                            value: inputValue,
                            required: true,
                            id: id,
                            "data-original-text": currentText,
                        });
                    }

                    $(this).replaceWith(inputField);
                });

                // hide and show the buttons
                $("#edit-informasi-akun").hide();
                $("#simpan-informasi-akun").show();
                $("#cancel-edit-informasi-akun").show();
                $("#open-modal-konfirmasi-edit").show();
            } else {
                let modalElement = "";
                let modal = "";
                modalElement = document.getElementById("email-modal");

                modal = new Modal(modalElement);

                const closeModalButtons =
                    modalElement.querySelectorAll("[data-modal-hide]");

                closeModalButtons.forEach(function (button) {
                    button.addEventListener("click", function () {
                        modal.hide();
                    });
                });

                modal.show();
            }
        });

        // cancel click button
        $("#cancel-edit-informasi-akun").click(function () {
            // change back input to text
            $(".editable-input").each(function () {
                let originalText = $(this).data("original-text");
                let id = $(this).attr("id");
                let paragraph = $("<p>", {
                    class: "editable w-56",
                    text: originalText,
                    id: id,
                });
                $(this).replaceWith(paragraph);
            });

            $("#edit-informasi-akun").show();
            $("#simpan-informasi-akun").hide();
            $("#cancel-edit-informasi-akun").hide();
            $("#open-modal-konfirmasi-edit").hide();
        });

        //-----------------------------
        //  Ganti email form
        //-----------------------------
        $("#change-email-form").submit(function (e) {
            e.preventDefault();
            let url = "{{ route('auth.change-email') }}";

            // get form data
            let formData = {
                old_email: $("#old_email").val(),
                new_email: $("#new_email").val(),
            };

            showProgressEmailChange();

            // ajax request
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    // show modal email confirmation
                    let modalElement = "";
                    let modal = "";
                    modalElement = document.getElementById(
                        "confirm-email-change-modal"
                    );

                    modal = new Modal(modalElement);
                    $("#confirmation-email-change").text(response.message);

                    const closeModalButtons =
                        modalElement.querySelectorAll("[data-modal-hide]");

                    closeModalButtons.forEach(function (button) {
                        button.addEventListener("click", function () {
                            modal.hide();
                        });
                    });

                    modal.show();

                    hideProgressEmailChange();

                    // reset the form
                    $("#change-email-form")[0].reset();
                },
                // ini form ganti email mas
                error: function (response) {
                    let errors = response.responseJSON;
                    let errorMessage = "";
                    $.each(errors.errors, function (key, value) {
                        errorMessage += value + "<br>";
                    });

                    hideProgressEmailChange();
                    showNotificationError(errorMessage);
                },
            });
        });

        //-----------------------------
        //  Ganti password  form
        //-----------------------------
        $("#change-password-form").submit(function (e) {
            e.preventDefault();
            let url = "{{ route('auth.change-password') }}";

            let formData = {
                old_password: $("#old_password").val(),
                new_password: $("#new_password").val(),
                confirm_password: $("#confirm_password").val(),
            };

            // Validasi password
            var passwordReg =
                /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[`~!@#$%^&*()_+\-={}\[\]|\\;',./:"<>?])[A-Za-z\d`~!@#$%^&*()_+\-={}\[\]|\\;',./:"<>?]{6,}$/;

            if (!passwordReg.test(formData.new_password)) {
                showNotificationError(
                    "Harap password, Minimal Terdiri Dari 6 Karakter,Minimal Terdiri Dari 1 Angka,Minimal Terdapat 1 karakter Huruf Kapital,Minimal 1 Special Karakter."
                );
                return; // Stop form submission
            }

            showProgressPasswordChange();

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    // reset the form
                    $("#change-password-form")[0].reset();

                    hideProgressPasswordChange();

                    showNotificationSuccess(response.message);
                },
                error: function (response) {
                    let errors = response.responseJSON;
                    let errorMessage = "";
                    $.each(errors.errors, function (key, value) {
                        errorMessage += value + "<br>";
                    });

                    hideProgressPasswordChange();
                    showNotificationError(errorMessage);
                },
            });
        });

        //-----------------------------
        //  open modal konfirmasi edit
        //-----------------------------
        $("#open-modal-konfirmasi-edit").click(function () {
            let modalElement = "";
            let modal = "";
            modalElement = document.getElementById("confirm-edit-modal");

            modal = new Modal(modalElement);

            const closeModalButtons =
                modalElement.querySelectorAll("[data-modal-hide]");

            closeModalButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    modal.hide();
                });
            });

            modal.show();
        });

        //-----------------------------
        //  edit informasi akun  form submit
        //-----------------------------
        $("#edit-informasi-akun-form").submit(function (e) {
            e.preventDefault();
            let url = "{{ route('auth.update-user') }}";

            let formData = {
                name: $("#informasi-nama-lengkap").val(),
                no_hp: $("#informasi-no-hp").val(),
                tanggal_lahir: $("#informasi-tanggal-lahir").val(),
                nomor_identitas: $("#informasi-nomor-identitas").val(),
                alamat: $("#informasi-alamat-lengkap").val(),
                jenis_kelamin: $("#informasi-jenis-kelamin").val(),
            };

            showProgressInformationChange();

            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: formData,
                success: function (response) {
                    // Replace each input with a paragraph
                    $(".editable-input").each(function () {
                        let id = $(this).attr("id");
                        let newValue = $(this).val(); // Get the current value from input

                        // Create a new paragraph element
                        let paragraph = $("<p>", {
                            class: "editable w-56",
                            id: id,
                            text:
                                id === "informasi-tanggal-lahir"
                                    ? formatDate(newValue)
                                          .replace(/pukul.*$/, "")
                                          .trim()
                                    : newValue,
                        });

                        // Replace the input with the paragraph
                        $(this).replaceWith(paragraph);
                    });

                    $("#edit-informasi-akun").show();
                    $("#simpan-informasi-akun").hide();
                    $("#cancel-edit-informasi-akun").hide();
                    $("#open-modal-konfirmasi-edit").hide();

                    // Update the UI in the header
                    $("#name").text(formData.name);

                    // set jenis kelamin text
                    let jenisKelamin;
                    if (formData.jenis_kelamin === "L") {
                        jenisKelamin = "Laki-Laki";
                    } else {
                        jenisKelamin = "Perempuan";
                    }

                    $("#informasi-jenis-kelamin").text(jenisKelamin);

                    // hide confirmation modal
                    let modalElement = "";
                    let modal = "";
                    modalElement =
                        document.getElementById("confirm-edit-modal");

                    modal = new Modal(modalElement);

                    modal.hide();

                    hideProgressInformationChange();

                    // Show success toast
                    showNotificationSuccess(response.message);
                },
                error: function (response) {
                    let errors = response.responseJSON;
                    let errorMessage = "";
                    $.each(errors.errors, function (key, value) {
                        errorMessage += value + "<br>";
                    });

                    hideProgressInformationChange();
                    showNotificationError(errorMessage);
                },
            });
        });
    });

    function showProgressPasswordChange() {
        $("#btn-change-password").html(
            `
                <svg aria-hidden="true"
                                class="inline w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
            `
        );
    }

    function hideProgressPasswordChange() {
        $("#btn-change-password").html(`Simpan`);
    }

    function showProgressEmailChange() {
        $("#btn-change-email").html(
            `
                <svg aria-hidden="true"
                                class="inline w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
            `
        );
    }

    function hideProgressEmailChange() {
        $("#btn-change-email").html(`Simpan`);
    }

    function showProgressInformationChange() {
        $("#simpan-informasi-akun").html(
            `
                <svg aria-hidden="true"
                                class="inline w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
            `
        );
    }

    function hideProgressInformationChange() {
        $("#simpan-informasi-akun").html(`Yakin`);
    }
</script>
@endpush @endsection

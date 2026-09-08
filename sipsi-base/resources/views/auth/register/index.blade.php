@extends('layouts.front.app')
@section('title')
    Daftar
@endsection
@section('content')
    <form class="lg:px-48 px-20 mx-auto my-12 lg:my-16" id="frm_daftar">
        @csrf
        <div class="text-center">
            <div class="font-bold text-primary text-4xl">DAFTAR</div>
        </div>

        <div class="font-semibold font-l mt-10">Informasi Akun</div>
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 gap-y-4 items-center justify-center mt-4">
            <div>
                <select name="jenis_pemohon" id="jenis_pemohon" onchange="onJenisPemohonChange(this);clearError(this)"
                    class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                    required>
                    <option selected value=""> JENIS PEMOHON *</option>
                    <option value="PERORANGAN">PERORANGAN</option>
                    <option value="LEMBAGA">LEMBAGA</option>
                    <option value="KELOMPOK ORANG">KELOMPOK ORANG</option>
                </select>
                <p id="error_jenis_pemohon" class="error text-sm text-red-600 dark:text-red-500"></p>
            </div>
            <div>
                <input type="text" name="name" id="name" onkeydown="clearError(this)"
                    class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                    placeholder="NAMA LENGKAP *" required="" />
                <p id="error_name" class="error text-sm text-red-600 dark:text-red-500"></p>
            </div>
            <div>
                <select name="jenis_identitas" id="jenis_identitas" disabled
                    onchange="onJenisIdentitasChange(this);clearError(this)"
                    class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                    required>
                    <option value="" selected>JENIS IDENTITAS *</option>
                </select>
                <p id="error_jenis_identitas" class="error text-sm text-red-600 dark:text-red-500"></p>
            </div>
            <div>
                <input type="text" name="nomor_identitas" id="nomor_identitas" onkeydown="clearError(this)"
                    class="bg-white border  border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                    placeholder="NOMOR IDENTITAS *" required="" />
                <p id="error_nomor_identitas" class="error text-sm text-red-600 dark:text-red-500"></p>
            </div>
            <div>
                <input type="text" name="alamat" id="alamat" onkeydown="clearError(this)"
                    class="bg-white border  border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                    placeholder="ALAMAT *" required="" />
                <p id="error_alamat" class="error text-sm text-red-600 dark:text-red-500"></p>
            </div>
            <div>
                <select name="jenis_kelamin" id="jenis_kelamin" onchange="clearError(this)"
                    class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary hidden w-full p-2.5">
                    <option value="" selected>JENIS KELAMIN *</option>
                    <option value="L">LAKI-LAKI</option>
                    <option value="P">PEREMPUAN</option>
                </select>
                <p id="error_jenis_kelamin" class="error text-sm text-red-600 dark:text-red-500"></p>
            </div>
        </div>
        <div class="font-semibold font-l mt-10">Kontak dan Password</div>
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 gap-y-4 items-center justify-center mt-4">
            <div>
                <input type="email" name="email" id="email" onkeydown="clearError(this)"
                    class="bg-white border  border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                    placeholder="EMAIL *" required="" />
                <p id="error_email" class="error text-sm text-red-600 dark:text-red-500"></p>
            </div>
            <div>
                <input type="number" name="no_hp" id="no_hp" onkeydown="clearError(this)"
                    class="bg-white border  border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                    placeholder="NOMOR TELPON / WHATSAPP *" required="" />
                <p id="error_no_hp" class="error text-sm text-red-600 dark:text-red-500"></p>
            </div>
            <div>
                <div class="relative">
                    <input type="password" name="password" id="password" onkeydown="clearError(this)"
                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 pr-10"
                        placeholder="PASSWORD *" required="" />
                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer toggle-password">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#AE0008"
                            viewBox="0 0 16 16">
                            <path
                                d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z" />
                            <path
                                d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z" />
                        </svg>
                    </span>
                </div>
                <p id="error_password" class="error text-sm text-red-600 dark:text-red-500"></p>
            </div>
            <div>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        onkeydown="clearError(this)"
                        class="bg-white border  border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 pr-10"
                        placeholder="ULANGI PASSWORD *" required="" />
                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer toggle-password">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#AE0008"
                            viewBox="0 0 16 16">
                            <path
                                d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z" />
                            <path
                                d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z" />
                        </svg>
                    </span>
                </div>
                <p id="error_password_confirmation" class="error text-sm text-red-600 dark:text-red-500"></p>
            </div>

        </div>

        <div class="w-full md:w-1/2 bg-white rounded-[15px] shadow-inner border-2 border-primary my-5">
            <div class="py-2 px-4">
                <div class="text-neutral-800 text-xs font-semibold font-lato mb-2">Disarankan Membuat Password
                    Yang Aman</div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:gap-x-16 md:gap-x-8 gap-y-2 items-center">
                    <div class="text-primary text-xs font-semibold font-lato">*Minimal Terdiri Dari 6
                        Karakter</div>
                    <div class="text-primary text-xs font-semibold font-lato">*Minimal Terdiri Dari 1
                        Angka</div>
                    <div class="text-primary text-xs font-semibold font-lato">*Minimal Terdapat 1 karakter
                        Huruf Kapital</div>
                    <div class="text-primary text-xs font-semibold font-lato">*Minimal 1 Special Karakter
                    </div>
                </div>
            </div>
        </div>

        <button type="reset"
            class="w-xl text-primary bg-white border border-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
            Reset
        </button>
        <button type="submit" id="btn_submit"
            class="w-xl text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
            Daftar
        </button>
        <button id="btn_loading" hidden
            class="w-xl text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
            <div role="status">
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
                <span class="sr-only">Loading...</span>
            </div>
        </button>
    </form>

    @push('js')
        <script>
            var identitasLembaga = {
                'value': 'SK Kemenkumham',
                'text': 'SK Kemenkumham'
            };

            var listIdentitasPerorangan = [{
                'value': 'KTP',
                'text': 'KTP'
            }, {
                'value': 'SIM',
                'text': 'SIM'
            }, {
                'value': 'PASPOR',
                'text': 'PASPOR'
            }];

            var listIdentitasKelompok = [{
                'value': 'SK Kemenkumham',
                'text': 'SK Kemenkumham'
            }, {
                'value': 'Akta Pendirian',
                'text': 'Akta Pendirian'
            }];

            $(document).ready(function() {
                $("#btn_submit").click(function(e) {
                    e.preventDefault();

                    var validate = validateForm();

                    // console.log($('#frm_daftar').serialize());

                    if (validate.length == 0) {
                        showButtonProgress();

                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            data: $('#frm_daftar').serialize(),
                            url: "{{ route('auth.register') }}",
                            success: function(response) {
                                // console.log(response)
                                window.location.href =
                                    "{{ route('daftar_sukses') }}";
                                // hideButtonProgress();

                            },
                            error: function(response) {
                                var errors = response.responseJSON;
                                var errorMessage = errors.message + '<br>';
                                $.each(errors.errors, function(key,
                                    value) {
                                    errorMessage += value + '<br>'
                                })
                                hideButtonProgress();
                                showNotificationError(errorMessage)
                            }
                        });
                    }

                });
            });

            //-----------------------------
            //  Event handler for password toggle
            //-----------------------------
            const toggleIcons = document.querySelectorAll(".toggle-password");
            toggleIcons.forEach((icon) => {
                icon.addEventListener("click", function() {
                    const inputField = icon.previousElementSibling;
                    if (inputField.type === "password") {
                        inputField.type = "text";
                        icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#AE0008" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                    </svg>`;
                    } else {
                        inputField.type = "password";
                        icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#AE0008" viewBox="0 0 16 16">
                                            <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                            <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                                    </svg>`;
                    }
                });
            });

            function validateForm() {
                var nameReg = /^[A-Za-z]+$/;
                var numberReg = /^[0-9]+$/;
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                var passwordReg =
                    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[`~!@#$%^&*()_+\-={}\[\]|\\;',./:"<>?])[A-Za-z\d`~!@#$%^&*()_+\-={}\[\]|\\;',./:"<>?]{6,}$/;
                var email = $('#email');
                var password = $('#password');
                var password_confirmation = $('#password_confirmation');
                var name = $('#name');
                var alamat = $('#alamat');
                var no_hp = $('#no_hp');
                var jenis_identitas = $('#jenis_identitas');
                var jenis_pemohon = $('#jenis_pemohon');
                var nomor_identitas = $('#nomor_identitas');
                var jenis_kelamin = $('#jenis_kelamin');

                var arrayBool = [];

                if (email.val() == "") {
                    $('#error_email').text('Email tidak boleh kosong');
                    arrayBool.push(true);
                } else if (!emailReg.test(email.val())) {
                    $('#error_email').text('Email tidak sesuai');
                    arrayBool.push(true);
                } else {
                    $('#error_email').text('');
                }

                if (password.val() == "") {
                    $('#error_password').text('Password tidak boleh kosong');
                    arrayBool.push(true);
                } else if (!passwordReg.test(password.val())) {
                    $('#error_password').text('Harap password mengikuti saran yang sudah ditetapkan');
                    arrayBool.push(true);
                } else {
                    $('#error_password').text('');
                }

                if (password_confirmation.val() == "") {
                    $('#error_password_confirmation').text('Konfirmasi Password tidak boleh kosong');
                    arrayBool.push(true);
                } else if (password_confirmation.val() != password.val()) {
                    $('#error_password_confirmation').text('Konfirmasi Password tidak sama');
                    arrayBool.push(true);
                } else {
                    $('#error_password_confirmation').text('');
                }

                if (name.val() == "") {
                    $('#error_name').text('Nama tidak boleh kosong');
                    arrayBool.push(true);
                } else {
                    $('#error_name').text('');
                }

                if (alamat.val() == "") {
                    $('#error_alamat').text('Alamat tidak boleh kosong');
                    arrayBool.push(true);
                } else {
                    $('#error_alamat').text('');
                }

                if (jenis_pemohon.val() == 'PERORANGAN') {
                    if (jenis_kelamin.val() == "") {
                        $('#error_jenis_kelamin').text('jenis kelamin tidak boleh kosong');
                        arrayBool.push(true);
                    } else {
                        $('#error_jenis_kelamin').text('');
                    }
                }


                if (no_hp.val() == "") {
                    $('#error_no_hp').text('Nomor Handphone tidak boleh kosong');
                    arrayBool.push(true);
                } else if (!numberReg.test(no_hp.val())) {
                    $('#error_no_hp').text('Nomor Handphone hanya boleh angka');
                    arrayBool.push(true);
                } else {
                    $('#error_no_hp').text('');
                }

                if (jenis_identitas.val() == "") {
                    $('#error_jenis_identitas').text('Jenis Identitas tidak boleh kosong');
                    arrayBool.push(true);
                } else {
                    $('#error_jenis_identitas').text('');
                }

                if (jenis_pemohon.val() == "") {
                    $('#error_jenis_pemohon').text('Jenis Pemohon tidak boleh kosong');
                    arrayBool.push(true);
                } else {
                    $('#error_jenis_pemohon').text('');
                }

                if (nomor_identitas.val() == "") {
                    $('#error_nomor_identitas').text('Nomor Identitas tidak boleh kosong');
                    arrayBool.push(true);
                } else {
                    $('#error_nomor_identitas').text('');
                }

                if (jenis_identitas.val() === "KTP") {
                    if (nomor_identitas.val().length != 16) {
                        $('#error_nomor_identitas').text('Nomor KTP harus terdiri dari 16 digit');
                        arrayBool.push(true);
                    } else {
                        $('#error_nomor_identitas').text('');
                    }
                } else if (jenis_identitas.val() === "SIM") {
                    if (nomor_identitas.val().length < 12) {
                        $('#error_nomor_identitas').text('Nomor SIM minimal harus terdiri dari 12 digit');
                        arrayBool.push(true);
                    } else {
                        $('#error_nomor_identitas').text('');
                    }
                }

                return arrayBool;
            }


            function onJenisPemohonChange(input) {
                $('#jenis_identitas').empty();
                hideJenisKelamin();

                if (input.value != '') {
                    if (input.value == 'LEMBAGA') {
                        $('#jenis_identitas').append($('<option>', {
                            value: identitasLembaga.value,
                            text: identitasLembaga.text
                        }));

                        hideJenisKelamin();

                    } else if (input.value == 'PERORANGAN') {
                        $.each(listIdentitasPerorangan, function(i, item) {
                            $('#jenis_identitas').append($('<option>', {
                                value: item.value,
                                text: item.text
                            }));
                        });

                        showJenisKelamin();
                    } else {
                        $.each(listIdentitasKelompok, function(i, item) {
                            $('#jenis_identitas').append($('<option>', {
                                value: item.value,
                                text: item.text
                            }));
                        });

                        // showJenisKelamin();
                    }

                    $('#jenis_identitas').removeAttr('disabled');
                }
            }

            function onJenisIdentitasChange(input) {
                if (input.value == 'SK Kemenkumham' || input.value == 'Akta Pendirian') {
                    hideJenisKelamin();
                } else {
                    showJenisKelamin();
                }
            }

            function showJenisKelamin() {
                $('#jenis_kelamin').removeClass('hidden');
                // $('#jenis_kelamin').attr('required', true);
            }

            function hideJenisKelamin() {
                $('#jenis_kelamin').addClass('hidden');
                $('#error_jenis_kelamin').text('');
                // $('#jenis_kelamin').attr('required', false);
            }

            function showButtonProgress() {
                $('#btn_loading').removeAttr('hidden');
                $('#btn_submit').attr('hidden', true);
            }

            function hideButtonProgress() {
                $('#btn_submit').removeAttr('hidden');
                $('#btn_loading').attr('hidden', true);
            }

            function clearError(input) {
                $('#error_' + input.id).text('');
            }
        </script>
    @endpush
@endsection

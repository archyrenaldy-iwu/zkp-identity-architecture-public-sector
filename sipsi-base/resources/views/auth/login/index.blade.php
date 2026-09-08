@extends('layouts.front.app')
@section('title')
    Masuk
@endsection
@section('content')
    <section class="bg-gray-50">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-secondary rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:border-gray-700">
                <div class="bg-primary flex-row rounded-md">
                    <div class="py-5">
                        <h1 class="text-xl font-lato font-bold leading-tight  text-center text-white md:text-2xl uppercase">
                            Komisi Informasi Pusat
                        </h1>
                        <h1 class="text-xl font-bold  leading-tight  text-center text-white md:text-2xl uppercase">
                            Republik Indonesia
                        </h1>
                    </div>
                </div>
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <form class="space-y-4 md:space-y-6" id="frm_login">
                        {{-- <form method="GET" class="space-y-4 md:space-y-6" action="{{ route('admin.beranda') }}"> --}}
                        @csrf
                        <div>
                            {{-- <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label> --}}
                            <input type="email" name="username" id="username" onkeydown="clearError(this)"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Email" required="" />
                            <p id="error_username" class="error text-sm text-red-600 dark:text-red-500"></p>
                        </div>
                        <div>
                            {{-- <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label> --}}
                            <div class="relative">
                                <input type="password" name="password" id="password" placeholder="Kata Sandi"
                                    onkeydown="clearError(this)"
                                    class="bg-gray-50 border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 pr-10"
                                    required="" />
                                <span
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer toggle-password">
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

                            <div class="mt-3">
                                <div class="flex justify-center space-x-2 items-center">
                                    <img id="captchaImage" src="{{ captcha_src() }}" alt="CAPTCHA Code">
                                    <button type="button" onclick="reloadCaptcha()"
                                        class="inline-flex items-center px-4 py-2 bg-themecolor-primary  text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                        </svg>

                                    </button>
                                    <input type="text" name="captcha" id="captcha" onkeydown="clearError(this)"
                                        class="w-full bg-white border  text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block p-2.5"
                                        placeholder="Captcha" required="" />
                                    <p id="error_captcha" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>
                            <!-- End Checkbox -->
                        </div>

                        <div class="text-center">
                            <button type="submit" id="btn_submit"
                                class="w-full text-white bg-primary hover:bg-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                                Masuk
                            </button>

                            <button id="btn_loading" hidden
                                class="w-full text-white bg-primary hover:bg-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
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


                            <div class="my-4">
                                <div style="height: 2px; width: 65px"
                                    class="inline-block mx-auto mb-1 bg-gray-700 rounded-md">
                                </div>
                                <div class="inline-block text-gray-700 font-semibold text-sm">
                                    Atau
                                </div>
                                <div style="height: 2px; width: 65px"
                                    class="inline-block mx-auto mb-1 bg-gray-700 rounded-md">
                                </div>
                            </div>


                            <a href="{{ route('cari_akun') }}"
                                class="text-sm font-medium text-primary hover:underline block dark:text-primary">Lupa
                                Kata Sandi?</a>

                            <p class="text-sm font-medium text-gray-600">
                                Belum punya akun ?
                                <a href="{{ route('register') }}"
                                    class="font-medium text-primary hover:underline dark:text-primary">Daftar</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    @push('js')
        <script>
            //var local = false; //! Kalo mau jalanin di local ini di true kan saja

            $(document).ready(function() {
                $("#btn_submit").click(function(e) {
                    e.preventDefault();

                    var validate = validateForm();

                    urlLogin = "{{ route('auth.login') }}";

                    if (validate.length == 0) {
                        showButtonProgress();

                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            data: $('#frm_login').serialize(),
                            url: urlLogin,
                            success: function(response) {
                                // console.log(response)

                                window.location.href =
                                    "{{ route('admin.beranda') }}";
                                // hideButtonProgress();

                            },
                            error: function(response) {
                                var errors = response.responseJSON;
                                var errorMessage = errors.message;
                                if (errorMessage != "The given data was invalid.") {
                                    errorMessage += '<br>';
                                    $.each(errors.errors, function(key,
                                        value) {
                                        errorMessage += value + '<br>'
                                    })
                                } else {
                                    errorMessage = "Captcha yang anda masukkan salah"
                                }

                                hideButtonProgress();
                                showNotificationError(errorMessage)

                            },
                            complete: function(response) {
                                reloadCaptcha()
                            }
                        });
                    }

                });
            });

            const toggleIcon = document.querySelector(".toggle-password");
            toggleIcon.addEventListener("click", function() {
                const inputField = toggleIcon.previousElementSibling;
                if (inputField.type === "password") {
                    inputField.type = "text";
                    toggleIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#AE0008" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                    </svg>`;
                } else {
                    inputField.type = "password";
                    toggleIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#AE0008" viewBox="0 0 16 16">
                                            <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                            <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                                    </svg>`;
                }
            });


            function validateForm() {
                var nameReg = /^[A-Za-z]+$/;
                var numberReg = /^[0-9]+$/;
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                var passwordReg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{6,}$/;

                var username = $('#username');
                var password = $('#password');
                var captcha = $('#captcha');
                // var g_recaptcha_response = $('#g-recaptcha-response');


                var arrayBool = [];

                if (username.val() == "") {
                    $('#error_username').text('username tidak boleh kosong');
                    arrayBool.push(true);
                } else {
                    $('#error_username').text('');
                }

                if (password.val() == "") {
                    $('#error_password').text('Password tidak boleh kosong');
                    arrayBool.push(true);
                } else {
                    $('#error_password').text('');
                }

                if (captcha.val() == "") {
                    showNotificationError("Captcha harus di isi")
                    arrayBool.push(true);
                }

                // if (!local) {

                //     // if (g_recaptcha_response.val() == "") {
                //     //     showNotificationError("Captcha harus di isi")
                //     //     arrayBool.push(true);
                //     // }
                // }

                return arrayBool;
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

            function reloadCaptcha() {
                var url =
                    "{{ route('get-captcha') }}";

                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(data) {
                        $('#captchaImage').attr('src', data.imageUrl);
                        $('#captcha').val(''); // Clear the input field
                    }
                });
            }
        </script>
    @endpush
@endsection

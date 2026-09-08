@extends('auth.lupa_password.index')
@section('title')
    Ganti Kata Sandi
@endsection
@section('desc')
    <div class="text-center mb-2 text-neutral-800 text-[20px] font-normal  px-12">
        Ganti Kata Sandi</div>
    <div class="text-center text-neutral-800 text-[15px] font-normal  px-12">
        Silahkan masukan kata sandi baru anda</div>
@endsection
@section('form')
    <form class="space-y-4 md:space-y-6" id="frm_ganti_sandi">
        @csrf
        <div>
            <input type="email" name="email" id="email" placeholder="Email"
                value="{{ request()->segment(count(request()->segments())) }}"
                class="bg-gray-50 border hidden border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary w-full p-2.5" />
            <input type="text" name="token" id="token" placeholder="token" value="{{ request()->token }}"
                class="bg-gray-50 border hidden border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary w-full p-2.5" />
            <input type="password" name="password" id="password" placeholder="Kata Sandi Baru" onkeydown="clearError(this)"
                class="bg-gray-50 border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                required="" />
            <p id="error_password" class="error text-sm text-red-600 dark:text-red-500"></p>
        </div>
        <div>
            <input type="password" name="password_confirmation" id="password_confirmation" onkeydown="clearError(this)"
                placeholder="Konfirmasi Kata Sandi Baru"
                class="bg-gray-50 border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                required="" />
            <p id="error_password_confirmation" class="error text-sm text-red-600 dark:text-red-500"></p>
        </div>

        <div class="text-center">
            <div>
                <button type="submit" id="btn_submit"
                    class="w-full text-white bg-primary hover:bg-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                    Simpan
                </button>
                @include('components.button_loading')
            </div>

            <div class="my-4">
                <div style="height: 2px; width: 65px" class="inline-block mx-auto mb-1 bg-gray-700 rounded-md">
                </div>
                <div class="inline-block text-gray-700 font-semibold text-sm">
                    Atau
                </div>
                <div style="height: 2px; width: 65px" class="inline-block mx-auto mb-1 bg-gray-700 rounded-md">
                </div>
            </div>

            <p class="text-sm font-medium text-gray-600">
                Belum punya akun ?
                <a href="{{ route('register') }}"
                    class="font-medium text-primary hover:underline dark:text-primary">Daftar</a>
            </p>
        </div>
    </form>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $("#btn_submit").click(function(e) {
                e.preventDefault();

                var validate = validateForm();

                if (validate.length == 0) {
                    showButtonProgress();

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: $('#frm_ganti_sandi').serialize(),
                        url: "{{ route('auth.reset-password') }}",
                        success: function(response) {
                            showNotificationSuccess(
                                "Password anda berhasil dirubah silahkan untuk login kembali"
                            )
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('login') }}";
                            }, 1500);

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

        function validateForm() {
            var passwordReg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{6,}$/;


            var password = $('#password');
            var password_confirmation = $('#password_confirmation');
            var arrayBool = [];

            if (password.val() == "") {
                $('#error_password').text('Password tidak boleh kosong');
                arrayBool.push(true);
            } else if (!passwordReg.test(password.val())) {
                $('#error_password').text(
                    "Harap password, Minimal Terdiri Dari 6 Karakter,Minimal Terdiri Dari 1 Angka,Minimal Terdapat 1 karakter Huruf Kapital,Minimal 1 Special Karakter"
                );
                arrayBool.push(true);
            } else {
                $('#error_password').text('');
            }

            if (password_confirmation.val() == "") {
                $('#error_password_confirmation').text('Konfirmasi Password tidak boleh kosong');
                arrayBool.push(true);
            } else if (password_confirmation.val() != password.val()) {
                $('#error_password_confirmation').text('Password tidak sesuai');
                arrayBool.push(true);
            } else {
                $('#error_password_confirmation').text('');
            }

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
    </script>
@endsection

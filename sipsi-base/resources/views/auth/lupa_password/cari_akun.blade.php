@extends('auth.lupa_password.index')
@section('title')
    Cari Akun
@endsection
@section('desc')
    <div class="text-center mb-2 text-neutral-800 text-[20px] font-normal px-12">
        Temukan Akun</div>
    <div class="text-center text-neutral-800 text-[15px] font-normal px-12">
        Masukkan email, nomor telepon, atau no. identitas anda dan kami akan mengirimkan tautan untuk
        mengganti kata sandi anda melalui email</div>
@endsection
@section('form')
    <form class="space-y-4 md:space-y-6" id="frm_cari_akun">
        @csrf
        <div>
            {{-- <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label> --}}
            <input type="text" name="data" id="data" onkeydown="clearError(this)"
                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                placeholder="Email, No. Telepon, No. Identitas" required="" />
            <p id="error_data" class="error text-sm text-red-600 dark:text-red-500"></p>
        </div>


        <div class="text-center">
            <div>
                <button type="submit" id="btn_submit"
                    class="w-full text-white bg-primary hover:bg-primary focus:ring-4 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                    Cari Akun
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
                        data: $('#frm_cari_akun').serialize(),
                        url: "{{ route('auth.forgot-password') }}",
                        success: function(response) {
                            // console.log(response)

                            var email = response.data.email;
                            var name = response.data.name;

                            window.location.href = "/verifikasi_email?email=" + email +
                                "&name=" + name;

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

        function validateForm() {
            var data = $('#data');

            var arrayBool = [];

            if (data.val() == "") {
                $('#error_data').text('Email/Nomor Telepon/No Identitas tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_data').text('');
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

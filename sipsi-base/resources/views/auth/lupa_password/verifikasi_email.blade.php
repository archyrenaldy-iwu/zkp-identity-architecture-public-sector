@extends('auth.lupa_password.index')
@section('title')
    Verifikasi Email
@endsection
@section('desc')
    <div class="text-center mb-2 text-neutral-800 text-[20px] font-normal  px-12">
        Apakah benar ini akun anda ?</div>
    <div class="text-center text-neutral-800 text-[15px] font-normal px-8">
        Nama akun anda adalah <span id="fullName" class="font-semibold"></span>, kami telah mengirim tautan ke email
        terdaftar <span id="emailName" class="font-semibold"></span> silahkan periksa
        email anda untuk mengganti kata sandi</div>
@endsection
@section('form')
    <form class="space-y-4 md:space-y-6" id="frm_verifikasi_email" method="GET" action="{{ route('login') }}">
        @csrf
        <div>
            {{-- <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label> --}}
            {{-- <input type="email" name="email" id="email" onkeydown="clearError(this)"
                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                placeholder="Email" required="" />
            <p id="error_email" class="error text-sm text-red-600 dark:text-red-500"></p> --}}
        </div>


        <div class="text-center">
            <div>
                <button type="submit" id="btn_submit"
                    class="w-full text-white bg-primary hover:bg-primary font-medium rounded-lg text-sm px-8 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                    Kembali
                </button>
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
            showNameAndEmail();
        });

        function validateForm() {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

            var email = $('#email');
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

        function showNameAndEmail() {
            let searchParams = new URLSearchParams(window.location.search)
            let email = searchParams.get('email');
            let name = searchParams.get('name');

            $('#emailName').text(email);
            $('#fullName').text(name);
        }
    </script>
@endsection

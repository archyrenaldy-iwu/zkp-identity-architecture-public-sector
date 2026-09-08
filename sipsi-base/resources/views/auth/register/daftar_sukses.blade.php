@extends('layouts.front.app')
@section('title')
    Verifikasi Akun
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
                <div class="space-y-4 md:space-y-6">
                    <div class="flex flex-col justify-center items-center pt-4 pb-8 px-12 space-y-2">
                        <img src="{{ asset('img/icons/check mark circle.png') }}" alt="">
                        <div class="text-center text-neutral-800 text-xl font-bold font-lato">
                            Selamat<br />Akun Anda Telah Terdaftar</div>
                        <div class="text-center text-neutral-800 text-[15px] font-normal font-lato">
                            Silahkan periksa email anda dan konfirmasi akun terlebih dahulu sebelum Masuk ke akun yang sudah
                            di daftarkan</div>

                    </div>
                </div>
                <div class="space-y-4 md:space-y-6">
                    <div class="flex flex-col justify-center items-center pt-4 pb-8 px-12 space-y-2">

                        <a href="{{ route('login') }}"
                            class="w-full text-white bg-primary hover:bg-primary focus:ring-4 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                            Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        @yield('js')
    @endpush
@endsection

@extends('layouts.front.app')
@section('title')
    Beranda
@endsection
@section('content')
    <section id="hero">
        <div class="relative">
            <img src="../img/banner.jpg" class="absolute inset-0 object-cover w-full h-full" alt="" />
            <div class="relative bg-primary bg-opacity-50 shadow-xl">
                <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full  md:px-24 lg:py-44">
                    <div class="xl:items-start lg:px-16">
                        <div class="w-full max-w-screen-xl mb-12 xl:mb-0 xl:pr-16 xl:w-7/12">
                            <h1
                                class=" mb-6 font-lato text-3xl font-bold tracking-tight text-white uppercase sm:text-5xl sm:leading-none">
                                Layanan Sistem <br class="hidden md:block" />
                                Informasi Sengketa
                            </h1>
                            @guest
                                <div class="flex flex-row space-x-6">
                                    <a href="{{ route('login') }}"
                                        class="inline-flex items-center font-lato justify-center h-10 px-6 font-semibold tracking-wide border border-primary text-accent transition duration-200 rounded-xl shadow-md bg-white hover:stroke-white focus:shadow-outline focus:outline-none"
                                        aria-label="Masuk" title="Masuk">
                                        Masuk
                                    </a>
                                    <a href="{{ route('register') }}"
                                        class="inline-flex items-center font-lato justify-center h-10 px-6 font-semibold tracking-wide text-white transition duration-200 rounded-xl shadow-md bg-primary hover:bg-primaryTransparent focus:shadow-outline focus:outline-none"
                                        aria-label="Daftar" title="Daftar">
                                        Daftar
                                    </a>
                                </div>
                                <p class="max-w-xl mb-4 mt-6 text-base font-lato text-white md:text-2xl">
                                    Harap Masuk Sebelum Membuat <br />
                                    Permohonan
                                </p>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="mx-auto lg:max-w-full bg-primary">
            <div class="p-8 rounded shadow-xl sm:p-16">
                <div class="flex flex-col items-center md:flex-row md:px-52">
                    <div class="mb-6 lg:mb-0 lg:w-1/2 lg:pr-5">
                        <h2
                            class="font-lato uppercase text-3xl font-bold tracking-tight text-white sm:text-4xl sm:leading-none">
                            Pengertian
                        </h2>
                    </div>
                    <div class="lg:w-1/2">
                        <p class="font-lato mb-4 text-base text-white text-justify md:max-w-full max-w-xl">
                            Adalah layanan bagi pengguna terdaftar untuk pendaftaran perkara
                            secara online. Mendapatkan pembayaran secara online. Dapat
                            mengetahui detail hasil keputusan sidang yang dimana ditampilkan
                            secara online dan pemanggilan secara elektronik
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-auto lg:max-w-full bg-white">
            <div class="p-8 rounded shadow-md sm:p-16">
                <div class="flex flex-col items-center md:flex-row md:px-52">
                    <div class="mb-6 lg:mb-0 lg:w-1/2 lg:pr-5">
                        <h2
                            class="font-lato uppercase text-3xl font-bold tracking-tight text-primary sm:text-4xl sm:leading-none">
                            Layanan
                        </h2>
                    </div>
                    <div class="lg:w-1/2">
                        <p class="font-lato mb-4 text-base text-primary text-justify md:max-w-full max-w-xl">
                            berikut merupakan layanan dalam pendaftaran sengketa informasi online, pengguna terdaftar harus
                            setelah mendaftar dan mendapatkan akun, harus melelui mekanisme validasi komisioner oleh
                            pengadilan tinggi tempat dimana komisioner disumpah sedangkan pendaftaran perorangan atau badan
                            hukum akan diatur lebih lanjut, berikut merupakan penjelasan singkat pendaftaran online.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="content">
        <div class="px-16 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-36 lg:py-16">
            <div class="grid gap-4 row-gap-5 md:grid-cols-2 lg:grid-cols-2">
                <div
                    class="flex flex-col justify-between p-5 border py-16 rounded-2xl shadow-xl outline outline-gray-400 outline-offset-1 outline-2">
                    <div>
                        <div class="flex items-center mx-auto justify-center w-16 h-16 mb-4 rounded-full">
                            <img src="{{ asset('img/icons/user circle-2.png') }}" alt="" srcset="">
                        </div>
                        <div class="text-center">
                            <h6 class="mb-8 font-lato text-2xl font-semibold leading-6 text-primary">Pengguna Telah <br>
                                Terdaftar
                            </h6>
                            <p class="font-lato text-sm text-primary">
                                Dalam hal ini harus terlebih dahulu terdaftar, sesuai dengan prosedur yang berlaku
                            </p>
                        </div>
                    </div>
                    <!-- <a href="/" aria-label="" class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">Learn more</a> -->
                </div>
                <div
                    class="flex flex-col justify-between p-5 py-16 border rounded-2xl shadow-xl outline outline-gray-400 outline-offset-1 outline-2">
                    <div>
                        <div class="flex items-center mx-auto justify-center w-16 h-16 mb-4 rounded-full">
                            <img src="{{ asset('img/icons/clipboard edit left-2.png') }}" alt="" srcset="">
                        </div>
                        <div class="text-center">
                            <h2 class="mb-8 font-lato text-2xl font-semibold leading-6 text-primary ">Pendaftaran <br>
                                permohonan
                            </h2>
                            <p class="font-lato text-sm text-primary">
                                Dihalaman ini untuk para pengguna yang telah terdaftar dapat langsung mengajukan permohonan
                                mengenai informasi
                            </p>
                        </div>
                    </div>
                    <!-- <a href="/" aria-label="" class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">Learn more</a> -->
                </div>
                {{-- <div
                    class="flex flex-col justify-between p-5 py-16 border rounded-2xl shadow-xl outline outline-gray-400 outline-offset-1 outline-2">
                    <div>
                        <div class="flex items-center mx-auto justify-center w-16 h-16 mb-4 rounded-full">
                            <img src="{{ asset('img/icons/invoice dollar.png') }}" alt="" srcset="">
                        </div>
                        <div class="text-center">
                            <h2 class="mb-8 font-lato text-2xl font-semibold leading-6 text-primary ">Taksiran Panjar<br>
                                Biaya
                            </h2>
                            <p class="font-lato text-sm text-primary">
                                Dihalaman ini untuk para pengguna yang telah terdafatar dapat langsung mengajukan permohonan
                                mengenai informasi
                            </p>
                        </div>
                    </div>
                    <!-- <a href="/" aria-label="" class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">Learn more</a> -->
                </div> --}}
                <div
                    class="flex flex-col justify-between p-5 py-16 border rounded-2xl shadow-xl outline outline-gray-400 outline-offset-1 outline-2">
                    <div>
                        <div class="flex items-center mx-auto justify-center w-16 h-16 mb-4 rounded-full">
                            <img src="{{ asset('img/icons/print alt 9.png') }}" alt="" srcset="">
                        </div>
                        <div class="text-center">
                            <h2 class="mb-8 font-lato text-2xl font-semibold leading-6 text-primary ">Mendapatkan<br>
                                Nomor
                                Sengketa
                            </h2>
                            <p class="font-lato text-sm text-primary">
                                Dihalaman ini untuk para pengguna yang telah terdafatar dapat langsung mengajukan permohonan
                                mengenai informasi
                            </p>
                        </div>
                    </div>
                    <!-- <a href="/" aria-label="" class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">Learn more</a> -->
                </div>
                <div
                    class="flex flex-col justify-between p-5 py-16 border rounded-2xl shadow-xl outline outline-gray-400 outline-offset-1 outline-2">
                    <div>
                        <div class="flex items-center mx-auto justify-center w-16 h-16 mb-4 rounded-full">
                            <img src="{{ asset('img/icons/notification circle.png') }}" alt="" srcset="">
                        </div>
                        <div class="text-center">
                            <h2 class="mb-8 font-lato text-2xl font-semibold leading-6 text-primary ">Pemanggilan Pihak<br>
                                Secara Online
                            </h2>
                            <p class="font-lato text-sm text-primary">
                                Dihalaman ini untuk para pengguna yang telah terdafatar dapat langsung mengajukan permohonan
                                mengenai informasi
                            </p>
                        </div>
                    </div>
                    <!-- <a href="/" aria-label="" class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">Learn more</a> -->
                </div>
                <div
                    class="flex flex-col justify-between p-5 py-16 border rounded-2xl shadow-xl outline outline-gray-400 outline-offset-1 outline-2">
                    <div>
                        <div class="flex items-center mx-auto justify-center w-16 h-16 mb-4 rounded-full">
                            <img src="{{ asset('img/icons/calendar-month.png') }}" alt="" srcset="">
                        </div>
                        <div class="text-center">
                            <h2 class="mb-8 font-lato text-2xl font-semibold leading-6 text-primary ">Jadwal<br>
                                Sidang Online
                            </h2>
                            <p class="font-lato text-sm text-primary">
                                Dihalaman ini menampilkan jadwal sidang yang bisa ditampilkan sesuai keinginan pengguna
                                berdasarkan tanggal dan kategori lainnya
                            </p>
                        </div>
                    </div>
                    <!-- <a href="/" aria-label="" class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">Learn more</a> -->
                </div>
                <div
                    class="flex flex-col justify-between p-5 py-16 border rounded-2xl shadow-xl outline outline-gray-400 outline-offset-1 outline-2">
                    <div>
                        <div class="flex items-center mx-auto justify-center w-16 h-16 mb-4 rounded-full">
                            <img src="{{ asset('img/icons/multi folder.png') }}" alt="" srcset="">
                        </div>
                        <div class="text-center">
                            <h2 class="mb-8 font-lato text-2xl font-semibold leading-6 text-primary ">Salinan Putusan
                                Dalam<br>
                                Bentuk Soft File (PDF)
                            </h2>
                            <p class="font-lato text-sm text-primary">
                                Dihalaman ini untuk para pengguna yang telah terdafatar dapat langsung mengajukan permohonan
                                mengenai informasi
                            </p>
                        </div>
                    </div>
                    <!-- <a href="/" aria-label="" class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">Learn more</a> -->
                </div>
                {{-- <div
                    class="flex flex-col justify-between p-5 py-16 border rounded-2xl shadow-xl outline outline-gray-400 outline-offset-1 outline-2">
                    <div>
                        <div class="flex items-center mx-auto justify-center w-16 h-16 mb-4 rounded-full">
                            <img src="{{ asset('img/icons/create note.png') }}" alt="" srcset="">
                        </div>
                        <div class="text-center">
                            <h2 class="mb-8 font-lato text-2xl font-semibold leading-6 text-primary ">Tanda Tangan
                                Secara<br>
                                Elektronik
                            </h2>
                            <p class="font-lato text-sm text-primary">
                                Dihalaman ini untuk para pengguna yang telah terdafatar dapat langsung mengajukan permohonan
                                mengenai informasi
                            </p>
                        </div>
                    </div>
                    <!-- <a href="/" aria-label="" class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">Learn more</a> -->
                </div> --}}
            </div>
    </section>
    @push('js')
        <script>
            $(document).ready(function() {
                //Get param value
                let searchParams = new URLSearchParams(window.location.search)
                let sectionValue = searchParams.get('section');

                doingScroll(sectionValue)
            });
        </script>
        <script>
            function scrollToSection(event, sectionId) {
                event.preventDefault(); // Prevent default jumping behavior
                doingScroll(sectionId)
            }

            function doingScroll(sectionId) {
                const element = document.getElementById(sectionId);

                if (element) {
                    element.scrollIntoView({
                        behavior: "smooth"
                    });
                }
            }
        </script>
    @endpush
@endsection

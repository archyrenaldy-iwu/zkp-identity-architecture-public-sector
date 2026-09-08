@extends('layouts.front.app')
@section('title')
    Direktori Putusan
@endsection
@section('content')
    <div class="flex flex-col items-center justify-center mx-auto h-screen">
        <div class="flex space-x-2">
            <img class="w-14" src="{{ asset('img/logo2.png') }}" alt="" />
            <div class="inline-block items-center">
                <div>
                    <span class="ml-2 mb-0 text-sm font-bold text-black uppercase font-lato">KOMISI INFORMASI
                        PUSAT</span>
                    <br class="hidden md:block" />
                    <p class="ml-2 mt-0 text-sm font-normal text-black uppercase font-lato">
                        Republik Indonesia
                    </p>
                </div>
            </div>
        </div>
        <div class="mt-6 text-center">
            <span class="md:text-6xl text-3xl font-bold text-primary uppercase font-lato">Halaman Direktori
                Putusan</span>

        </div>
        <div class="md:mt-1 mt-3 text-center">
            <span class="md:text-3xl text-xl font-normal text-primary uppercase font-lato">Sedang dalam tahap
                pengembangan</span>
        </div>
    </div>
@endsection

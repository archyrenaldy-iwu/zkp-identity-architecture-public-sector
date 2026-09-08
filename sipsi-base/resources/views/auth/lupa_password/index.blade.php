@extends('layouts.front.app')
@section('title')
    @yield('title')
@endsection
@section('content')
    <section class="bg-gray-50">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto  md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-[15px] shadow-inner border-2 border-red-700 md:mt-0 sm:max-w-md xl:p-0">
                <div class="py-5 flex justify-center items-center">
                    <img src="{{ asset('img/icons/lock_1.png') }}" alt="">
                </div>

                @yield('desc')

                <div class="px-6 space-y-4 pb-8">
                    @yield('form')
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    @yield('js')
@endpush

@extends('admin.layouts.master')
@section('title', 'Sengketa')
@section('content')
    @php
        $permissions = getPermissionsForActiveRole();
    @endphp
    <!-- Breadcrumb -->
    {{ Breadcrumbs::render('sengketa') }}

    {{-- filter card --}}
    <div class="">
        <div class="mx-auto md:max-w-xl lg:max-w-full rounded schedule-filter-form">
            <div
                class="block max-w-full mt-2 p-6 border text-white border-gray-200 rounded-2xl shadow-2xl bg-themecolor-primary">
                <form id="filter-form" action="#" method="GET">
                    <div class="grid grid-cols-1 lg:grid-cols-12">
                        <div class="lg:col-span-4 p-4 lg:px-0 flex">
                            <div class="grid grid-cols-5 items-center w-full">
                                <div class="col-span-2">
                                    <span class="">Dari Tanggal</span>
                                </div>
                                <div class="col-span-3 text-black ml-2 lg:ml-0">
                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-autohide
                                            datepicker-format="yyyy/mm/dd" type="text" name="start_date"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full lg:w-3/4 ps-9 sm:w-full md:w-full p-2.5"
                                            placeholder="Dari Tanggal">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-4 p-4 lg:px-0 flex items-center">
                            <div class="grid grid-cols-5 items-center w-full">
                                <div class="col-span-2">
                                    <span class="">Sampai Tanggal</span>
                                </div>
                                <div class="col-span-3 text-black ml-2 lg:ml-0">
                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-autohide
                                            datepicker-format="yyyy/mm/dd" type="text" name="to_date"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full lg:w-3/4 sm:w-full md:w-full ps-9 p-2.5"
                                            placeholder="Sampai Tanggal">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-4 p-4 lg:px-0 flex">
                            <div class="grid grid-cols-5 items-center w-full">
                                <div class="col-span-2">
                                    <span class="">Komisi Informasi</span>
                                </div>
                                <div class="col-span-3 text-black ml-2 lg:ml-0">
                                    <select name="id_ki"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-themecolor-primary w-full focus:border-red-800 block sm:w-full ps-4 p-2.5">
                                        <option value="">Pilih Komisi Informasi</option>
                                        @foreach (getListKiConfig() as $ki)
                                            <option value="{{ $ki->id }}">{{ $ki->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-12">
                        <div class="lg:col-span-4 p-4 lg:px-0 flex">
                            <div class="grid grid-cols-5 items-center w-full">
                                <div class="col-span-2">
                                    <span class="">Status Sengketa</span>
                                </div>
                                <div class="col-span-3 text-black ml-2 lg:ml-0">
                                    <select name="status"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-themecolor-primary w-full focus:border-red-800 block lg:w-3/4 sm:w-full ps-4 p-2.5">
                                        <option value="" selected>Pilih Status</option>
                                        @foreach (getListStatusSengketa() as $status)
                                            <option value="{{ $status->id }}">{{ $status->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-4 p-4 lg:px-0 flex items-center">
                            <div class="grid grid-cols-5 items-center w-full">
                                <div class="col-span-2">
                                    <span class="">No. Sengketa</span>
                                </div>
                                <div class="col-span-3 text-black ml-2 lg:ml-0">
                                    <input type="text" name="no_sengketa" id="no_sengketa"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block lg:w-3/4 sm:w-full w-full ps-4 p-2.5"
                                        placeholder="No. Sengketa" />
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-4 p-4 lg:px-0 flex">
                            <div class="grid grid-cols-2 lg:grid-cols-2 items-center w-full gap-4">
                                <div class="col-span-2 lg:col-span-1 hidden lg:inline-block">
                                    <button type="submit"
                                        class="w-full bg-themecolor-primary border-2 text-white rounded-lg px-2.5 py-[7px]">Cari</button>
                                </div>
                                <div class="col-span-2 lg:col-span-1 text-black w-full">
                                    <button id="reset-button"
                                        class="w-full bg-themecolor-primary border-2 text-white rounded-lg px-2.5 py-[7px]">
                                        Reset
                                    </button>
                                    <button type="submit"
                                        class="w-full sm:block lg:hidden bg-themecolor-primary border-2 text-white rounded-lg px-2.5 py-[7px] mt-3 lg:mt-0">Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @if (in_array(Permissions::FITUR_SENGKETA_CREATE, $permissions))
        <div class="mt-6">
            <div class="flex flex-row justify-between">
                <a class="flex items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-4"
                    href="{{ route('admin.sengketa.create') }}">
                    <svg class="h-4 w-4 mr-2 font-semibold" fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Tambah Sengketa
                </a>
            </div>
        </div>
    @endif

    {{-- statistik --}}
    <div class="mt-6">
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 text-sm lg:text-base font-lato font-semibold">
            <div class="bg-white p-4 rounded-2xl shadow-md text-center cursor-pointer transition duration-300 ease-in-out transform hover:scale-105"
                id="menunggu-verifikasi">
                <p class="text-themecolor-primary">MENUNGGU VERIFIKASI : <span id="menunggu-verifikasi-count">0</span></p>
            </div>
            <div class="bg-white p-4 rounded-2xl shadow-md text-center cursor-pointer transition duration-300 ease-in-out transform hover:scale-105"
                id="sengketa-ditolak">
                <p class="text-themecolor-primary">SENGKETA DITOLAK : <span id="sengketa-ditolak-count">0</span></p>
            </div>
            <div class="bg-white p-4 rounded-2xl shadow-md text-center cursor-pointer transition duration-300 ease-in-out transform hover:scale-105"
                id="sengketa-diterima">
                <p class="text-themecolor-primary">SENGKETA DITERIMA : <span id="sengketa-diterima-count">0</span></p>
            </div>
            <div class="bg-white p-4 rounded-2xl shadow-md text-center cursor-pointer transition duration-300 ease-in-out transform hover:scale-105"
                id="pengajuan-pencabutan">
                <p class="text-themecolor-primary">PENGAJUAN PENCABUTAN : <span id="pengajuan-pencabutan-count">0</span>
                </p>
            </div>
            <div class="bg-white p-4 rounded-2xl shadow-md text-center cursor-pointer transition duration-300 ease-in-out transform hover:scale-105"
                id="pengajuan-pembatalan">
                <p class="text-themecolor-primary">PENGAJUAN PEMBATALAN : <span id="pengajuan-pembatalan-count">0</span>
                </p>
            </div>
            <div class="bg-white p-4 rounded-2xl shadow-md text-center cursor-pointer transition duration-300 ease-in-out transform hover:scale-105"
                id="sengketa-selesai">
                <p class="text-themecolor-primary">SENGKETA SELESAI : <span id="sengketa-selesai-count">0</span></p>
            </div>
        </div>
    </div>

    <div class="relative overflow-x-auto sm:rounded-lg mt-5 mb-2 mx-auto md:max-w-xl lg:max-w-full w-full">
        <table class="w-full mt-8 text-sm text-white table-auto display table-sengketa border-spacing-y-4"
            style="width:100%" id="sengekta-table">
            <thead class="text-base text-white bg-themecolor-primary dark:bg-themecolor-primary ">
                <tr>
                    <th class="text-white font-semibold">
                        No
                    </th>
                    <th class="text-white font-semibold">
                        No. Sengketa
                    </th>
                    <th class="text-white font-semibold">
                        Termohon
                    </th>
                    <th class="text-white font-semibold">
                        Status Sengketa
                    </th>
                    <th class="text-white font-semibold">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="text-sm lg:text-lg text-center">

            </tbody>
        </table>
    </div>

    {{-- <x-unified-modal id="cancel-modal" hiddenInputId="cancel_id" type="cancel" />
<x-unified-modal id="cabut-modal" hiddenInputId="cabut_id" type="cabut" />
<x-unified-modal id="delete-modal" hiddenInputId="delete_id" type="delete" />
<x-unified-modal id="perangkat-persidangan-modal" hiddenInputId="id_sengketa" type="perangkat-persidangan" /> --}}

    <!-- cancel modal -->
    <div id="cancel-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-6 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-red-100 rounded-lg shadow-lg p-6 text-center border-4 border-primary">
                <!-- Modal body -->
                <div class="flex flex-col items-center">
                    <input type="hidden" id="cancel_id">
                    <p class="text-lg font-semibold text-primary mb-6">
                        Apakah Anda Yakin Akan Membatalkan Sengketa ini ?
                    </p>
                    <div id="file_upload_container" class="mb-4">
                        <input type="file" id="file_akta_pembatalan" name="file_akta_pembatalan" class="hidden" />
                        <label for="file_akta_pembatalan"
                            class="cursor-pointer inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                            Upload Akta Pembatalan
                        </label>
                    </div>
                    <span id="file_name" class="text-black"></span>
                    <div class="flex space-x-4 mt-4">
                        <button data-modal-hide="cancel-modal" type="button"
                        class="text-white focus:outline-none bg-gray-600 rounded-lg border hover:bg-gray-100 hover:text-themecolor-primary focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 font-medium text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Kembali
                        </button>
                        <button type="button" id="btn_cancel"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-white rounded-lg bg-themecolor-primary hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 ">
                        Iya
                        </button>
                        <button id="btn_loading_cancel" hidden
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
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- cabut modal -->
    <div id="cabut-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-6 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-red-100 rounded-lg shadow-lg p-6 text-center border-4 border-primary">
                <!-- Modal body -->
                <div class="flex flex-col items-center">
                    <input type="hidden" id="cabut_id">
                    <p class="text-lg font-semibold text-primary mb-6">
                        Apakah Anda Yakin Akan Mencabut Sengketa ini ?
                    </p>
                    {{-- <div id="file_upload_cabut" class="mb-4 hidden">
                    <input type="file" id="file_akta_pencabutan" name="file_akta_pencabutan" class="" />
                    <label for="file_akta_pencabutan" class="cursor-pointer px-4 py-2 bg-primary text-white rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Upload Akta Pencabutan
                    </label>
                </div> --}}
                    <div id="file_upload_container_cabut" class="mb-4">
                        <input type="file" id="file_akta_pencabutan" name="file_akta_pencabutan" class="hidden" />
                        <label for="file_akta_pencabutan"
                            class="cursor-pointer inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                            Upload Akta Pencabutan
                        </label>
                    </div>
                    <span id="file_name_cabut" class="text-black"></span>
                    <div class="flex space-x-4 mt-4">
                        <button data-modal-hide="cabut-modal" type="button"
                        class="text-white focus:outline-none bg-gray-600 rounded-lg border hover:bg-gray-100 hover:text-themecolor-primary focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 font-medium text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Kembali
                        </button>
                        <button type="button" id="btn_cabut"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-white rounded-lg bg-themecolor-primary hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 ">
                        Iya
                        </button>
                        <button id="btn_loading_cabut" hidden
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="delete-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-xl max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="delete-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <input type="hidden" id="delete_id">
                    <svg class="mx-auto mb-4 text-themecolor-primary w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-black dark:text-gray-400">Anda yakin akan hapus data Sengketa
                        ini?</h3>
                    <input type="text" id="alasan" name="alasan" placeholder="Masukkan Alasan"
                        class="w-full p-2.5 mb-4 border border-gray-200 rounded-lg focus:ring-2 focus:ring-themecolor-primary focus:border-themecolor-primary dark:focus:ring-gray-600 dark:focus:border-gray-600 dark:bg-gray-800 dark:text-gray-400">
                    <button data-modal-hide="delete-modal" type="button"
                    class="text-white focus:outline-none bg-gray-600 rounded-lg border hover:bg-gray-100 hover:text-themecolor-primary focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 font-medium text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Kembali
                    </button>
                    <button type="button" id="btn_delete"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-white rounded-lg bg-themecolor-primary hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 ">
                    Iya</button>
                    <button id="btn_loading_delete" hidden
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

                </div>
            </div>
        </div>
    </div>

    {{-- perangkat pelengkap modal --}}
    <div id="perangkat-persidangan-modal" tabindex="-1" aria-hidden="true" data-id-ki=""
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-6 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-themecolor-secondary rounded-xl shadow-lg p-6 border-4 border-red-800">
                <h2 class="text-xl font-bold text-center text-gray-800 mb-4">Perangkat Persidangan</h2>
                <!-- Modal body -->
                <input type="hidden" id="id_sengketa">
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label for="ketua_komisioner" class="block text-sm font-medium text-gray-800">Ketua Majelis
                            Komisioner</label>
                        <select id="ketua_komisioner"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                            <option value="">Pilih Ketua Majelis Komisioner</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="anggota1_komisioner" class="block text-sm font-medium text-gray-800">Anggota Majelis
                            Komisioner</label>
                        <select id="anggota1_komisioner"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                            <option value="">Pilih Anggota Majelis Komisioner</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="anggota2_komisioner" class="block text-sm font-medium text-gray-800">Anggota Majelis
                            Komisioner</label>
                        <select id="anggota2_komisioner"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                            <option value="">Pilih Anggota Majelis Komisioner</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="mediator" class="block text-sm font-medium text-gray-800">Mediator</label>
                        <select id="mediator"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                            <option value="">Pilih Mediator</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="panitera_pengganti" class="block text-sm font-medium text-gray-800">Panitera
                            Pengganti</label>
                        <select id="panitera_pengganti"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                            <option value="">Pilih Panitera Pengganti</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-4 mt-4">
                        <button data-modal-hide="perangkat-persidangan-modal" type="button"
                        class="text-white focus:outline-none bg-gray-600 rounded-lg border hover:bg-gray-100 hover:text-themecolor-primary focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 font-medium text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Kembali
                        </button>
                        <button id="simpanPerangkatPersidanganBtn" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-white rounded-lg bg-themecolor-primary hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 ">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('prepend-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
    {{-- datatables responsive css cdn start --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
    {{-- datatables responsive css cdn end --}}
@endpush

@push('prepend-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.tailwindcss.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    @vite(['resources/js/modal.js', 'resources/js/select2.js', 'resources/js/actionHandler.js'])
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
    <script>
        function handleFileChange(inputId, fileNameId) {
            document.getElementById(inputId).addEventListener('change', function(e) {
                const fileName = e.target.files[0] ? e.target.files[0].name : 'No file selected';
                document.getElementById(fileNameId).textContent = fileName;
            });
        }

        function toggleButtonProgress(buttonIds, loadingButtonIds, show) {
            buttonIds.forEach(function(buttonId) {
                if (show) {
                    $(buttonId).removeAttr('hidden');
                } else {
                    $(buttonId).attr('hidden', true);
                }
            });

            loadingButtonIds.forEach(function(loadingButtonId) {
                if (show) {
                    $(loadingButtonId).attr('hidden', true);
                } else {
                    $(loadingButtonId).removeAttr('hidden');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize select2
            initializeSelect2(['#panitera_pengganti', '#mediator', '#anggota2_komisioner', '#anggota1_komisioner',
                '#ketua_komisioner'
            ]);

            // Initialize modals
            var deleteModal = initializeModal('delete-modal');
            var cabutModal = initializeModal('cabut-modal');
            var cancelModal = initializeModal('cancel-modal');
            var perangkatPersidanganModal = initializeModal('perangkat-persidangan-modal');

            // Handle file changes
            handleFileChange('file_akta_pembatalan', 'file_name');
            handleFileChange('file_akta_pencabutan', 'file_name_cabut');

            // tableId, actionClass, inputId, modal, type = null, containerId = null
            handleAction('#sengekta-table', '.delete', '#delete_id', deleteModal);
            handleAction('#sengekta-table', '.cabut-sengketa', '#cabut_id', cabutModal, 'konfirmasi',
                '#file_upload_container_cabut');
            handleAction('#sengekta-table', '.cancel', '#cancel_id', cancelModal, 'konfirmasi',
                '#file_upload_container');
            handleAction('#sengekta-table', '.lengkap-sengketa', '#id_sengketa', perangkatPersidanganModal,
                'perangkat-persidangan');

            // show hide button progress
            function showButtonProgress() {
                var buttonIds = ['#btn_delete', '#btn_cancel', '#btn_cabut'];
                var loadingButtonIds = ['#btn_loading_delete', '#btn_loading_cabut', '#btn_loading_cancel'];
                toggleButtonProgress(buttonIds, loadingButtonIds, false);
            }

            function hideButtonProgress() {
                var buttonIds = ['#btn_delete', '#btn_cancel', '#btn_cabut'];
                var loadingButtonIds = ['#btn_loading_delete', '#btn_loading_cabut', '#btn_loading_cancel'];
                toggleButtonProgress(buttonIds, loadingButtonIds, true);
            }

            // datatable sengketa
            var table = $('#sengekta-table').DataTable({
                layout: {
                    topStart: null,
                    topEnd: null,
                    bottomStart: 'paging',
                    bottomEnd: 'info',
                },
                "processing": true,
                "serverSide": true,
                "destroy": true,
                "searching": true,
                "info": true,
                "responsive": true,
                "ajax": {
                    "url": "{{ route('sengketa.list') }}",
                    "data": function(d) {
                        d.status = $('select[name="status"]').val();
                        d.tanggal1 = $('input[name="start_date"]').val();
                        d.tanggal2 = $('input[name="to_date"]').val();
                        d.no_sengketa = $('input[name="no_sengketa"]').val();
                        d.id_ki = $('select[name="id_ki"]').val();
                    },
                    "error": function(xhr, error, code) {
                        if (xhr.status == 401) {
                            showNotificationError('Anda tidak memiliki akses ke fitur ini');
                        }
                    }
                },
                "order": [
                    [0, "desc"]
                ],
                "columns": [{
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return row.no_sengketa ? row.no_sengketa : row.no_registrasi;
                        }
                    },
                    {
                        "data": "nama_termohon"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return renderAction(data, row);
                        }
                    }
                ]
            });

            // render action
            function renderAction(data, row) {
                var actionButtons = '';
                var urlSengketaShow = "{{ route('admin.sengketa.show', '') }}" + "/" + row.id;
                var urlSengketaEdit = "{{ route('admin.sengketa.edit', '') }}" + "/" + row.id;
                var urlSengketaLacak = "{{ route('admin.sengketa.lacak', '') }}" + "/" + row.id;

                @if (in_array(Permissions::FITUR_SENGKETA_SHOW, $permissions))
                    if (row.enable_lihat_pengajuan === true) {
                        actionButtons +=
                            `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                                <a
                                href=${urlSengketaShow}
                                class="lihat bg-[#3B82F6] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                                <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#3B82F6] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Lihat Sengketa</span>
                            </div>`;
                    }
                @endif

                @if (in_array(Permissions::FITUR_SENGKETA_BATAL, $permissions))
                    if (row.status != "{{ Constant::STATUS_SENGKETA_SELESAI_TEXT }}") {
                        if (row.enable_pengajuan_batal === true) {
                            actionButtons +=
                                `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                                    <button
                                    data-id=${row.id}
                                    data-modal-target="cancel-modal"
                                    data-tipe="pengajuan"
                                    type="button"
                                    class="cancel bg-[#4338CA] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#4338CA] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Batalkan Sengketa</span>
                                </div>`;
                        }
                    }
                @endif
                    // test
                @if (in_array(Permissions::FITUR_SENGKETA_CABUT, $permissions))
                    if (row.status != "{{ Constant::STATUS_SENGKETA_SELESAI_TEXT }}") {
                        if (row.enable_pengajuan_cabut === true) {
                            actionButtons +=
                                `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                                    <button
                                    data-id=${row.id}
                                    data-modal-target="cabut-modal"
                                    data-tipe="pengajuan"
                                    type="button"
                                    class="cabut-sengketa bg-[#7C3AED] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </button>
                                    <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#7C3AED] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Cabut Sengketa</span>
                                </div>`;
                        }
                    }
                @endif

                @if (in_array(Permissions::FITUR_SENGKETA_UPDATE, $permissions))
                    if (row.status != "{{ Constant::STATUS_SENGKETA_SELESAI_TEXT }}") {
                        if (row.enable_lengkapi_data === true) {
                            actionButtons +=
                                `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                                    <a
                                    href=${urlSengketaEdit}
                                    class="bg-[#D97706] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                        <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                    </svg>
                                    </a>
                                    <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#D97706] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Lengkapi Data</span>
                                </div>`;
                        }
                    }
                @endif

                @if (in_array(Permissions::FITUR_SENGKETA_CABUT_KONFIRMASI, $permissions))
                    if (row.status != "{{ Constant::STATUS_SENGKETA_SELESAI_TEXT }}") {
                        if (row.enable_konfirmasi_cabut === true) {
                            actionButtons +=
                                `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                                    <button
                                    data-id=${row.id}
                                    data-modal-target="cabut-modal"
                                    data-tipe="konfirmasi"
                                    type="button"
                                    class="cabut-sengketa bg-[#4C1D95] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m4 6 2 2 4-4m4-8v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z"/>
                                        </svg>
                                    </button>
                                    <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#4C1D95] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Konfirmasi Pencabutan Sengketa</span>
                                </div>`;
                        }
                    }
                @endif

                @if (in_array(Permissions::FITUR_SENGKETA_BATAL_KONFIRMASI, $permissions))
                    if (row.status != "{{ Constant::STATUS_SENGKETA_SELESAI_TEXT }}") {
                        if (row.enable_konfirmasi_batal === true) {
                            actionButtons +=
                                `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                                    <button
                                    data-id=${row.id}
                                    data-modal-target="cancel-modal"
                                    data-tipe="konfirmasi"
                                    type="button"
                                    class="cancel bg-[#312E81] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Z"/>
                                            <path fill-rule="evenodd" d="M11 7V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm4.707 5.707a1 1 0 0 0-1.414-1.414L11 14.586l-1.293-1.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#312E81] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Konfirmasi Pembatalan Sengketa</span>
                                </div>`;
                        }
                    }
                @endif

                @if (in_array(Permissions::FITUR_SENGKETA_LACAK, $permissions))
                    if (row.status != "{{ Constant::STATUS_SENGKETA_DIHAPUS_TEXT }}") {
                        if (row.enable_lacak === true) {
                            actionButtons +=
                                `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                                    <a
                                    href=${urlSengketaLacak}
                                    class="bg-[#059669] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm.5 5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Zm0 5c.47 0 .917-.092 1.326-.26l1.967 1.967a1 1 0 0 0 1.414-1.414l-1.817-1.818A3.5 3.5 0 1 0 11.5 17Z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                    <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#059669] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Lacak</span>
                                </div>`;
                        }
                    }
                @endif

                @if (in_array(Permissions::FITUR_SENGKETA_PERANGKAT, $permissions))
                    if (row.enable_lengkapi_perangkat === true) {
                        actionButtons +=
                            `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                                <button
                                data-id=${row.id_ki}
                                data-id-sengketa=${row.id}
                                data-modal-target="perangkat-persidangan-modal"
                                type="button"
                                class="lengkap-sengketa bg-[#FBBF24] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H7Zm8-1a1 1 0 0 1 1-1h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#FBBF24] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Perangkat Persidangan</span>
                            </div>`;
                    }
                @endif

                @if (in_array(Permissions::FITUR_SENGKETA_DELETE, $permissions))
                    if (row.status != "{{ Constant::STATUS_SENGKETA_SELESAI_TEXT }}") {
                        if (row.status != "{{ Constant::STATUS_SENGKETA_DIHAPUS_TEXT }}") {
                            actionButtons +=
                                `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                                    <button
                                    data-id=${row.id}
                                    type="button"
                                    class="delete bg-[#AE0008] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#AE0008] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Hapus</span>
                                </div>`;
                        }
                    }
                @endif


                return '<div class="w-full text-center space-x-1">' + actionButtons + '</div>';
            }

            $('form').on('submit', function(e) {
                var startDate = $('input[name="start_date"]').val();
                var toDate = $('input[name="to_date"]').val();

                if ((startDate && !toDate) || (!startDate && toDate)) {
                    showNotificationError('Tanggal Awal dan Tanggal Akhir harus diisi');
                    e.preventDefault();
                    return;
                }
                table.search('').columns().search('').draw();

                e.preventDefault();
                // table.ajax.reload();
            });

            $('#reset-button').on('click', function() {
                $('select[name="status"]').val('');
                $('input[name="start_date"]').val('');
                $('input[name="to_date"]').val('');
                $('select[name="id_ki"]').val('');
                $('input[name="no_sengketa"]').val('');

                table.search('').columns().search('').draw();
            });

            // ajax batal sengketa
            $('#btn_cancel').on('click', function() {
                showButtonProgress();
                var id = $('#cancel_id').val();
                var cancelUrl = '{{ route('sengketa.batal', ':id') }}'.replace(':id', id);

                var fileInput = $('#file_akta_pembatalan')[0];
                var formData = new FormData();

                if (fileInput.files.length > 0) {
                    formData.append('file_akta_pembatalan', fileInput.files[0]);
                    formData.append('type', 'konfirmasi');
                } else {
                    formData.append('type', 'pengajuan');
                }

                if (formData.get('type') === 'konfirmasi' && fileInput.files.length === 0) {
                    showNotificationError('File akta pembatalan harus diunggah!');
                    hideButtonProgress();
                    return;
                }
                $.ajax({
                    url: cancelUrl,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            cancelModal.hide();
                            $('#sengekta-table').DataTable().ajax.reload();
                            showNotificationSuccess('Sengketa berhasil dibatalkan.');
                        } else {
                            showNotificationError(response.message ||
                                'Gagal membatalkan sengketa.');
                        }
                        hideButtonProgress();
                    },
                    error: function(xhr, status, error) {
                        showNotificationError(xhr.responseJSON.message || 'Terjadi kesalahan saat membatalkan sengketa.');
                    },
                    complete: function() {
                        hideButtonProgress();
                    }
                });
            });

            // ajax hapus sengketa
            $("#btn_delete").click(function(e) {
                e.preventDefault();
                showButtonProgress();

                var deleteId = $('#delete_id').val();
                var alasan = $('#alasan').val();
                var url = "{{ route('sengketa.delete', ':id') }}";
                url = url.replace(':id', deleteId);

                if (alasan.trim() === '') {
                    showNotificationError('Masukkan alasan penghapusan!');
                    hideButtonProgress();
                    return;
                }

                $.ajax({
                    method: "DELETE",
                    dataType: "json",
                    url: url,
                    data: {
                        alasan_dihapus: alasan,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotificationSuccess("Data berhasil dihapus");

                            deleteModal.hide();

                            table.ajax.reload();

                        } else {
                            showNotificationError(response.message ||
                                'Penghapusan gagal!');
                        }
                        hideButtonProgress();
                    },
                    error: function(response) {
                        var errors = response.responseJSON;
                        console.log(errors.message);
                        showNotificationError(errors.message);
                        if (errors.errors != null) {
                            $.each(errors.errors, function(key, value) {
                                showNotificationError(value);
                            });
                        }
                        hideButtonProgress();
                    }
                });
            });

            // ajax cabut sengketa
            $('#btn_cabut').on('click', function() {
                showButtonProgress();
                var id = $('#cabut_id').val();
                var cabutUrl = '{{ route('sengketa.cabut', ':id') }}'.replace(':id', id);

                var fileInput = $('#file_akta_pencabutan')[0];
                var formData = new FormData();

                if (fileInput.files.length > 0) {
                    formData.append('file_akta_pencabutan', fileInput.files[0]);
                    formData.append('type', 'konfirmasi');
                } else {
                    formData.append('type', 'pengajuan');
                }

                if (formData.get('type') === 'konfirmasi' && fileInput.files.length === 0) {
                    showNotificationError('File akta pencabutan harus diunggah!');
                    hideButtonProgress();
                    return;
                }
                $.ajax({
                    url: cabutUrl,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            cabutModal.hide();
                            $('#sengekta-table').DataTable().ajax.reload();
                            showNotificationSuccess('Sengketa berhasil dicabut.');
                        } else {
                            showNotificationError(response.message ||
                                'Gagal mencabut sengketa.');
                        }

                        hideButtonProgress();
                    },
                    error: function(xhr, status, error) {
                        showNotificationError(xhr.responseJSON.message || 'Terjadi kesalahan saat mencabut sengketa.');
                    },
                    complete: function() {
                        hideButtonProgress();
                    }
                });
            });

            $('#sengekta-table').on('click', '.lengkap-sengketa', function() {
                var id_ki = $(this).data('id');
                var idSengketa = $(this).data('id-sengketa');
                $('#id_sengketa').val(idSengketa);
                var role = $(this).data('role');
                fetchPaniteraList('#panitera_pengganti', id_ki, 'panitera-pengganti',
                    'Panitera Pengganti');
                fetchPaniteraList('#mediator', id_ki, 'majelis-komisioner', 'Mediator');
                fetchPaniteraList('#anggota1_komisioner', id_ki, 'majelis-komisioner',
                    'Anggota Majelis Komisioner');
                fetchPaniteraList('#anggota2_komisioner', id_ki, 'majelis-komisioner',
                    'Anggota Majelis Komisioner');
                fetchPaniteraList('#ketua_komisioner', id_ki, 'majelis-komisioner',
                    'Ketua Majelis Komisioner');
                perangkatPersidanganModal.show();
            });


            $('#simpanPerangkatPersidanganBtn').on('click', function() {
                var idSengketa = $('#id_sengketa').val();
                var id_ketua = $('#ketua_komisioner').val();
                var id_anggota1 = $('#anggota1_komisioner').val();
                var id_anggota2 = $('#anggota2_komisioner').val();
                var id_mediator = $('#mediator').val();
                var id_panitera_pengganti = $('#panitera_pengganti').val();

                var url = '{{ route('sengketa.save-perangkat', ':id') }}';
                url = url.replace(':id', idSengketa);

                var data = {
                    id_ketua: id_ketua,
                    id_anggota1: id_anggota1,
                    id_anggota2: id_anggota2,
                    id_mediator: id_mediator,
                    id_panitera_pengganti: id_panitera_pengganti,
                    _token: '{{ csrf_token() }}'
                };

                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    data: JSON.stringify(data),
                                    contentType: 'application/json',
                                    success: function(response) {
                                        if (response.success) {
                                            showNotificationSuccess('Data perangkat persidangan berhasil disimpan.');
                                            $('#sengekta-table').DataTable().ajax.reload();
                                            perangkatPersidanganModal.hide();
                                        } else {
                                            showNotificationError(
                                                'Gagal menyimpan data perangkat persidangan: ' +
                                                response.message);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error:', error);
                                        showNotificationError(xhr.responseJSON.message || 'Terjadi kesalahan saat menyimpan perangkat sengketa.');
                                    }
                                });
                            });


            function fetchPaniteraList(selectId, id_ki, role, roleName) {

                $.ajax({
                    url: '{{ route('sengketa.list-user-ki') }}',
                    type: 'GET',
                    data: {
                        role: role,
                        id_ki: id_ki
                    },
                    success: function(response) {
                        if (response.success) {
                            var select = $(selectId);
                            select.empty();
                            select.append('<option value="">Pilih ' + roleName + '</option>');
                            response.data.forEach(function(item) {
                                select.append('<option value="' + item.id + '">' + item.nama +
                                    '</option>');
                            });
                        } else {
                            showNotificationError('Gagal memuat data panitera.');
                        }
                    },
                    error: function(xhr) {
                        showNotificationError(xhr.responseJSON.message || 'Terjadi kesalahan saat mengambil data Panitera.');
                        console.error(xhr);
                    }
                });
            }

            function fetchData() {
                $.ajax({
                    url: "{{ route('sengketa.list') }}",
                    method: 'GET',
                    success: function(response) {
                        const data = response.data;

                        const counts = {
                            "{{ Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI_TEXT }}": 0,
                            "{{ Constant::STATUS_SENGKETA_TERVERIFIKASI_TEXT }}": 0,
                            "{{ Constant::STATUS_SENGKETA_DITOLAK_TEXT }}": 0,
                            "{{ Constant::STATUS_SENGKETA_MENUNGGU_PEMBATALAN_TEXT }}": 0,
                            "{{ Constant::STATUS_SENGKETA_DIBATALKAN_TEXT }}": 0,
                            "{{ Constant::STATUS_SENGKETA_MENUNGGU_PENCABUTAN_TEXT }}": 0,
                            "{{ Constant::STATUS_SENGKETA_DICABUT_TEXT }}": 0,
                            "{{ Constant::STATUS_SENGKETA_SELESAI_TEXT }}": 0
                        };

                        data.forEach(item => {
                            if (item.status in counts) {
                                counts[item.status]++;
                            }
                        });

                        $('#menunggu-verifikasi-count').text(counts[
                            "{{ Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI_TEXT }}"
                        ]);
                        $('#sengketa-ditolak-count').text(counts[
                            "{{ Constant::STATUS_SENGKETA_DITOLAK_TEXT }}"]);
                        $('#sengketa-diterima-count').text(counts[
                            "{{ Constant::STATUS_SENGKETA_TERVERIFIKASI_TEXT }}"]);
                        $('#pengajuan-pencabutan-count').text(counts[
                            "{{ Constant::STATUS_SENGKETA_MENUNGGU_PENCABUTAN_TEXT }}"
                        ]);
                        $('#pengajuan-pembatalan-count').text(counts[
                            "{{ Constant::STATUS_SENGKETA_MENUNGGU_PEMBATALAN_TEXT }}"
                        ]);
                        $('#sengketa-selesai-count').text(counts[
                            "{{ Constant::STATUS_SENGKETA_SELESAI_TEXT }}"]);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            fetchData();

            function filterTable(status) {
                table.column(3).search(status).draw();
            }

            $('#menunggu-verifikasi').click(function() {
                filterTable("{{ Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI_TEXT }}");
            });
            $('#sengketa-ditolak').click(function() {
                filterTable("{{ Constant::STATUS_SENGKETA_DITOLAK_TEXT }}");
            });
            $('#sengketa-diterima').click(function() {
                filterTable("{{ Constant::STATUS_SENGKETA_TERVERIFIKASI_TEXT }}");
            });
            $('#pengajuan-pencabutan').click(function() {
                filterTable("{{ Constant::STATUS_SENGKETA_MENUNGGU_PENCABUTAN_TEXT }}");
            });
            $('#pengajuan-pembatalan').click(function() {
                filterTable("{{ Constant::STATUS_SENGKETA_MENUNGGU_PEMBATALAN_TEXT }}");
            });
            $('#sengketa-selesai').click(function() {
                filterTable("{{ Constant::STATUS_SENGKETA_SELESAI_TEXT }}");
            });




            // tutup DOM
        });

        $(document).ready(function() {

        });
    </script>
@endpush

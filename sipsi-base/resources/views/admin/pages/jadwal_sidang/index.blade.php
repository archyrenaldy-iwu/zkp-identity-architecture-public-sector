@extends('admin.layouts.master')
@section('title', 'Jadwal Sidang')
@push('prepend-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
@endpush
@section('content')

    @php
        $permissions = getPermissionsForActiveRole();
    @endphp

    <!-- Breadcumb -->
    {{ Breadcrumbs::render('jadwal') }}

    <div class="mx-auto w-full rounded schedule-filter-form">
        <div
            class="block max-w-full mt-2 p-6 border text-white border-gray-200 rounded-2xl shadow-2xl bg-themecolor-primary">
            <form action="#" method="GET">
                <div class="grid grid-cols-1 lg:grid-cols-12">
                    <!-- Row pertama -->
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
                                        datepicker-format="dd/mm/yyyy" type="text" name="start_date"
                                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full lg:w-3/4 ps-9 sm:w-full md:w-full p-2.5"
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
                                        datepicker-format="dd/mm/yyyy" type="text" name="to_date"
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
                    <!-- Row pertama -->
                    <div class="lg:col-span-4 lg:px-0 p-4 flex">
                        <div class="grid grid-cols-5 items-center w-full">
                            <div class="col-span-2">
                                <span class="">Jenis Sidang</span>
                            </div>
                            <div class="col-span-3 text-black ml-2 lg:ml-0">
                                <select id="jenis_sidang" name="jenis_sidang"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-themecolor-primary w-full focus:border-red-800 block lg:w-3/4 sm:w-full ps-4 p-2.5">
                                    <option value="" selected>Semua</option>
                                    @foreach (getJenisSidang() as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" name="username" id="username"
                                    class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block lg:w-3/4 sm:w-full w-full ps-4 p-2.5"
                                    placeholder="No. Registrasi" /> --}}
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

    <!-- Header -->
    <div class="mt-6">

        @if (in_array(Permissions::FITUR_JADWAL_SIDANG_CREATE, $permissions))
            <div class="flex flex-row justify-between">
                <div class="flex flex-row justify-between">
                    <button data-modal-target="sengketa-modal" id="pilih_sengketa"
                        class="flex items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-4">
                        <svg class="h-4 w-4 mr-2 font-semibold" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        Tambah Jadwal
                    </button>
                </div>
                {{-- <button id="open-modal-button" class="text-yellowColor hover:text-blue-600 font-semibold text-xs uppercase leading-tight">[perbarui]</button> --}}
            </div>
        @endif
    </div>

    <!-- Table Jadwal Sidang -->
    <div class="relative overflow-x-auto sm:rounded-lg mt-5 mb-2 mx-auto md:max-w-xl lg:max-w-full w-full">
        <table class="w-full text-sm text-white table-auto display table-jadwal" style="width:100%"
            id="jadwal-sidang-table">
            <thead class="text-base bg-themecolor-primary dark:bg-themecolor-primary ">
                <tr>
                    <th class="text-white font-semibold">
                        No
                    </th>
                    <th class="text-white font-semibold">
                        No Sengketa
                    </th>
                    <th class="text-white font-semibold">
                        Tanggal
                    </th>
                    <th class="text-white font-semibold">
                        Agenda
                    </th>
                    <th class="text-white font-semibold">
                        Aksi
                    </th>

                </tr>
            </thead>
            <tbody class="text-sm text-center">

            </tbody>
        </table>

    </div>

    <!-- Sengketa modal -->
    <div id="sengketa-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-5xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow border-2 border-primary dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 id="title-form" class="text-lg font-semibold text-primary dark:text-white">
                        Pilih Sengketa
                    </h3>
                    <button type="button" data-modal-hide="sengketa-modal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <div class="flex justify-items-start space-x-2 px-5 mt-2 ">
                    <div class="relative w-1/4">
                        <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-autohide
                            datepicker-format="dd/mm/yyyy" type="text" name="start_date_sengketa"
                            class="bg-white border border-primary text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:w-full md:w-full"
                            placeholder="Dari Tanggal">
                    </div>

                    <div class="relative w-1/4">

                        <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-autohide
                            datepicker-format="dd/mm/yyyy" type="text" name="to_date_sengketa"
                            class="bg-white border border-primary text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:w-full md:w-full "
                            placeholder="Sampai Tanggal">
                    </div>
                    <div class="relative w-1/4">
                        <input type="text" name="no_registrasi_sengketa" id="no_registrasi_sengketa"
                            class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block sm:w-full w-full ps-4"
                            placeholder="No. Sengketa" />
                    </div>
                    <div>
                        <button type="submit" onclick="getSengketa()"
                            class="w-24 bg-themecolor-primary border-2 text-white rounded-lg p-1.5">Cari</button>
                    </div>
                </div>
                <!-- Modal body -->

                <div class="relative overflow-x-auto sm:rounded-lg p-4 md:p-5 mx-auto md:max-w-xl lg:max-w-full w-full">
                    <table class="w-full text-lg text-white table-auto display table-jadwal border-spacing-y-4"
                        style="width:100%" id="pilih-sengketa-table">
                        <thead class="text-base bg-themecolor-primary dark:bg-themecolor-primary table-auto">
                            <tr>
                                <th class="text-white h-10 font-semibold">
                                    No
                                </th>
                                <th class="text-white h-10 font-semibold">
                                    No.Sengketa
                                </th>
                                <th class="text-white h-10 font-semibold">
                                    Pemohon
                                </th>
                                <th class="text-white h-10 font-semibold">
                                    Termohon
                                </th>
                                <th class="text-white  h-10 font-semibold">
                                    Status Perkara
                                </th>
                                <th class="text-white h-10 font-semibold">
                                    Aksi
                                </th>

                            </tr>
                        </thead>
                        <tbody id="list_sengketa" class="text-sm  font-normal text-center">
                            <tr class="cari-data-sengketa hidden">
                                <td colspan="6">
                                    <p class="text-lg">Mencari Data...</p>
                                </td>
                            </tr>
                            <tr class="empty-data-sengketa hidden">
                                <td colspan="6">
                                    <p class="text-lg">Data tidak ditemukan</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- Show Modal -->
    <div id="show-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-3xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="px-8 py-4 md:py-5">
                    <div class="card-detail">
                        <div class="mb-3 bg-themecolor-primary rounded-md">
                            <h3 class="text-2xl font-normal text-white px-4 py-2">Detail Jadwal Sidang</h3>
                        </div>
                        <div id="item-detail" class="item-detail animate-pulse">
                            <table class="table-borderless">
                                <tr>
                                    <td class="w-64 align-top">
                                        <label class="shrink label-item-detail font-semibold text-md"> No Registrasi
                                        </label>
                                    </td>
                                    <td>
                                        <p id="val_no_registrasi" class="value-item-detail">
                                        <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64 align-top">
                                        <label class="shrink w-1/3 label-item-detail font-semibold text-md"> Tanggal Sidang
                                        </label>
                                    </td>
                                    <td>
                                        <p id="val_sidang_waktu" class="value-item-detail">
                                        <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64 align-top">
                                        <label class="shrink w-1/3  label-item-detail font-semibold text-md"> Pemohon
                                        </label>
                                    </td>
                                    <td>
                                        <p id="val_nama_pemohon" class="value-item-detail">
                                        <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64 align-top">
                                        <label class="shrink w-1/3 label-item-detail font-semibold text-md"> Termohon
                                        </label>
                                    </td>
                                    <td>
                                        <p id="val_nama_termohon" class="value-item-detail">
                                        <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64 align-top">
                                        <label class="shrink w-1/4 label-item-detail font-semibold text-md"> Sidang
                                        </label>
                                    </td>
                                    <td>
                                        <p id="val_sidang_nama" class="value-item-detail">
                                        <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64 align-top">
                                        <label class="shrink w-1/4 label-item-detail font-semibold text-md"> Agenda Sidang
                                        </label>
                                    </td>
                                    <td>
                                        <p id="val_sidang_agenda" class="value-item-detail">
                                        <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64 align-top">
                                        <label class="shrink w-1/4 label-item-detail font-semibold text-md"> Ketua Majelis
                                            Komisioner </label>
                                    </td>
                                    <td>
                                        <p id="val_nama_ketua" class="value-item-detail">
                                        <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64 align-top">
                                        <label class="shrink w-1/4 label-item-detail font-semibold text-md"> Anggota
                                            Majelis
                                            Komisioner </label>
                                    </td>
                                    <td>

                                        <p id="val_nama_anggota1" class="value-item-detail">
                                        <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64 align-top">
                                        <label class="shrink w-1/4 label-item-detail font-semibold text-md"> Anggota
                                            Majelis
                                            Komisioner </label>
                                    </td>
                                    <td>
                                        <p id="val_nama_anggota2" class="value-item-detail">
                                        <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64 align-top">
                                        <label class="shrink w-1/4 label-item-detail font-semibold text-md"> Mediator
                                        </label>
                                    </td>
                                    <td>
                                        <p id="val_nama_mediator" class="value-item-detail">
                                        <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64 align-top">
                                        <label class="shrink w-1/4 label-item-detail font-semibold text-md"> Panitera Utama
                                        </label>
                                    </td>
                                    <td>
                                        <p id="val_nama_panitera_utama" class="value-item-detail">
                                        <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64 align-top">
                                        <label class="shrink w-1/4 label-item-detail font-semibold text-md"> Panitera
                                            Pengganti
                                        </label>
                                    </td>
                                    <td>
                                        <p id="val_nama_panitera_pengganti" class="value-item-detail">
                                        <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </div>

                    </div>


                    <div class="text-right justify-end">
                        <button data-modal-hide="show-modal" type="button"
                            class="text-white bg-themecolor-primary hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5">
                            Kembali
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="delete-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                <div class="p-4 md:p-5 text-center">
                    <input type="hidden" id="delete_id">
                    <svg class="mx-auto mb-4 text-themecolor-primary w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-black dark:text-gray-400">Anda yakin akan hapus jadwal sidang
                        ini?</h3>
                    <input type="text" name="alasan_hapus" id="alasan_hapus"
                        class="bg-white w-1/2 mb-5 border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block sm:w-full ps-4"
                        placeholder="Alasan Hapus" />
                    <button data-modal-hide="delete-modal" type="button"
                        class="text-white focus:outline-none bg-gray-600 rounded-lg border hover:bg-gray-100 hover:text-themecolor-primary focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 font-medium text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Kembali
                    </button>
                    <button type="button" id="btn_delete"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-white rounded-lg bg-themecolor-primary hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 ">
                        Iya</button>
                    <button id="btn_loading" hidden
                        class="w-xl text-themecolor-primary bg-white border border-themecolor-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
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

    <!-- Loading Modal -->
    <div id="loading-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-xl max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-4 md:p-5 text-center animate-pulse">
                    <h3 class="text-lg font-normal text-black dark:text-gray-400">Sedang Membuat Reelas ...</h3> <br>
                    <button
                        class="w-xl text-white bg-transparent hover:bg-transparent focus:outline-none font-medium rounded-lg text-sm px-5 text-center">
                        <div role="status">
                            <svg aria-hidden="true"
                                class="inline w-10 h-10 text-themecolor-primary animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>

                        </div>
                    </button> <br>
                    <p class="mt-5 text-sm font-normal text-black dark:text-gray-400">Harap jangan tutup website</h3> <br>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- stack js --}}
@push('prepend-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.tailwindcss.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script>
        var modalElementPilihSengketa = '';
        var modalElementShow = '';
        var modalElementLoading = '';
        var modalElementDelete = '';
        var sengketaModal = '';
        var showModal = '';
        var loadingModal = '';
        var deleteModal = '';

        document.addEventListener('DOMContentLoaded', function() {
            modalElementPilihSengketa = document.getElementById('sengketa-modal');
            modalElementShow = document.getElementById('show-modal');
            modalElementLoading = document.getElementById('loading-modal');
            modalElementDelete = document.getElementById('delete-modal');

            sengketaModal = new Modal(modalElementPilihSengketa, {
                backdrop: 'static'
            });

            showModal = new Modal(modalElementShow, {
                backdrop: 'static'
            });

            loadingModal = new Modal(modalElementLoading, {
                backdrop: 'static'
            });

            deleteModal = new Modal(modalElementDelete, {
                backdrop: 'static'
            });

            const closeModalButtonsSengketa = modalElementPilihSengketa.querySelectorAll('[data-modal-hide]');
            const closeModalButtonsShow = modalElementShow.querySelectorAll('[data-modal-hide]');
            const closeModalButtonsDelete = modalElementDelete.querySelectorAll('[data-modal-hide]');

            //Hide each close closeModalButtonsSengketa
            closeModalButtonsSengketa.forEach(function(button) {
                button.addEventListener('click', function() {
                    sengketaModal.hide();
                });
            });

            //Hide each close closeModalButtonsShow
            closeModalButtonsShow.forEach(function(button) {
                button.addEventListener('click', function() {
                    showModal.hide();
                });
            });

            //Hide each close delete modal button
            closeModalButtonsDelete.forEach(function(button) {
                button.addEventListener('click', function() {
                    deleteModal.hide();
                    $('#alasan_hapus').val('')
                });
            });

            //show detail jadwal sidang
            $('#jadwal-sidang-table').on('click', '.show', function() {
                getJadwalSidangById($(this).data('id'))
                showModal.show();
            });

            //show/create reelas
            $('#jadwal-sidang-table').on('click', '.reelas', function() {
                const historyId = $(this).data("id");
                const isCreated = $(this).data("iscreated");
                createReelas(historyId, isCreated)
            });

            //show confirm delete
            $('#jadwal-sidang-table').on('click', '.delete', function() {
                var id = $(this).data("id");
                $('#delete_id').val(id);
                deleteModal.show();
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#jadwal-sidang-table').DataTable({
                language: {
                    "emptyTable": "Tidak ada jadwal sidang hari ini",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "loadingRecords": "Sedang memuat...",
                    "zeroRecords": "Tidak ditemukan entri yang sesuai",
                },
                layout: {
                    topStart: null,
                    topEnd: null,
                    bottomStart: 'paging',
                    bottomEnd: 'info',
                },
                processing: true,
                serverSide: true,
                destroy: true,
                searching: true,
                info: true,
                responsive: true,
                ajax: {
                    "url": "{{ route('jadwal-sidang.list') }}",
                    "data": function(d) {
                        d.jenis_sidang = $('select[name="jenis_sidang"]').val();
                        d.tanggal1 = formatYmd($('input[name="start_date"]').val());
                        d.tanggal2 = formatYmd($('input[name="to_date"]').val());
                        d.no_sengketa = $('input[name="no_sengketa"]').val();
                        d.id_ki = $('select[name="id_ki"]').val();
                    }
                },
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'no_sengketa',
                        name: 'no_sengketa'
                    },
                    {
                        data: 'sidang_waktu',
                        name: 'sidang_waktu',
                        render: function(data, type, row) {
                            return formatDate(data) + ' ' + row.timezone;
                        }
                    },
                    {
                        data: 'sidang_agenda',
                        name: 'sidang_agenda'
                    },
                    {
                        data: 'id_history',
                        render: (data, type, row) => renderAction(data, row)
                    }
                ]
            });

            //Submit form delete modal
            $("#btn_delete").click(function(e) {
                e.preventDefault();

                var deleteId = $('#delete_id').val();
                var url = "{{ route('jadwal-sidang.delete', ':id') }}";
                var alasanHapus = $('#alasan_hapus').val();

                url = url.replace(':id', deleteId);

                if (alasanHapus == '') {
                    showNotificationError('Alasan hapus wajib di isi');
                    return
                }

                showButtonProgress();

                $.ajax({
                    type: "DELETE",
                    dataType: "json",
                    data: JSON.stringify({
                        "alasan_dihapus": alasanHapus
                    }),
                    contentType: 'application/json',
                    url: url,
                    success: function(response) {
                        deleteModal.hide();

                        table.ajax.reload();

                        hideButtonProgress();

                        showNotificationSuccess(response.message)

                        $('#alasan_hapus').val('')
                    },
                    error: function(response) {
                        var errors = response.responseJSON;

                        // error hide button progress and hide the modal
                        hideButtonProgress();
                        $('#alasan_hapus').val('')
                        deleteModal.hide();
                        
                        showNotificationError(errors.message);
                        if (errors.errors != null) {
                            $.each(errors.errors, function(key, value) {
                                showNotificationError(value);
                            });
                        }
                    }
                });
            });


            $('form').on('submit', function(e) {
                var startDate = $('input[name="start_date"]').val();
                var toDate = $('input[name="to_date"]').val();

                if ((startDate && !toDate) || (!startDate && toDate)) {
                    showNotificationError('Tanggal Awal dan Tanggal Akhir harus diisi');
                    e.preventDefault();
                    return;
                }

                e.preventDefault();
                table.ajax.reload();
            });

            $('#reset-button').on('click', function() {
                $('select[name="jenis_sidang"]').val('');
                $('input[name="start_date"]').val('');
                $('input[name="to_date"]').val('');
                $('input[name="no_sengketa"]').val('');
                $('select[name="id_ki"]').val('');

                table.search('').columns().search('').draw();
            });

            //button pilih sengketa
            $('#pilih_sengketa').on('click', function() {
                // $("#id_wilayah_provinsi").empty().trigger('change');
                // $('#input_ki_kota').addClass('hidden');
                // $("#id_ki").empty().trigger('change');
                // $("#frm-user").trigger("reset");
                // $('#title-form').html("Tambah Akun Admin");
                // $('.error').text("");
                getSengketa();
                sengketaModal.show();
            });
        });

        function getJadwalSidangById(historyId) {
            resetDetailJadwal();

            var url = "  {{ route('jadwal-sidang.list', ':params') }}";
            url = url.replace(':params', "type=detail_sidang&id_history=" + historyId);


            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(response) {
                    assignDetailJadwalSidang(response)
                },
                error: function(response) {
                    showNotificationError('Data tidak ditemukan')
                }
            });
        }

        function getSengketa() {
            var url = "  {{ route('jadwal-sidang.list-sengketa', ':params') }}";
            var startDate = formatYmd($('input[name="start_date_sengketa"]').val());
            var toDate = formatYmd($('input[name="to_date_sengketa"]').val());
            var noSengketa = $('input[name="no_registrasi_sengketa"]').val();

            if ((startDate && !toDate) || (!startDate && toDate)) {
                showNotificationError('Tanggal Awal dan Tanggal Akhir harus diisi');
                e.preventDefault();
                return;
            }

            url = url.replace(':params', "tanggal1=" + startDate + "&tanggal2=" + toDate + "&no_sengketa=" +
                noSengketa);

            showLoadingSengketa();

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(response) {
                    if (response.length < 1) {
                        showEmptyListSengketa();
                    } else {
                        assignListSengketaToTable(response)
                    }

                },
                error: function(response) {
                    showNotificationError('Data tidak ditemukan')
                    showEmptyListSengketa();
                }
            });
        }

        function assignDetailJadwalSidang(value) {
            $('#item-detail').removeClass('animate-pulse');
            $('.pulse').addClass('hidden');

            $("#val_no_registrasi").html(value.no_registrasi);
            $("#val_sidang_waktu").html(formatDate(value.sidang_waktu) + ' ' + value.timezone);
            $("#val_nama_pemohon").html(value.nama_pemohon);
            $("#val_nama_termohon").html(value.nama_termohon);
            $("#val_sidang_nama").html(value.sidang_nama);
            $("#val_sidang_agenda").html(value.sidang_agenda);
            $("#val_nama_ketua").html(value.nama_ketua);
            $("#val_nama_anggota1").html(value.nama_anggota1);
            $("#val_nama_anggota2").html(value.nama_anggota2);
            $("#val_nama_mediator").html(value.nama_mediator);
            $("#val_nama_panitera").html(value.nama_panitera);
            $("#val_nama_panitera_utama").html(value.nama_panitera_utama);
            $("#val_nama_panitera_pengganti").html(value.nama_panitera_pengganti);
        }

        function assignListSengketaToTable(listSengketa) {
            hideLoadingSengketa();

            var tableBody = $('#list_sengketa'); // Target the table body
            var no = 1;
            // Loop through API data
            $.each(listSengketa, function(index, item) {
                var newRow = $('<tr class=isi-data-sengketa></tr>');

                // Create table cells and populate with data
                newRow.append('<td class=h-10>' + no + '</td>');
                newRow.append('<td class=h-10>' + item.no_sengketa + '</td>');
                newRow.append('<td class=h-10>' + item.nama_pemohon + '</td>');
                newRow.append('<td class=h-10>' + item.nama_termohon + '</td>');
                newRow.append('<td class=h-10>' + item.status + '</td>');
                newRow.append('<td class=h-10>' + pilihSengketaAction(item) + '</td>');
                // Add more cells as needed based on your API data structure

                tableBody.append(newRow);

                no++;
            });
        }

        function renderAction(data, row) {
            // Button Show
            var show = "";
            var reelas = "";
            var deleted = "";
            //Button Reelas
            var title = 'Buat Reelas'
            var isCreated = false;

            if (row.file_reelas_pemohon != null) {
                title = 'Lihat Reelas';
                isCreated = true;
            }
            show =
                `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                    <button
                    data-id=${data}
                    type="button"
                    class="show bg-[#059669] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </button>
                    <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#059669] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Detail</span>
                </div>`;

            @if (in_array(Permissions::FITUR_JADWAL_SIDANG_DELETE, $permissions))
                deleted =
                    `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                    <button
                    data-id=${row.id_history}
                    type="button"
                    class="delete bg-[#AE0008] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#AE0008] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Hapus</span>
                </div>`;
            @endif

            @if (in_array(Permissions::FITUR_JADWAL_SIDANG_REELAS_CREATE, $permissions))
                reelas =
                    `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                    <button
                    data-id=${row.id_history}
                    data-iscreated=${isCreated}
                    type="button"
                    class="reelas bg-[#3B82F6] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#3B82F6] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">${title}</span>
                </div>`;
            @endif

            @if (in_array(Permissions::FITUR_JADWAL_SIDANG_REELAS_SHOW, $permissions))
                reelas =
                    `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                    <button
                    data-id=${row.id_history}
                    data-iscreated=${isCreated}
                    type="button"
                    class="reelas bg-[#3B82F6] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#3B82F6] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">${title}</span>
                </div>`;
            @endif


            return '<div class="w-full text-center">' + show +
                '<span style="text-black text-lg font-semibold uppercase leading-tight"> </span>' + reelas +
                '<span style="text-black text-lg font-semibold uppercase leading-tight"> </span>' + deleted + '</div>';
        }

        function createReelas(historyId, isCreated) {
            var targetUrl =
                "{{ route('admin.jadwal_sidang.reelas', ['id_history' => ':id_history']) }}";
            var url = "{{ route('jadwal-sidang.reelas-create', ':id_history') }}";

            url = url.replace(':id_history', historyId);
            targetUrl = targetUrl.replace(':id_history', historyId);

            if (!isCreated) {
                loadingModal.show();

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: url,
                    success: function(response) {
                        loadingModal.hide();
                        showNotificationSuccess(response.message)

                        setTimeout(function() {
                            window.location.href = targetUrl;
                        }, 2000);
                    },
                    error: function(response) {
                        var errors = response.responseJSON;
                        var errorMessage = errors.message + '<br>';
                        $.each(errors.errors, function(key,
                            value) {
                            errorMessage += value + '<br>'
                        })
                        loadingModal.hide();
                        showNotificationError(errorMessage)
                    }
                });
            } else {
                window.location.href = targetUrl;
            }
        }

        function pilihSengketaAction(data) {
            var url =
                "{{ route('admin.jadwal_sidang.show', ['id_sengketa' => ':id_sengketa']) }}";
            url = url.replace(':id_sengketa', data.id);

            var pilih =
                '<a href=' + url +
                ' class =' +
                '"text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-1 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary" >' +
                'Pilih </a>';
            return '<div class="w-full text-center">' + pilih +
                '<span style="text-black text-lg font-semibold uppercase leading-tight"> </span></div>'
        }

        function resetDetailJadwal() {
            $('.pulse').removeClass('hidden');
            $('.value-item-detail').html('');
        }

        function showLoadingSengketa() {
            $('.isi-data-sengketa').remove();
            $('.empty-data-sengketa').addClass('hidden');
            $('.cari-data-sengketa').removeClass('hidden');
            $('#list_sengketa').addClass('animate-pulse')
        }

        function showEmptyListSengketa() {
            $('.empty-data-sengketa').removeClass('hidden');
            $('.cari-data-sengketa').addClass('hidden');
        }

        function hideLoadingSengketa() {
            $('.cari-data-sengketa').addClass('hidden');
            $('.empty-data-sengketa').addClass('hidden');
            $('#list_sengketa').removeClass('animate-pulse')
        }

        function showButtonProgress() {
            $('#btn_loading').removeAttr('hidden');
            $('#btn_delete').attr('hidden', true);
        }

        function hideButtonProgress() {
            $('#btn_delete').removeAttr('hidden');
            $('#btn_loading').attr('hidden', true);
        }

        function formatYmd(dateString) {
            if (dateString != '' && dateString != null) {
                const parts = dateString.split('/')
                const day = parts[0];
                const month = parts[1];
                const year = parts[2];

                const formattedDate = `${year}-${month}-${day}`;
                return formattedDate;
            }
            return '';
        }
    </script>
@endpush

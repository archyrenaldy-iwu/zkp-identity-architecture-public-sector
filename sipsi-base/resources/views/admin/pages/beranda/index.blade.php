@extends('admin.layouts.master')
@section('title', 'Beranda')
@section('content')
    <div class="py-4 ml-0 lg:ml-0">
        @if (getActiveRole() == Roles::ROLE_PEMOHON && !Auth::user()->hasVerifiedEmail())
            <div id="alert-verify"
                class="max-w-full mx-auto p-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                role="alert">
                <div class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <h3 class="text-base lg:text-lg font-medium">Akun belum terverifikasi sehingga sebagian menu tidak
                        muncul, mohon verifikasi akun anda!</h3>
                </div>
                <div class="flex mt-4">
                    <button id="btnVerify" type="button"
                        class="w-1/3 lg:w-1/5 xl:w-1/6 text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        {{-- <svg class="me-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 14">
                            <path
                                d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                        </svg> --}}
                        Verifikasi Akun
                    </button>
                    <button id="btnLoading" hidden
                        class="w-1/3 lg:w-1/5 xl:w-1/6 text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
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
                    <button id="dismissVerify" type="button"
                        class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-red-600 dark:border-red-600 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800"
                        data-dismiss-target="#alert-verify" aria-label="Close">
                        Abaikan
                    </button>
                </div>
            </div>
        @endif
        <div href="#"
            class="block max-w-full mt-2 p-6 border text-white border-gray-200 rounded-lg shadow bg-themecolor-primary">
            <div class="flex justify-between">
                <div class="mt-10">
                    <h6 class="mb-2 text-2xl font-bold tracking-tight">
                        @php
                            use Carbon\Carbon;
                            setlocale(LC_TIME, 'id_ID.utf8');
                            Carbon::setLocale('id');
                            $date = Carbon::now();
                        @endphp
                        {{ $date->isoFormat('D MMMM YYYY') }}
                    </h6>
                    <p class="mt-32 text-2xl lg:text-3xl font-bold">Selamat Datang di Layanan SISE</p>
                    <p class="text-xl">Sistem Informasi Sengketa</p>
                </div>
                <div class="">
                    <img class="relative lg:right-20 top-2 w-20 lg:w-64" src="../img/logo2.png" alt="garuda">
                </div>
            </div>
        </div>
        @if (getActiveRole() != Roles::ROLE_PEMOHON)
            {{-- ADMIN --}}
            <div class="max-w-full mx-auto mt-2">
                <div class="bg-primary text-white px-6 md:px-12 lg:px-24 xl:px-32 py-6 rounded-lg">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-16">
                        <div class="lg:col-span-1 p-4 lg:px-0 flex items-center">
                            <div class="grid grid-cols-4 items-center w-full">
                                <label for="start-date" class="col-span-2 block text-sm font-medium">Dari Tanggal</label>
                                <div class="col-span-2 text-black ml-2">
                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-autohide
                                            datepicker-format="dd/mm/yyyy" type="text" name="start_date" id="start-date"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-800 focus:border-blue-500 block w-full ps-9 sm:w-full md:w-full p-2.5"
                                            placeholder="Dari Tanggal">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-1 p-4 lg:px-0 flex items-center">
                            <div class="grid grid-cols-4 items-center w-full">
                                <label for="end-date" class="col-span-2 block text-sm font-medium">Sampai Tanggal</label>
                                <div class="col-span-2 text-black ml-2">
                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-autohide
                                            datepicker-format="dd/mm/yyyy" type="text" name="to_date" id="end-date"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-800 focus:border-blue-500 block w-full sm:w-full md:w-full ps-9 p-2.5"
                                            placeholder="Sampai Tanggal">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-16">
                        <div class="lg:col-span-1 p-4 lg:px-0 flex items-center">
                            <div class="grid grid-cols-4 items-center w-full">
                                <label for="id_ki" class="col-span-2 block text-sm font-medium">Komisi Informasi</label>
                                <div class="col-span-2 text-black ml-2">
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
                        <div class="lg:col-span-1 p-4 lg:px-0 flex items-center">
                            <div class="grid grid-cols-2 lg:grid-cols-2 items-center w-full gap-4">
                                <div class="col-span-2 lg:col-span-1 hidden lg:inline-block">
                                    <button
                                        class="btn-download w-full bg-white border-2 text-red-700 rounded-xl px-2.5 py-[7px]">Download</button>
                                </div>
                                <div class="col-span-2 lg:col-span-1 text-black w-full">
                                    <button id="btn-search"
                                        class="w-full bg-white border-2 text-red-700 rounded-xl px-2.5 py-[7px]">
                                        Cari
                                    </button>
                                    <button
                                        class="btn-download w-full sm:block lg:hidden bg-white border-2 text-red-700 rounded-xl px-2.5 py-[7px] mt-3 lg:mt-0">Download</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="max-w-full mx-auto mt-2">
                    <div class="bg-[#F3F4F6] text-primary px-6 py-4">
                        <h1 class="text-2xl lg:text-3xl font-bold text-center">INFORMASI PENGAJUAN SENGKETA</h1>
                        <div
                            class="grid grid-cols-2 lg:grid-cols-6 gap-4 text-sm lg:text-base font-lato font-semibold mt-6">
                            <div
                                class="lg:col-span-2 bg-white p-4 rounded-2xl shadow-md text-start cursor-pointer transition duration-300 ease-in-out transform hover:scale-105">
                                <p id="countBaru" class="font-extrabold text-2xl">0</p>
                                <p class="text-themecolor-primary"> <span class="font-extrabold">TOTAL</span> PERMOHONAN
                                    SENGKETA BARU</p>
                            </div>
                            <div
                                class="lg:col-span-2 bg-white p-4 rounded-2xl shadow-md text-start cursor-pointer transition duration-300 ease-in-out transform hover:scale-105">
                                <p id="countDitolak" class="font-extrabold text-2xl">0</p>
                                <p class="text-themecolor-primary"> <span class="font-extrabold">TOTAL</span> SENGKETA
                                    DITOLAK</p>
                            </div>
                            <div
                                class="lg:col-span-2 bg-white p-4 rounded-2xl shadow-md text-start cursor-pointer transition duration-300 ease-in-out transform hover:scale-105">
                                <p id="countDiterima" class="font-extrabold text-2xl">0</p>
                                <p class="text-themecolor-primary"> <span class="font-extrabold">TOTAL</span> SENGKETA
                                    DITERIMA</p>
                            </div>
                            <div
                                class="lg:col-span-2 bg-white p-4 rounded-2xl shadow-md text-start cursor-pointer transition duration-300 ease-in-out transform hover:scale-105">
                                <p id="countPengajuanPencabutan" class="font-extrabold text-2xl">0</p>
                                <p class="text-themecolor-primary"> <span class="font-extrabold">TOTAL</span> PENGAJUAN
                                    PENCABUTAN SENGKETA</p>
                            </div>
                            <div
                                class="lg:col-span-2 bg-white p-4 rounded-2xl shadow-md text-start cursor-pointer transition duration-300 ease-in-out transform hover:scale-105">
                                <p id="countPengajuanPembatalan" class="font-extrabold text-2xl">0</p>
                                <p class="text-themecolor-primary"> <span class="font-extrabold">TOTAL</span> PENGAJUAN
                                    PEMBATALAN SENGKETA</p>
                            </div>
                            <div
                                class="lg:col-span-2 bg-white p-4 rounded-2xl shadow-md text-start cursor-pointer transition duration-300 ease-in-out transform hover:scale-105">
                                <p id="countSelesai" class="font-extrabold text-2xl">0</p>
                                <p class="text-themecolor-primary"> <span class="font-extrabold">TOTAL</span> SENGKETA
                                    SELESAI</p>
                            </div>
                            <div
                                class="lg:col-span-3 bg-white p-6 rounded-2xl shadow-md text-start cursor-pointer transition duration-300 ease-in-out transform hover:scale-105">
                                <p id="countSidang" class="font-extrabold text-2xl">0</p>
                                <p class="text-themecolor-primary"> <span class="font-extrabold">TOTAL</span> PROSES
                                    SIDANG SENGKETA</p>
                            </div>
                            <div
                                class="lg:col-span-3 bg-white p-6 rounded-2xl shadow-md text-start cursor-pointer transition duration-300 ease-in-out transform hover:scale-105">
                                <p id="countTotal" class="font-extrabold text-2xl">0</p>
                                <p class="text-themecolor-primary"> <span class="font-extrabold">TOTAL</span> PERMOHONAN
                                    SENGKETA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (getActiveRole() == Roles::ROLE_PEMOHON)
            {{-- PEMOHON --}}
            <div class="relative overflow-x-auto sm:rounded-lg mt-5 mb-2 mx-auto md:max-w-xl lg:max-w-full w-full">
                <table class="w-full mt-8 text-sm text-white table-auto display table-dashboard-pemohon border-spacing-y-4"
                    style="width:100%" id="dashboard-pemohon-table">
                    <thead class="text-base text-white bg-themecolor-primary dark:bg-themecolor-primary ">
                        <tr>
                            <th class="text-white font-semibold">
                                No
                            </th>
                            <th class="text-white font-semibold">
                                Info Sengketa Informasi
                            </th>
                            <th class="text-white font-semibold">
                                Jumlah
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm lg:text-lg">

                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @if (getActiveRole() == Roles::ROLE_PEMOHON)
        <div id="init-modal" data-modal-placement="bottom-right" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-6 w-full max-w-3xl max-h-full">
                <!-- Modal content -->
                <div
                    class="relative bg-red-100 rounded-lg shadow-lg p-8 text-center min-h-[350px] border-2 border-themecolor-primary">
                    <!-- Modal body -->
                    <div class="flex flex-col items-center">
                        <div class="bg-themecolor-primary rounded-full p-4 mb-4">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <p class="text-xl font-semibold text-gray-800 mb-4 mt-8">
                            Pelayanan akan dilakukan saat jam kerja
                        </p>
                        <a href="#" data-modal-hide="init-modal" type="button"
                            class="text-white bg-themecolor-primary hover:bg-red-700 focus:ring-4 focus:outline-none mt-10 focus:ring-red-300 font-medium rounded-lg text-base px-6 py-3">
                            Tutup
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('prepend-script')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.tailwindcss.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
        @if (getActiveRole() == Roles::ROLE_PEMOHON)
            <script>
                var modalElement = '';
                var modal = '';
                document.addEventListener('DOMContentLoaded', function() {
                    modalElement = document.getElementById('init-modal');

                    modal = new Modal(modalElement);

                    const closeModalButtons = modalElement.querySelectorAll('[data-modal-hide]');

                    closeModalButtons.forEach(function(button) {
                        button.addEventListener('click', function() {
                            modal.hide();
                        });
                    });

                    modal.show();
                })
            </script>
            <script>
                $(document).ready(function() {
                    $('#dashboard-pemohon-table').DataTable({
                        layout: {
                            topStart: null,
                            topEnd: null,
                            bottomStart: null,
                            bottomEnd: null,
                        },
                        processing: true,
                        serverSide: true,
                        ordering: false,
                        paging: false,
                        responsive: true,
                        ajax: {
                            url: "{{ route('beranda.summary') }}",
                            headers: {
                                'Authorization': 'Bearer ' + localStorage.getItem('access_token') // ambil token dari localStorage/sessionStorage
                            },
                            dataSrc: function(json) {
                                var totalMenungguVerifikasi = json.data.baru;
                                var totalDiterima = json.data.diterima;
                                var totalDitolak = json.data.ditolak;
                                var totalDicabut = json.data.pengajuan_pencabutan;
                                var totalDibatalkan = json.data.pengajuan_pembatalan;
                                var totalSelesai = json.data.selesai;
                                let totalSengketa = json.data.total;
                                return [{
                                        info_sengketa_informasi: '{{ Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI_TEXT }}',
                                        jumlah: totalMenungguVerifikasi
                                    },
                                    {
                                        info_sengketa_informasi: 'Sengketa Diterima',
                                        jumlah: totalDiterima
                                    },
                                    {
                                        info_sengketa_informasi: 'Sengketa {{ Constant::STATUS_SENGKETA_DITOLAK_TEXT }}',
                                        jumlah: totalDitolak
                                    },
                                    {
                                        info_sengketa_informasi: 'Sengketa {{ Constant::STATUS_SENGKETA_DICABUT_TEXT }}', // or STATUS_SENGKETA_MENUNGGU_PENCABUTAN_TEXT
                                        jumlah: totalDicabut
                                    },
                                    {
                                        info_sengketa_informasi: 'Sengketa {{ Constant::STATUS_SENGKETA_DIBATALKAN_TEXT }}', // or STATUS_SENGKETA_MENUNGGU_PEMBATALAN_TEXT
                                        jumlah: totalDibatalkan
                                    },
                                    {
                                        info_sengketa_informasi: 'Sengketa {{ Constant::STATUS_SENGKETA_SELESAI_TEXT }}',
                                        jumlah: totalSelesai
                                    },
                                    {
                                        info_sengketa_informasi: 'Total Sengketa',
                                        jumlah: totalSengketa
                                    }
                                ];
                            }
                        },
                        columns: [{
                                "data": "id",
                                "render": function(data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart +
                                        1;
                                }
                            },
                            {
                                data: 'info_sengketa_informasi',
                                name: 'info_sengketa_informasi'
                            },
                            {
                                data: 'jumlah',
                                name: 'jumlah'
                            }
                        ]
                    });
                });
            </script>

            @if (!Auth::user()->hasVerifiedEmail())
                <script>
                    $(document).ready(function() {
                        $(document).on('click', '#btnVerify', function() {
                            showButtonProgress();

                            $.ajax({
                                url: "{{ route('verification.resend') }}",
                                type: 'POST',
                                success: function(response) {
                                    showNotificationSuccess('Harap cek email anda');

                                    $('#alert-verify').hide();
                                },
                                error: function(xhr, status, error) {
                                    console.log(xhr);
                                    hideButtonProgress()
                                    showNotificationError('Verifikasi gagal')
                                },
                                complete: function(response) {
                                    hideButtonProgress();
                                }
                            });
                        });
                    });

                    function showButtonProgress() {
                        $('#btnLoading').removeAttr('hidden');
                        $('#btnVerify').attr('hidden', true);
                    }

                    function hideButtonProgress() {
                        $('#btnVerify').removeAttr('hidden');
                        $('#btnLoading').attr('hidden', true);
                    }
                </script>
            @endif
        @else
            <script>
                $(document).ready(function() {
                    // load data
                    function loadData(startDate = null, endDate = null, idKi) {
                        var data = {};
                        if (startDate && endDate) {
                            data.tanggal1 = startDate;
                            data.tanggal2 = endDate;
                        }

                        if (idKi != '') {
                            data.id_ki = idKi;
                        }

                        var loadingInterval = setInterval(function() {
                            $('#countBaru').text(Math.floor(Math.random() * 100));
                            $('#countDitolak').text(Math.floor(Math.random() * 100));
                            $('#countDiterima').text(Math.floor(Math.random() * 100));
                            $('#countPengajuanPencabutan').text(Math.floor(Math.random() * 100));
                            $('#countPengajuanPembatalan').text(Math.floor(Math.random() * 100));
                            $('#countSelesai').text(Math.floor(Math.random() * 100));
                            $('#countSidang').text(Math.floor(Math.random() * 100));
                            $('#countTotal').text(Math.floor(Math.random() * 100));
                        }, 100);

                        $.ajax({
                            url: "{{ route('beranda.summary') }}",
                            type: 'GET',
                            data: data,
                            success: function(response) {
                                // Tambahkan baris ini
                                console.log(response); 
                                
                                clearInterval(loadingInterval);
                                $('#countBaru').text(response.data.baru);
                                $('#countDitolak').text(response.data.ditolak);
                                $('#countDiterima').text(response.data.diterima);
                                $('#countPengajuanPencabutan').text(response.data.pengajuan_pencabutan);
                                $('#countPengajuanPembatalan').text(response.data.pengajuan_pembatalan);
                                $('#countSelesai').text(response.data.selesai);
                                $('#countSidang').text(response.data.sidang);
                                $('#countTotal').text(response.data.total);
                            },
                            error: function(xhr, status, error) {
                                clearInterval(loadingInterval);
                                console.log(xhr);
                            }
                        });
                    }

                    loadData();

                    $('#btn-search').click(function() {
                        var startDate = formatYmd($('#start-date').val());
                        var endDate = formatYmd($('#end-date').val());
                        if (startDate == '' || endDate == '') {
                            showNotificationError('Tanggal tidak boleh kosong');
                            return;
                        }
                        if (startDate > endDate) {
                            showNotificationError('Tanggal tidak valid');
                            return;
                        }

                        var idKi = $('select[name="id_ki"]').val();

                        loadData(startDate, endDate, idKi);
                    });

                    // Download data
                    function downloadData(startDate = null, endDate = null, idKi) {
                        var data = {};
                        if (startDate && endDate) {
                            data.tanggal1 = startDate;
                            data.tanggal2 = endDate;
                        }

                        if (idKi != '') {
                            data.id_ki = idKi;
                        }

                        $.ajax({
                            url: "{{ route('beranda.download') }}",
                            type: 'GET',
                            data: data,
                            xhrFields: {
                                responseType: 'blob'
                            },
                            success: function(response) {
                                var url = window.URL || window.webkitURL;
                                var objectUrl = url.createObjectURL(response);
                                window.open(objectUrl);
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                            }
                        });
                    }

                    $('.btn-download').click(function() {
                        var startDate = formatYmd($('#start-date').val());
                        var endDate = formatYmd($('#end-date').val());
                        if (startDate == '' || endDate == '') {
                            showNotificationError('Tanggal tidak boleh kosong');
                            return;
                        }
                        if (startDate > endDate) {
                            showNotificationError('Tanggal tidak valid');
                            return;
                        }

                        var idKi = $('select[name="id_ki"]').val();

                        downloadData(startDate, endDate, idKi);
                    });
                });

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
        @endif
    @endpush



@endsection

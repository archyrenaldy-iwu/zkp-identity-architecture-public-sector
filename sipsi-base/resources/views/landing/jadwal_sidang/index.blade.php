@extends('layouts.front.app')
@section('title')
    Jadwal Sidang
@endsection
@section('content')
    <div class="bg-gray-200 h-full">
        <div class="relative mb-2 mx-auto md:w-xl lg:w-full sm:w-full bg-no-repeat bg-cover bg-center h-80 flex flex-col items-center justify-center"
            style="background-image: url('../../img/banner/jadwal-sidang.png')">
            <span class="text-center text-4xl sm:text-4xl md:text-5xl lg:text-6xl  text-white font-bold">
                JADWAL SIDANG
            </span>
            <hr class="mt-7 w-1/3 border-b-4 border-white">
            <span class="text-center text-4xl sm:text-4xl md:text-5xl lg:text-6xl text-white font-bold mt-2">
                @php
                    use Carbon\Carbon;
                    setlocale(LC_TIME, 'id_ID.utf8');
                    Carbon::setLocale('id');
                    $date = Carbon::now();
                @endphp
                {{ $date->isoFormat('D MMMM YYYY') }}

            </span>
        </div>

        <div class="p-8">
            <x-schedule-filter-card :action="route('schedule.filter')">
                <div class="grid grid-cols-1 lg:grid-cols-12">
                    <!-- Row pertama -->
                    <div class="lg:col-span-5 p-4 flex">
                        <div class="grid grid-cols-3 items-center w-full">
                            <div class="col-span-1">
                                <span class="">Dari Tanggal</span>
                            </div>
                            <div class="col-span-2 text-black ml-2 lg:ml-0">
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
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full lg:w-3/4 ps-9 sm:w-full md:w-full p-2.5"
                                        placeholder="Dari Tanggal">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 p-4 flex items-center">
                        <div class="grid grid-cols-3 items-center w-full">
                            <div class="col-span-1">
                                <span class="">Sampai Tanggal</span>
                            </div>
                            <div class="col-span-2 text-black ml-2 lg:ml-0">
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
                    <div class="lg:col-span-2 p-4 hidden lg:inline-block">
                        <button type="submit"
                            class="w-full bg-themecolor-primary border-2 text-white rounded-lg p-2.5">Cari</button>
                    </div>

                </div>
                <div class="grid grid-cols-1 lg:grid-cols-12">
                    <!-- Row pertama -->
                    <div class="lg:col-span-5 p-4 flex">
                        <div class="grid grid-cols-3 items-center w-full">
                            <div class="col-span-1">
                                <span class="">No. Sengketa</span>
                            </div>
                            <div class="col-span-2 text-black ml-2 lg:ml-0">
                                <input type="text" name="no_sengketa" id="no_sengketa"
                                    class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block lg:w-3/4 sm:w-full w-full ps-4 p-2.5"
                                    placeholder="No. Sengketa" />
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 p-4 flex items-center">
                        <div class="grid grid-cols-3 items-center w-full">
                            <div class="col-span-1">
                                <span class="">Komisi Informasi</span>
                            </div>
                            <div class="col-span-2 text-black ml-2 lg:ml-0">
                                <select id="countries" name="id_ki"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-themecolor-primary w-full focus:border-red-800 block lg:w-3/4 sm:w-full ps-4 p-2.5">
                                    <option value="">Pilih Komisi Informasi</option>
                                    @foreach ($kiList as $ki)
                                        <option value="{{ $ki->id }}">{{ $ki->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-2 p-4">
                        <button id="reset-button" class="w-full bg-themecolor-primary border-2 text-white rounded-lg p-2.5">
                            Reset
                        </button>
                        <button type="submit"
                            class="w-full sm:block lg:hidden bg-themecolor-primary border-2 text-white rounded-lg p-2.5 mt-3 lg:mt-0">Cari</button>
                    </div>
                </div>
            </x-schedule-filter-card>

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
                                Pemohon
                            </th>
                            <th class="text-white font-semibold">
                                Termohon
                            </th>
                            <th class="text-white font-semibold">
                                Agenda
                            </th>
                            <th class="text-white font-semibold">
                                Aksi
                            </th>

                        </tr>
                    </thead>
                    <tbody class="text-lg text-center">

                    </tbody>
                </table>

            </div>


        </div>
    @endsection

    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    @endpush

    {{-- stack js --}}
    @push('js')
        {{-- <script src="https://cdn.tailwindcss.com/3.4.3"></script> --}}
        {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.tailwindcss.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.tailwindcss.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>


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
                            data: 'nama_pemohon',
                            name: 'nama_pemohon'
                        },
                        {
                            data: 'nama_termohon',
                            name: 'nama_termohon'
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
                    $('input[name="start_date"]').val('');
                    $('input[name="to_date"]').val('');
                    $('input[name="no_sengketa"]').val('');
                    $('select[name="id_ki"]').val('');

                    table.search('').columns().search('').draw();
                });

                function renderAction(data, row) {
                    var urlDetailSengketa = "{{ route('detail_jadwal_sidang', ':id') }}";
                    urlDetailSengketa = urlDetailSengketa.replace(':id', row.id_sengketa);
                    var title = 'Lacak'

                    reelas =
                        '<a href="' + urlDetailSengketa +
                        '" type="button" class="reelas text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-1 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">' +
                        title + '</a>';


                    return '<div class="w-full text-center"><span style="text-black text-lg font-semibold uppercase leading-tight"> </span>' +
                        reelas + '</div>'
                }

                function formatDate(dateString) {
                    // Parse the original date string
                    const originalDate = new Date(dateString);

                    // Define the desired format options
                    const options = {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric',
                        timeZone: 'Asia/Jakarta', // Adjust if needed based on your location
                    };

                    // Format the date according to the options
                    const formattedDate = originalDate.toLocaleDateString('id-ID', options);

                    return formattedDate;
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


            });
        </script>
    @endpush

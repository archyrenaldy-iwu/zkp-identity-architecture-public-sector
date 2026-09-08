@extends('admin.layouts.master')
@section('title', 'Sengketa')
@section('content')
    @php
        $permissions = getPermissionsForActiveRole();
    @endphp
    <!-- Breadcrumb -->
    {{ Breadcrumbs::render('putusan') }}

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
                                    <select name="sidang_nama"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-themecolor-primary w-full focus:border-red-800 block lg:w-3/4 sm:w-full ps-4 p-2.5">
                                        <option value="" selected>Pilih Status</option>
                                        @foreach (getJenisSidang() as $status)
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
                                    <input type="text" name="no_sengketa"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full lg:w-3/4 sm:w-full md:w-full p-2.5"
                                        placeholder="No. Sengketa">
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

    <div class="relative overflow-x-auto sm:rounded-lg mt-5 mb-2 mx-auto md:max-w-xl lg:max-w-full w-full">
        <table class="w-full mt-8 text-sm text-white table-auto display table-sengketa" id="putusan-table">
            <thead class="text-base text-white bg-themecolor-primary dark:bg-themecolor-primary ">
                <tr>
                    <th class="text-white font-semibold">
                        No
                    </th>
                    <th class="text-white font-semibold">
                        No. Sengketa
                    </th>
                    <th class="text-white font-semibold">
                        Tanggal
                    </th>
                    <th class="text-white font-semibold">
                        Status Sengketa
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

@endsection

@push('prepend-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('prepend-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.tailwindcss.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#putusan-table').DataTable({
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
                    "url": "{{ route('putusan.list') }}",
                    "data": function(d) {
                        d.jenis_sidang = $('select[name="sidang_nama"]').val();
                        d.tanggal1 = $('input[name="start_date"]').val();
                        d.tanggal2 = $('input[name="to_date"]').val();
                        d.no_sengketa = $('input[name="no_sengketa"]').val();
                        d.id_ki = $('select[name="id_ki"]').val();
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
                        "data": "no_sengketa"
                    },
                    {
                        "data": "sidang_waktu"
                    },
                    {
                        "data": "sidang_nama"
                    },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return renderAction(data, row);
                        }
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
                $('select[name="sidang_nama"]').val('');
                $('input[name="start_date"]').val('');
                $('input[name="to_date"]').val('');
                $('input[name="no_sengketa"]').val('');
                $('select[name="id_ki"]').val('');

                table.search('').columns().search('').draw();
            });


            function renderAction(data, row) {
                var actionButtons = '';
                var urlCreatePutusan = "{{ route('admin.putusan.create', '') }}" + "/" + row.id_sengketa;

                // sementara

                @if (in_array(Permissions::FITUR_PUTUSAN_CREATE, $permissions))
                    actionButtons +=
                        `
                    <div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                        <a href="${urlCreatePutusan}"
                        class="bg-[#059669] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </a>
                        <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#059669] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Detail Putusan</span>
                    </div>
                    `
                @endif


                return '<div class="w-full flex items-center justify-center">' + actionButtons + '</div>';
            }



            function showButtonProgress() {
                $('#btn_delete').attr('hidden', true);
                $('#btn_loading_delete').removeAttr('hidden');
                $('#btn_loading_cabut').removeAttr('hidden');
                $('#btn_loading_cancel').removeAttr('hidden');
                $('#btn_cancel').attr('hidden', true);
                $('#btn_cabut').attr('hidden', true);
            }

            function hideButtonProgress() {
                $('#btn_loading_delete').attr('hidden', true);
                $('#btn_loading_cabut').attr('hidden', true);
                $('#btn_loading_cancel').attr('hidden', true);
                $('#btn_delete').removeAttr('hidden');
                $('#btn_cancel').removeAttr('hidden');
                $('#btn_cabut').removeAttr('hidden');
            }

        });
    </script>
@endpush

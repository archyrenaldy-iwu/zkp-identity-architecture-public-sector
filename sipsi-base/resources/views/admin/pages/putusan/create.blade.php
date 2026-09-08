@extends('admin.layouts.master')
@section('title', 'Sengketa')
@section('content')
    @php
        $permissions = getPermissionsForActiveRole();
    @endphp
    <!-- Breadcrumb -->
    <nav class="flex mt-2" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.beranda') }}"
                    class="inline-flex items-center text-sm font-medium text-primary hover:text-blue-600">

                    Beranda
                </a>
            </li>
            <li class="inline-flex items-center">
                /
            </li>
            <li class="inline-flex items-center">
                <p class="inline-flex items-center text-sm font-medium text-primary">
                    Putusan
                </p>
            </li>
            <li class="inline-flex items-center">
                /
            </li>
            <li class="inline-flex items-center">
                <p class="inline-flex items-center text-sm font-medium text-primary">
                    Tambah Putusan
                </p>
            </li>
        </ol>
    </nav>
    <div class="flex justify-start md:ml-0 mt-2">
        <a href="{{ route(Permissions::MENU_PUTUSAN) }}"
            class="bg-themecolor-primary text-white rounded-lg p-2.5 mt-4">Kembali</a>
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
                        Pemohon
                    </th>
                    <th class="text-white font-semibold">
                        Termohon
                    </th>
                    <th class="text-white font-semibold">
                        Jenis Sidang
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

    <!-- tambah modal -->
    <div id="tambah-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-6 w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-themecolor-secondary rounded-lg shadow-lg border-4 border-primary">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 rounded-t dark:border-gray-600 bg-primary">
                    <h3 class="text-xl font-bold text-white">Nomor Sengketa: <span id="no_sengketa"></span></h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 md:p-5 space-y-4">
                    <input type="hidden" id="id_history" value="">
                    <div class="mb-4 grid grid-cols-3 gap-2">
                        <div class="text-xl font-bold text-red-900 col-span-1">No. Akta Registrasi </div>
                        <div class="text-xl text-red-900 col-span-2" id="no_registrasi"></div>
                    </div>
                    <div class="mb-4 grid grid-cols-3 gap-2">
                        <div class="text-xl font-bold text-red-900 col-span-1">Nama Pemohon </div>
                        <div class="text-xl text-red-900 col-span-2" id="nama_pemohon"></div>
                    </div>
                    <div class="mb-4 grid grid-cols-3 gap-2">
                        <div class="text-xl font-bold text-red-900 col-span-1">Nama Termohon </div>
                        <div class="text-xl text-red-900 col-span-2" id="nama_termohon"></div>
                    </div>
                    <div class="mb-4 grid grid-cols-3 gap-2">
                        <div class="text-xl font-bold text-red-900 col-span-1">Tanggal Registrasi </div>
                        <div class="text-xl text-red-900 col-span-2" id="tanggal_registrasi"></div>
                    </div>
                    <div class="mb-4 grid grid-cols-3 gap-2">
                        <div class="text-xl font-bold text-red-900 col-span-1">Jenis Putusan </div>
                        <div class="text-xl text-red-900 col-span-2">
                            <select id="jenisPutusan"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                <option value="" selected>Pilih Jenis Putusan</option>
                                @foreach (getJenisPutusan() as $putusan)
                                    <option value="{{ $putusan->id }}" data-is-selesai="{{ $putusan->is_selesai }}">{{ $putusan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 grid grid-cols-3 gap-2">
                        <div class="text-xl font-bold text-red-900 col-span-1">Berkas </div>
                        <div class="text-xl text-red-900 col-span-2">
                            <input id="berkas" type="file"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" />
                        </div>
                    </div>
                    <div class="mb-4 grid grid-cols-3 gap-2">
                        <div class="text-xl font-bold text-red-900 col-span-1">Link JDIH </div>
                        <div class="text-xl text-red-900 col-span-2">
                            <input id="linkJDIH" type="text"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                                placeholder="Link JDIH" />
                        </div>
                    </div>
                    <div id="keterangan_selesai" class="mb-4 text-sm text-red-900">
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button class="bg-gray-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-gray-600"
                            data-modal-hide="tambah-modal">Kembali</button>
                        <button class="bg-primary text-white px-4 py-2 rounded-md shadow-md hover:bg-red-600"
                            id="simpanBtn">Simpan</button>
                        <button id="btn_loading" hidden
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
                    <h3 class="mb-5 text-lg font-normal text-black dark:text-gray-400">Anda yakin akan hapus Putusan
                        ini?</h3>
                    <button data-modal-hide="delete-modal" type="button"
                        class="text-white bg-gray-600 border hover:bg-gray-100 hover:text-themecolor-primary focus:z-10 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Kembali
                    </button>
                    <button type="button" id="btn_delete"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-white rounded-lg bg-themecolor-primary hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
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

    {{-- init modal --}}
    <script>
        var modalElement = '';
        var modal = '';
        var deleteModal = '';

        document.addEventListener('DOMContentLoaded', function() {
            //initialize modal
            modalElement = document.getElementById('tambah-modal');
            modalElementDelete = document.getElementById('delete-modal');

            modal = new Modal(modalElement);
            deleteModal = new Modal(modalElementDelete, {
                backdrop: 'static'
            });

            closeModalButtonsCabut = modalElement.querySelectorAll('[data-modal-hide]');
            closeModalButtonsDelete = modalElementDelete.querySelectorAll('[data-modal-hide]');

            closeModalButtonsCabut.forEach(function(button) {
                button.addEventListener('click', function() {
                    modal.hide();
                });
            });

            closeModalButtonsDelete.forEach(function(button) {
                button.addEventListener('click', function() {
                    deleteModal.hide();
                });
            });

            $('#putusan-table').on('click', '.tambah', function() {
                var id_history = $(this).data("id");
                var no_registrasi = $(this).data("no-registrasi");
                var no_sengketa = $(this).data("no-sengketa");
                var nama_pemohon = $(this).data("nama-pemohon");
                var nama_termohon = $(this).data("nama-termohon");
                var tanggal_registrasi = $(this).data("tanggal-registrasi");
                $('#id_history').val(id_history);
                $('#no_registrasi').text(no_registrasi);
                $('#nama_pemohon').text(nama_pemohon);
                $('#nama_termohon').text(nama_termohon);
                $('#no_sengketa').text(no_sengketa);
                var date = new Date(tanggal_registrasi);
                var formattedDate = date.getDate() + " " + date.toLocaleString('id', {
                    month: 'long'
                }) + " " + date.getFullYear();
                $('#tanggal_registrasi').text(formattedDate);

                modal.show();
            });

            $('#putusan-table').on('click', '.delete', function() {
                var id = $(this).data("id");
                $('#delete_id').val(id);
                deleteModal.show();
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            var id = {{ $id }};
            var url = 'id_sengketa=' + id;
            var newUrl = '{{ route('putusan.list', ':url') }}';
            newUrl = newUrl.replace(':url', url);

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
                    "url": newUrl,
                    "data": function(d) {}
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
                        "data": "nama_pemohon"
                    },
                    {
                        "data": "nama_termohon"
                    },
                    {
                        "data": "sidang_nama"
                    },
                    {
                        "data": "sidang_agenda"
                    },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return renderAction(data, row);
                        }
                    }
                ]
            });

            function renderAction(data, row) {
                var actionButtons = '';
                var urlCreatePutusan = "{{ route('admin.putusan.create', '') }}" + "/" + row.id_sengketa;

                if (row.id_jenis_putusan === null) {
                    @if (in_array(Permissions::FITUR_PUTUSAN_CREATE, $permissions))
                        actionButtons += `
                            <div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                                <button data-id="${row.id_history}"
                                data-no-registrasi="${row.no_registrasi}"
                                data-no-sengketa="${row.no_sengketa}"
                                data-nama-pemohon="${row.nama_pemohon}"
                                data-nama-termohon="${row.nama_termohon}"
                                data-tanggal-registrasi="${row.tanggal_permohonan}"
                                data-tipe="pengajuan"
                                data-modal-target="tambah-modal"
                                class="tambah bg-[#059669] px-2 py-1 rounded hover:opacity-75">
                                    <svg class="h-4 w-4 font-semibold text-white" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                    </svg>
                                </button>
                                <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#059669] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Tambah Putusan</span>
                            </div>
                        `;
                    @endif
                } else {
                    @if (in_array(Permissions::FITUR_PUTUSAN_DELETE, $permissions))
                        actionButtons += `
                            <div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                                <button data-id="${row.id_history}"
                                class="delete bg-[#AE0008] px-2 py-1 rounded hover:opacity-75">
                                    <svg class="h-4 w-4 font-semibold text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#AE0008] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Hapus Putusan</span>
                            </div>
                        `;
                    @endif
                }

                return '<div class="w-full text-center">' + actionButtons + '</div>';
            }

            $('#simpanBtn').on('click', function() {
                var jenisPutusan = $('#jenisPutusan').val();
                var berkas = $('#berkas').prop('files')[0];
                var linkJDIH = $('#linkJDIH').val();
                var id_history = $('#id_history').val();
                var formData = new FormData();
                formData.append('id_jenis_putusan', jenisPutusan);
                formData.append('file_putusan', berkas);
                formData.append('putusan_link_jdih', linkJDIH);
                formData.append('id_history', id_history);
                showButtonProgress();
                if (!validateForm()) {
                    hideButtonProgress();
                    return;
                }
                $.ajax({
                    url: "{{ route('putusan.create') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            showNotificationSuccess(response.message);
                            $('#putusan-table').DataTable().ajax.reload();
                            modal.hide();
                        } else {
                            showNotificationError(response.message);
                        }
                        hideButtonProgress();
                        table.ajax.reload();
                    },
                    error: function(response) {
                        showNotificationError(response.responseJSON.message);
                        hideButtonProgress();
                    }
                });
            });

            $("#btn_delete").click(function(e) {
                e.preventDefault();
                showButtonProgress();

                var deleteId = $('#delete_id').val();
                var url = "{{ route('putusan.delete', ':id') }}";

                url = url.replace(':id', deleteId);

                $.ajax({
                    type: "DELETE",
                    dataType: "json",
                    url: url,
                    success: function(response) {
                        deleteModal.hide();

                        table.ajax.reload();

                        hideButtonProgress();

                        showNotificationSuccess(response.message)
                    },
                    error: function(response) {
                        var errors = response.responseJSON;
                        hideButtonProgress();
                        showNotificationError(errors.message);
                        if (errors.errors != null) {
                            $.each(errors.errors, function(key, value) {
                                showNotificationError(value);
                            });
                        }
                    }
                });
            });

            function validateForm() {
                var jenisPutusan = $('#jenisPutusan').val();
                var berkas = $('#berkas').prop('files')[0];
                var linkJDIH = $('#linkJDIH').val();
                var selectedSengketaIsSelesai = $('#jenisPutusan option:selected').data('is-selesai');
                var sengketaIsSelesai = selectedSengketaIsSelesai == 1 ? true : false;

                if (sengketaIsSelesai == true && linkJDIH == '' || sengketaIsSelesai && linkJDIH == null) {
                    showNotificationError('Link JDIH harus diisi');
                    return false;
                }

                if (jenisPutusan == '' || !berkas) {
                    showNotificationError('Semua field harus diisi');
                    return false;
                }
                return true;
            }

            $('#jenisPutusan').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var isSelesai = selectedOption.data('is-selesai');
                var keteranganSelesaiDiv = $('#keterangan_selesai');
                
                if (isSelesai == true) {
                    keteranganSelesaiDiv.text("Putusan yang anda pilih akan menyelesaikan sengketa");
                } else {
                    keteranganSelesaiDiv.text("");
                }
            });

            function showButtonProgress() {
                $('#simpanBtn').attr('hidden', true);
                $('#btn_delete').attr('hidden', true);
                $('#btn_loading').removeAttr('hidden');
                $('#btn_loading_delete').removeAttr('hidden');
            }

            function hideButtonProgress() {
                $('#btn_loading_delete').attr('hidden', true);
                $('#btn_loading').attr('hidden', true);
                $('#btn_delete').removeAttr('hidden');
                $('#simpanBtn').removeAttr('hidden');
            }


        });
    </script>
@endpush

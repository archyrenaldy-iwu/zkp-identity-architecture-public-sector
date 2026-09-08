@extends('admin.layouts.master')
@section('title', 'Panduan')
@push('prepend-style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
@endpush
@section('content')

    @php
        $permissions = getPermissionsForActiveRole();
    @endphp

    <!-- Breadcumb -->
    {{ Breadcrumbs::render('panduan') }}


    <!-- Header -->
    {{-- <div class="max-w-lg mt-5 text-primary text-3xl font-semibold font-lato leading-[39px]">Panduan</div> --}}
    <div class="mt-6">
        @if (in_array(Permissions::FITUR_PANDUAN_CREATE, $permissions))
            @if ($isSuperAdmin)
                <div class="flex flex-row justify-between">
                    <div class="flex flex-row justify-between">
                        <button data-modal-target="crud-modal" id="tambah_data"
                            class="flex items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-4">
                            <svg class="h-4 w-4 mr-2 font-semibold" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Tambah Panduan
                        </button>
                    </div>
                    {{-- <button id="open-modal-button" class="text-yellowColor hover:text-blue-600 font-semibold text-xs uppercase leading-tight">[perbarui]</button> --}}
                </div>
            @endif
        @endif

    </div>

    <!-- Table User -->
    <div class="relative overflow-x-auto sm:rounded-lg mt-5 mb-2 w-full">
        <table class="w-full text-sm text-white table-auto display table-jadwal" id="panduan-table">
            <thead class="text-base bg-themecolor-primary dark:bg-themecolor-primary ">
                <tr>
                    <th class="text-white font-semibold">
                        No
                    </th>
                    <th class="text-white font-semibold">
                        Nama Dokumen
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

    <!-- Main modal -->
    <div id="crud-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow border-2 border-primary dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 id="title-form" class="text-lg font-semibold text-primary dark:text-white">
                        Tambah Panduan
                    </h3>
                    <button type="button" data-modal-hide="crud-modal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="frm-panduan" class="p-4 md:p-5" enctype="multipart/form-data">

                    <div class="grid gap-4 mb-4 grid-cols-1">
                        <div class="col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="jenis">
                                    Jenis Identitas
                                </label>
                                <div>
                                    <select name="jenis" id="jenis" onchange="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        required>
                                        <option value="" selected>Jenis Panduan *</option>
                                        <option value="super-admin">Super Admin</option>
                                        <option value="admin">Admin</option>
                                        <option value="pemohon">Pemohon</option>
                                        {{-- @foreach (getRolesAll() as $key => $item)
                                            <option value="{{ $item->name }}">{{ $item->description }}</option>
                                        @endforeach --}}
                                    </select>
                                    <p id="error_jenis" class="error text-sm text-red-600 dark:text-red-500">
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="judul">
                                    Judul Panduan
                                </label>
                                <div>
                                    <input type="text" name="judul" id="judul" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Judul Panduan *" required="">
                                    <p id="error_judul" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>
                        </div>


                        <div class="col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="file_panduan">
                                    Berkas Panduan
                                </label>
                                <div>
                                    <input type="file" name="file_panduan" id="file_panduan" onchange="clearError(this)"
                                        class="mt-1 block w-full text-gray-500" required>
                                    <p id="error_file_panduan" class="error text-sm text-red-600 dark:text-red-500">
                                    </p>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="text-right mt-5">
                        <button type="reset" data-modal-hide="crud-modal"
                            class="w-xl text-primary bg-white border border-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                            Kembali
                        </button>
                        <button type="submit" id="btn_submit"
                            class="w-xl text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                            Simpan
                        </button>
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
                </form>
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
                    <h3 class="mb-5 text-lg font-normal text-black dark:text-gray-400">Anda yakin akan hapus panduan ini?
                    </h3>
                    <button data-modal-hide="delete-modal" type="button"
                        class="text-white bg-gray-600 border hover:bg-gray-100 hover:text-themecolor-primary focus:z-10 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Kembali
                    </button>
                    <button type="button" id="btn_delete"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-white rounded-lg bg-themecolor-primary hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
                        Iya</button>
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
@endsection
{{-- stack js --}}
@push('prepend-script')
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.tailwindcss.js"></script>
    <script>
        var modalElement = '';
        var modalElementDelete = '';
        var modal = '';
        var deleteModal = '';
        document.addEventListener('DOMContentLoaded', function() {
            modalElement = document.getElementById('crud-modal');
            modalElementDelete = document.getElementById('delete-modal');
            modal = new Modal(modalElement, {
                backdrop: 'static'
            });
            deleteModal = new Modal(modalElementDelete, {
                backdrop: 'static'
            });

            const closeModalButtons = modalElement.querySelectorAll('[data-modal-hide]');
            const closeModalButtonsDelete = modalElementDelete.querySelectorAll('[data-modal-hide]');

            //Hide each close modal button
            closeModalButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    modal.hide();
                });
            });

            //Hide each close delete modal button
            closeModalButtonsDelete.forEach(function(button) {
                button.addEventListener('click', function() {
                    deleteModal.hide();
                });
            });

            //button tambah data ki
            $('#tambah_data').on('click', function() {
                $("#frm-panduan").trigger("reset");
                $('#title-form').html("Tambah Panduan");
                $('.error').text("");

                modal.show();
            });

            $('#panduan-table').on('click', '.edit', function() {
                var userId = $(this).data('id');
                $("#frm-panduan").trigger("reset");
                $('#title-form').html("Edit Panduan");
                $('.error').text("");
                // getUserById(userId);
                modal.show();
            });

            //button delete data ki from table
            $('#panduan-table').on('click', '.delete', function() {
                var id = $(this).data("id");
                $('#delete_id').val(id);
                deleteModal.show();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#panduan-table').DataTable({
                layout: {
                    topStart: 'search',
                    topEnd: null,
                    bottomStart: 'paging',
                    bottomEnd: 'info',
                },
                processing: true,
                serverSide: true,
                paging: false,
                bDestroy: true,
                lengthChange: true,
                searching: false,
                ordering: false,
                info: false,
                autoWidth: false,
                responsive: true,
                pagingType: 'first_last_numbers',
                ajax: "{{ route('panduan.list') }}",
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
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'file',
                        render: (data, type, row) => renderAction(data, row),

                    }
                ]
            });

            //Submit form modal
            $("#btn_submit").click(function(e) {
                e.preventDefault();

                var url = "{{ route('panduan.create') }}";

                //if edit change the URL
                // if ($('#id_user').val() != '') {
                //     url = "{{ route('user-internal.update', ':id') }}";
                //     url = url.replace(':id', $('#id_user').val());
                // }

                var formData = {
                    _token: "{{ csrf_token() }}",
                    judul: $("#judul").val(),
                    file_panduan: $("#file_panduan").val(),
                    jenis: $("#jenis").val(),
                };

                var frmSerialize = new FormData($('#frm-panduan')[0]);

                // Validate Form
                var validate = validateForm(formData);

                if (validate.length == 0) {
                    showButtonProgress();

                    $.ajax({
                        type: 'POST',
                        data: frmSerialize,
                        processData: false,
                        contentType: false,
                        url: url,
                        success: function(response) {
                            hideButtonProgress();
                            modal.hide();
                            table.ajax.reload();
                            showNotificationSuccess(response.message)
                        },
                        error: function(response) {
                            var errors = response.responseJSON;
                            var errorMessage = '';
                            $.each(errors.errors, function(key,
                                value) {
                                errorMessage += value + '<br>'
                            })
                            hideButtonProgress();
                            showNotificationError(errorMessage)
                        }
                    });
                }

            });

            //Submit form delete modal
            $("#btn_delete").click(function(e) {
                e.preventDefault();
                showButtonProgress();

                var deleteId = $('#delete_id').val();
                var url = "{{ route('panduan.destroy', ':id') }}";

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
                        // showNotificationError(errors.message);
                        hideButtonProgress();
                        if (errors.errors != null) {
                            $.each(errors.errors, function(key, value) {
                                showNotificationError(value);
                            });
                        }
                    }
                });
            });


        });

        function validateForm(formData) {
            var arrayBool = [];

            if (formData.judul == "") {
                $('#error_judul').text('Judul tidak boleh kosong')
                arrayBool.push(true);
            } else {
                $('#error_judul').text('');
            }


            if (formData.file_panduan == "") {
                $('#error_file_panduan').text('File Panduan tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_file_panduan').text('');
            }

            if (formData.jenis == "") {
                $('#error_jenis').text('Jenis Panduan tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_jenis').text('');
            }

            return arrayBool;
        }

        function showButtonProgress() {
            $('#btn_loading').removeAttr('hidden');
            $('#btn_submit').attr('hidden', true);
        }

        function hideButtonProgress() {
            $('#btn_submit').removeAttr('hidden');
            $('#btn_loading').attr('hidden', true);
        }

        function clearError(input) {
            if (input == 'jenis_pengguna') {
                $('#error_jenis_pengguna').text('');
            } else {
                $('#error_' + input.id).text('');

            }
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

        function formatDmy(dateString) {
            if (dateString != '' && dateString != null) {
                const parts = dateString.split('-')
                const year = parts[0];
                const month = parts[1];
                const day = parts[2];

                const formattedDate = `${day}/${month}/${year}`;
                return formattedDate;
            }
            return '';
        }

        function renderAction(data, row) {
            // Button Show
            var isSuperAdmin = "{{ $isSuperAdmin }}";
            var route = "{{ route('admin.menu_panduan.show', 'path=:path') }}";
            route = route.replace(':path', data);

            var show =
                `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                    <a
                    href=${route}
                    class="show bg-[#059669] px-2 py-1 rounded hover:opacity-75 inline-flex items-center">
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                    <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#059669] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Lihat</span>
                </div>`;

            var hapus = "";
            @if (in_array(Permissions::FITUR_PANDUAN_DELETE, $permissions))
                if (isSuperAdmin) {
                    var hapus =
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
            @endif

            return '<div class="w-full text-center">' + show +
                '<span style="text-black text-lg font-semibold uppercase leading-tight"> </span>' + hapus + '</div>'
        }
    </script>
@endpush

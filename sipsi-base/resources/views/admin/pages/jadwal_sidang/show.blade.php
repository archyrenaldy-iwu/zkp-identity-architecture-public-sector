@extends('admin.layouts.master')
@section('title', 'History Sengketa')
@push('prepend-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')

    @php
        $permissions = getPermissionsForActiveRole();
    @endphp

    <!-- Breadcumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.beranda') }}"
                    class="inline-flex items-center text-sm font-medium text-primary hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    Beranda
                </a>
            </li>
            <li class="inline-flex items-center">
                /
            </li>
            <li class="inline-flex items-center">
                <a href="{{ route(Permissions::MENU_JADWAL) }}"
                    class="inline-flex items-center text-sm font-medium text-primary hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    Jadwal Sidang
                </a>
            </li>
            <li class="inline-flex items-center">
                /
            </li>
            <li class="inline-flex items-center">
                <p
                    class="inline-flex items-center text-sm font-medium text-primary dark:text-gray-400 dark:hover:text-white">
                    History Sengketa
                </p>
            </li>
        </ol>
    </nav>
    <div class="flex flex-row justify-between w-full mt-5 text-primary text-xl font-semibold font-lato leading-[39px]">
        <div>
            Nomor Sengketa : {{ $sengketa->no_sengketa }}
        </div>
        @if ($sengketa->enable_tambah_jadwal)
            @if (in_array(Permissions::FITUR_JADWAL_SIDANG_CREATE, $permissions))
                <div>
                    <button type="button" data-modal-target="tambah-modal" id="tambah_data"
                        class="show z-20 text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                        Tambah Jadwal
                    </button>
                </div>
            @endif
        @endif
    </div>
    <!-- Table Sengketa Detail -->
    <div class="relative overflow-x-auto sm:rounded-lg mt-5 mb-2 mx-auto md:max-w-xl lg:max-w-full w-full">
        <table class="w-full text-sm text-white table-auto display table-jadwal" style="width:100%"
            id="history-sengketa-table">
            <thead class="text-base bg-themecolor-primary dark:bg-themecolor-primary ">
                <tr>
                    <th class="text-white font-semibold">
                        No
                    </th>
                    <th class="text-white font-semibold">
                        Jenis Sidang
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

    <!-- Tambah modal -->
    <div id="tambah-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow border-2 border-primary dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 id="title-form" class="text-lg font-semibold text-primary dark:text-white">
                        Nomor Sengketa :<p id="val_no_sengketa" class="value-item-detail">
                        <div class="pulse h-2.5 inline-block bg-gray-200 rounded-full dark:bg-gray-700 w-48"></div>
                        </p>
                    </h3>
                    <button type="button" data-modal-hide="tambah-modal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Detail Sengketa -->
                <div id="item-detail" class="item-detail animate-pulse p-4 md:p-5">
                    <table class="table-borderless">
                        <tr>
                            <td class="w-56 align-top">
                                <label class="shrink label-item-detail font-semibold text-md"> No Akta Registrasi
                                </label>
                            </td>
                            <td>
                                <p id="val_no_registrasi" class="value-item-detail">
                                <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-56 align-top">
                                <label class="shrink label-item-detail font-semibold text-md"> Nama Pemohon </label>
                            </td>
                            <td>
                                <p id="val_nama_pemohon" class="value-item-detail">
                                <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-56 align-top">
                                <label class="shrink label-item-detail font-semibold text-md"> Nama Termohon </label>
                            </td>
                            <td>
                                <p id="val_nama_termohon" class="value-item-detail">
                                <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-56 align-top">
                                <label class="shrink label-item-detail font-semibold text-md"> Tanggal Registrasi
                                </label>
                            </td>
                            <td>
                                <p id="val_tanggal_permohonan" class="value-item-detail">
                                <div class="pulse h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- Modal body -->
                <form id="frm-jadwal" class="hidden p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-1">
                        <!-- Identitas User -->
                        <div class="col-span-1">
                            <div class="flex flex-col space-y-2">
                                <Label class="text-sm">Jenis Sidang</Label>
                                <div>
                                    <select name="id_jenis_sidang" id="id_jenis_sidang" onchange="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        required>
                                        <option value="">Jenis Sidang</option>
                                        @foreach (getJenisSidang() as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>

                                    <p id="error_id_jenis_sidang" class="error text-sm text-red-600 dark:text-red-500">
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="flex flex-col space-y-2">
                                <Label class="text-sm">Agenda</Label>
                                <div>
                                    <input type="text" name="sidang_agenda" id="sidang_agenda"
                                        onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Agenda *" required="">
                                    <p id="error_sidang_agenda" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-1">
                            <div class="flex flex-col space-y-2">
                                <Label class="text-sm">Tanggal Jam</Label>
                                <div>
                                    <div class="flex flex-row space-x-2">
                                        <input onclick="clearError(this)" type="text" name="sidang_waktu_tanggal"
                                            id="sidang_waktu_tanggal"
                                            class="bg-white border border-primary text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48"
                                            placeholder="Tanggal dan Jam">
                                    </div>
                                    <p id="error_sidang_waktu" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-1">
                            <div class="flex flex-col space-y-2">
                                <Label class="text-sm">Alamat</Label>
                                <div>
                                    <textarea id="sidang_alamat" rows="4" name="sidang_alamat" onkeydown="clearError(this)"
                                        class="text-sm bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Alamat *"></textarea>
                                    <p id="error_sidang_alamat" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="text-right mt-5">
                        <button type="reset" data-modal-hide="tambah-modal"
                            class="w-xl text-primary bg-white border border-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                            Kembali
                        </button>
                        <button type="submit" id="btn_submit"
                            class="w-xl text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                            Simpan dan Buat Reelas
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        var modalElement = '';
        var modalElementLoading = '';
        var modal = '';
        var loadingModal = '';
        document.addEventListener('DOMContentLoaded', function() {
            modalElement = document.getElementById('tambah-modal');
            modalElementLoading = document.getElementById('loading-modal');

            modal = new Modal(modalElement, {
                backdrop: 'static'
            });

            loadingModal = new Modal(modalElementLoading, {
                backdrop: 'static'
            });

            const closeModalButtons = modalElement.querySelectorAll('[data-modal-hide]');

            //Hide each close modal button
            closeModalButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    modal.hide();
                });
            });

            //button tambah Jadwal Sidang
            $('#tambah_data').on('click', function() {
                $("#frm-jadwal").trigger("reset");
                $("#frm-jadwal").addClass('hidden');
                $('.error').text("");
                getDetailSengketa()
                modal.show();
            });

            $('#history-sengketa-table').on('click', '.reelas', function() {
                const historyId = $(this).data("id");
                const isCreated = $(this).data("iscreated");
                createReelas(historyId, isCreated)
            });
        });
    </script>
    <script>
        const path = window.location.pathname;
        const lastSlashIndex = path.lastIndexOf('/');
        const idSengketa = path.substring(lastSlashIndex + 1);

        $(document).ready(function() {

            var url =
                "{{ route('jadwal-sidang.history-sidang', ':id_sengketa') }}";
            url = url.replace(':id_sengketa', idSengketa);

            var table = $('#history-sengketa-table').DataTable({
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
                    "url": url
                },
                "order": [
                    [0, "desc"]
                ],
                columns: [{
                        "data": "id_history",
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'jenis_sidang',
                        name: 'jenis_sidang'
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

            //Submit form modal
            $("#btn_submit").click(function(e) {
                e.preventDefault();
                var url = "{{ route('jadwal-sidang.create') }}";

                var formData = {
                    _token: "{{ csrf_token() }}",
                    id_sengketa: idSengketa,
                    id_jenis_sidang: $("#id_jenis_sidang").val(),
                    sidang_agenda: $("#sidang_agenda").val(),
                    sidang_waktu: formatYmdWithTime($("#sidang_waktu_tanggal").val()) + ':00',
                    sidang_alamat: $("#sidang_alamat").val(),
                };
                // console.log(formData)

                // Validate Form
                var validate = validateForm(formData);

                if (validate.length == 0) {
                    showButtonProgress();

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        url: url,
                        success: function(response) {
                            hideButtonProgress();
                            modal.hide();
                            table.ajax.reload();
                            showNotificationSuccess(response.message)
                        },
                        error: function(response) {
                            var errors = response.responseJSON;
                            var errorMessage = errors.message + '<br>';
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

            $('#sidang_waktu_tanggal').flatpickr({
                enableTime: true,
                dateFormat: "d/m/Y H:i",
            });
        });

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

        function validateForm(formData) {
            var arrayBool = [];

            if (formData.id_jenis_sidang == "") {
                $('#error_id_jenis_sidang').text('Jenis Sidang tidak boleh kosong')
                arrayBool.push(true);
            } else {
                $('#error_id_jenis_sidang').text('');
            }

            if (formData.sidang_agenda == "") {
                $('#error_sidang_agenda').text('Agenda tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_sidang_agenda').text('');
            }

            if (formData.sidang_waktu == ":00") {
                $('#error_sidang_waktu').text('Tanggal dan jam tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_sidang_waktu').text('');
            }


            if (formData.sidang_alamat == "") {
                $('#error_sidang_alamat').text('Jenis identitas tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_sidang_alamat').text('');
            }

            return arrayBool;
        }

        function getDetailSengketa() {
            var url = "{{ route('jadwal-sidang.list-sengketa', ':id_sengketa') }}";

            url = url.replace(':id_sengketa', "id_sengketa=" + idSengketa);
            resetDetailSengketa();
            showLoadingSengketa();
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(response) {
                    assignDetailSengketaIntoForm(response)
                },
                error: function(response) {
                    showNotificationError('Data tidak ditemukan')
                    hideLoadingSengketa();
                }
            });
        }

        function assignDetailSengketaIntoForm(sengketa) {
            $('#item-detail').removeClass('animate-pulse');
            $('.pulse').addClass('hidden');

            $("#val_no_sengketa").html(sengketa.no_sengketa);
            $("#val_no_registrasi").html(sengketa.no_registrasi);
            $("#val_nama_pemohon").html(sengketa.nama_pemohon);
            $("#val_nama_termohon").html(sengketa.nama_termohon);
            $("#val_tanggal_permohonan").html(formatDateNoHour(sengketa.tanggal_permohonan));
            $("#sidang_alamat").val(sengketa.alamat_ki);

            $("#frm-jadwal").removeClass('hidden');
        }

        function resetDetailSengketa() {
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
            $('#btn_submit').attr('hidden', true);
        }

        function hideButtonProgress() {
            $('#btn_submit').removeAttr('hidden');
            $('#btn_loading').attr('hidden', true);
        }

        function clearError(input) {
            if (input.id == 'sidang_waktu_tanggal' || input.id == 'sidang_waktu_jam') {
                $('#error_sidang_waktu').text('');
            }
            $('#error_' + input.id).text('');
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

        function formatYmdWithTime(dateString) {
            if (dateString != '' && dateString != null) {
                const dateAndTime = dateString.split(' ');
                const date = dateAndTime[0];
                const time = dateAndTime[1];

                const parts = date.split('/');
                const day = parts[0];
                const month = parts[1];
                const year = parts[2];

                const formattedDate = `${year}-${month}-${day}` + ' ' + time;
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
            var title = 'Buat Reelas'
            var isCreated = false;
            var reelas = "";

            if (row.file_reelas_pemohon != null) {
                title = 'Lihat Reelas';
                isCreated = true;
            }

            @if (in_array(Permissions::FITUR_JADWAL_SIDANG_REELAS_CREATE, $permissions))
                reelas =
                    '<button data-id=' + data + ' data-iscreated=' + isCreated +
                    ' type="button" class="reelas text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-1 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">' +
                    title + '</button>';
            @endif

            @if (in_array(Permissions::FITUR_JADWAL_SIDANG_REELAS_SHOW, $permissions))
                reelas =
                    '<button data-id=' + data + ' data-iscreated=' + isCreated +
                    ' type="button" class="reelas text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-1 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">' +
                    title + '</button>';
            @endif


            return '<div class="w-full text-center">' + reelas +
                '<span style="text-black text-lg font-semibold uppercase leading-tight"> </span></div>'
            // var edit =
            //     '<button data-id=' + data +
            //     ' type="button" class="edit text-yellowColor hover:text-blue-600 font-semibold text-xs uppercase leading-tight">[perbarui]</button>';
            // var hapus =
            //     '<button data-id=' + data +
            //     ' class="delete text-themecolor-primary hover:text-blue-600 font-semibold text-xs uppercase leading-tight">[Hapus]</button>';
            // return '<div class="w-full text-center">' + edit +
            //     '<span style="text-black text-lg font-semibold uppercase leading-tight"> </span>' +
            //     hapus + '</div>'
        }
    </script>
@endpush

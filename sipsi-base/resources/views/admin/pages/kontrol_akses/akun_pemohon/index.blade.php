@extends('admin.layouts.master')
@section('title', 'Akun Pemohon')
@push('prepend-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
@endpush
@section('content')

    @php
        $permissions = getPermissionsForActiveRole();
    @endphp

    <!-- Breadcumb -->
    {{ Breadcrumbs::render('akun_pemohon') }}


    <!-- Header -->
    <div class="max-w-lg mt-5 text-primary text-3xl font-semibold font-lato leading-[39px]">Akun Pemohon</div>
    <div class="mt-6">

        @if (in_array(Permissions::FITUR_USER_PEMOHON_CREATE, $permissions))
            <div class="flex flex-row justify-between">
                <div class="flex flex-row justify-between">
                    <button data-modal-target="crud-modal" id="tambah_data"
                        class="flex items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-4">
                        <svg class="h-4 w-4 mr-2 font-semibold" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        Tambah Akun
                    </button>
                </div>
                {{-- <button id="open-modal-button" class="text-yellowColor hover:text-blue-600 font-semibold text-xs uppercase leading-tight">[perbarui]</button> --}}
            </div>
        @endif
    </div>

    <!-- Table User -->
    <div class="relative overflow-x-auto sm:rounded-lg mt-5 mb-2 mx-auto md:max-w-xl lg:max-w-full w-full">
        <table class="w-full text-sm text-white table-auto display table-jadwal" style="width:100%" id="user-table">
            <thead class="text-base bg-themecolor-primary dark:bg-themecolor-primary ">
                <tr>
                    <th class="text-white font-semibold">
                        No
                    </th>
                    <th class="text-white font-semibold">
                        Nama
                    </th>
                    <th class="text-white font-semibold">
                        Email
                    </th>
                    <th class="text-white font-semibold">
                        Role
                    </th>
                    <th class="text-white font-semibold">
                        Jenis Pemohon
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
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow border-2 border-primary dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 id="title-form" class="text-lg font-semibold text-primary dark:text-white">
                        Tambah Akun Pemohon
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
                <form id="frm-user" class="p-4 md:p-5">
                    <div class="col-span-2 sm:col-span-1">
                        <input type="hidden" id="id_user">
                    </div>
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <!-- Identitas User -->
                        <div class="col-span-2">
                            <label for="category"
                                class="block mb-2 text-base font-semibold text-gray-900 dark:text-white">A.
                                Informasi Akun</label>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="jenis_pemohon">
                                    Jenis Pemohon <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <select name="jenis_pemohon" id="jenis_pemohon"
                                        onchange="onJenisPemohonChange(this);clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        required>
                                        <option selected value=""> JENIS PEMOHON</option>
                                        <option value="PERORANGAN">PERORANGAN</option>
                                        <option value="LEMBAGA">LEMBAGA</option>
                                        <option value="KELOMPOK ORANG">KELOMPOK ORANG</option>
                                    </select>
                                    <p id="error_jenis_pemohon" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="name">
                                    Nama Lengkap <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="text" name="name" id="name" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Nama Lengkap" required="">
                                    <p id="error_name" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="jenis_identitas">
                                    Jenis Identitas <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <select name="jenis_identitas" id="jenis_identitas" disabled
                                        onchange="onJenisIdentitasChange(this);clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        required>
                                        <option value="" selected>Jenis Identitas</option>
                                        <option value="KTP">KTP</option>
                                        <option value="SIM">SIM</option>
                                        <option value="PASPOR">PASPOR</option>
                                    </select>
                                    <p id="error_jenis_identitas" class="error text-sm text-red-600 dark:text-red-500">
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="nomor_identitas">
                                    Nomor Identitas <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="text" name="nomor_identitas" id="nomor_identitas"
                                        onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Nomor Identitas" required="">
                                    <p id="error_nomor_identitas" class="error text-sm text-red-600 dark:text-red-500">
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="tanggal_lahir">
                                    Tanggal Lahir
                                </label>
                                <div>
                                    <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-autohide
                                        datepicker-format="dd/mm/yyyy" type="text" name="tanggal_lahir"
                                        id="tanggal_lahir" onclick="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Tanggal Lahir ">
                                    <p id="error_tanggal_lahir" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <div class="hidden col-span-2 sm:col-span-1" id="input_jenis_kelamin">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="jenis_kelamin">
                                    Jenis Kelamin <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <select required name="jenis_kelamin" id="jenis_kelamin" onchange="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary w-full p-2.5">
                                        <option value="" selected>Jenis Kelamin</option>
                                        <option value="L">LAKI-LAKI</option>
                                        <option value="P">PEREMPUAN</option>
                                    </select>
                                    <p id="error_jenis_kelamin" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="alamat">
                                    Alamat <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <textarea id="alamat" rows="4" name="alamat" onkeydown="clearError(this)"
                                        class="text-sm bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Alamat"></textarea>
                                    <p id="error_alamat" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <!-- Kontak dan Password -->
                        <div class="col-span-2">
                            <label for="category" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">
                                B. Kontak
                            </label>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="email">
                                    Email <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="email" name="email" id="email" onkeydown="clearError(this)"
                                        class="bg-white border  border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Email" required="" />
                                    <p id="error_email" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="no_hp">
                                    No Telpon / Whatsapp <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="number" name="no_hp" id="no_hp" onkeydown="clearError(this)"
                                        class="bg-white border  border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Nomor Telpon / Whatsapp" required="" />
                                    <p id="error_no_hp" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        {{-- <div class="col-span-2 sm:col-span-1">
                            <input type="password" name="password" id="password" onkeydown="clearError(this)"
                                class="bg-white border  border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Password *" required="" />
                            <p id="error_password" class="error text-sm text-red-600 dark:text-red-500"></p>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                onkeydown="clearError(this)"
                                class="bg-white border  border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Konfirmasi Password *" required="" />
                            <p id="error_password_confirmation" class="error text-sm text-red-600 dark:text-red-500"></p>
                        </div> --}}
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
                    <h3 class="mb-5 text-lg font-normal text-black dark:text-gray-400">Anda yakin akan hapus user ini?</h3>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.tailwindcss.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script>
        var identitasLembaga = {
            'value': 'SK Kemenkumham',
            'text': 'SK Kemenkumham'
        };

        var listIdentitasPerorangan = [{
            'value': 'KTP',
            'text': 'KTP'
        }, {
            'value': 'SIM',
            'text': 'SIM'
        }, {
            'value': 'PASPOR',
            'text': 'PASPOR'
        }];

        var listIdentitasKelompok = [{
            'value': 'SK Kemenkumham',
            'text': 'SK Kemenkumham'
        }, {
            'value': 'Akta Pendirian',
            'text': 'Akta Pendirian'
        }];

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

            //button tambah akun pemohon
            $('#tambah_data').on('click', function() {
                $('#id_user').val('');
                $("#frm-user").trigger("reset");
                $('#title-form').html("Tambah Akun Pemohon");
                $('.error').text("");
                modal.show();
            });

            $('#user-table').on('click', '.edit', function() {
                var userId = $(this).data('id');
                $("#frm-user").trigger("reset");
                $('#title-form').html("Edit Akun Pemohon");
                $('.error').text("");
                getUserById(userId);
                modal.show();
            });

            //button delete akun pemohon from table
            $('#user-table').on('click', '.delete', function() {
                var id = $(this).data("id");
                $('#delete_id').val(id);
                deleteModal.show();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#user-table').DataTable({
                layout: {
                    topStart: 'search',
                    topEnd: null,
                    bottomStart: 'paging',
                    bottomEnd: 'info',
                },
                processing: true,
                serverSide: true,
                paging: true,
                bDestroy: true,
                lengthChange: true,
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                responsive: true,
                pagingType: 'first_last_numbers',
                ajax: "{{ route('user-pemohon.list') }}",
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
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'roles',
                        name: 'roles'
                    },
                    {
                        data: 'jenis_pemohon',
                        name: 'jenis_pemohon'
                    },
                    {
                        data: 'id_user',
                        render: (data, type, row) => renderAction(data, row)
                    }
                ]
            });

            //Submit form modal
            $("#btn_submit").click(function(e) {
                e.preventDefault();
                var url = "{{ route('user-pemohon.create') }}";

                //if edit change the URL
                if ($('#id_user').val() != '') {
                    url = "{{ route('user-pemohon.update', ':id') }}";
                    url = url.replace(':id', $('#id_user').val());
                }

                var formData = {
                    _token: "{{ csrf_token() }}",
                    name: $("#name").val(),
                    email: $("#email").val(),
                    // password: $("#password").val(),
                    // password_confirmation: $("#password_confirmation").val(),
                    no_hp: $("#no_hp").val(),
                    jenis_kelamin: $("#jenis_kelamin").val(),
                    jenis_identitas: $("#jenis_identitas").val(),
                    nomor_identitas: $("#nomor_identitas")
                        .val(),
                    tanggal_lahir: formatYmd($("#tanggal_lahir").val()),
                    alamat: $("#alamat").val(),
                    jenis_pemohon: $("#jenis_pemohon").val(),
                    id_ki: $("#id_ki").val()
                };
                // console.log(formData)

                // Validate Form
                var validate = validateForm(formData);

                if (validate.length == 0) {
                    showButtonProgress();

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: JSON.stringify(formData),
                        url: url,
                        contentType: 'application/json',
                        success: function(response) {
                            hideButtonProgress();
                            modal.hide();
                            table.ajax.reload();
                            showNotificationSuccess(response.message)
                        },
                        error: function(response) {
                            var errors = response.responseJSON;
                            let errorMessage = "";
                            $.each(errors.errors, function(key, value) {
                                errorMessage += value + "<br>";
                            });
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
                var url = "{{ route('user-pemohon.delete', ':id') }}";

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
                        hideButtonProgress()
                        showNotificationError(errors.message);
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
            var numberReg = /^[0-9]+$/;
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var passwordReg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{6,}$/;

            var arrayBool = [];

            if (formData.name == "") {
                $('#error_name').text('Nama tidak boleh kosong')
                arrayBool.push(true);
            } else {
                $('#error_name').text('');
            }

            if (formData.email == "") {
                $('#error_email').text('Email tidak boleh kosong');
                arrayBool.push(true);
            } else if (!emailReg.test(formData.email)) {
                $('#error_email').text('Email tidak sesuai');
                arrayBool.push(true);
            } else {
                $('#error_email').text('');
            }

            //Check if edit password not required
            if ($('#id_user').val() == '') {
                // if (formData.password == "") {
                //     $('#error_password').text('Password tidak boleh kosong');
                //     arrayBool.push(true);
                // } else if (!passwordReg.test(formData.password)) {
                //     $('#error_password').text(
                //         'Harap password, Minimal Terdiri Dari 6 Karakter,Minimal Terdiri Dari 1 Angka,Minimal Terdapat 1 karakter Huruf Kapital,Minimal 1 Special Karakter'
                //     );
                //     arrayBool.push(true);
                // } else {
                //     $('#error_password').text('');
                // }

                // if (formData.password_confirmation == "") {
                //     $('#error_password_confirmation').text('Konfirmasi Password tidak boleh kosong');
                //     arrayBool.push(true);
                // } else if (formData.password_confirmation != formData.password) {
                //     $('#error_password_confirmation').text('Password tidak sesuai');
                //     arrayBool.push(true);
                // } else {
                //     $('#error_password_confirmation').text('');
                // }
            }

            if (formData.no_hp == "") {
                $('#error_no_hp').text('Nomor Hp tidak boleh kosong');
                arrayBool.push(true);
            } else if (!numberReg.test(formData.no_hp)) {
                $('#error_no_hp').text('Nomor Hp hanya boleh angka');
                arrayBool.push(true);
            } else {
                $('#error_no_hp').text('');
            }


            if (formData.jenis_identitas == "") {
                $('#error_jenis_identitas').text('Jenis identitas tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_jenis_identitas').text('');
            }

            if (formData.nomor_identitas == "") {
                $('#error_nomor_identitas').text('Nomor identitas tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_nomor_identitas').text('');
            }

            // if (formData.tanggal_lahir == "") {
            //     $('#error_tanggal_lahir').text('Tanggal lahir tidak boleh kosong');
            //     arrayBool.push(true);
            // } else {
            //     $('#error_tanggal_lahir').text('');
            // }

            if (formData.alamat == "") {
                $('#error_alamat').text('Alamat tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_alamat').text('');
            }

            if (formData.jenis_pemohon == "") {
                $('#error_jenis_pemohon').text('Jenis Pemohon tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_jenis_pemohon').text('');
            }

            if (formData.jenis_pemohon == 'PERORANGAN') {
                if (formData.jenis_kelamin == "") {
                    $('#error_jenis_kelamin').text('jenis kelamin tidak boleh kosong');
                    arrayBool.push(true);
                } else {
                    $('#error_jenis_kelamin').text('');
                }
            }

            if (formData.jenis_identitas === "KTP") {
                if (formData.nomor_identitas.length != 16) {
                    $('#error_nomor_identitas').text('Nomor KTP harus terdiri dari 16 digit');
                    arrayBool.push(true);
                } else {
                    $('#error_nomor_identitas').text('');
                }
            } else if (formData.jenis_identitas === "SIM") {
                if (formData.nomor_identitas.length < 12) {
                    $('#error_nomor_identitas').text('Nomor SIM minimal harus terdiri dari 12 digit');
                    arrayBool.push(true);
                } else {
                    $('#error_nomor_identitas').text('');
                }
            }

            return arrayBool;
        }

        function getUserById(userId) {
            var url = "{{ route('user-pemohon.show', ':id') }}";
            url = url.replace(':id', userId);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(response) {
                    assignDetailUserToForm(response.data)
                },
                error: function(response) {
                    var errors = response.responseJSON;
                    var errorMessage = errors.message + '<br>';
                    $.each(errors.errors, function(key,
                        value) {
                        errorMessage += value + '<br>'
                    })
                    showNotificationError(errorMessage)
                }
            });
        }

        function assignDetailUserToForm(data) {
            $("#id_user").val(data.id_user);
            $("#name").val(data.nama);
            $("#email").val(data.email);
            $("#no_hp").val(data.no_hp);
            $("#jenis_kelamin").val(data.jenis_kelamin);
            $("#jenis_pemohon").val(data.jenis_pemohon);
            $("#nomor_identitas").val(data.nomor_identitas);
            $("#tanggal_lahir").val(formatDmy(data.tanggal_lahir));
            $("#alamat").val(data.alamat);

            var input = {
                value: data.jenis_pemohon
            }

            onJenisPemohonChange(input);

            $("#jenis_identitas").val(data.jenis_identitas);
        }

        function onJenisPemohonChange(input) {
            $('#jenis_identitas').empty();
            hideJenisKelamin();

            // console.log(input)

            if (input.value != '') {
                if (input.value == 'LEMBAGA') {
                    $('#jenis_identitas').append($('<option>', {
                        value: identitasLembaga.value,
                        text: identitasLembaga.text
                    }));

                    hideJenisKelamin();

                } else if (input.value == 'PERORANGAN') {
                    $.each(listIdentitasPerorangan, function(i, item) {
                        $('#jenis_identitas').append($('<option>', {
                            value: item.value,
                            text: item.text
                        }));
                    });

                    showJenisKelamin();
                } else if (input.value == 'KELOMPOK ORANG') {
                    $.each(listIdentitasKelompok, function(i, item) {
                        $('#jenis_identitas').append($('<option>', {
                            value: item.value,
                            text: item.text
                        }));
                    });

                    // showJenisKelamin();
                } else {
                    $('#jenis_identitas').attr('disabled');
                }

                $('#jenis_identitas').removeAttr('disabled');
            }
        }

        function onJenisIdentitasChange(input) {
            if (input.value == 'SK Kemenkumham' || input.value == 'Akta Pendirian') {
                hideJenisKelamin();
            } else {
                showJenisKelamin();

            }
        }

        function showJenisKelamin() {
            $('#input_jenis_kelamin').removeClass('hidden');
            // $('#input_jenis_kelamin').attr('required', true);
        }

        function hideJenisKelamin() {
            $('#input_jenis_kelamin').addClass('hidden');
            $('#error_jenis_kelamin').text('');
            // $('#input_jenis_kelamin').attr('required', false);
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
            var edit = "";
            var hapus = "";

            @if (in_array(Permissions::FITUR_USER_PEMOHON_UPDATE, $permissions))
                edit =
                    `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                <button data-id=${data}
                type="button" class="edit bg-[#059669] px-2 py-1 rounded hover:opacity-75">
                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#059669] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Perbarui Data</span>
            </div>`;
            @endif

            @if (in_array(Permissions::FITUR_USER_PEMOHON_DELETE, $permissions))
                hapus =
                    `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                <button data-id=${data}
                class="delete bg-[#AE0008] px-2 py-1 rounded hover:opacity-75">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#AE0008] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Hapus Data</span>
            </div>`;
            @endif

            return '<div class="w-full text-center">' + edit +
                '<span style="text-black text-lg font-semibold uppercase leading-tight"> </span>' +
                hapus + '</div>';
        }
    </script>
@endpush

@extends('admin.layouts.master')
@section('title', 'Data KI')
@push('prepend-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
@endpush

@section('content')
    @php
        $permissions = getPermissionsForActiveRole();
    @endphp
    <!-- Breadcrumb -->
    {{ Breadcrumbs::render('data_ki') }}

    <!-- Header -->
    <div class="max-w-lg mt-5 text-primary text-3xl font-semibold font-lato leading-[39px]">Data KI</div>
    <div class="mt-6">
        @if (in_array(Permissions::FITUR_KI_CREATE, $permissions))
            <div class="flex flex-row justify-between">
                <button data-modal-target="tambah-modal" id="tambah_data"
                    class="flex items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-4">
                    <svg class="h-4 w-4 mr-2 font-semibold" fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Tambah Data KI
                </button>
            </div>
        @endif
    </div>
    <!-- Table Data KI -->
    <div class="relative overflow-x-auto sm:rounded-lg mt-5 mb-2 mx-auto md:max-w-xl lg:max-w-full w-full">
        <table class="w-full text-sm text-white table-auto display table-jadwal" id="dataki-table">
            <thead class="text-base bg-themecolor-primary dark:bg-themecolor-primary ">
                <tr>
                    <th class="text-white font-semibold">
                        No
                    </th>
                    <th class="text-white font-semibold">
                        Nama KI
                    </th>
                    <th class="text-white font-semibold">
                        Email
                    </th>
                    <th class="text-white font-semibold">
                        No.Telp
                    </th>
                    <th class="text-white font-semibold">
                        Alamat
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
                    <h3 class="text-lg font-semibold text-primary dark:text-white">
                        Tambah Data KI
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="tambah-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="frm-tambah-ki" class="p-4 md:p-5">
                    @csrf
                    <div class="flex flex-row space-x-2 mb-4">
                        <div class="flex items-center">
                            <input checked id="jenis_ki_provinsi" type="radio" value="provinsi" name="jenis_ki"
                                class="w-4 h-4 text-themecolor-primary bg-gray-100 border-gray-300 focus:ring-themecolor-primary">
                            <label for="jenis_ki_provinsi"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Provinsi</label>
                        </div>
                        <div class="flex items-center">
                            <input id="jenis_ki_kota" type="radio" value="kota" name="jenis_ki"
                                class="w-4 h-4 text-themecolor-primary bg-gray-100 border-gray-300 focus:ring-themecolor-primary">
                            <label for="jenis_ki_kota"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Kab/Kota</label>
                        </div>
                    </div>
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <!-- Data Komisi Informasi-->
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">A.
                                Data Komisi Informasi</label>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="id_wilayah_provinsi">
                                    Provinsi
                                </label>
                                <div>
                                    <select id="id_wilayah_provinsi" name="id_wilayah_provinsi"
                                        onchange="getKomisiKota(this,'id_wilayah_kota');clearError(this)"
                                        class="bg-gray-50 border border-gray-700 text-gray-900 text-sm rounded-lg focus:ring-themecolor-primary w-full focus:border-red-800 block ">
                                        <option value="">-- Pilih Provinsi --</option>
                                    </select>
                                    <p id="error_id_wilayah_provinsi" class="error text-sm text-red-600 dark:text-red-500">
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="hidden col-span-2 sm:col-span-1" id="input_ki_kota">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="id_wilayah_kota">
                                    Kota
                                </label>
                                <div>
                                    <select id="id_wilayah_kota" name="id_wilayah_kota" onchange="clearError(this)"
                                        class="bg-gray-50 border border-gray-700 text-gray-900 text-sm rounded-lg focus:ring-themecolor-primary w-full focus:border-red-800 block ">
                                    </select>
                                    <p id="error_id_wilayah_kota" class="error text-sm text-red-600 dark:text-red-500">
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="no_telp">
                                    No Telepon <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="number" name="no_telp" id="no_telp" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Nomor Telp" required="">
                                    <p id="error_no_telp" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="email">
                                    Email <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="email" name="email" id="email" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Email" required="">
                                    <p id="error_email" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="no_hp">
                                    No Whatsapp
                                </label>
                                <div>
                                    <input type="number" name="no_hp" id="no_hp" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="No. WhatsApp ">
                                    <p id="error_no_hp" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="fax">
                                    Fax
                                </label>
                                <div>
                                    <input type="text" name="fax" id="fax"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Fax">
                                    {{-- <p id="error_fax" class="error text-sm text-red-600 dark:text-red-500"></p> --}}
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="timezone">
                                    Zona Waktu
                                </label>
                                <div>
                                    <select name="timezone" id="timezone" onchange="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        required>
                                        <option value="WIB" selected>WIB</option>
                                        <option value="WITA">WITA</option>
                                        <option value="WIT">WIT</option>
                                    </select>
                                    <p id="error_timezone" class="error text-sm text-red-600 dark:text-red-500"></p>
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

                        <!-- Data Website dan Sosial Media-->
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                B. Website dan Sosial Media</label>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="link_website">
                                    Link Website
                                </label>
                                <div>
                                    <input type="text" name="link_website" id="link_website"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Link Website">
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="link_instagram">
                                    Link Instagram
                                </label>
                                <div>
                                    <input type="text" name="link_instagram" id="link_instagram"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Link Instagram">
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="link_facebook">
                                    Link Facebook
                                </label>
                                <div>
                                    <input type="text" name="link_facebook" id="link_facebook"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Link Facebook">
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="link_twitter">
                                    Link Twitter
                                </label>
                                <div>
                                    <input type="text" name="link_twitter" id="link_twitter"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Link Twitter">
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="link_youtube">
                                    Link Youtube
                                </label>
                                <div>
                                    <input type="text" name="link_youtube" id="link_youtube"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Link Youtube">
                                </div>
                            </div>

                        </div>

                        <!-- Template Kode Surat-->
                        <div class="col-span-2">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                C. Template Kode Surat</label>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="template_kode_surat_akta_registrasi">
                                    Template Kode Surat Akta Registrasi <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="text" name="template_kode_surat_akta_registrasi"
                                        id="template_kode_surat_akta_registrasi" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="{nomor}/{bulan}/REG-PS/{tahun}" required="">

                                    <p id="error_template_kode_surat_akta_registrasi"
                                        class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="template_kode_surat_spkd">
                                    Template Kode Surat SPKD <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="text" name="template_kode_surat_spkd" id="template_kode_surat_spkd"
                                        onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="{nomor}/{bulan}/KIP-SPKD/{tahun}" required="">
                                    <p id="error_template_kode_surat_spkd"
                                        class="error text-sm text-red-600 dark:text-red-500">
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="template_kode_nomor_sengketa">
                                    Template Kode Nomor Sengketa <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="text" name="template_kode_nomor_sengketa"
                                        id="template_kode_nomor_sengketa" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="{nomor}/{bulan}/KIP-PSI/{tahun}" required="">
                                    <p id="error_template_kode_nomor_sengketa"
                                        class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="template_kode_surat_reelas">
                                    Template Kode Surat Reelas <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="text" name="template_kode_surat_reelas"
                                        id="template_kode_surat_reelas" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="{nomor}/{bulan}/KIP-RLS/{tahun}" required="">
                                    <p id="error_template_kode_surat_reelas"
                                        class="error text-sm text-red-600 dark:text-red-500">
                                    </p>
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

    <!-- Edit modal -->
    <div id="edit-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow border-2 border-primary dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-primary dark:text-white">
                        Edit Data KI
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="edit-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="frm-edit-ki" class="p-4 md:p-5">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <!-- Data Komisi Informasi-->
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">A.
                                Data Komisi Informasi
                            </label>
                        </div>
                        <input type="hidden" id="edit_id">
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_name">
                                    Nama Komisi Informasi
                                </label>
                                <div>
                                    <input type="text" name="edit_name" id="edit_name" readonly
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Nama">
                                </div>
                            </div>

                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_no_telp">
                                    No Telepon <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="number" name="edit_no_telp" id="edit_no_telp"
                                        onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Nomor Telp" required="">
                                    <p id="error_edit_no_telp" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_email">
                                    Email <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="email" name="edit_email" id="edit_email" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Email" required="">
                                    <p id="error_edit_email" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_no_hp">
                                    No Whatsapp
                                </label>
                                <div>
                                    <input type="number" name="edit_no_hp" id="edit_no_hp" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="No. WhatsApp ">
                                    <p id="error_edit_no_hp" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_fax">
                                    Fax
                                </label>
                                <div>
                                    <input type="text" name="edit_fax" id="edit_fax"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Fax">
                                    {{-- <p id="error_fax" class="error text-sm text-red-600 dark:text-red-500"></p> --}}
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_timezone">
                                    Zona Waktu
                                </label>
                                <div>
                                    <select name="edit_timezone" id="edit_timezone" onchange="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        required>
                                        <option value="WIB" selected>WIB</option>
                                        <option value="WITA">WITA</option>
                                        <option value="WIT">WIT</option>
                                    </select>
                                    <p id="error_edit_timezone" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_alamat">
                                    Alamat <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <textarea id="edit_alamat" rows="4" name="edit_alamat" onkeydown="clearError(this)"
                                        class="text-sm bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Alamat"></textarea>
                                    <p id="error_edit_alamat" class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>

                        <!-- Data Website dan Sosial Media-->
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                B. Website dan Sosial Media</label>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_link_website">
                                    Link Website
                                </label>
                                <div>
                                    <input type="text" name="edit_link_website" id="edit_link_website"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Link Website">
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_link_instagram">
                                    Link Instagram
                                </label>
                                <div>
                                    <input type="text" name="edit_link_instagram" id="edit_link_instagram"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Link Instagram">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_link_facebook">
                                    Link Facebook
                                </label>
                                <div>
                                    <input type="text" name="edit_link_facebook" id="edit_link_facebook"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Link Facebook">
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_link_twitter">
                                    Link Twitter
                                </label>
                                <div>
                                    <input type="text" name="edit_link_twitter" id="edit_link_twitter"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Link Twitter">
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_link_youtube">
                                    Link Youtube
                                </label>
                                <div>
                                    <input type="text" name="edit_link_youtube" id="edit_link_youtube"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="Link Youtube">
                                </div>
                            </div>

                        </div>

                        <!-- Template Kode Surat-->
                        <div class="col-span-2">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                C. Template Kode Surat</label>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_template_kode_surat_akta_registrasi">
                                    Template Kode Surat Akta Registrasi <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="text" name="edit_template_kode_surat_akta_registrasi"
                                        id="edit_template_kode_surat_akta_registrasi" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="{nomor}/{bulan}/REG-PS/{tahun}" required="">

                                    <p id="error_edit_template_kode_surat_akta_registrasi"
                                        class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_template_kode_surat_spkd">
                                    Template Kode Surat SPKD <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="text" name="edit_template_kode_surat_spkd"
                                        id="edit_template_kode_surat_spkd" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="{nomor}/{bulan}/KIP-SPKD/{tahun}" required="">
                                    <p id="error_edit_template_kode_surat_spkd"
                                        class="error text-sm text-red-600 dark:text-red-500">
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_template_kode_nomor_sengketa">
                                    Template Kode Nomor Sengketa <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="text" name="edit_template_kode_nomor_sengketa"
                                        id="edit_template_kode_nomor_sengketa" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="{nomor}/{bulan}/KIP-PSI/{tahun}" required="">
                                    <p id="error_edit_template_kode_nomor_sengketa"
                                        class="error text-sm text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="flex flex-col space-y-2">
                                <label class="text-sm" for="edit_template_kode_surat_reelas">
                                    Template Kode Surat Reelas <span class="text-red-600">*</span>
                                </label>
                                <div>
                                    <input type="text" name="edit_template_kode_surat_reelas"
                                        id="edit_template_kode_surat_reelas" onkeydown="clearError(this)"
                                        class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                        placeholder="{nomor}/{bulan}/KIP-RLS/{tahun}" required="">
                                    <p id="error_edit_template_kode_surat_reelas"
                                        class="error text-sm text-red-600 dark:text-red-500">
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="text-right mt-5">
                        <button type="reset" data-modal-hide="edit-modal"
                            class="w-xl text-primary bg-white border border-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                            Kembali
                        </button>
                        <button type="submit" id="btn_update"
                            class="w-xl text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                            Simpan
                        </button>
                        <button id="btn_loading_edit" hidden
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
                    <h3 class="mb-5 text-lg font-normal text-black dark:text-gray-400">Anda yakin akan hapus data KI
                        ini?</h3>
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
        //define modal
        var modalElement = '';
        var modalElementEdit = '';
        var modalElementDelete = '';
        var modal = '';
        var editModal = '';
        var deleteModal = '';

        document.addEventListener('DOMContentLoaded', function() {
            //initialize modal
            modalElement = document.getElementById('tambah-modal');
            modalElementEdit = document.getElementById('edit-modal');
            modalElementDelete = document.getElementById('delete-modal');

            modal = new Modal(modalElement, {
                backdrop: 'static'
            });
            editModal = new Modal(modalElementEdit, {
                backdrop: 'static'
            });
            deleteModal = new Modal(modalElementDelete, {
                backdrop: 'static'
            });

            //initialize close modal
            closeModalButtons = modalElement.querySelectorAll('[data-modal-hide]');
            closeModalButtonsEdit = modalElementEdit.querySelectorAll('[data-modal-hide]');
            closeModalButtonsDelete = modalElementDelete.querySelectorAll('[data-modal-hide]');

            //Hide each close modal button
            closeModalButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    modal.hide();
                });
            });

            //Hide each close edit modal button
            closeModalButtonsEdit.forEach(function(button) {
                button.addEventListener('click', function() {
                    editModal.hide();
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
                $("#id_wilayah_provinsi").empty().trigger('change');
                $("#id_wilayah_kota").empty().trigger('change');
                $("#frm-tambah-ki").trigger("reset");
                $('#input_ki_kota').addClass('hidden');
                $('.error').text("");
                getKomisiProvinsi();
                modal.show();
            });

            //button edit data ki from table
            $('#dataki-table').on('click', '.edit', function() {
                var id = $(this).data("id");

                $("#frm-edit-ki").trigger("reset");
                $('.error').text("");
                getKIDetail(id)

                editModal.show();
            });

            //button delete data ki from table
            $('#dataki-table').on('click', '.delete', function() {
                var id = $(this).data("id");
                $('#delete_id').val(id);
                deleteModal.show();
            });

        });
    </script>
    <script>
        $(document).ready(async () => {
            // showLoading();
            $('#id_wilayah_provinsi').select2();
            $('#id_wilayah_kota').select2();
            $('#provinsi').select2();
            $('#kota').select2();

            var table = $('#dataki-table').DataTable({
                layout: {
                    topStart: 'search',
                    topEnd: null,
                    bottomStart: 'paging',
                    bottomEnd: 'info',
                },
                "processing": true,
                "paging": true,
                "serverside": true,
                "bDestroy": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "responsive": true,
                "ajax": "{{ route('ki.list') }}",
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
                        "data": "nama"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "no_telp"
                    },
                    {
                        "data": "alamat"
                    },
                    {
                        data: null,
                        render: (data, type, row) => renderAction(data, row)
                    }
                ]
            });

            //Submit form modal
            $("#btn_submit").click(function(e) {
                e.preventDefault();

                // Set Form Data
                var idWilayah = $("#id_wilayah_provinsi").val()

                if ($('input[type=radio][name="jenis_ki"]:checked').val() == 'kota') {
                    idWilayah = $("#id_wilayah_kota").val()
                }

                var formData = {
                    _token: "{{ csrf_token() }}",
                    id_wilayah: idWilayah,
                    id_wilayah_provinsi: $("#id_wilayah_provinsi").val(),
                    id_wilayah_kota: $("#id_wilayah_kota").val(),
                    no_telp: $("#no_telp").val(),
                    email: $("#email").val(),
                    fax: $("#fax").val(),
                    timezone: $("#timezone").val(),
                    no_hp: $("#no_hp").val(),
                    alamat: $("#alamat").val(),
                    template_kode_surat_akta_registrasi: $("#template_kode_surat_akta_registrasi")
                        .val(),
                    template_kode_surat_spkd: $("#template_kode_surat_spkd").val(),
                    template_kode_nomor_sengketa: $("#template_kode_nomor_sengketa").val(),
                    template_kode_surat_reelas: $("#template_kode_surat_reelas").val(),
                    link_instagram: $("#link_instagram").val(),
                    link_twitter: $("#link_twitter").val(),
                    link_website: $("#link_website").val(),
                    link_facebook: $("#link_facebook").val(),
                    link_youtube: $("#link_youtube").val(),
                };

                //Validate Form
                var validate = validateForm(formData);

                if (validate.length == 0) {
                    showButtonProgress();

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        url: "{{ route('ki.create') }}",
                        success: function(response) {
                            $("frm-tambah-ki").trigger("reset");
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

            //Submit form update modal
            $("#btn_update").click(function(e) {
                e.preventDefault();

                // Set Form Data
                var editId = $("#edit_id").val()
                var url = "{{ route('ki.update', ':id') }}";
                url = url.replace(':id', editId);

                var formData = {
                    _token: "{{ csrf_token() }}",
                    name: $("#edit_name").val(),
                    no_telp: $("#edit_no_telp").val(),
                    email: $("#edit_email").val(),
                    fax: $("#edit_fax").val(),
                    timezone: $("#edit_timezone").val(),
                    no_hp: $("#edit_no_hp").val(),
                    alamat: $("#edit_alamat").val(),
                    template_kode_surat_akta_registrasi: $(
                            "#edit_template_kode_surat_akta_registrasi")
                        .val(),
                    template_kode_surat_spkd: $("#edit_template_kode_surat_spkd").val(),
                    template_kode_nomor_sengketa: $("#edit_template_kode_nomor_sengketa").val(),
                    template_kode_surat_reelas: $("#edit_template_kode_surat_reelas").val(),
                    link_instagram: $("#edit_link_instagram").val(),
                    link_twitter: $("#edit_link_twitter").val(),
                    link_website: $("#edit_link_website").val(),
                    link_facebook: $("#edit_link_facebook").val(),
                    link_youtube: $("#edit_link_youtube").val(),
                };

                //Validate Form
                var validate = validateForm(formData);

                // console.log(formData);
                if (validate.length == 0) {
                    showButtonProgress();

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        url: url,
                        success: function(response) {
                            $("frm-edit-ki").trigger("reset");
                            hideButtonProgress();
                            editModal.hide();
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
                var url = "{{ route('ki.delete', ':id') }}";

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
                        if (errors.errors != null) {
                            $.each(errors.errors, function(key, value) {
                                showNotificationError(value);
                            });
                        }
                    }
                });
            });

            // Jenis tambah data KI
            $('input[type=radio][name="jenis_ki"]').change(function() {
                if (this.value == 'kota') {
                    $('#input_ki_kota').removeClass('hidden');
                } else {
                    $('#input_ki_kota').addClass('hidden');
                }
            });
        });

        function validateForm(formData) {
            var numberReg = /^[0-9]+$/;
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

            var arrayBool = [];

            if (formData.id_wilayah_provinsi == "") {
                showNotificationError('Provinsi tidak boleh kosong')
                arrayBool.push(true);
            } else {
                $('#error_id_wilayah_provinsi').text('');
            }

            if (formData.id_wilayah_kota == "null" && $('input[type=radio][name="jenis_ki"]:checked') == 'kota') {
                showNotificationError('Kota tidak boleh kosong')
                arrayBool.push(true);
            } else {
                $('#error_id_wilayah_kota').text('');
            }

            if (formData.no_telp == "") {
                $('#error_no_telp').text('Nomor Telepon tidak boleh kosong');
                arrayBool.push(true);
            } else if (!numberReg.test(formData.no_telp)) {
                $('#error_no_telp').text('Nomor Telepon hanya boleh angka');
                arrayBool.push(true);
            } else {
                $('#error_no_telp').text('');
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

            // if (formData.no_hp == "") {
            //     $('#error_no_hp').text('Nomor Whatsapp tidak boleh kosong');
            //     arrayBool.push(true);
            // } else if (!numberReg.test(formData.no_hp)) {
            //     $('#error_no_hp').text('Nomor Whatsapp hanya boleh angka');
            //     arrayBool.push(true);
            // } else {
            //     $('#error_no_hp').text('');
            // }


            if (formData.alamat == "") {
                $('#error_alamat').text('Alamat tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_alamat').text('');
            }

            if (formData.timezone == "") {
                $('#error_timezone').text('Zona Waktu tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_timezone').text('');
            }


            if (formData.template_kode_surat_akta_registrasi == "") {
                $('#error_template_kode_surat_akta_registrasi').text('Field ini tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_template_kode_surat_akta_registrasi').text('');
            }

            if (formData.template_kode_surat_spkd == "") {
                $('#error_template_kode_surat_spkd').text('Field ini tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_template_kode_surat_spkd').text('');
            }

            if (formData.template_kode_nomor_sengketa == "") {
                $('#error_template_kode_nomor_sengketa').text('Field ini tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_template_kode_nomor_sengketa').text('');
            }

            if (formData.template_kode_surat_reelas == "") {
                $('#error_template_kode_surat_reelas').text('Field ini tidak boleh kosong');
                arrayBool.push(true);
            } else {
                $('#error_template_kode_surat_reelas').text('');
            }

            return arrayBool;
        }

        function renderAction(data, row) {
            var edit = "";
            var hapus = "";

            @if (in_array(Permissions::FITUR_KI_UPDATE, $permissions))
                edit =
                    `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                <button data-id=${row.id}
                type="button" class="edit bg-[#059669] px-2 py-1 rounded hover:opacity-75">
                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <span class="absolute left-1/2 transform -translate-x-1/2 bg-[#059669] text-white text-xs py-1 px-2 rounded mt-2 hidden group-hover:block z-50">Perbarui Data</span>
            </div>`;
            @endif

            @if (in_array(Permissions::FITUR_KI_DELETE, $permissions))
                hapus =
                    `<div class="relative group inline-block uppercase font-semibold text-xs leading-tight">
                <button data-id=${row.id}
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


        async function getKIDetail(id) {
            var url = "{{ route('ki.show', ':id') }}";
            url = url.replace(':id', id);

            await $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(response) {
                    assignDetailKIToForm(response.data)
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

        function getKomisiProvinsi() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('wilayah.provinsi') }}",
                success: function(response) {
                    showListKomisiProvinsi(response.data)
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

        function getKomisiKota(input, id) {
            $('#' + id).empty();

            var url = "{{ route('wilayah.kabupaten', ':idWilayah') }}";
            url = url.replace(':idWilayah', input.value);

            if (input.value != "") {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    success: function(response) {
                        showListKomisiKota(response.data, id)
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

        }

        function showListKomisiProvinsi(list) {
            $('#id_wilayah_provinsi').append($('<option>', {
                value: "",
                text: "-- Pilih Provinsi --"
            }));
            $.each(list, function(i, item) {
                $('#id_wilayah_provinsi').append($('<option>', {
                    value: item.id_wilayah,
                    text: item.nama_wilayah
                }));
            });

            $('#provinsi').removeAttr('disabled');
        }

        function showListKomisiKota(list, id) {
            $.each(list, function(i, item) {
                $('#' + id).append($('<option>', {
                    value: item.id_wilayah,
                    text: item.nama_wilayah
                }));
            });

            $('#' + id).removeAttr('disabled');

            // hideLoading();
        }

        function assignDetailKIToForm(data) {
            $("#edit_id").val(data.id);
            $("#edit_name").val(data.nama);
            $("#edit_no_telp").val(data.no_telp);
            $("#edit_email").val(data.email);
            $("#edit_fax").val(data.fax);
            $("#edit_timezone").val(data.timezone);
            $("#edit_no_hp").val(data.no_hp);
            $("#edit_alamat").val(data.alamat);
            $("#edit_template_kode_surat_akta_registrasi")
                .val(data.template_kode_surat_akta_registrasi);
            $("#edit_template_kode_surat_spkd").val(data.template_kode_surat_spkd);
            $("#edit_template_kode_nomor_sengketa").val(data.template_kode_nomor_sengketa);
            $("#edit_template_kode_surat_reelas").val(data.template_kode_surat_reelas);
            $("#edit_link_instagram").val(data.link_instagram);
            $("#edit_link_twitter").val(data.link_twitter);
            $("#edit_link_website").val(data.link_website);
            $("#edit_link_facebook").val(data.link_facebook);
            $("#edit_link_youtube").val(data.link_youtube);
        }

        function showButtonProgress() {
            $('#btn_loading').removeAttr('hidden');
            $('#btn_loading_edit').removeAttr('hidden');
            $('#btn_submit').attr('hidden', true);
            $('#btn_update').attr('hidden', true);
        }

        function hideButtonProgress() {
            $('#btn_submit').removeAttr('hidden');
            $('#btn_update').removeAttr('hidden');
            $('#btn_loading').attr('hidden', true);
            $('#btn_loading_edit').attr('hidden', true);
        }

        function clearError(input) {
            $('#error_' + input.id).text('');
        }
    </script>
@endpush

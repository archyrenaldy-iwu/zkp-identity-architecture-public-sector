@extends('admin.layouts.master')
@section('title', 'Sengketa')
@section('content')
    @php
        $permissions = getPermissionsForActiveRole();
    @endphp
    <!-- Breadcrumb -->
    {{ Breadcrumbs::render('sengketa.show', $id) }}

    <!-- Content -->
    <div class="container mx-auto pb-4">
        <h1 class="text-2xl font-bold mb-6 text-red-700">Formulir Permohonan Sengketa</h1>

        <form id="sengketaForm" enctype="multipart/form-data" method="POST">
            <!-- A. Identitas Pemohon -->
            <div class="mb-6">
                <label for="komisi" class="block text-sm font-medium text-gray-700">Komisi Informasi yang Dituju</label>
                <select id="komisi" name="id_ki"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50"
                    disabled>
                    @foreach (getListKiConfig() as $ki)
                        <option value="{{ $ki->id }}">{{ $ki->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- A. Identitas Pemohon -->
            <fieldset class="mb-6">
                <legend class="text-lg font-medium text-gray-700">A. Identitas Pemohon</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="pemohon_nama" class="block text-sm font-medium text-gray-700">Nama Pemohon/Lembaga
                            Pemohon <span class="text-red-900 text-md">*</span> </label>
                        <input type="text" id="pemohon_nama" name="pemohon_nama"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                    </div>
                    <div>
                        <label for="pemohon_no_hp" class="block text-sm font-medium text-gray-700">No. HP/WA <span
                                class="text-red-900 text-md">*</span></label>
                        <input type="text" id="pemohon_no_hp" name="pemohon_no_hp"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                    </div>
                    <div>
                        <label for="jenis_pemohon" class="block text-sm font-medium text-gray-700">Jenis Pemohon <span
                                class="text-red-900 text-md">*</span></label>
                        <select name="jenis_pemohon" id="jenis_pemohon"
                            onchange="onJenisPemohonChange(this);clearError(this)"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                            <option selected value=""> JENIS PEMOHON *</option>
                            <option value="PERORANGAN">PERORANGAN</option>
                            <option value="LEMBAGA">LEMBAGA</option>
                            <option value="KELOMPOK ORANG">KELOMPOK ORANG</option>
                        </select>
                    </div>
                    <div>
                        <label for="pemohon_email" class="block text-sm font-medium text-gray-700">Email <span
                                class="text-red-900 text-md">*</span></label>
                        <input type="email" id="pemohon_email" name="pemohon_email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                    </div>
                    <div>
                        <label for="jenis_identitas" class="block text-sm font-medium text-gray-700">Tanda Bukti Identitas
                            <span class="text-red-900 text-md">*</span></label>
                        <select name="jenis_identitas" id="jenis_identitas" disabled
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"">
                            <option value="" selected>JENIS IDENTITAS </option>
                            <option value="KTP">KTP</option>
                            <option value="SIM">SIM</option>
                            <option value="PASPOR">PASPOR</option>
                            <option value="SK Kemenkumham">SK Kemenkumham</option>
                            <option value="Akta Pendirian">Akta Pendirian</option>
                        </select>
                    </div>
                    <div>
                        <label for="nomor_identitas" class="block text-sm font-medium text-gray-700">Nomor Identitas <span
                                class="text-red-900 text-md">*</span></label>
                        <input type="text" id="nomor_identitas" name="nomor_identitas"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                    </div>
                    <div>
                        <label for="pemohon_alamat" class="block text-sm font-medium text-gray-700">Alamat <span
                                class="text-red-900 text-md">*</span></label>
                        <textarea id="pemohon_alamat" name="pemohon_alamat"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled></textarea>
                    </div>
                    <div>
                        <label id="label_jenis_kelamin" for="jenis_kelamin"
                            class="text-sm font-medium text-gray-700 hidden">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin"
                            class="hidden mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                            <option value="" selected>JENIS KELAMIN</option>
                            <option value="L">LAKI-LAKI</option>
                            <option value="P">PEREMPUAN</option>
                        </select>
                    </div>

                </div>
            </fieldset>

            <!-- B. Identitas Kuasa Pemohon -->
            <fieldset class="mb-6">
                <legend class="text-lg font-medium text-gray-700">B. Identitas Kuasa Pemohon</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="kuasa_pemohon_nama" class="block text-sm font-medium text-gray-700">Nama Kuasa
                            Pemohon</label>
                        <input type="text" id="kuasa_pemohon_nama" name="kuasa_pemohon_nama"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                    </div>
                    <div>
                        <label for="kuasa_pemohon_jk" class="block text-sm font-medium text-gray-700">Jenis
                            Kelamin</label>
                        <select id="kuasa_pemohon_jk" name="kuasa_pemohon_jk"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <!-- C. Mengenai Permohonan Informasi -->
            <fieldset class="mb-6">
                <legend class="text-lg font-medium text-gray-700">C. Mengenai Permohonan Informasi</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="termohon_nama" class="block text-sm font-medium text-gray-700">Nama Badan Publik <span
                                class="text-red-900 text-md">*</span></label>
                        <input type="text" id="termohon_nama" name="termohon_nama"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                    </div>
                    <div>
                        <label for="termohon_alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input type="text" id="termohon_alamat" name="termohon_alamat"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                    </div>
                    <div>
                        <label for="tanggal_permohonan" class="block text-sm font-medium text-gray-700">Tanggal Permohonan
                            <span class="text-red-900 text-md">*</span></label>
                        <div class="relative w-full" id="tanggal_permohonan">
                            <div
                                class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-autohide
                                datepicker-format="yyyy/mm/dd" type="text" name="tanggal_permohonan"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full ps-9 sm:w-full md:w-full p-2.5"
                                placeholder="Tanggal Permohonan" disabled>
                        </div>
                    </div>
                    <div>
                        <label for="tanggal_jawaban" class="block text-sm font-medium text-gray-700">Tanggal
                            Jawaban</label>
                        <div class="relative w-full">
                            <div
                                class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-autohide
                                datepicker-format="yyyy/mm/dd" type="text" name="tanggal_jawaban"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full ps-9 sm:w-full md:w-full p-2.5"
                                placeholder="Tanggal Jawaban" disabled>
                        </div>
                    </div>
                    <div>
                        <label for="tanggal_keberatan" class="block text-sm font-medium text-gray-700">Tanggal Keberatan
                            <span class="text-red-900 text-md">*</span></label>
                        <div class="relative w-full" id="tanggal_keberatan">
                            <div
                                class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-autohide
                                datepicker-format="yyyy/mm/dd" type="text" name="tanggal_keberatan"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full ps-9 sm:w-full md:w-full p-2.5"
                                placeholder="Tanggal Keberatan" disabled>
                        </div>
                    </div>
                    <div>
                        <label for="tanggal_tanggapan" class="block text-sm font-medium text-gray-700">Tanggal
                            Tanggapan</label>
                        <div class="relative w-full">
                            <div
                                class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-autohide
                                datepicker-format="yyyy/mm/dd" type="text" name="tanggal_tanggapan"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full ps-9 sm:w-full md:w-full p-2.5"
                                placeholder="Tanggal Tanggapan" disabled>
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- Alasan Permohonan -->
            <fieldset class="mb-6">
                <legend id="legendAlasan" class="text-lg font-medium text-gray-700">Alasan Permohonan Penyelesaian
                    Sengketa
                    Informasi</legend>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]"
                            value="Alasan PPID menolak permohonan informasi dengan alasan pengecualian berdasarkan Pasal 17 UU KIP"
                            class="mr-2" disabled> Alasan PPID menolak permohonan informasi dengan alasan pengecualian
                        berdasarkan Pasal 17 UU KIP
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]"
                            value="Tidak disediakannya informasi berkala sebagaimana diatur di dalam Pasal 9 UU KIP"
                            class="mr-2" disabled> Tidak disediakannya informasi berkala sebagaimana diatur di dalam
                        Pasal 9
                        UU KIP
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]"
                            value="Atasan PPID tidak menanggapi keberatan Pemohon." class="mr-2" disabled> Atasan PPID
                        tidak
                        menanggapi keberatan Pemohon.
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]"
                            value="Pemohon tidak puas terhadap tanggapan Atasan PPID atas keberatan." class="mr-2"
                            disabled>
                        Pemohon tidak puas terhadap tanggapan Atasan PPID atas keberatan.
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]" value="Pengenaan biaya yang tidak wajar."
                            class="mr-2" disabled> Pengenaan biaya yang tidak wajar.
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]"
                            value="Penyampaian informasi yang melebihi waktu yang diatur di dalam UU KIP." class="mr-2"
                            disabled> Penyampaian informasi yang melebihi waktu yang diatur di dalam UU KIP.
                    </label>
                </div>
            </fieldset>

            <!-- Dokumen Kelengkapan -->
            {{-- <iframe id="file_identitas_iframe" class="hidden w-full h-64 mt-2"></iframe> --}}
            <fieldset class="mb-6">
                <legend class="text-lg font-medium text-gray-700">D. Dokumen Kelengkapan Pemohon</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">KTP/SIM/Paspor</label>
                        <div class="mt-4 mb-4" id="identitas_container">
                            <a href="#" id="file_identitas_link"
                                class="inline-flex mt-2 items-center justify-center text-white font-lato font-semibold text-xs uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">
                                Lihat Dokumen
                            </a>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Surat Pengajuan Keberatan/Formulir Pengajuan
                            Keberatan </label>
                        <div class="mt-2 mb-4">
                            <a href="#" id="file_formulir_keberatan_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Surat Kuasa</label>
                        <div class="mt-2 mb-4">
                            <a href="#" id="file_surat_kuasa_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggapan Atasan PPID Atas Keberatan</label>
                        <div class="mt-2 mb-4">
                            <a href="#" id="file_tanggapan_atasan_ppid_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Surat Permohonan/Formuiir permohonan</label>
                        <div class="mt-2 mb-4">
                            <a href="#" id="file_formulir_permohonan_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pemberitahuan Tertulis</label>
                        <div class="mt-2 mb-4">
                            <a href="#" id="file_pemberitahuan_tertulis_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dokumen Pendukung Lain</label>
                        <div class="mt-2 mb-4">
                            <a href="#" id="file_pendukung_sengketa1_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dokumen Pendukung Lain</label>
                        <div class="mt-2 mb-4">
                            <a href="#" id="file_pendukung_sengketa2_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jawaban PPID terhadap Pemohon</label>
                        <div class="mt-2 mb-4">
                            <a href="#" id="file_jawaban_ppid_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <!-- Modal toggle -->
            <a href="{{ route(Permissions::MENU_SENGKETA) }}"
                class="block text-white bg-gray-600 hover:bg-gray-300 hover:text-themecolor-primary focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-6 py-2.5 text-center m-2"
                type="button">KEMBALI</a>
            @if (in_array(Permissions::FITUR_SENGKETA_TOLAK, $permissions))
                <button
                    class="block text-white bg-primary hover:bg-red-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-6 py-2.5 text-center m-2 reject"
                    type="button">
                    TOLAK
                </button>
            @endif
            @if (in_array(Permissions::FITUR_SENGKETA_TERIMA, $permissions))
                <button
                    class="px-6 py-2.5 bg-[#059669] text-white rounded-md shadow-md hover:bg-green-800 focus:outline-none focus:ring-2 font-medium text-sm focus:ring-offset-2 focus:greenbg-green-700 m-2 confirm"
                    type="button">
                    TERIMA
                </button>
            @endif
        </div>
    </div>

    <!-- Main modal -->
    <div id="confirm-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-6 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-red-100 rounded-xl shadow-lg p-6 text-center border-4 border-primary">
                <!-- Modal body -->
                <div class="flex flex-col items-center">
                    <p class="text-lg font-semibold text-gray-700 mb-6">
                        Apakah anda yakin akan menerima sengketa ini ?
                    </p>
                    <div class="w-full mb-6">
                        <select id="id_user_internal"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                            <option>Nama Panitera</option>
                            {{-- @foreach (getListPanitera() as $panitera)
                            <option value="{{ $panitera->id }}">{{ $panitera->nama }}</option>
                        @endforeach --}}
                        </select>
                    </div>
                    <div class="flex space-x-4">
                        <button data-modal-hide="confirm-modal" type="button"
                            class="text-white focus:outline-none bg-gray-600 rounded-lg border hover:bg-gray-100 hover:text-themecolor-primary focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 font-medium text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Kembali
                        </button>
                        <button id="terimaSengketaBtn" type="button"
                            class="px-6 py-2 bg-[#059669] text-white rounded-md hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Terima
                        </button>
                        <button id="btn_loading_terima" hidden
                            class="w-xl text-white bg-[#059669] hover:bg-green-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
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

    <!-- reject modal -->
    <div id="reject-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-6 w-full max-w-3xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-red-100 rounded-lg shadow-lg p-6 text-center border-4 border-primary">
                <!-- Modal body -->
                <div class="flex flex-col items-center">
                    <p class="text-lg font-semibold text-primary mb-4">
                        Apakah anda yakin akan menolak sengketa ini ?
                    </p>
                    <div class="w-full mb-4 text-left">
                        <p class="text-left text-sm font-semibold text-gray-700 mb-2">Informasi yang dimohon</p>
                        <textarea name="penolakan_info"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                            rows="3"></textarea>
                    </div>
                    <div class="w-full mb-6 text-left">
                        <p class="text-left text-sm font-semibold text-gray-700 mb-2 checklist">Checklist yang belum
                            lengkap</p>
                        <div class="space-y-2">
                            <label class="flex items-center text-sm text-gray-700">
                                <input type="checkbox" name="penolakan_checklist[]"
                                    value=" Salinan identitas; KTP/SIM/Paspor." class="mr-2">
                                Salinan identitas; KTP/SIM/Paspor.
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <input type="checkbox" name="penolakan_checklist[]"
                                    value="Salinan formulir permohonan, tanda terima atau tanda pemberian/pengajuan permohonan informasi."
                                    class="mr-2">
                                Salinan formulir permohonan, tanda terima atau tanda pemberian/pengajuan permohonan
                                informasi.
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <input type="checkbox" name="penolakan_checklist[]"
                                    value="Salinan surat tanggapan tertulis atas keberatan Pemohon oleh atasan PPID/surat pengajuan keberatan/tanda pemberian/pengajuan/tanda pengiriman atau tanda terima keberatan."
                                    class="mr-2">
                                Salinan surat tanggapan tertulis atas keberatan Pemohon oleh atasan PPID/surat pengajuan
                                keberatan/tanda pemberian/pengajuan/tanda pengiriman atau tanda terima keberatan.
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <input type="checkbox" name="penolakan_checklist[]"
                                    value="Salinan surat kuasa (jika Pemohon diwakili oleh Kuasa)." class="mr-2">
                                Salinan surat kuasa (jika Pemohon diwakili oleh Kuasa).
                            </label>
                        </div>
                    </div>
                    <div class="w-full mb-6">
                        <select id="id_user_internal_tolak"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                            <option>Nama Panitera</option>
                            {{-- @foreach (getListPanitera() as $panitera)
                        <option value="{{ $panitera->id }}">{{ $panitera->nama }}</option>
                        @endforeach --}}
                        </select>
                    </div>
                    <div class="flex space-x-4">
                        <button data-modal-hide="reject-modal" type="button"
                            class="text-white focus:outline-none bg-gray-600 rounded-lg border hover:bg-gray-100 hover:text-themecolor-primary focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 font-medium text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Kembali
                        </button>
                        <button id="tolakSengketaBtn" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-white rounded-lg bg-themecolor-primary hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 ">
                            Tolak
                        </button>
                        <button id="btn_loading_tolak" hidden
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

    <!-- File Modal -->
    <div id="documentModal" tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-7xl max-h-full mx-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 pb-1 md:p-5 md:pb-2 rounded-t">
                    <button id="closeModal" type="button"
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
                <div class="p-4 pt-1 md:p-5 md:pt-2">
                    <iframe id="documentIframe" class="min-h-screen min-w-full" src=""></iframe>
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
    {{-- tolak sengketa --}}
    <script>
        $(document).ready(function() {
            $('#tolakSengketaBtn').on('click', function() {
                var informasiDimohon = $('textarea[name="penolakan_info"]').val();
                var alasanPenolakan = [];
                $('input[name="penolakan_checklist[]"]:checked').each(function() {
                    alasanPenolakan.push($(this).val());
                });
                var paniteraTolak = $('#id_user_internal_tolak').val();
                var validate = validateForm();
                var sengketaId = {{ $id }};
                var url = '{{ route('sengketa.tolak', ':id') }}';
                url = url.replace(':id', sengketaId);


                if (validate.length == 0) {
                    showButtonProgress();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            penolakan_info: informasiDimohon,
                            penolakan_checklist: alasanPenolakan,
                            id_user_internal: paniteraTolak
                        },
                        success: function(response) {
                            if (response.success) {
                                showNotificationSuccess(response.message)
                                location.href = '{{ route(Permissions::MENU_SENGKETA) }}';
                            } else {
                                alert('Gagal menolak sengketa');
                            }
                            hideButtonProgress();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr);
                            showNotificationError(xhr.responseJSON.message ||
                                'Terjadi kesalahan saat menolak sengketa.');
                            hideButtonProgress();
                        }
                    });
                }


            });
        });

        function validateForm() {
            var nameReg = /^[A-Za-z\s]+$/;
            var numberReg = /^[0-9]+$/;
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

            var informasiDimohon = $('textarea[name="penolakan_info"]');
            var paniteraTolak = $('#id_user_internal_tolak');

            var arrayBool = [];

            $('.error-message').remove();

            if (informasiDimohon.val() == "") {
                informasiDimohon.after(
                    '<span class="error-message text-red-600">Informasi yang dimohon tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            if (paniteraTolak.val() == "" || paniteraTolak.val() == "Nama Panitera") {
                paniteraTolak.after('<span class="error-message text-red-600">Panitera tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            return arrayBool;
        }
    </script>

    {{-- terima sengketa --}}
    <script>
        $(document).ready(function() {
                $('#terimaSengketaBtn').on('click', function() {
                    if (validateTerimaForm()) {
                        var panitera = $('#id_user_internal').val();
                        var sengketaId = {{ $id }};

                        var url = '{{ route('sengketa.terima', ':id') }}';
                        url = url.replace(':id', sengketaId);
                        showButtonProgress();

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_user_internal: panitera,
                            },
                            success: function(response) {
                                if (response.success) {
                                    showNotificationSuccess(response.message)
                                    location.href = '{{ route(Permissions::MENU_SENGKETA) }}';
                                } else {
                                    showNotificationError(response.message);
                                }
                                hideButtonProgress();
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr);
                                showNotificationError(xhr.responseJSON.message ||
                                    'Terjadi kesalahan saat terima sengketa.');
                                hideButtonProgress();
                            }
                        });
                    }
                })
            }

        );

        function validateTerimaForm() {
            var panitera = $('#id_user_internal');
            var arrayBool = [];

            $('.error-message').remove(); // Clear previous error messages

            if (panitera.val() == "" || panitera.val() == "Nama Panitera") {
                panitera.after('<span class="error-message text-red-600">Panitera tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            return arrayBool.length === 0;
        }
    </script>

    <script>
        //define modal
        var modalElement = '';
        var modal = '';
        $('#id_user_internal').select2();
        $('#id_user_internal_tolak').select2();

        document.addEventListener('DOMContentLoaded', function() {
            //initialize modal
            modalElement = document.getElementById('reject-modal');
            modal = new Modal(modalElement);

            modalElementConfirm = document.getElementById('confirm-modal');
            modalConfirm = new Modal(modalElementConfirm);

            //initialize close modal button
            closeModalButtons = modalElement.querySelectorAll('[data-modal-hide]');
            closeModalButtonsConfirm = modalElementConfirm.querySelectorAll('[data-modal-hide]');

            //Hide each close modal button
            closeModalButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    modal.hide();
                });
            });

            closeModalButtonsConfirm.forEach(function(button) {
                button.addEventListener('click', function() {
                    modalConfirm.hide();
                });
            });

            $('.reject').on('click', function() {
                modal.show();

            });

            $('.confirm').on('click', function() {
                modalConfirm.show();
            });

        });
    </script>


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
            if (input.value == 'SK Kemenkumham') {
                hideJenisKelamin();
                hideLabelJenisKelamin();
            } else {
                showJenisKelamin();
                showLabelJenisKelamin();
            }
        }

        function showJenisKelamin() {
            $('#jenis_kelamin').removeClass('hidden');
            $('#label_jenis_kelamin').removeClass('hidden');
        }

        function hideJenisKelamin() {
            $('#jenis_kelamin').addClass('hidden');
            $('#label_jenis_kelamin').addClass('hidden');
        }
    </script>
    <script>
        $(document).ready(function() {
            var id = "{{ $id }}";
            var url = "{{ route('sengketa.show', '') }}/" + id;
            showLoading();

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;

                        // Update identitas container based on approval status
                        if (data.is_approved) {
                            $('#identitas_container').html(
                                '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Terverifikasi</span>'
                            );
                        }

                        $('#komisi').val(data.id_ki);
                        $('#pemohon_nama').val(data.pemohon.nama);
                        $('#pemohon_no_hp').val(data.pemohon.no_hp);
                        $('#jenis_pemohon').val(data.pemohon.jenis_pemohon);
                        $('#pemohon_email').val(data.pemohon.email);
                        $('#jenis_identitas').val(data.pemohon.jenis_identitas);
                        $('#nomor_identitas').val(data.pemohon.nomor_identitas);
                        $('#pemohon_alamat').val(data.pemohon.alamat);

                        $('#kuasa_pemohon_nama').val(data.kuasa_pemohon_nama);
                        $('#kuasa_pemohon_jk').val(data.kuasa_pemohon_jk);

                        $('#termohon_nama').val(data.termohon.nama);
                        $('#termohon_alamat').val(data.termohon.alamat);

                        $('#pemohon').val(data.pemohon);
                        $('#termohon').val(data.termohon);

                        $('[name="tanggal_permohonan"]').val(data.tanggal_permohonan);
                        $('[name="tanggal_jawaban"]').val(data.tanggal_jawaban);
                        $('[name="tanggal_keberatan"]').val(data.tanggal_keberatan);
                        $('[name="tanggal_tanggapan"]').val(data.tanggal_tanggapan);

                        if (data.alasan_permohonan && data.alasan_permohonan.length > 0) {
                            data.alasan_permohonan.forEach(function(alasan) {
                                $('input[name="alasan_permohonan[]"][value="' + alasan + '"]')
                                    .prop('checked', true);
                            });
                        }

                        // Handling file fields
                        setFileLink('#file_identitas', '#file_identitas_link', data.file_identitas, id);
                        setFileLink('#file_formulir_keberatan', '#file_formulir_keberatan_link', data
                            .file_formulir_keberatan, id);
                        setFileLink('#file_surat_kuasa', '#file_surat_kuasa_link', data
                            .file_surat_kuasa, id);
                        setFileLink('#file_tanggapan_atasan_ppid', '#file_tanggapan_atasan_ppid_link',
                            data.file_tanggapan_atasan_ppid, id);
                        setFileLink('#file_formulir_permohonan', '#file_formulir_permohonan_link', data
                            .file_formulir_permohonan, id);
                        setFileLink('#file_pemberitahuan_tertulis', '#file_pemberitahuan_tertulis_link',
                            data.file_pemberitahuan_tertulis, id);
                        setFileLink('#file_pendukung_sengketa1', '#file_pendukung_sengketa1_link', data
                            .file_pendukung1, id);
                        setFileLink('#file_pendukung_sengketa2', '#file_pendukung_sengketa2_link', data
                            .file_pendukung2, id);
                        setFileLink('#file_jawaban_ppid', '#file_jawaban_ppid_link', data
                            .file_jawaban_ppid, id);

                        @if (in_array(Permissions::FITUR_SENGKETA_TOLAK, $permissions))
                            fetchPaniteraList('#id_user_internal_tolak');
                        @endif
                        @if (in_array(Permissions::FITUR_SENGKETA_TERIMA, $permissions))
                            fetchPaniteraList('#id_user_internal');
                        @endif

                        hideLoading();

                    } else {
                        showNotificationError('Gagal mendapatkan data sengketa.');
                    }
                },
                error: function(xhr, status, error) {
                    $('#sengketa-data').html('<p>Terjadi kesalahan saat mengambil data.</p>');
                    console.error(error);
                }
            });

            function setFileLink(inputId, linkId, fileUrl, id) {
                if (fileUrl) {
                    const url = '{{ route('get_pdf_view') }}?path=' + fileUrl;

                    $(linkId).attr('href', '#').removeClass('hidden').click(function(e) {
                        e.preventDefault();
                        showModal(url);
                    });
                } else {
                    $(linkId).attr('href', '#').removeClass('hidden');
                    $(linkId).text('Dokumen tidak tersedia');
                    $(linkId).addClass('!bg-gray-700 cursor-not-allowed pointer-events-none');
                }
            }

            function showModal(url) {
                $('#documentIframe').attr('src', url);
                $('#documentModal').removeClass('hidden');
            }

            $('#closeModal').click(function() {
                $('#documentModal').addClass('hidden');
                $('#documentIframe').attr('src', '');
            });

        });

        function fetchPaniteraList(selectId) {
            var role = 'panitera';
            var id_ki = $('#komisi').val();
            if (id_ki == '') {
                showNotificationError('Pilih Komisi Informasi terlebih dahulu.');
                return;
            }
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
                        select.append('<option value="">Nama Panitera</option>');
                        response.data.forEach(function(item) {
                            select.append('<option value="' + item.id + '">' + item.nama + '</option>');
                        });
                    } else {
                        showNotificationError('Gagal memuat data panitera.');
                    }
                },
                error: function(xhr) {
                    showNotificationError('Terjadi kesalahan. Mohon coba lagi.');
                    console.error(xhr);
                }
            });
        }

        function showButtonProgress() {
            $('#btn_loading_terima').removeAttr('hidden');
            $('#btn_loading_tolak').removeAttr('hidden');
            $('#terimaSengketaBtn').attr('hidden', true);
            $('#tolakSengketaBtn').attr('hidden', true);
        }

        function hideButtonProgress() {
            $('#terimaSengketaBtn').removeAttr('hidden');
            $('#tolakSengketaBtn').removeAttr('hidden');
            $('#btn_loading_terima').attr('hidden', true);
            $('#btn_loading_tolak').attr('hidden', true);
        }
    </script>
@endpush

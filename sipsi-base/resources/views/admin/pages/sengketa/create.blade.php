@extends('admin.layouts.master')
@section('title', 'Sengketa')
@section('content')
    @php
        $permissions = getPermissionsForActiveRole();
    @endphp
    <!-- Breadcrumb -->
    {{ Breadcrumbs::render('sengketa.create') }}

    <!-- Content -->
    <div class="container mx-auto pb-4">
        <h1 class="text-2xl font-bold mb-6 text-red-700">Formulir Permohonan Sengketa</h1>

        <form id="sengketaForm" enctype="multipart/form-data" method="POST">
            <!-- A. Identitas Pemohon -->
            <div class="mb-6">
                <label for="komisi" class="block text-sm font-medium text-gray-700">Komisi Informasi yang Dituju</label>
                <select id="komisi" name="id_ki"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                    <option value="">Pilih Komisi Informasi</option>
                    @foreach (getListKiConfig() as $ki)
                        <option value="{{ $ki->id }}">{{ $ki->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- A. Identitas Pemohon -->
            @if (getActiveRole() == 'pemohon')
                <fieldset class="mb-6">
                    <legend class="text-lg font-medium text-gray-700">A. Identitas Pemohon</legend>
                    <input type="hidden" id="id_pemohon" name="id_pemohon" value="{{ Auth::user()->id }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="form_pemohon_nama" class="block text-sm font-medium text-gray-700">Nama
                                Pemohon/Lembaga
                                Pemohon </label>
                            <input type="text" id="form_pemohon_nama" name="form_pemohon_nama" disabled disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                                value="{{ Auth::user()->pemohon->nama }}">
                        </div>
                        <div>
                            <label for="form_pemohon_no_hp" class="block text-sm font-medium text-gray-700">No.
                                HP/WA</label>
                            <input type="text" id="form_pemohon_no_hp" name="form_pemohon_no_hp" disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                                value="{{ Auth::user()->pemohon->no_hp }}">
                        </div>
                        <div>
                            <label for="form_jenis_pemohon" class="block text-sm font-medium text-gray-700">Jenis
                                Pemohon</label>
                            <select name="form_jenis_pemohon" id="form_jenis_pemohon" onchange="onJenisPemohonChange(this);"
                                disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                                <option selected value="{{ Auth::user()->pemohon->jenis_pemohon }}">
                                    {{ Auth::user()->pemohon->jenis_pemohon }}</option>
                            </select>
                        </div>
                        <div>
                            <label for="form_pemohon_email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="form_pemohon_email" name="form_pemohon_email" disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                                value="{{ Auth::user()->pemohon->nama }}">
                        </div>
                        <div>
                            <label for="form_jenis_identitas" class="block text-sm font-medium text-gray-700">Tanda Bukti Identitas
                            </label>
                            <select name="form_jenis_identitas" id="form_jenis_identitas" disabled
                                onchange="onJenisIdentitasChange(this);" disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                                <option value="{{ Auth::user()->pemohon->jenis_identitas }}" selected>
                                    {{ Auth::user()->pemohon->jenis_identitas }} </option>
                            </select>
                        </div>
                        <div>
                            <label for="form_nomor_identitas" class="block text-sm font-medium text-gray-700">Nomor
                                Identitas</label>
                            <input type="text" id="form_nomor_identitas" name="form_nomor_identitas" disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                                value="{{ Auth::user()->pemohon->nomor_identitas }}">
                        </div>
                        <div id="form_kata_kunci_identitas_container">
                            <label for="form_kata_kunci_identitas" id="label_kata_kunci_identitas" class="block text-sm font-medium text-gray-700">Buat Kata Kunci Identitas</label>
                            <input type="text" id="form_kata_kunci_identitas" name="form_kata_kunci_identitas"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                                value="{{ Auth::user()->pemohon->kata_kunci_identitas ?? '' }}">
                        </div>
                        <div>
                            <label for="form_pemohon_alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea id="form_pemohon_alamat" name="form_pemohon_alamat" disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">{{ Auth::user()->pemohon->alamat }}</textarea>
                        </div>
                        <div>
                            <label id="form_label_jenis_kelamin" for="form_jenis_kelamin"
                                class="text-sm font-medium text-gray-700 hidden">Jenis Kelamin</label>
                            <select name="form_jenis_kelamin" id="form_jenis_kelamin"
                                class="hidden mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                                <option value="L">LAKI-LAKI</option>
                                <option value="P">PEREMPUAN</option>
                            </select>
                        </div>

                    </div>
                </fieldset>
            @else
                <fieldset class="mb-6">
                    <legend class="text-lg font-medium text-gray-700">A. Identitas Pemohon</legend>
                    <button type="button" id="cari_pemohon"
                        class="mt-2 px-6 py-2 bg-primary text-white rounded-md shadow-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:primary cari">
                        CARI DATA PEMOHON
                    </button>
                    <input type="hidden" id="id_pemohon" name="id_pemohon">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="form_pemohon_nama" class="block text-sm font-medium text-gray-700">Nama
                                Pemohon/Lembaga
                                Pemohon </label>
                            <input type="text" id="form_pemohon_nama" name="form_pemohon_nama" disabled disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="form_pemohon_no_hp" class="block text-sm font-medium text-gray-700">No.
                                HP/WA</label>
                            <input type="text" id="form_pemohon_no_hp" name="form_pemohon_no_hp" disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="form_jenis_pemohon" class="block text-sm font-medium text-gray-700">Jenis
                                Pemohon</label>
                            <select name="form_jenis_pemohon" id="form_jenis_pemohon"
                                onchange="onJenisPemohonChange(this);" disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                                <option selected value=""> JENIS PEMOHON</option>
                                <option value="PERORANGAN">PERORANGAN</option>
                                <option value="LEMBAGA">LEMBAGA</option>
                                <option value="KELOMPOK ORANG">KELOMPOK ORANG</option>
                            </select>
                        </div>
                        <div>
                            <label for="form_pemohon_email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="form_pemohon_email" name="form_pemohon_email" disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="form_jenis_identitas" class="block text-sm font-medium text-gray-700">Tanda Bukti
                                Identitas
                            </label>
                            <select name="form_jenis_identitas" id="form_jenis_identitas" disabled
                                onchange="onJenisIdentitasChange(this);" disabled
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
                            <label for="form_nomor_identitas" class="block text-sm font-medium text-gray-700">Nomor
                                Identitas</label>
                            <input type="text" id="form_nomor_identitas" name="form_nomor_identitas" disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="form_pemohon_alamat"
                                class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea id="form_pemohon_alamat" name="form_pemohon_alamat" disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"></textarea>
                        </div>
                        <div id="form_kata_kunci_identitas_container">
                            <label for="form_kata_kunci_identitas" id="label_kata_kunci_identitas" class="block text-sm font-medium text-gray-700">Buat Kata Kunci Identitas</label>
                            <input type="text" id="form_kata_kunci_identitas" name="form_kata_kunci_identitas"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                                value="{{ Auth::user()->pemohon->kata_kunci_identitas ?? '' }}">
                        </div>
                        <div>
                            <label id="form_label_jenis_kelamin" for="form_jenis_kelamin"
                                class="text-sm font-medium text-gray-700 hidden">Jenis Kelamin</label>
                            <select name="form_jenis_kelamin" id="form_jenis_kelamin"
                                class="hidden mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                                <option value="" selected>JENIS KELAMIN</option>
                                <option value="L">LAKI-LAKI</option>
                                <option value="P">PEREMPUAN</option>
                            </select>
                        </div>

                    </div>
                </fieldset>
            @endif

            <!-- B. Identitas Kuasa Pemohon -->
            <fieldset class="mb-6">
                <legend class="text-lg font-medium text-gray-700">B. Identitas Kuasa Pemohon</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="kuasa_pemohon_nama" class="block text-sm font-medium text-gray-700">Nama Kuasa
                            Pemohon</label>
                        <input type="text" id="kuasa_pemohon_nama" name="kuasa_pemohon_nama"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="kuasa_pemohon_jk" class="block text-sm font-medium text-gray-700">Jenis
                            Kelamin</label>
                        <select id="kuasa_pemohon_jk" name="kuasa_pemohon_jk"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                            <option value="">Pilih Jenis Kelamin</option>
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
                            required>
                    </div>
                    <div>
                        <label for="termohon_alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input type="text" id="termohon_alamat" name="termohon_alamat"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
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
                                placeholder="Tanggal Permohonan">
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
                                placeholder="Tanggal Jawaban">
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
                                placeholder="Tanggal Keberatan">
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
                                placeholder="Tanggal Tanggapan">
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
                            class="mr-2"> Alasan PPID menolak permohonan informasi dengan alasan pengecualian berdasarkan
                        Pasal 17 UU KIP
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]"
                            value="Tidak disediakannya informasi berkala sebagaimana diatur di dalam Pasal 9 UU KIP"
                            class="mr-2"> Tidak disediakannya informasi berkala sebagaimana diatur di dalam Pasal 9 UU
                        KIP
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]"
                            value="Atasan PPID tidak menanggapi keberatan Pemohon." class="mr-2"> Atasan PPID tidak
                        menanggapi keberatan Pemohon.
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]"
                            value="Pemohon tidak puas terhadap tanggapan Atasan PPID atas keberatan." class="mr-2">
                        Pemohon
                        tidak puas terhadap tanggapan Atasan PPID atas keberatan.
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]" value="Pengenaan biaya yang tidak wajar."
                            class="mr-2"> Pengenaan biaya yang tidak wajar.
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]"
                            value="Penyampaian informasi yang melebihi waktu yang diatur di dalam UU KIP." class="mr-2">
                        Penyampaian informasi yang melebihi waktu yang diatur di dalam UU KIP.
                    </label>
                </div>
            </fieldset>

            <!-- Dokumen Kelengkapan -->
            <fieldset class="mb-6">
                <legend class="text-lg font-medium text-gray-700">D. Dokumen Kelengkapan Pemohon</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">KTP/SIM/Paspor <span
                                class="text-red-900 text-md">*</span></label>
                        <div class="flex items-center h-[40px]">
                            <label for="file_identitas"
                                class="cursor-pointer inline-flex items-center px-2 xl:px-4 py-2 text-sm lg:text-base bg-primary text-white rounded-s-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary h-full">
                                <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Pilih File
                            </label>
                            <span class="inline-flex items-center h-full w-[200px] md:w-[100px] lg:w-[200px] px-3 py-1 text-xs lg:text-sm rounded-e-md border border-gray-300 font-semibold text-gray-600"><p class="file_info truncate">tidak ada file yang dipilih</p></span>
                        </div>
                        <input type="file" id="file_identitas" name="file_identitas" class="hidden" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Surat Pengajuan Keberatan/Formulir Pengajuan
                            Keberatan <span class="text-red-900 text-md">*</span></label>
                        <div class="flex items-center h-[40px]">
                            <label for="file_formulir_keberatan"
                                class="cursor-pointer inline-flex items-center px-2 xl:px-4 py-2 text-sm lg:text-base bg-primary text-white rounded-s-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary h-full">
                                <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Pilih File
                            </label>
                            <span class="inline-flex items-center h-full w-[200px] md:w-[100px] lg:w-[200px] px-3 py-1 text-xs lg:text-sm rounded-e-md border border-gray-300 font-semibold text-gray-600"><p class="file_info truncate">tidak ada file yang dipilih</p></span>
                        </div>
                        <input type="file" id="file_formulir_keberatan" name="file_formulir_keberatan"
                            class="hidden" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Surat Kuasa</label>
                        <div class="flex items-center h-[40px]">
                            <label for="file_surat_kuasa"
                                class="cursor-pointer inline-flex items-center px-2 xl:px-4 py-2 text-sm lg:text-base bg-primary text-white rounded-s-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary h-full">
                                <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Pilih File
                            </label>
                            <span class="inline-flex items-center h-full w-[200px] md:w-[100px] lg:w-[200px] px-3 py-1 text-xs lg:text-sm rounded-e-md border border-gray-300 font-semibold text-gray-600"><p class="file_info truncate">tidak ada file yang dipilih</p></span>
                        </div>
                        <input type="file" id="file_surat_kuasa" name="file_surat_kuasa"
                            class="hidden" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggapan Atasan PPID Atas Keberatan</label>
                        <div class="flex items-center h-[40px]">
                            <label for="file_tanggapan_atasan_ppid"
                                class="cursor-pointer inline-flex items-center px-2 xl:px-4 py-2 text-sm lg:text-base bg-primary text-white rounded-s-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary h-full">
                                <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Pilih File
                            </label>
                            <span class="inline-flex items-center h-full w-[200px] md:w-[100px] lg:w-[200px] px-3 py-1 text-xs lg:text-sm rounded-e-md border border-gray-300 font-semibold text-gray-600"><p class="file_info truncate">tidak ada file yang dipilih</p></span>
                        </div>
                        <input type="file" id="file_tanggapan_atasan_ppid" name="file_tanggapan_atasan_ppid"
                            class="hidden" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Surat Permohonan/Formuiir permohonan <span
                                class="text-red-900 text-md">*</span></label>
                        <div class="flex items-center h-[40px]">
                            <label for="file_formulir_permohonan"
                                class="cursor-pointer inline-flex items-center px-2 xl:px-4 py-2 text-sm lg:text-base bg-primary text-white rounded-s-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary h-full">
                                <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Pilih File
                            </label>
                            <span class="inline-flex items-center h-full w-[200px] md:w-[100px] lg:w-[200px] px-3 py-1 text-xs lg:text-sm rounded-e-md border border-gray-300 font-semibold text-gray-600"><p class="file_info truncate">tidak ada file yang dipilih</p></span>
                        </div>
                        <input type="file" id="file_formulir_permohonan" name="file_formulir_permohonan"
                            class="hidden" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pemberitahuan Tertulis</label>
                        <div class="flex items-center h-[40px]">
                            <label for="file_pemberitahuan_tertulis"
                                class="cursor-pointer inline-flex items-center px-2 xl:px-4 py-2 text-sm lg:text-base bg-primary text-white rounded-s-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary h-full">
                                <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Pilih File
                            </label>
                            <span class="inline-flex items-center h-full w-[200px] md:w-[100px] lg:w-[200px] px-3 py-1 text-xs lg:text-sm rounded-e-md border border-gray-300 font-semibold text-gray-600"><p class="file_info truncate">tidak ada file yang dipilih</p></span>
                        </div>
                        <input type="file" id="file_pemberitahuan_tertulis" name="file_pemberitahuan_tertulis"
                            class="hidden" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dokumen Pendukung Lain</label>
                        <div class="flex items-center h-[40px]">
                            <label for="file_pendukung_sengketa1"
                                class="cursor-pointer inline-flex items-center px-2 xl:px-4 py-2 text-sm lg:text-base bg-primary text-white rounded-s-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary h-full">
                                <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Pilih File
                            </label>
                            <span class="inline-flex items-center h-full w-[200px] md:w-[100px] lg:w-[200px] px-3 py-1 text-xs lg:text-sm rounded-e-md border border-gray-300 font-semibold text-gray-600"><p class="file_info truncate">tidak ada file yang dipilih</p></span>
                        </div>
                        <input type="file" id="file_pendukung_sengketa1" name="file_pendukung_sengketa1"
                            class="hidden" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dokumen Pendukung Lain</label>
                        <div class="flex items-center h-[40px]">
                            <label for="file_pendukung_sengketa2"
                                class="cursor-pointer inline-flex items-center px-2 xl:px-4 py-2 text-sm lg:text-base bg-primary text-white rounded-s-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary h-full">
                                <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Pilih File
                            </label>
                            <span class="inline-flex items-center h-full w-[200px] md:w-[100px] lg:w-[200px] px-3 py-1 text-xs lg:text-sm rounded-e-md border border-gray-300 font-semibold text-gray-600"><p class="file_info truncate">tidak ada file yang dipilih</p></span>
                        </div>
                        <input type="file" id="file_pendukung_sengketa2" name="file_pendukung_sengketa2"
                            class="hidden" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jawaban PPID terhadap Pemohon</label>
                        <div class="flex items-center h-[40px]">
                            <label for="file_jawaban_ppid"
                                class="cursor-pointer inline-flex items-center px-2 xl:px-4 py-2 text-sm lg:text-base bg-primary text-white rounded-s-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary h-full">
                                <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Pilih File
                            </label>
                            <span class="inline-flex items-center h-full w-[200px] md:w-[100px] lg:w-[200px] px-3 py-1 text-xs lg:text-sm rounded-e-md border border-gray-300 font-semibold text-gray-600"><p class="file_info truncate">tidak ada file yang dipilih</p></span>
                        </div>
                        <input type="file" id="file_jawaban_ppid" name="file_jawaban_ppid"
                            class="hidden" />
                    </div>
                </div>
            </fieldset>

            <!-- Pernyataan Permohonan -->
            <fieldset class="mb-6">
                <legend class="text-lg font-medium">Pernyataan Permohonan</legend>
                <ol id="sengketa-statements" class="ps-5 mt-2 space-y-1 list-decimal list-outside">
                    <li>Dengan ini saya menyatakan bahwa sengketa informasi yang saya ajukan kepada <span
                            id="komisi-name">Komisi Informasi Pusat</span>
                        tidak sedang diproses atau belum pernah diputus oleh lembaga peradilan dan tidak sedang diproses
                        atau difasilitasi oleh lembaga penyelesaian sengketa lainnya.
                    </li>
                    <li>Bahwa saya bersedia mengikuti seluruh proses penyelesaian sengketa di <span
                            id="komisi-name-2">Komisi Informasi Pusat</span>.</li>
                    <li>Apabila pernyataan yang saya berikan di atas tidak sesuai dengan keadaan yang sebenarnya, maka
                        <span id="komisi-name-3">Komisi Informasi Pusat</span> berhak untuk menolak permohonan penyelesaian
                        sengketa yang saya ajukan atau
                        menghentikan seluruh proses penyelesaian sengketa informasi ini.
                    </li>
                </ol>
                <div id="labelCheckbox" class="flex items-center me-4 mt-4">
                    <input type="checkbox" value=""
                        class="w-8 h-8 text-primary bg-gray-100 border-gray-300 rounded focus:primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        id="red-checkbox" name="red-checkbox" required>
                    <label for="red-checkbox" class="ms-2 text-md font-medium text-gray-900 dark:text-gray-300">Demikian
                        permohonan penyelesaian sengketa informasi ini saya ajukan dengan sadar tanpa pengaruh atau paksaan
                        dari pihak manapun.</label>
                </div>
            </fieldset>
        </form>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <div class="relative w-1/2 md:w-1/5 lg:w-1/6">
                <button type="submit" id="submitBtn"
                    class="absolute w-full px-6 py-2 bg-primary text-white rounded-md shadow-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:primary">
                    KIRIM
                </button>
                <button id="btn_loading" hidden
                    class="w-full absolute px-6 py-2 bg-primary text-white rounded-md shadow-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:primary">
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

    <!-- Success modal -->
    <div id="success-modal" data-modal-placement="bottom-right" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full border border-themecolor-primary border-collapse">
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
                        Selamat {{ Auth::user()->name }} Dengan No. Registrasi Online <span id="no_registrasi"></span>
                        Permohonan Sengketa Anda Berhasil Diajukan
                    </p>
                    <a href="{{ route(Permissions::MENU_SENGKETA) }}" data-modal-hide="success-modal" type="button"
                        class="text-white bg-themecolor-primary hover:bg-red-700 focus:ring-4 focus:outline-none mt-10 focus:ring-red-300 font-medium rounded-lg text-base px-6 py-3">
                        LIHAT DAFTAR SENGKETA SAYA
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- Cari modal -->
    <div id="cari-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div id="loadingIndicator"
                    class="absolute inset-0 items-center justify-center bg-gray-700 bg-opacity-50 hidden">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-white"></div>
                </div>
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Cari Data Pemohon
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="cari-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    @if (in_array(Permissions::FITUR_USER_PEMOHON_CREATE, $permissions))
                        <button type="button"
                            class="bg-primary hover:bg-red-800 text-white py-2 px-6 rounded mt-4 crud-modal"
                            data-modal-target="crud-modal">Tambah Pemohon</button>
                    @endif
                    <form id="cariForm">
                        <div class="flex">
                            <div class="w-full m-2">
                                <label for="cari_nomor_identitas" class="block text-sm font-medium text-gray-700">No.
                                    Identitas</label>
                                <input type="text" id="cari_nomor_identitas" name="cari_nomor_identitas"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                            </div>
                            <div class="flex justify-end items-end">
                                <button type="button"
                                    class="bg-primary text-white hover:bg-red-800 py-2 px-6 rounded m-2"
                                    id="cariButton">Cari</button>
                                <button type="button"
                                    class="bg-gray-600 text-white hover:bg-gray-800 py-2 px-6 rounded m-2"
                                    id="resetButton">Reset</button>
                            </div>
                        </div>
                    </form>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                            id="resultTable">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        No. Identitas
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                </div>
            </div>
        </div>
    </div>

    <!-- Main modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
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
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">A.
                                Informasi Akun</label>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <select name="jenis_pemohon" id="jenis_pemohon"
                                onchange="onJenisPemohonChange(this);clearError(this)"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                required>
                                <option selected value=""> JENIS PEMOHON *</option>
                                <option value="PERORANGAN">PERORANGAN</option>
                                <option value="LEMBAGA">LEMBAGA</option>
                                <option value="KELOMPOK ORANG">KELOMPOK ORANG</option>
                            </select>
                            <p id="error_jenis_pemohon" class="error text-sm text-red-600 dark:text-red-500"></p>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="name" id="name" onkeydown="clearError(this)"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Nama Lengkap *" required="">
                            <p id="error_name" class="error text-sm text-red-600 dark:text-red-500"></p>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <select name="jenis_identitas" id="jenis_identitas" disabled
                                onchange="onJenisIdentitasChange(this);clearError(this)"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                required>
                                <option value="" selected>Jenis Identitas *</option>
                                <option value="KTP">KTP</option>
                                <option value="SIM">SIM</option>
                                <option value="PASPOR">PASPOR</option>
                            </select>
                            <p id="error_jenis_identitas" class="error text-sm text-red-600 dark:text-red-500"></p>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="nomor_identitas" id="nomor_identitas"
                                onkeydown="clearError(this)"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Nomor Identitas *" required="">
                            <p id="error_nomor_identitas" class="error text-sm text-red-600 dark:text-red-500"></p>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-autohide
                                datepicker-format="dd/mm/yyyy" type="text" name="tanggal_lahir" id="tanggal_lahir"
                                onclick="clearError(this)"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Tanggal Lahir ">
                            <p id="error_tanggal_lahir" class="error text-sm text-red-600 dark:text-red-500"></p>
                        </div>
                        <div class="hidden col-span-2 sm:col-span-1" id="input_jenis_kelamin">
                            <select name="jenis_kelamin" id="jenis_kelamin" onchange="clearError(this)"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary w-full p-2.5">
                                <option value="" selected>Jenis Kelamin</option>
                                <option value="L">LAKI-LAKI</option>
                                <option value="P">PEREMPUAN</option>
                            </select>
                            <p id="error_jenis_kelamin" class="error text-sm text-red-600 dark:text-red-500"></p>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <textarea id="alamat" rows="4" name="alamat" onkeydown="clearError(this)"
                                class="text-sm bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Alamat *"></textarea>
                            <p id="error_alamat" class="error text-sm text-red-600 dark:text-red-500"></p>
                        </div>
                        <!-- Kontak dan Password -->
                        <div class="col-span-2">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                B. Kontak</label>
                            {{-- <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        B. Kontak dan Password</label> --}}

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="email" name="email" id="email" onkeydown="clearError(this)"
                                class="bg-white border  border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Email *" required="" />
                            <p id="error_email" class="error text-sm text-red-600 dark:text-red-500"></p>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="number" name="no_hp" id="no_hp" onkeydown="clearError(this)"
                                class="bg-white border  border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Nomor Telpon / Whatsapp *" required="" />
                            <p id="error_no_hp" class="error text-sm text-red-600 dark:text-red-500"></p>
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
                            class="w-xl text-primary cari bg-white border border-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                            Kembali
                        </button>
                        <button type="submit" id="btn_submit"
                            class="w-xl text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                            Simpan
                        </button>
                        <button id="btn_loading_crud" hidden
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
@endsection

@push('prepend-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('prepend-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script>
        //define modal
        var modalElementSuccess = '';
        var modalSuccess = '';

        var modalElement = '';
        var modal = '';

        var modalElementCari = '';
        var modalCari = '';

        document.addEventListener('DOMContentLoaded', function() {
            //initialize modal
            modalElement = document.getElementById('crud-modal');
            modalElementSuccess = document.getElementById('success-modal');
            modalElementCari = document.getElementById('cari-modal');

            modalSuccess = new Modal(modalElementSuccess);
            modal = new Modal(modalElement);
            modalCari = new Modal(modalElementCari);

            //initialize close modal button
            const closeModalButtons = modalElement.querySelectorAll('[data-modal-hide]');
            const closeModalSuccessButtons = modalElementSuccess.querySelectorAll('[data-modal-hide]');
            const closeModalCariButtons = modalElementCari.querySelectorAll('[data-modal-hide]');


            //Hide each close modal button
            closeModalSuccessButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    modalSuccess.hide();
                });
            });

            closeModalButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    modal.hide();
                });
            });

            closeModalCariButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    modalCari.hide();
                });
            });

            $('.cari').on('click', function() {
                modalCari.show();
            });

            $('.crud-modal').on('click', function() {
                modalCari.hide();
                modal.show();
            });

            const komisiSelect = document.getElementById('komisi');
            const komisiNameSpans = document.querySelectorAll('#sengketa-statements span[id^="komisi-name"]');

            komisiSelect.addEventListener('change', function() {
                const selectedKomisi = komisiSelect.options[komisiSelect.selectedIndex].text;

                komisiNameSpans.forEach(span => {
                    span.textContent = selectedKomisi;
                });
            });



        });
    </script>

    <script>
        $(document).ready(function() {
            $('#submitBtn').on('click', function(e) {
                e.preventDefault();

                var formData = new FormData($('#sengketaForm')[0]);
                var validateCreate = validateFormCreate();
                var agreeCheckbox = document.getElementById('red-checkbox');

                showButtonProgress();

                if (validateCreate.length == 0) {
                    $.ajax({
                        url: '{{ route('sengketa.create') }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // showNotificationSuccess(response.message)
                            hideButtonProgress();
                            $('#sengketaForm')[0].reset();
                            $('#no_registrasi').text(response.data.no_registrasi);
                            modalSuccess.show();
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                var errorMessage = 'Terjadi kesalahan validasi:\n';
                                $.each(errors, function(key, value) {
                                    errorMessage += key + ': ' + value.join(', ') +
                                        '\n';
                                });
                                showNotificationError(errorMessage)
                            } else if (xhr.status === 406) {
                                showNotificationError(xhr.responseJSON.message)
                            } else {
                                showNotificationError('Terjadi kesalahan. Mohon coba lagi.');
                            }
                            console.error(xhr);
                            hideButtonProgress();
                        }
                    });

                } else {
                    showNotificationError(
                        'Mohon cek kembali form yang anda masukkan. Pastikan tidak ada field yang kosong atau salah.'
                    );
                    hideButtonProgress();
                }




            });

        });

        $('input[type=file]').change(function() {
            var fileInput = $(this);
            var val = fileInput.val().toLowerCase();
            var allowedExtensions;
            var isFileIdentitas = fileInput.attr('name') === 'file_identitas';

            if (isFileIdentitas) {
                allowedExtensions = new RegExp("(.*?)\.(pdf|jpg|jpeg)$");
            } else {
                allowedExtensions = new RegExp("(.*?)\.(pdf)$");
            }

            if (!allowedExtensions.test(val)) {
                fileInput.val('');
                var errorMessage = isFileIdentitas ? 'File yang diupload harus berupa PDF, JPG, atau JPEG' :
                    'File yang diupload harus berupa PDF';
                showNotificationError(errorMessage);
            } else if (fileInput[0].files[0].size > 2000000) {
                fileInput.val('');
                showNotificationError('Ukuran file tidak boleh lebih dari 2MB');
            } else {
                fileInput.parent().find('.error-message').remove();
            }
        });

        $('input[type="file"]').change(function() {
            const fileName = this.files[0]?.name;
            const fileInfo = $(this).prev('div').find('.file_info');

            if (fileName) {
                fileInfo.text(`${fileName}`);
            } else {
                fileInfo.text(`tidak ada file yang dipilih`);
            }
        });

        function validateFormCreate() {
            var nameReg = /^[A-Za-z\s]+$/;
            var numberReg = /^[0-9]+$/;
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

            var pemohon = $('#id_pemohon');

            var komisi = $('#komisi');

            var termohon_nama = $('#termohon_nama');
            var tanggal_permohonan = $('[name="tanggal_permohonan"]');
            var tanggal_keberatan = $('[name="tanggal_keberatan"]');
            var div_tanggal_permohonan = $('#tanggal_permohonan');
            var div_tanggal_keberatan = $('#tanggal_keberatan');
            var checkbox = $('#red-checkbox');
            var labelCheckbox = $('#labelCheckbox');
            var alasan_permohonan = $('input[name="alasan_permohonan[]"]:checked');
            var legendAlasan = $('#legendAlasan');
            var file_identitas = $('#file_identitas');
            var file_formulir_keberatan = $('#file_formulir_keberatan');
            var file_formulir_permohonan = $('#file_formulir_permohonan');
            var kata_kunci_identitas = $('#form_kata_kunci_identitas');

            var arrayBoolCreate = [];

            $('.error-message').remove();
            
            if (komisi.val() == "") {
                komisi.after('<span class="error-message text-red-600">Komisi Informasi harus dipilih terlebih dahulu</span>');
                arrayBoolCreate.push(true);
            }

            if (pemohon.val() == "") {
                pemohon.after('<span class="error-message text-red-600">Pemohon harus dipilih terlebih dahulu</span>');
                arrayBoolCreate.push(true);
            }

            if (termohon_nama.val() == "") {
                termohon_nama.after('<span class="error-message text-red-600">Nama Badan Publik tidak boleh kosong</span>');
                arrayBoolCreate.push(true);
            }

            if (tanggal_permohonan.val() == "") {
                div_tanggal_permohonan.after(
                    '<span class="error-message text-red-600">Tanggal Permohonan tidak boleh kosong</span>');
                arrayBoolCreate.push(true);
            }

            if (tanggal_keberatan.val() == "") {
                div_tanggal_keberatan.after(
                    '<span class="error-message text-red-600">Tanggal Keberatan tidak boleh kosong</span>');
                arrayBoolCreate.push(true);
            }

            if (!checkbox.is(':checked')) {
                labelCheckbox.after(
                    '<span class="error-message text-red-600">Anda harus menyetujui pernyataan permohonan</span>');
                arrayBoolCreate.push(true);
            }

            if (alasan_permohonan.length == 0) {
                legendAlasan.after(
                    '<span class="error-message text-red-600">Setidaknya satu alasan permohonan harus dipilih</span>');
                arrayBoolCreate.push(true);
            }

            if (file_identitas.val() == "") {
                file_identitas.after(
                    '<span class="block error-message text-red-600">KTP/SIM/Paspor tidak boleh kosong</span>'
                    );
                arrayBoolCreate.push(true);
            }

            if (file_formulir_keberatan.val() == "") {
                file_formulir_keberatan.after(
                    '<span class="block error-message text-red-600">Surat Pengajuan Keberatan/Formulir Pengajuan Keberatan tidak boleh kosong</span>'
                );
                arrayBoolCreate.push(true);
            }

            if (file_formulir_permohonan.val() == "") {
                file_formulir_permohonan.after(
                    '<span class="block error-message text-red-600">Surat Permohonan/Formulir Permohonan tidak boleh kosong</span>'
                );
                arrayBoolCreate.push(true);
            }

            if (kata_kunci_identitas.val() == "") {
                kata_kunci_identitas.after(
                    '<span class="block error-message text-red-600">Kata kunci identitas tidak boleh kosong</span>'
                );
                arrayBoolCreate.push(true);
            } else if (kata_kunci_identitas.val().length < 3) {
                kata_kunci_identitas.after(
                    '<span class="block error-message text-red-600">Kata kunci identitas minimal 3 karakter</span>'
                );
                arrayBoolCreate.push(true);
            } else if (kata_kunci_identitas.val().length > 25) {
                kata_kunci_identitas.after(
                    '<span class="block error-message text-red-600">Kata kunci identitas maksimal 25 karakter</span>'
                );
                arrayBoolCreate.push(true);
            } else if (!/^[a-zA-Z0-9\s]+$/.test(kata_kunci_identitas.val())) {
                kata_kunci_identitas.after(
                    '<span class="block error-message text-red-600">Kata kunci identitas hanya boleh mengandung huruf, angka, dan spasi</span>'
                );
                arrayBoolCreate.push(true);
            }

            return arrayBoolCreate;
        }

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

            return arrayBool;
        }
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
            $('#btn_loading_crud').removeAttr('hidden');
            $('#btn_loading').removeAttr('hidden');
            $('#btn_submit').attr('hidden', true);
            $('#submitBtn').attr('hidden', true);
        }

        function hideButtonProgress() {
            $('#btn_submit').removeAttr('hidden');
            $('#submitBtn').removeAttr('hidden');
            $('#btn_loading').attr('hidden', true);
            $('#btn_loading_crud').attr('hidden', true);
        }

        function clearError(input) {
            $('#error_' + input.id).text('');
        }
    </script>
    <script>
        $(document).ready(function() {
            // ============================
            // Element references
            // ============================
            var kataKunciField = $('#form_kata_kunci_identitas_container');
            var isAdminMode = !!$('#id_pemohon').length; // Kalau ada #id_pemohon berarti admin memilih pemohon

            // ============================
            // Function: Check ZKP approval
            // ============================
            function checkZkpApproval(nomorIdentitas) {
                if (!nomorIdentitas) return;

                const ZKP_BASE_URL = '{{ config('services.zkp_url') }}';
                const url = ZKP_BASE_URL + '/is-approved/' + nomorIdentitas;

                console.log('Checking approval for NIK:', nomorIdentitas, 'URL:', url);

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        console.log('Approval status:', response);
                        if (response.approved) {
                            $('#label_kata_kunci_identitas').text('Verifikasi Kata Kunci Identitas');
                        } else {
                            $('#label_kata_kunci_identitas').text('Buat Kata Kunci Identitas');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error checking approval status:', error);
                        $('#label_kata_kunci_identitas').text('Kata Kunci Identitas');
                    }
                });
            }

            // ============================
            // Admin mode: pilih pemohon
            // ============================
            if (isAdminMode) {
                // Hide initially
                kataKunciField.hide();

                // Triggered when pemohon selected
                $('#id_pemohon').on('change', function() {
                    var nomorIdentitas = $(this).find(':selected').data('nomor-identitas') || $('#form_nomor_identitas').val();
                    if ($(this).val()) {
                        kataKunciField.show();
                        console.log('Form kata kunci ditampilkan (Admin)');
                        checkZkpApproval(nomorIdentitas);
                    } else {
                        kataKunciField.hide();
                        console.log('Form kata kunci disembunyikan (Admin)');
                    }
                });

                // Optional: kalau #id_pemohon sudah pre-selected (edit page)
                if ($('#id_pemohon').val()) {
                    kataKunciField.show();
                    checkZkpApproval($('#form_nomor_identitas').val());
                }

                // Cari pemohon button (AJAX search)
                $('#cariButton').on('click', function() {
                    var nomorIdentitas = $('#cari_nomor_identitas').val().trim();
                    if (!nomorIdentitas) {
                        showNotificationError('Nomor Identitas tidak boleh kosong.');
                        return;
                    }
                    showLoadingg();

                    $.ajax({
                        url: '{{ route('sengketa.list-pemohon') }}',
                        type: 'GET',
                        data: { nomor_identitas: nomorIdentitas },
                        success: function(response) {
                            hideLoadingg();
                            $('#resultTable tbody').empty();
                            if (response.success && response.data.length > 0) {
                                response.data.forEach(function(item) {
                                    $('#resultTable tbody').append(`
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">${item.nama}</td>
                                            <td class="px-6 py-4">${item.nomor_identitas}</td>
                                            <td class="px-6 py-4">
                                                <button type="button" class="bg-primary px-6 py-2 rounded text-white hover:bg-red-800" id="pilih-button" 
                                                    data-nama="${item.nama}" 
                                                    data-nomor-identitas="${item.nomor_identitas}" 
                                                    data-id="${item.id}" 
                                                    data-no_hp="${item.no_hp}" 
                                                    data-email="${item.email}" 
                                                    data-jenis_pemohon="${item.jenis_pemohon}" 
                                                    data-alamat="${item.alamat}" 
                                                    data-jenis_kelamin="${item.jenis_kelamin}" 
                                                    data-jenis_identitas="${item.jenis_identitas}">
                                                    Pilih
                                                </button>
                                            </td>
                                        </tr>
                                    `);
                                });
                            } else {
                                $('#resultTable tbody').append(`
                                    <tr>
                                        <td colspan="3" class="text-center py-4">Data tidak ditemukan</td>
                                    </tr>
                                `);
                                showNotificationError('Data tidak ditemukan.');
                            }
                        },
                        error: function(xhr) {
                            hideLoadingg();
                            showNotificationError('Terjadi kesalahan. Mohon coba lagi.');
                            console.error(xhr);
                        }
                    });
                });

                // Pilih pemohon dari hasil search
                $(document).on('click', '#pilih-button', function() {
                    var nomorIdentitas = $(this).data('nomor-identitas');
                    $('#id_pemohon').val($(this).data('id')).trigger('change');
                    $('#form_nomor_identitas').val(nomorIdentitas);

                    // Check approval once
                    checkZkpApproval(nomorIdentitas);

                    // Fill other fields
                    $('#form_pemohon_nama').val($(this).data('nama'));
                    $('#form_pemohon_no_hp').val($(this).data('no_hp'));
                    $('#form_pemohon_email').val($(this).data('email'));
                    $('#form_pemohon_alamat').val($(this).data('alamat'));
                    $('#form_jenis_kelamin').val($(this).data('jenis_kelamin'));
                    $('#form_jenis_identitas').val($(this).data('jenis_identitas'));
                    $('#form_jenis_pemohon').val($(this).data('jenis_pemohon'));

                    modalCari.hide();
                });

            } else {
                // ============================
                // Peserta mode: langsung cek approval NIK
                // ============================
                kataKunciField.show();
                var nomorIdentitas = $('#form_nomor_identitas').val();
                checkZkpApproval(nomorIdentitas);
            }
        });
    </script>


    

    <script>
        $("#btn_submit").click(function(e) {
            e.preventDefault();
            var url = "{{ route('user-pemohon.create') }}";

            //if edit change the URL
            if ($('#id_user').val() != '') {
                url = "{{ route('user-pemohon.update', ':id') }}";
                url = url.replace(':id', $('#id_user').val());
            }
            showButtonProgress();

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
                console.log(formData)

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: JSON.stringify(formData),
                    url: url,
                    contentType: 'application/json',
                    success: function(response) {
                        hideButtonProgress();
                        // modal.hide();
                        showNotificationSuccess(response.message)

                        var data = response.data;
                        console.log(data.nama);
                        $('#form_pemohon_nama').val(data.nama);
                        $('#form_nomor_identitas').val(data.nomor_identitas);
                        $('#form_pemohon_no_hp').val(data.no_hp);
                        $('#form_pemohon_email').val(data.email);
                        $('#form_pemohon_alamat').val(data.alamat);
                        $('#form_jenis_kelamin').val(data.jenis_kelamin);
                        $('#form_jenis_identitas').val(data.jenis_identitas);
                        $('#form_jenis_pemohon').val(data.jenis_pemohon);
                        $('#id_pemohon').val(data.id).trigger('change');

                        modal.hide();


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
                        console.log(response)
                    }
                });
            } else {
                showNotificationError(
                    'Mohon cek kembali form yang anda masukkan. Pastikan tidak ada field yang kosong atau salah.'
                );
                hideButtonProgress();
            }

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

        function showLoadingg() {
            $('#resultTable tbody').empty();
            document.getElementById('loadingIndicator').classList.remove('hidden');
        }

        function hideLoadingg() {
            document.getElementById('loadingIndicator').classList.add('hidden');
        }
    </script>

    <!-- <script>
        $(document).ready(function() {
            $('#cariButton').on('click', function() {
                var nomorIdentitas = $('#cari_nomor_identitas').val().trim();
                if (!nomorIdentitas) {
                    showNotificationError('Nomor Identitas tidak boleh kosong.');
                    return;
                }
                showLoadingg();

                $.ajax({
                    url: '{{ route('sengketa.list-pemohon') }}',
                    type: 'GET',
                    data: {
                        nomor_identitas: nomorIdentitas
                    },
                    success: function(response) {
                        hideLoadingg();
                        $('#resultTable tbody').empty();

                        if (response.success && response.data.length > 0) {
                            response.data.forEach(function(item) {
                                $('#resultTable tbody').append(`
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">${item.nama}</td>
                                    <td class="px-6 py-4">${item.nomor_identitas}</td>
                                    <td class="px-6 py-4">
                                        <button type="button" class="bg-primary px-6 py-2 rounded text-white hover:bg-red-800" id="pilih-button" data-nama="${item.nama}" data-nomor-identitas="${item.nomor_identitas}" data-id="${item.id}" data-no_hp="${item.no_hp}" data-email="${item.email}" data-jenis_pemohon="${item.jenis_pemohon}" data-alamat="${item.alamat}" data-jenis_kelamin="${item.jenis_kelamin}" data-jenis_identitas="${item.jenis_identitas}">Pilih</button>
                                    </td>
                                </tr>
                            `);
                            });
                        } else if (response.success && response.data.length === 0) {
                            $('#resultTable tbody').append(`
                            <tr>
                                <td colspan="3" class="text-center py-4">Data tidak ditemukan</td>
                            </tr>
                        `);
                            showNotificationError('Data tidak ditemukan.');
                        } else {
                            showNotificationError('Terjadi kesalahan. Mohon coba lagi.');
                        }
                    },
                    error: function(xhr) {
                        hideLoadingg();
                        showNotificationError('Terjadi kesalahan. Mohon coba lagi.');
                        console.error(xhr);
                    }
                });
            });

            $(document).on('click', '#pilih-button', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                var nomorIdentitas = $(this).data('nomor-identitas');
                var noHp = $(this).data('no_hp');
                var email = $(this).data('email');
                var jenisPemohon = $(this).data('jenis_pemohon');
                var alamat = $(this).data('alamat');
                var jenisKelamin = $(this).data('jenis_kelamin');
                var jenisIdentitas = $(this).data('jenis_identitas');
                // Ambil base URL dari config/services.php
                const ZKP_BASE_URL = '{{ config('services.zkp_url') }}';
                console.log('Request URL:', ZKP_BASE_URL);

                // Check approval status immediately with the nomor identitas we have
                if (nomorIdentitas) {
                    const url = ZKP_BASE_URL + '/is-approved/' + nomorIdentitas;
                    console.log('Request URL:', url);

                    $.ajax({
                        url: url, // route Laravel
                        method: 'GET',
                        success: function(response) {
                            console.log('Approval status:', response);
                            if (response.approved) {
                                $('#label_kata_kunci_identitas').text('Verifikasi Kata Kunci Identitas');
                            } else {
                                $('#label_kata_kunci_identitas').text('Buat Kata Kunci Identitas');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error checking approval status:', error);
                            // If error occurs, default to
                            $('#label_kata_kunci_identitas').text('Kata Kunci Identitas');
                        }
                    });
                }

                $('#id_pemohon').val(id).trigger('change');
                $('#form_pemohon_nama').val(nama);
                $('#form_nomor_identitas').val(nomorIdentitas);
                $('#form_pemohon_no_hp').val(noHp);
                $('#form_pemohon_email').val(email);
                $('#form_jenis_pemohon').val(jenisPemohon);
                $('#form_pemohon_alamat').val(alamat);
                $('#form_jenis_kelamin').val(jenisKelamin);
                $('#form_jenis_identitas').val(jenisIdentitas);

                modalCari.hide();
            });


            $('#resetButton').on('click', function() {
                $('#cari_nomor_identitas').val('');
                $('#resultTable tbody').empty();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var kataKunciField = $('#form_kata_kunci_identitas_container');
            
            // Function to check ZKP approval
            function checkZkpApproval() {
                var nomorIdentitas = $('#form_nomor_identitas').val();
                console.log('Nomor identitas:', nomorIdentitas);
                // Ambil base URL dari config/services.php
                const ZKP_BASE_URL = '{{ config('services.zkp_url') }}';
                console.log('Request URL:', ZKP_BASE_URL);

                if (nomorIdentitas) {
                    const url = ZKP_BASE_URL + '/is-approved/' + nomorIdentitas;
                    console.log('Request URL:', url);
                    
                    // Check approval status via AJAX
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            console.log('Approval status:', response);
                            if (response.approved) {
                                $('#label_kata_kunci_identitas').text('Verifikasi Kata Kunci Identitas');
                            } else {
                                $('#label_kata_kunci_identitas').text('Buat Kata Kunci Identitas');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error checking approval status:', error);
                            // If error occurs, default to
                            $('#label_kata_kunci_identitas').text('Kata Kunci Identitas');
                        }
                    });
                } else {
                    console.log('Nomor identitas tidak ditemukan');
                }
            }

            // Initial check if #id_pemohon is populated
            if ($('#id_pemohon').val()) {
                kataKunciField.show();
                console.log('Form kata kunci tampil');
                checkZkpApproval(); // Check ZKP approval on page load
            } else {
                kataKunciField.hide();
                console.log('Form kata kunci disembunyikan');
            }

            // Handle pemohon change event
            $('#id_pemohon').on('change', function() {
                console.log('Pemohon selection changed!');
                
                if ($(this).val()) {
                    kataKunciField.show();
                    console.log('Form kata kunci ditampilkan');
                    checkZkpApproval(); // Check ZKP approval when pemohon is selected
                } else {
                    kataKunciField.hide();
                    console.log('Form kata kunci disembunyikan');
                }
            });
        });
    </script> -->
@endpush

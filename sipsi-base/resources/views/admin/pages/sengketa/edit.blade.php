@extends('admin.layouts.master')
@section('title', 'Sengketa')
@section('content')
    <!-- Breadcrumb -->
    {{ Breadcrumbs::render('sengketa.edit', $id) }}

    <!-- Content -->

    <div class="container mx-auto pb-4">
        <h1 class="text-2xl font-bold mb-6 text-red-700">Formulir Permohonan Sengketa</h1>

        <form id="sengketaForm" enctype="multipart/form-data" method="POST">
            <div class="mb-6">
                <label for="no_registrasi" class="block text-xl font-medium text-primary">Informasi yang dimohon</label>
                <div id="list-informasi"></div>
            </div>
            <div class="mb-6">
                <label for="no_registrasi" class="block text-xl font-medium text-primary">Checklist yang belum
                    lengkap</label>
                <label class="block text-sm font-medium text-gray-700">
                    <input type="checkbox" name="penolakan_checklist[]"
                        value="Salinan identitas; KTP/SIM/Paspor." class="mr-2" disabled> Salinan
                    identitas; KTP/SIM/Paspor.
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    <input type="checkbox" name="penolakan_checklist[]"
                        value="Salinan formulir permohonan, tanda terima atau tanda pemberian/pengajuan permohonan informasi."
                        class="mr-2" disabled> Salinan formulir permohonan, tanda terima atau tanda pemberian/pengajuan
                    permohonan informasi.
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    <input type="checkbox" name="penolakan_checklist[]"
                        value="Salinan surat tanggapan tertulis atas keberatan Pemohon oleh atasan PPID/surat pengajuan keberatan/tanda pemberian/pengajuan/tanda pengiriman atau tanda terima keberatan."
                        class="mr-2" disabled> Salinan surat tanggapan tertulis atas keberatan Pemohon oleh atasan
                    PPID/surat pengajuan keberatan/tanda pemberian/pengajuan/tanda pengiriman atau tanda terima keberatan.
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    <input type="checkbox" name="penolakan_checklist[]"
                        value="Salinan surat kuasa (jika Pemohon diwakili oleh Kuasa)." class="mr-2" disabled> Salinan
                    surat kuasa (jika Pemohon diwakili oleh Kuasa).
                </label>

            </div>



            <!-- A. Identitas Pemohon -->
            <div class="mb-6">
                <label for="komisi" class="block text-sm font-medium text-gray-700">Komisi Informasi yang Dituju</label>
                <select id="komisi" name="id_ki"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
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
                            Pemohon </label>
                        <input type="text" id="pemohon_nama" name="pemohon_nama"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                    </div>
                    <div>
                        <label for="pemohon_no_hp" class="block text-sm font-medium text-gray-700">No. HP/WA </label>
                        <input type="text" id="pemohon_no_hp" name="pemohon_no_hp"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                    </div>
                    <div>
                        <label for="jenis_pemohon" class="block text-sm font-medium text-gray-700">Jenis Pemohon </label>
                        <select name="jenis_pemohon" id="jenis_pemohon" onchange="onJenisPemohonChange(this);"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled required>
                            <option selected value=""> JENIS PEMOHON *</option>
                            <option value="PERORANGAN">PERORANGAN</option>
                            <option value="LEMBAGA">LEMBAGA</option>
                            <option value="KELOMPOK ORANG">KELOMPOK ORANG</option>
                        </select>
                    </div>
                    <div>
                        <label for="pemohon_email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="pemohon_email" name="pemohon_email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                    </div>
                    <div>
                        <label for="jenis_identitas" class="block text-sm font-medium text-gray-700">Tanda Bukti Identitas
                        </label>
                        <select name="jenis_identitas" id="jenis_identitas"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                            <option value="" selected>JENIS IDENTITAS </option>
                            <option value="KTP">KTP</option>
                            <option value="SIM">SIM</option>
                            <option value="PASPOR">PASPOR</option>
                            <option value="SK Kemenkumham">SK Kemenkumham</option>
                        </select>
                    </div>
                    <div>
                        <label for="nomor_identitas" class="block text-sm font-medium text-gray-700">Nomor Identitas
                        </label>
                        <input type="text" id="nomor_identitas" name="nomor_identitas"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50"
                            disabled>
                    </div>
                    <div>
                        <label for="pemohon_alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
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
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="kuasa_pemohon_jk" class="block text-sm font-medium text-gray-700">Jenis
                            Kelamin</label>
                        <select id="kuasa_pemohon_jk" name="kuasa_pemohon_jk"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
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
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-themecolor-primary focus:ring focus:ring-themecolor-primary focus:ring-opacity-50">
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
                                datepicker-format="yyyy-mm-dd" type="text" name="tanggal_permohonan"
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
                                datepicker-format="yyyy-mm-dd" type="text" name="tanggal_jawaban"
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
                                datepicker-format="yyyy-mm-dd" type="text" name="tanggal_keberatan"
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
                                datepicker-format="yyyy-mm-dd" type="text" name="tanggal_tanggapan"
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
                            class="mr-2"> Alasan PPID menolak permohonan informasi dengan alasan pengecualian
                        berdasarkan Pasal 17 UU KIP
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]"
                            value="Tidak disediakannya informasi berkala sebagaimana diatur di dalam Pasal 9 UU KIP"
                            class="mr-2"> Tidak disediakannya informasi berkala sebagaimana diatur di dalam Pasal 9
                        UU KIP
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]"
                            value="Atasan PPID tidak menanggapi keberatan Pemohon." class="mr-2"> Atasan PPID tidak
                        menanggapi keberatan Pemohon.
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="alasan_permohonan[]"
                            value="Pemohon tidak puas terhadap tanggapan Atasan PPID atas keberatan." class="mr-2">
                        Pemohon tidak puas terhadap tanggapan Atasan PPID atas keberatan.
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
                        <label class="block text-sm font-medium text-gray-700">KTP/SIM/Paspor <span
                                class="text-red-900 text-md">*</span></label>
                        <div class="mt-4 mb-5">
                            <a href="#" id="file_identitas_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
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
                        <label class="block text-sm font-medium text-gray-700">Surat Pengajuan Keberatan/Formulir Pengajuan
                            Keberatan <span class="text-red-900 text-md">*</span></label>
                        <div class="mt-2 mb-5">
                            <a href="#" id="file_formulir_keberatan_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
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
                        <label class="block text-sm font-medium text-gray-700">Surat Kuasa</label>
                        <div class="mt-2 mb-5">
                            <a href="#" id="file_surat_kuasa_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
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
                        <input type="file" id="file_surat_kuasa" name="file_surat_kuasa" class="hidden" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggapan Atasan PPID Atas Keberatan</label>
                        <div class="mt-2 mb-5">
                            <a href="#" id="file_tanggapan_atasan_ppid_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
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
                        <label class="block text-sm font-medium text-gray-700">Surat Permohonan/Formuiir permohonan <span
                                class="text-red-900 text-md">*</span></label>
                        <div class="mt-2 mb-5">
                            <a href="#" id="file_formulir_permohonan_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
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
                        <label class="block text-sm font-medium text-gray-700">Pemberitahuan Tertulis</label>
                        <div class="mt-2 mb-5">
                            <a href="#" id="file_pemberitahuan_tertulis_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
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
                        <label class="block text-sm font-medium text-gray-700">Dokumen Pendukung Lain</label>
                        <div class="mt-2 mb-5">
                            <a href="#" id="file_pendukung_sengketa1_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
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
                        <label class="block text-sm font-medium text-gray-700">Dokumen Pendukung Lain</label>
                        <div class="mt-2 mb-5">
                            <a href="#" id="file_pendukung_sengketa2_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
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
                        <label class="block text-sm font-medium text-gray-700">Jawaban PPID terhadap Pemohon</label>
                        <div class="mt-2 mb-5">
                            <a href="#" id="file_jawaban_ppid_link"
                                class="hidden mt-2 items-center justify-center text-white font-lato font-semibold text-xs  uppercase bg-primary hover:bg-primaryTransparent rounded-xl p-2">Lihat
                                Dokumen</a>
                        </div>
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
                        <input type="file" id="file_jawaban_ppid" name="file_jawaban_ppid" class="hidden" />
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mt-4">
                <h4 class="text-md font-medium text-gray-700">Catatan :</h4>
                <h4 class="text-md font-medium text-gray-700">Kolom bertanda (<span class="text-primary">*</span>) wajib
                    diisi</h4>
                <h4 id="expired" class="text-md font-semibold text-primary">Batas Akhir Pengisian Kelengkapan Data 28
                    Maret 2024 Pukul 23.59</h4>
            </div>
            <div class="flex justify-center md:justify-end mt-4 md:mt-0">
                <div class="relative w-1/2 md:w-1/2 lg:w-1/3">
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
                        Permohonan Sengketa Anda Berhasil Diajukan Ulang
                    </p>
                    <a href="{{ route(Permissions::MENU_SENGKETA) }}" data-modal-hide="success-modal" type="button"
                        class="text-white bg-themecolor-primary hover:bg-red-700 focus:ring-4 focus:outline-none mt-10 focus:ring-red-300 font-medium rounded-lg text-base px-6 py-3">
                        LIHAT DAFTAR SENGKETA SAYA
                    </a>
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

    <script>
        //define modal
        var modalElementSuccess = '';
        var modalSuccess = '';

        document.addEventListener('DOMContentLoaded', function() {
            //initialize modal
            modalElementSuccess = document.getElementById('success-modal');

            modalSuccess = new Modal(modalElementSuccess);

            //initialize close modal
            const closeModalSuccessButtons = modalElementSuccess.querySelectorAll('[data-modal-hide]');


            //Hide each close modal button
            closeModalSuccessButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    modalSuccess.hide();
                });
            });

            // const komisiSelect = document.getElementById('komisi');
            // const komisiNameSpans = document.querySelectorAll('#sengketa-statements span[id^="komisi-name"]');

            // komisiSelect.addEventListener('change', function () {
            //     const selectedKomisi = komisiSelect.options[komisiSelect.selectedIndex].text;

            //     komisiNameSpans.forEach(span => {
            //         span.textContent = selectedKomisi;
            //     });
            // });

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
    {{-- show --}}
    <script>
        $(document).ready(function() {
            const komisiSelect = document.getElementById('komisi');
            const komisiNameSpans = document.querySelectorAll('#sengketa-statements span[id^="komisi-name"]');
            const id = "{{ $id }}";
            const url = "{{ route('sengketa.show', '') }}/" + id;

            function updateSpans(selectedKomisi) {
                komisiNameSpans.forEach(span => {
                    span.textContent = selectedKomisi;
                });
            }
            showLoading();

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;

                        $('#komisi').val(data.id_ki);
                        const selectedKomisi = $('#komisi option:selected').text();
                        updateSpans(selectedKomisi);

                        komisiSelect.disabled = true;
                        $('#pemohon_nama').val(data.pemohon.nama);
                        $('#pemohon_no_hp').val(data.pemohon.no_hp);
                        $('#jenis_pemohon').val(data.pemohon.jenis_pemohon);
                        $('#pemohon_email').val(data.pemohon.email);
                        $('#jenis_identitas').val(data.pemohon.jenis_identitas);
                        $('#nomor_identitas').val(data.pemohon.nomor_identitas);
                        $('#pemohon_alamat').val(data.pemohon.alamat);
                        if (data.pemohon.jenis_pemohon == 'PERORANGAN') {
                            showJenisKelamin();
                            $('#jenis_kelamin').val(data.pemohon.jenis_kelamin);
                        }

                        $('#kuasa_pemohon_nama').val(data.kuasa_pemohon_nama);
                        $('#kuasa_pemohon_jk').val(data.kuasa_pemohon_jk);

                        $('#termohon_nama').val(data.termohon.nama);
                        $('#termohon_alamat').val(data.termohon.alamat);

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

                        var listInformasi = $('#list-informasi');
                        listInformasi.empty();

                        if (data.history && data.history.length > 0) {
                            data.history.forEach(function(item) {
                                if (item.penolakan_info) {
                                    var infoItems = item.penolakan_info.split('\n');
                                    infoItems.forEach(function(info) {
                                        listInformasi.append('<p>' + info + '</p>');
                                    });
                                }

                                if (item.penolakan_checklist && item.penolakan_checklist
                                    .length > 0) {
                                    item.penolakan_checklist.forEach(function(checklistItem) {
                                        $('input[name="penolakan_checklist[]"][value="' +
                                            checklistItem + '"]').prop('checked',
                                            true);
                                    });
                                }
                            });
                        }
                        var expired = new Date(data.updated_at);
                        expired.setDate(expired.getDate() + 7);
                        expired = expired.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });

                        var updatedTime = new Date(data.updated_at).toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        });

                        $('#expired').text('Batas Akhir Pengisian Kelengkapan Data ' + expired +
                            ' Pukul ' + updatedTime);


                        // data.history.forEach(function (item) {
                        //     if(item.penolakan_checklist && item.penolakan_checklist.length > 0) {
                        //         item.penolakan_checklist.forEach(function(checklistItem) {
                        //             $('input[name="penolakan_checklist[]"][value="' + checklistItem + '"]').prop('checked', true);
                        //         });
                        //     }
                        //     $('#list-informasi').html(item.penolakan_info);
                        // });

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

                        $('#file_identitas').data('previous', data.file_identitas);
                        $('#file_formulir_keberatan').data('previous', data.file_formulir_keberatan);
                        $('#file_formulir_permohonan').data('previous', data.file_formulir_permohonan);

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

            komisiSelect.addEventListener('change', function() {
                const selectedKomisi = komisiSelect.options[komisiSelect.selectedIndex].textContent;
                updateSpans(selectedKomisi);
            });

            // function setFileLink(inputId, linkId, fileUrl, id) {
            //     if (fileUrl) {
            //         var path = fileUrl.split('/');
            //         const url = '{{ route('admin.lacak.dokumen', ['id' => ':id', 'path' => ':path']) }}';
            //         const fullUrl = url.replace(':id', id).replace(':path', encodeURIComponent(path[path.length - 1]));
            //         $(linkId).attr('href', fullUrl).removeClass('hidden');
            //     }
            // }

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

        function showButtonProgress() {
            $('#btn_loading').removeAttr('hidden');
            $('#submitBtn').attr('hidden', true);
        }

        function hideButtonProgress() {
            $('#submitBtn').removeAttr('hidden');
            $('#btn_loading').attr('hidden', true);
        }
    </script>

    {{-- update --}}
    <script>
        $(document).ready(function() {
            $('#submitBtn').on('click', function(e) {
                e.preventDefault();

                var id = "{{ $id }}";
                var url = "{{ route('sengketa.update', '') }}/" + id;

                var formData = new FormData($('#sengketaForm')[0]);
                var validateCreate = validateFormCreate();
                var agreeCheckbox = document.getElementById('red-checkbox');

                showButtonProgress();

                if (validateCreate.length == 0) {
                    $.ajax({
                        url: url,
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
                            modalSuccess.show();
                            setTimeout(() => {
                                window.location.href =
                                    "{{ route(Permissions::MENU_SENGKETA) }}";
                            }, 3000);
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

            var pemohon_nama = $('#pemohon_nama');
            var pemohon_no_hp = $('#pemohon_no_hp');
            var jenis_pemohon = $('#jenis_pemohon');
            var pemohon_email = $('#pemohon_email');
            var jenis_identitas = $('#jenis_identitas');
            var nomor_identitas = $('#nomor_identitas');
            var pemohon_alamat = $('#pemohon_alamat');
            var jenis_kelamin = $('#jenis_kelamin');


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

            var arrayBool = [];

            $('.error-message').remove();

            if (pemohon_nama.val() == "") {
                pemohon_nama.after('<span class="error-message text-red-600">Nama Pemohon tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            if (pemohon_no_hp.val() == "") {
                pemohon_no_hp.after('<span class="error-message text-red-600">Nomor HP Pemohon tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            if (jenis_pemohon.val() == "") {
                jenis_pemohon.after('<span class="error-message text-red-600">Jenis Pemohon tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            if (pemohon_email.val() == "") {
                pemohon_email.after('<span class="error-message text-red-600">Email Pemohon tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            if (jenis_identitas.val() == "") {
                jenis_identitas.after('<span class="error-message text-red-600">Jenis Identitas tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            if (nomor_identitas.val() == "") {
                nomor_identitas.after('<span class="error-message text-red-600">Nomor Identitas tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            if (pemohon_alamat.val() == "") {
                pemohon_alamat.after('<span class="error-message text-red-600">Alamat Pemohon tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            if (jenis_kelamin.val() == "" && jenis_pemohon.val() == "PERORANGAN") {
                jenis_kelamin.after('<span class="error-message text-red-600">Jenis Kelamin tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            if (termohon_nama.val() == "") {
                termohon_nama.after('<span class="error-message text-red-600">Nama Badan Publik tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            if (tanggal_permohonan.val() == "") {
                div_tanggal_permohonan.after(
                    '<span class="error-message text-red-600">Tanggal Permohonan tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            if (tanggal_keberatan.val() == "") {
                div_tanggal_keberatan.after(
                    '<span class="error-message text-red-600">Tanggal Keberatan tidak boleh kosong</span>');
                arrayBool.push(true);
            }

            if (!checkbox.is(':checked')) {
                labelCheckbox.after(
                    '<span class="error-message text-red-600">Anda harus menyetujui pernyataan permohonan</span>');
                arrayBool.push(true);
            }

            if (alasan_permohonan.length == 0) {
                legendAlasan.after(
                    '<span class="error-message text-red-600">Setidaknya satu alasan permohonan harus dipilih</span>');
                arrayBool.push(true);
            }

            // if (file_identitas.val() == "") {
            //     file_identitas.after('<span class="error-message text-red-600">KTP/SIM/Paspor tidak boleh kosong</span>');
            //     arrayBool.push(true);
            // }

            // if (file_formulir_keberatan.val() == "") {
            //     file_formulir_keberatan.after('<span class="error-message text-red-600">Surat Pengajuan Keberatan/Formulir Pengajuan Keberatan tidak boleh kosong</span>');
            //     arrayBool.push(true);
            // }

            // if (file_formulir_permohonan.val() == "") {
            //     file_formulir_permohonan.after('<span class="error-message text-red-600">Surat Permohonan/Formulir Permohonan tidak boleh kosong</span>');
            //     arrayBool.push(true);
            // }

            if (file_identitas.val() == "" && !file_identitas.data('previous')) {
                file_identitas.after(
                    '<span class="block error-message text-red-600">KTP/SIM/Paspor tidak boleh kosong</span>'
                    );
                arrayBool.push(true);
            }

            if (file_formulir_keberatan.val() == "" && !file_formulir_keberatan.data('previous')) {
                file_formulir_keberatan.after(
                    '<span class="block error-message text-red-600">Surat Pengajuan Keberatan/Formulir Pengajuan Keberatan tidak boleh kosong</span>'
                    );
                arrayBool.push(true);
            }

            if (file_formulir_permohonan.val() == "" && !file_formulir_permohonan.data('previous')) {
                file_formulir_permohonan.after(
                    '<span class="block error-message text-red-600">Surat Permohonan/Formulir Permohonan tidak boleh kosong</span>'
                    );
                arrayBool.push(true);
            }



            return arrayBool;
        }
    </script>
@endpush

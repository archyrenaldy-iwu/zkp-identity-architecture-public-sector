@extends('admin.layouts.master')
@section('title', 'Sengketa')
@section('content')
<!-- Breadcrumb -->
{{ Breadcrumbs::render('sengketa.lacak', $id) }}

{{-- content --}}
<div class="flex justify-start md:ml-0 mt-2">
    <a href="{{ route(Permissions::MENU_SENGKETA) }}" class="bg-themecolor-primary text-white rounded-lg p-2.5 mt-4">Kembali</a>
</div>
<div class="bg-gray-50 h-full mt-8">
    <div class="w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12">
            <div class="lg:col-span-6 w-full lg:w-11/12">
                <!-- Detail Pengajuan Sengketa -->
                <div class="text-center md:text-left">
                    <div class="text-white p-2 rounded-lg bg-themecolor-primary">
                        <h2 class="text-2xl lg:text-3xl p-3 text-center font-bold">Detail Pengajuan Sengketa</h2>
                    </div>
                    <div class="bg-white rounded lg:p-8 md:p-6 p-4">
                        <div class="grid-detail-sengketa grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                    </div>
                </div>
                <!-- Perangkat Persidangan -->
                <div class="text-center md:text-left">
                    <div class="text-white p-2 rounded-lg bg-themecolor-primary">
                        <h2 class="text-2xl lg:text-3xl p-3 text-center font-bold">Perangkat Persidangan</h2>
                    </div>
                    <div class="bg-white rounded lg:p-8 md:p-6 p-4">
                        <div class="grid-perangkat-sidang grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                    </div>
                </div>
            </div>

            {{-- LINIMASA --}}
            <div class="lg:col-span-6 max-w-full font-bold mt-4 lg:mt-0">
                <div class="text-white p-2 rounded-lg bg-themecolor-primary">
                    <h2 class="text-2xl lg:text-3xl p-3 text-center">Linimasa</h2>
                </div>
                <div class="bg-white rounded">
                    <div class="grid grid-cols-4 gap-2">
                        <div class="flex flex-col col-span-4 text-2xl p-4">
                            <div class="w-full p-6 mt-2 mx-auto">
                                <ol class="relative timeline-list">
                                    <li class="ms-12 first-timeline-item">


                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 gap-2">
                        <div class="flex flex-col col-span-4 text-2xl p-4 px-">
                            <div class="w-full p-6 mx-auto">
                                <ol class="relative remaining-timeline">
                                    <!-- Remaining timeline items will be injected here -->
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('prepend-script')

<script>
    $(document).ready(function() {
        var id = "{{ $id }}";
        var urlLacak = "{{ route('sengketa.lacak', '') }}/" + id;
        showLoading();

        $.ajax({
            url: urlLacak,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    var data = response.data;

                    // Assuming you have a 'data' object with the necessary data

                $('.grid-detail-sengketa').html(`
                    <div class="font-bold py-2">No Registrasi</div>
                    <div class="py-2 px-4">${data.no_registrasi}</div>
                    <div class="font-bold py-2">Tanggal Register</div>
                    <div class="py-2 px-4">${data.tanggal_permohonan}</div>
                    <div class="font-bold py-2">No Sengketa</div>
                    <div class="py-2 px-4">${data.no_sengketa || 'Belum ada'}</div>
                    <div class="font-bold py-2">Nama Pemohon</div>
                    <div class="py-2 px-4">${data.nama_pemohon || 'Belum ada'}</div>
                    <div class="font-bold py-2">Nama Termohon</div>
                    <div class="py-2 px-4">${data.nama_termohon || 'Belum ada'}</div>
                `);

                $('.grid-perangkat-sidang').html(`
                    <div class="font-bold py-2">Ketua</div>
                    <div class="py-2 px-4">${data.nama_ketua || 'Belum ada'}</div>
                    <div class="font-bold py-2">Anggota 1</div>
                    <div class="py-2 px-4">${data.nama_anggota1 || 'Belum ada'}</div>
                    <div class="font-bold py-2">Anggota 2</div>
                    <div class="py-2 px-4">${data.nama_anggota2 || 'Belum ada'}</div>
                    <div class="font-bold py-2">Mediator</div>
                    <div class="py-2 px-4">${data.nama_mediator || 'Belum ada'}</div>
                    <div class="font-bold py-2">Panitera Pengganti</div>
                    <div class="py-2 px-4">${data.nama_panitera_pengganti || 'Belum ada'}</div>
                    <div class="font-bold py-2">Panitera Utama</div>
                    <div class="py-2 px-4">${data.nama_panitera_utama || 'Belum ada'}</div>
                `);


                    if (data.history && data.history.length > 0) {
                        var countPengajuan = 0;
                        var firstItem = data.history.find(item => item.nama === "Pengajuan Sengketa");
                        var pathPermohonan = firstItem.file ? firstItem.file.split('/').slice(-1).join() : '';
                        // var pathPermohonan = firstItem.file ? encodeURIComponent(firstItem.file) : '';
                        var urlPermohonan = '{{ route("admin.lacak.dokumen",[":id",":path"]) }}';
                        urlPermohonan = urlPermohonan.replace(':id', id);
                        urlPermohonan = urlPermohonan.replace(':path', pathPermohonan);
                        if (firstItem) {
                            $('.first-timeline-item').html(`
                                <li class="">
                                    <img src="{{ asset('img/icons/clock.png') }}" alt="icon"
                                        class="w-10 h-10 absolute flex items-center justify-center rounded-full -start-4">
                                    <div class="lg:flex lg:items-center lg:justify-between">
                                        <div class="mb-4 lg:mb-0">
                                            <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">${firstItem.waktu}</h3>
                                        </div>
                                        <div class="lg:pl-20 lg:w-5/6">
                                            <h4 class="mb-1 text-2xl text-red-800 dark:text-white">${firstItem.nama}</h4>
                                            ${firstItem.file ? '<a href="'+urlPermohonan+'" class="text-blue-500 text-lg">Formulir Permohonan Sengketa</a>' : ''}
                                        </div>
                                    </div>
                                </li>
                            `);
                            countPengajuan++;
                        }

                        var timelineHtmlRemaining = data.history
                            .filter(item => item !== firstItem)
                            .map(item => {
                                var formulirName = '';
                                if (item.nama === "Pengajuan Sengketa Ulang") {
                                    formulirName = 'Formulir Permohonan Sengketa';
                                } else if (item.nama === "Sengketa Ditolak") {
                                    formulirName = 'Dokumen SPKD';
                                } else if (item.nama === "Sengketa Diterima") {
                                    formulirName = 'Surat Akta Registrasi';
                                }
                                // path file
                                var path = item.file ? item.file.split('/').slice(-1).join() : '';
                                var pathRellasPemohon = item.file_reelas_pemohon ? item.file_reelas_pemohon.split('/').slice(-1).join() : '';
                                var pathRellasTermohon = item.file_reelas_termohon ? item.file_reelas_termohon.split('/').slice(-1).join() : '';
                                var pathPutusan = item.file_putusan ? item.file_putusan.split('/').slice(-1).join() : '';
                                // template url
                                var urlTemplate = '{{ route("admin.lacak.dokumen",[":id",":path"]) }}';
                                // link url file
                                var url = urlTemplate.replace(':id', id).replace(':path', path);
                                var urlRellasPemohon = urlTemplate.replace(':id', id).replace(':path', pathRellasPemohon);
                                var urlRellasTermohon = urlTemplate.replace(':id', id).replace(':path', pathRellasTermohon);
                                var urlPutusan = urlTemplate.replace(':id', id).replace(':path', pathPutusan);

                                return `
                                    ${item.is_selesai ?`
                                    <li class="pb-10 ps-12 border-s border-red-200 dark:border-red-700 last:border-s-0">
                                        <img src="{{ asset('img/icons/circle.png') }}" alt="icon"
                                            class="w-6 h-6 absolute flex items-center justify-center rounded-full -start-3">
                                        <div class="lg:flex lg:items-center lg:justify-between">
                                            <div class="mb-4 lg:mb-0">
                                                <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">${item.is_sidang ? item.sidang_waktu : item.waktu}</h3>
                                            </div>
                                            <div class="lg:pl-20 lg:w-5/6">
                                                <h4 class="mb-1 text-2xl text-red-800 dark:text-white">${item.is_sidang ? item.sidang_nama : item.nama}</h4>
                                                <h4 class="mb-1 text-lg text-gray-800 dark:text-white">${item.is_sidang ? "Agenda : "+ item.sidang_agenda : ''}</h4>
                                                ${item.file ? '<a href="{{ route("get_pdf_view") }}?path='+item.file+'" class="text-blue-500 text-lg">Formulir</a>' : ''}
                                                 ${item.is_sidang ? `
                                                    ${item.file_reelas_pemohon ? '<a class="text-blue-500 text-lg" href="' + urlRellasPemohon + '">Dokumen Relaas Pemohon</a>' : ''}
                                                    ${item.file_reelas_termohon ? '<br><a class="text-blue-500 text-lg" href="' + urlRellasTermohon + '">Dokumen Relaas Termohon</a><br>' : ''}
                                                    ${item.file_putusan ? '<a class="text-blue-500 text-lg" href="' + urlPutusan + '">Dokumen Putusan</a>' : ''}
                                                    ${item.putusan_link_jdih != null ? '<br><a class="text-blue-500 text-lg" href="' + item.putusan_link_jdih + '" target="_blank">Link JDIH</a>' : ''}
                                                ` : ''}
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pb-10 ps-12 border-s border-red-200 dark:border-red-700 last:border-s-0">
                                        <img src="{{ asset('img/icons/circle.png') }}" alt="icon"
                                            class="w-6 h-6 absolute flex items-center justify-center rounded-full -start-3">
                                        <div class="lg:flex lg:items-center lg:justify-between">
                                            <div class="mb-4 lg:mb-0">
                                                <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">${item.is_sidang ? item.sidang_waktu : item.waktu}</h3>
                                            </div>
                                            <div class="lg:pl-20 lg:w-5/6">
                                                <h4 class="mb-1 text-2xl text-red-800 dark:text-white">Selesai</h4>
                                                <h4 class="mb-1 text-lg text-gray-800 dark:text-white">${item.keterangan ? "Keterangan : "+ item.keterangan : ''}</h4>
                                            </div>
                                        </div>
                                    </li>
                                    ` : `
                                    <li class="pb-10 ps-12 border-s border-red-200 dark:border-red-700 last:border-s-0">
                                        <img src="{{ asset('img/icons/circle.png') }}" alt="icon"
                                            class="w-6 h-6 absolute flex items-center justify-center rounded-full -start-3">
                                        <div class="lg:flex lg:items-center lg:justify-between">
                                            <div class="mb-4 lg:mb-0">
                                                <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">${item.is_sidang ? item.sidang_waktu : item.waktu}</h3>
                                            </div>
                                            <div class="lg:pl-20 lg:w-5/6">
                                                <h4 class="mb-1 text-2xl text-red-800 dark:text-white">${item.is_sidang ? item.sidang_nama : item.nama}</h4>
                                                <h4 class="mb-1 text-lg text-gray-800 dark:text-white">${item.is_sidang ? "Agenda : "+ item.sidang_agenda : ''}</h4>
                                                ${item.file ? '<a href="'+url+'" class="text-blue-500 text-lg">'+formulirName+'</a>' : ''}
                                                ${item.is_sidang ? `
                                                    ${item.file_reelas_pemohon ? '<a class="text-blue-500 text-lg" href="' + urlRellasPemohon + '">Dokumen Relaas Pemohon</a>' : ''}
                                                    ${item.file_reelas_termohon ? '<br><a class="text-blue-500 text-lg" href="' + urlRellasTermohon + '">Dokumen Relaas Termohon</a><br>' : ''}
                                                    ${item.file_putusan ? '<a class="text-blue-500 text-lg" href="' + urlPutusan + '">Dokumen Putusan</a>' : ''}
                                                    ${item.putusan_link_jdih != null ? '<br><a class="text-blue-500 text-lg" href="' + item.putusan_link_jdih + '" target="_blank">Link JDIH</a>' : ''}
                                                ` : ''}

                                            </div>
                                        </div>
                                    </li>
                                    `}
                                `;
                            }).join('');

                        $('.remaining-timeline').html(timelineHtmlRemaining);
                    } else {
                        $('.remaining-timeline').html('<li class="ms-12"><p class="text-gray-500">Tidak ada data linimasa tersedia</p></li>');
                    }
                    hideLoading();
                } else {
                    console.error("Gagal mendapatkan data: ", response.errors);
                    hideLoading();
                }
            },
            error: function(error) {
                console.error("Terjadi kesalahan: ", error);
                hideLoading();
            }
        });
    });
</script>
@endpush

@extends('layouts.front.app')
@section('title')
    Detail Jadwal Sidang
@endsection
@section('content')
    <div class="bg-gray-50 h-full p-10">
        <div class="mx-auto w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12">
                {{-- <div class="lg:col-span-6 max-w-full mx-auto w-full lg:w-3/4">
                    <div class="text-white p-2 rounded-lg bg-themecolor-primary">
                        <h2 class="text-2xl lg:text-3xl p-3 text-center font-bold">Detail Pengajuan Sengketa</h2>
                    </div>
                    <div class="bg-white rounded lg:p-8 md:p-6 p-4">
                        <table class="mx-auto table-detail-sengketa">
                            <tr>
                                <td class="td-detail-jadwal font-bold py-2">No Registrasi</td>
                                <td class="py-2">050/REG-PSI/X/2023</td>
                            </tr>
                            <tr>
                                <td class="td-detail-jadwal font-bold py-2">Tanggal Register</td>
                                <td class="py-2">12 february 2023</td>
                            </tr>
                            <tr>
                                <td class="td-detail-jadwal font-bold py-2">No Sengketa</td>
                                <td class="py-2">050/x/kIP-PS/2023</td>
                            </tr>
                            <tr>
                                <td class="td-detail-jadwal font-bold py-2">Nama Pemohon</td>
                                <td class="py-2">Ucok</td>
                            </tr>
                            <tr>
                                <td class="td-detail-jadwal font-bold">Nama Termohon</td>
                                <td class="py-2">Universitas Negri</td>
                            </tr>
                        </table>
                    </div>
                </div> --}}
                <div class="lg:col-span-6 w-full sm:w-11/12 lg:w-11/12 lg:max-w-3xl mx-auto">
                    <!-- Detail Pengajuan Sengketa -->
                    <div class="text-center md:text-left shadow-lg shadow-gray-300">
                        <div class="text-white p-2 rounded-lg bg-themecolor-primary">
                            <h2 class="text-2xl lg:text-3xl p-3 text-center font-bold">Detail Pengajuan Sengketa</h2>
                        </div>
                        <div class="bg-white rounded lg:p-8 md:p-6 p-4">
                            <div class="grid-detail-sengketa grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                        </div>
                    </div>
                    <!-- Perangkat Persidangan -->
                    <div class="text-center md:text-left mt-8 shadow-lg shadow-gray-300">
                        <div class="text-white p-2 rounded-lg bg-themecolor-primary">
                            <h2 class="text-2xl lg:text-3xl p-3 text-center font-bold">Perangkat Persidangan</h2>
                        </div>
                        <div class="bg-white rounded lg:p-8 md:p-6 p-4">
                            <div class="grid-perangkat-sidang grid grid-cols-1 md:grid-cols-2 gap-4 mx-auto"></div>
                        </div>
                    </div>
                </div>


                {{-- kanan --}}
                {{-- <div class="lg:col-span-6 max-w-full font-bold mt-4 lg:mt-0">
                    <div class="text-white p-2 rounded-lg bg-themecolor-primary">
                        <h2 class="text-2xl lg:text-3xl p-3 text-center">Linimasa</h2>
                    </div>
                    <div class="bg-white rounded">
                        <div class="grid grid-cols-4 gap-2">
                            <div class="flex flex-col col-span-4 text-2xl p-4">
                                <div class="w-full p-6 mt-2 mx-auto">
                                    <ol class="relative">
                                        <li class="ms-12">
                                            <img src="{{ asset('img/icons/clock.png') }}" alt="icon"
                                                class="w-10 h-10 absolute flex items-center justify-center rounded-full -start-4">
                                            <div class="lg:flex lg:items-center lg:justify-between">
                                                <div class="mb-4 lg:mb-0">
                                                    <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">Senin, 12
                                                        Februari 2023</h3>
                                                    <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">Pukul 13.00</h3>
                                                </div>
                                                <div class="lg:ml-10 lg:w-80">
                                                    <h4 class="mb-1 text-2xl text-red-800 dark:text-white">Pengajuan
                                                        Sengketa</h4>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-2">
                            <div class="flex flex-col col-span-4 text-2xl p-4">
                                <div class="w-full p-6 mx-auto">
                                    <ol class="relative border-s border-red-200 dark:border-red-700">
                                        <li class="mb-10 ms-12 timeline-item">
                                            <img src="{{ asset('img/icons/circle.png') }}" alt="icon"
                                                class="w-6 h-6 absolute flex items-center justify-center rounded-full -start-3">
                                            <div class="lg:flex lg:items-center lg:justify-between">
                                                <div class="mb-4 lg:mb-0">
                                                    <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">Senin, 12
                                                        Februari 2023</h3>
                                                    <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">Pukul 13.00</h3>
                                                </div>
                                                <div class="lg:ml-10 lg:w-80">
                                                    <h4 class="mb-1 text-2xl text-red-800 dark:text-white">Pengajuan
                                                        Sengketa</h4>
                                                    <h4 class="mb-1 text-lg text-gray-800 dark:text-white">Pembacaan</h4>
                                                    <h4 class="mb-1 text-lg text-blue-800 dark:text-white">Pengajuan
                                                        Sengketa</h4>
                                                </div>
                                            </div>

                                        </li>
                                        <li class="mb-10 ms-12">
                                            <img src="{{ asset('img/icons/circle.png') }}" alt="icon"
                                                class="w-6 h-6 absolute flex items-center justify-center rounded-full -start-3">
                                            <div class="lg:flex lg:items-center lg:justify-between">
                                                <div class="mb-4 lg:mb-0">
                                                    <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">Senin, 12
                                                        Februari 2023</h3>
                                                    <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">Pukul 13.00</h3>
                                                </div>
                                                <div class="lg:ml-10 lg:w-80">
                                                    <h4 class="mb-1 text-2xl text-red-800 dark:text-white">Pengajuan
                                                        Sengketa</h4>
                                                    <h4 class="mb-1 text-lg text-gray-800 dark:text-white">Pembacaan Putusan
                                                        Mediasi Berhasil</h4>
                                                    <h4 class="mb-1 text-lg text-blue-800 dark:text-white">Pengajuan
                                                        Sengketa</h4>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-10 ms-12">
                                            <img src="{{ asset('img/icons/circle.png') }}" alt="icon"
                                                class="w-6 h-6 absolute flex items-center justify-center rounded-full -start-3">
                                            <div class="lg:flex lg:items-center lg:justify-between">
                                                <div class="mb-4 lg:mb-0">
                                                    <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">Senin, 12
                                                        Februari 2023</h3>
                                                    <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">Pukul 13.00</h3>
                                                </div>
                                                <div class="lg:ml-10 lg:w-80">
                                                    <h4 class="mb-1 text-2xl text-red-800 dark:text-white">Sidang
                                                        Pemerikasaan Awal</h4>
                                                    <h4 class="mb-1 text-lg text-gray-800 dark:text-white">Pembacaan Putusan
                                                        Mediasi Berhasil Berhasil</h4>
                                                    <h4 class="mb-1 text-lg text-blue-800 dark:text-white">Pengajuan
                                                        Sengketa</h4>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                {{-- LINIMASA --}}
                <div class="lg:col-span-6 lg:max-w-3xl mx-auto font-bold mt-4 lg:mt-0">
                    <div class="text-white p-2 rounded-lg bg-themecolor-primary">
                        <h2 class="text-2xl lg:text-3xl p-3 text-center">Linimasa</h2>
                    </div>
                    <div class="bg-white rounded shadow-lg shadow-gray-300">
                        <div class="grid grid-cols-4 gap-2">
                            <div class="flex flex-col col-span-4 text-2xl p-4 px-10">
                                <div class="w-full p-6 mt-2 mx-auto">
                                    <ol class="relative timeline-list">
                                        <li class="ms-12 first-timeline-item">

                                            
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-2">
                            <div class="flex flex-col col-span-4 text-2xl p-4 px-10">
                                <div class="w-full p-6 mx-auto">
                                    <ol class="relative border-s border-red-200 dark:border-red-700 remaining-timeline">
                                        <!-- Remaining timeline items will be injected here -->
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="mx-auto w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12">
                <div class="lg:col-span-6 lg:w-11/12 max-w-3xl mx-auto mt-10">
                    <a href="{{ route('landing.jadwal_sidang') }}"
                        class="bg-themecolor-primary text-white rounded-lg p-2.5 mt-4">Kembali</a>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('js')
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
                    <div class="font-bold py-2 px-4">No Registrasi</div>
                    <div class="py-2 px-4">${data.no_registrasi}</div>
                    <div class="font-bold py-2 px-4">Tanggal Register</div>
                    <div class="py-2 px-4">${data.tanggal_permohonan}</div>
                    <div class="font-bold py-2 px-4">No Sengketa</div>
                    <div class="py-2 px-4">${data.no_sengketa || 'Belum ada'}</div>
                    <div class="font-bold py-2 px-4">Nama Pemohon</div>
                    <div class="py-2 px-4">${data.nama_pemohon || 'Belum ada'}</div>
                    <div class="font-bold py-2 px-4">Nama Termohon</div>
                    <div class="py-2 px-4">${data.nama_termohon || 'Belum ada'}</div>
                `);

                $('.grid-perangkat-sidang').html(`
                    <div class="font-bold py-2 px-4">Ketua</div>
                    <div class="py-2 px-4">${data.nama_ketua || 'Belum ada'}</div>
                    <div class="font-bold py-2 px-4">Anggota 1</div>
                    <div class="py-2 px-4">${data.nama_anggota1 || 'Belum ada'}</div>
                    <div class="font-bold py-2 px-4">Anggota 2</div>
                    <div class="py-2 px-4">${data.nama_anggota2 || 'Belum ada'}</div>
                    <div class="font-bold py-2 px-4">Mediator</div>
                    <div class="py-2 px-4">${data.nama_mediator || 'Belum ada'}</div>
                    <div class="font-bold py-2 px-4">Panitera Pengganti</div>
                    <div class="py-2 px-4">${data.nama_panitera_pengganti || 'Belum ada'}</div>
                    <div class="font-bold py-2 px-4">Panitera Utama</div>
                    <div class="py-2 px-4">${data.nama_panitera_utama || 'Belum ada'}</div>
                `);


                    if (data.history && data.history.length > 0) {
                        var countPengajuan = 0;
                        var firstItem = data.history.find(item => item.nama === "Pengajuan Sengketa");
                        var pathPermohonan = firstItem.file ? firstItem.file.split('/').slice(-1).join() : '';
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
                                if (item.nama === "Pengajuan Sengketa") {
                                    countPengajuan++;
                                    item.nama = "Pengajuan Sengketa Ulang";
                                    formulirName = 'Formulir Permohonan Sengketa';
                                } else if (item.nama === "Sengketa Ditolak") {
                                    formulirName = 'Dokumen SKPD';
                                } else if (item.nama === "Sengketa Diterima") {
                                    formulirName = 'Surat Akta Registrasi';
                                }

                                return `
                                    ${item.is_selesai ?`
                                    <li class="mb-10 ms-12">
                                        <img src="{{ asset('img/icons/circle.png') }}" alt="icon"
                                            class="w-6 h-6 absolute flex items-center justify-center rounded-full -start-3">
                                        <div class="lg:flex lg:items-center lg:justify-between">
                                            <div class="mb-4 lg:mb-0">
                                                <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">${item.is_sidang ? item.sidang_waktu : item.waktu}</h3>
                                            </div>
                                            <div class="lg:pl-20 lg:w-5/6">
                                                <h4 class="mb-1 text-2xl text-red-800 dark:text-white">${item.is_sidang ? item.sidang_nama : item.nama}</h4>
                                                <h4 class="mb-1 text-lg text-gray-800 dark:text-white">${item.is_sidang ? "Agenda : "+ item.sidang_agenda : ''}</h4>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-10 ms-12">
                                        <img src="{{ asset('img/icons/circle.png') }}" alt="icon"
                                            class="w-6 h-6 absolute flex items-center justify-center rounded-full -start-3">
                                        <div class="lg:flex lg:items-center lg:justify-between">
                                            <div class="mb-4 lg:mb-0">
                                                <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">${item.is_sidang ? item.sidang_waktu : item.waktu}</h3>
                                            </div>
                                            <div class="lg:pl-20 lg:w-5/6">
                                                <h4 class="mb-1 text-2xl text-red-800 dark:text-white">Selesai</h4>
                                            </div>
                                        </div>
                                    </li>
                                    ` : `
                                    <li class="mb-10 ms-12">
                                        <img src="{{ asset('img/icons/circle.png') }}" alt="icon"
                                            class="w-6 h-6 absolute flex items-center justify-center rounded-full -start-3">
                                        <div class="lg:flex lg:items-center lg:justify-between">
                                            <div class="mb-4 lg:mb-0">
                                                <h3 class="mb-1 text-2xl text-gray-900 dark:text-white">${item.is_sidang ? item.sidang_waktu : item.waktu}</h3>
                                            </div>
                                            <div class="lg:pl-20 lg:w-5/6">
                                                <h4 class="mb-1 text-2xl text-red-800 dark:text-white">${item.is_sidang ? item.sidang_nama : item.nama}</h4>
                                                <h4 class="mb-1 text-lg text-gray-800 dark:text-white">${item.is_sidang ? "Agenda : "+ item.sidang_agenda : ''}</h4>
                                                
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

        function showLoading() {
            var loadingProgress = $('#loading-progress');

            loadingProgress.addClass('flex');
            loadingProgress.removeClass('hidden');
        }

        function hideLoading() {
            var loadingProgress = $('#loading-progress');

            loadingProgress.addClass('hidden');
            loadingProgress.removeClass('flex');
        }
    });
</script>

@endpush
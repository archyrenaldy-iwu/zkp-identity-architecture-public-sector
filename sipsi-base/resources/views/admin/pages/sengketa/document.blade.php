@extends('admin.layouts.master')
@section('title', 'Sengketa')
@section('content')
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
                Sengketa
            </p>
        </li>
        <li class="inline-flex items-center">
            /
        </li>
        <li class="inline-flex items-center">
            <p class="inline-flex items-center text-sm font-medium text-primary" id="status">
            </p>
        </li>
        <li class="inline-flex items-center">
            /
        </li>
        <li class="inline-flex items-center">
            <p class="inline-flex items-center text-sm font-medium text-primary" id="no_registrasi">
            </p>
        </li>
    </ol>
</nav>

<!-- Content -->
<div class="flex justify-start md:ml-0 mt-2">
    <a href="{{ route("admin.sengketa.lacak", $id) }}" class="bg-primary hover:bg-primaryTransparent  text-white rounded-lg p-2.5 mt-4">Kembali</a>
</div>
<iframe id="dokumen_iframe" class="hidden w-full h-screen mt-2"></iframe>
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
        $(document).ready(function () {
            var id = "{{ $id }}";
            var url = "{{ route('sengketa.lacak', '') }}/" + id;
            var path = "{{ $path }}";
            var customPath = "sengketa/file_document_pdf/" + path;
            var customPathPutusan = "sengketa/file_putusan/" + path;
            var putusan = false;
            showLoading();

            $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {
                    if (response.success) {
                        var data = response.data;
                        $('#no_registrasi').text(data.no_sengketa ? data.no_sengketa : data.no_registrasi);

                        data.history.forEach(function (item) {
                            if (item.file_putusan === customPathPutusan) {
                                $('#status').text(item.sidang_nama);
                                putusan = true;
                            } else if (item.file_reelas_pemohon === customPath || item.file_reelas_termohon === customPath || item.file === customPath) {
                                $('#status').text(item.sidang_nama || item.nama);
                            }
                        });

                        if (data.history && data.history.length > 0) {
                            setFileLink('#dokumen_iframe', putusan);
                        }
                        hideLoading();

                    } else {
                        showNotificationError('Gagal mendapatkan data sengketa.');
                    }
                },
                error: function (xhr, status, error) {
                    $('#sengketa-data').html('<p>Terjadi kesalahan saat mengambil data.</p>');
                    console.error(error);
                }
            });

            function setFileLink(iframeId, putusan) {
                var src = '{{ route('get_pdf_view') }}?path=' + (putusan ? customPathPutusan : customPath);
                $(iframeId).attr('src', src).removeClass('hidden');
            }

        });
    </script>
@endpush
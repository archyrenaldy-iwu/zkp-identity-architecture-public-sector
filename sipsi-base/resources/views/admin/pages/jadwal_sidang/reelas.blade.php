@extends('admin.layouts.master')
@section('title', 'Reelas')
@push('prepend-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
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
                <a href="{{ route('admin.jadwal_sidang.show', ['id_sengketa' => $sengketa->id]) }}"
                    class="inline-flex items-center text-sm font-medium text-primary hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    {{ $sengketa->no_sengketa }}
                </a>
            </li>
            <li class="inline-flex items-center">
                /
            </li>
            <li class="inline-flex items-center">
                <p
                    class="inline-flex items-center text-sm font-medium text-primary dark:text-gray-400 dark:hover:text-white">
                    Reelas
                </p>
            </li>
        </ol>
    </nav>
    <div class="header mt-5">
        <div class="flex flex-row justify-between">
            <div class="flex flex-row space-x-2">
                <div class=" text-primary text-lg font-semibold font-lato leading-[39px]">Filter</div>

                <form action="#" class="block" method="GET">
                    <div class="flex flex-row space-x-2">
                        <div class="items-center">
                            <div class="lg:w-64 w-full">
                                <select id="pilih_reelas" onchange="getPreviewPdf(this.value)"
                                    class="bg-gray-50 border border-themecolor-primary text-gray-900 text-sm rounded-lg focus:ring-themecolor-primary w-full focus:border-red-800 block ">
                                    <option value="pemohon" selected>Reelas Pemohon</option>
                                    <option value="termohon">Reelas Termohon</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div>
                @if (in_array(Permissions::FITUR_JADWAL_SIDANG_REELAS_SEND, $permissions))
                    <button type="button" data-modal-target="confirm-modal" id="btn_kirim_reelas"
                        class="hidden z-20 text-white bg-themecolor-primary hover:bg-primary hover:bg-opacity-90 focus:outline-none font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                        Kirim
                    </button>
                @endif

                <a href="{{ url()->previous() }}" id="btn_kembali_reelas"
                    class="hidden z-20 text-themecolor-primary bg-white border border-themecolor-primary hover:text-white hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                    Kembali
                </a>
            </div>
        </div>
    </div>


    <!-- Preview PDF Detail -->
    <div id="pdf_preview"
        class="relative overflow-x-auto sm:rounded-lg mt-5 mb-2 mx-auto md:max-w-xl lg:max-w-full w-full px-16 pb-6">
    </div>
    <div class="px-16">
        <div class="pulse px-16 h-72 inline-block bg-gray-400 rounded-sm dark:bg-gray-700 w-full"></div>
    </div>

    <!-- Delete Modal -->
    <div id="confirm-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-xl max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-4 md:p-5 text-center">
                    <input type="hidden" id="delete_id">
                    <svg class="mx-auto mb-4 text-themecolor-primary w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-black dark:text-gray-400">Anda yakin akan mengirim Reelas?</h3>
                    <button data-modal-hide="confirm-modal" type="button"
                        class="bg-white text-themecolor-primary border border-themecolor-primary focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Batal
                    </button>
                    <button type="button" id="btn_submit_reelas"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-white bg-themecolor-primary focus:outline-none  rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-themecolor-primary focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Kirim</button>
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
    <script>
        var modalElement = '';
        var modal = '';
        document.addEventListener('DOMContentLoaded', function() {
            modalElement = document.getElementById('confirm-modal');

            modal = new Modal(modalElement, {
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
            $('#btn_kirim_reelas').on('click', function() {
                modal.show();
            });
        });
    </script>
    <script>
        const path = window.location.pathname;
        const lastSlashIndex = path.lastIndexOf('/');
        const idHistory = path.substring(lastSlashIndex + 1);

        var dataDetailHistoryJadwal = '';

        $(document).ready(function() {
            getDetailHistoryJadwal();

            //Submit form modal
            $("#btn_submit_reelas").click(function(e) {
                e.preventDefault();
                var url = "{{ route('jadwal-sidang.reelas-send', ':id_history') }}";

                url = url.replace(':id_history', idHistory);

                showButtonProgress();

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: url,
                    success: function(response) {
                        hideButtonProgress();
                        showNotificationSuccess(response.message)
                        modal.hide();
                        $('#btn_kirim_reelas').addClass('hidden');
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
                        modal.hide();
                    }
                });

            });
        });

        function getPreviewPdf(value) {
            showLoadingHistoryJadwal();

            var path = dataDetailHistoryJadwal.file_reelas_pemohon;

            if (value == 'termohon') {
                path = dataDetailHistoryJadwal.file_reelas_termohon;
            }
            var url =
                "{{ route('get_pdf_view', ':path') }}";
            url = url.replace(':path', 'path=' + path);

            // Create an iframe element to display the PDF preview
            var iframe = document.createElement("iframe");
            iframe.src = url;
            iframe.class = 'pdf_view'
            iframe.style.width = "100%"; // Adjust width/height as needed
            iframe.style.height = "800px";

            // Append the iframe to a container element (replace with your container ID)
            $("#pdf_preview").html(iframe);

            hideLoadingHistoryJadwal();

        }

        function getDetailHistoryJadwal() {
            var url =
                "{{ route('jadwal-sidang.list', ':id_history') }}";
            url = url.replace(':id_history', 'id_history=' + idHistory);

            showLoadingHistoryJadwal();
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(response) {
                    dataDetailHistoryJadwal = response;
                    showButtonKirimKembali();
                    getPreviewPdf('pemohon')
                },
                error: function(response) {
                    showNotificationError('Data tidak ditemukan')
                    hideLoadingHistoryJadwal();
                }
            });
        }

        function showLoadingHistoryJadwal() {
            $('.pulse').removeClass('hidden');
            $('.pulse').addClass('animate-pulse')
        }

        function hideLoadingHistoryJadwal() {
            $('.pulse').addClass('hidden');
            $('.pulse').removeClass('animate-pulse')
        }

        function showButtonProgress() {
            $('#btn_loading').removeAttr('hidden');
            $('#btn_submit_reelas').attr('hidden', true);
        }

        function hideButtonProgress() {
            $('#btn_submit_reelas').removeAttr('hidden');
            $('#btn_loading').attr('hidden', true);
        }

        function showButtonKirimKembali() {
            if (!dataDetailHistoryJadwal.reelas_sudah_kirim) {
                $('#btn_kirim_reelas').removeClass('hidden');
            }

            $('#btn_kembali_reelas').removeClass('hidden');
        }
    </script>
@endpush

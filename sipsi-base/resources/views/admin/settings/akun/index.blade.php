@extends('admin.layouts.master')
@section('title', 'Akun')
@section('content')

    <!-- Breadcrumb -->
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
                <p
                    class="inline-flex items-center text-sm font-medium text-primary dark:text-gray-400 dark:hover:text-white">
                    Akun
                </p>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="max-w-lg mt-5 text-primary text-3xl font-semibold font-lato leading-[39px]">Data KI</div>
    <div class="mt-6">
        <button type="button" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
            class="flex items-center justify-center text-white font-lato font-semibold text-xs uppercase leading-snug bg-primary hover:bg-primaryTransparent rounded-xl px-3 py-3">
            <svg class="h-4 w-4 mr-1 font-semibold" fill="currentColor" viewbox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path clip-rule="evenodd" fill-rule="evenodd"
                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
            </svg>
            Tambah Data KI
        </button>
    </div>

    <!-- Table Data KI -->
    <div class="relative overflow-x-auto sm:rounded-lg mt-5 mb-2 mx-auto md:max-w-xl lg:max-w-full w-full">
        <table class="w-full text-sm text-white table-auto display table-jadwal" style="width:100%" id="dataki-table">
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
                        Komisi Informasi
                    </th>
                    <th class="text-white font-semibold">
                        Aksi
                    </th>

                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>

    <!-- Main modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
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
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <!-- Data Komisi Informasi-->
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">A.
                                Data Komisi Informasi</label>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="nama_komisi_informasi" id="nama_komisi_informasi"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Nama Komisi Informasi *" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="number" name="no_tlp" id="no_tlp"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Nama Telp *" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="email" name="email" id="email"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Email *" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="number" name="no_whatsapp" id="no_whatsapp"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="No. WhatsApp *" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="fax" id="fax"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Fax">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <textarea id="alamat" rows="4" name="alamat"
                                class="text-sm bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Alamat *"></textarea>
                        </div>

                        <!-- Data Website dan Sosial Media-->
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                B. Website dan Sosial Media</label>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="link_website" id="link_website"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Link Website">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="link_instagram" id="link_instagram"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Link Instagram">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="link_facebook" id="link_facebook"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Link Facebook">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="link_twitter" id="link_twitter"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Link Twitter">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="link_youtube" id="link_youtube"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="Link Youtube">
                        </div>

                        <!-- Template Kode Surat-->
                        <div class="col-span-2">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                C. Template Kode Surat</label>

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="reg_ps" id="reg_ps"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="{nomor}/{bulan}/REG-PS/{tahun}* *" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="kip_spkd" id="kip_spkd"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="{nomor}/{bulan}/KIP-SPKD/{tahun}* *" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="kip_psi" id="kip_psi"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="{nomor}/{bulan}/KIP-PSI/{tahun}* *" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="kip_rls" id="kip_rls"
                                class="bg-white border border-primary text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                                placeholder="{nomor}/{bulan}/KIP-RLS/{tahun}* *" required="">
                        </div>
                    </div>
                    <div class="text-right mt-5">
                        <button type="reset" data-modal-toggle="crud-modal"
                            class="w-xl text-primary bg-white border border-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                            Kembali
                        </button>
                        <button type="submit" id="btn_submit"
                            class="w-xl text-white bg-primary hover:bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary">
                            Simpan
                        </button>
                        @include('components.button_loading')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
{{-- stack js --}}
@push('prepend-script')
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.tailwindcss.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('crud-modal');
            const modal = new Modal(modalElement);

            const closeModalButtons = modalElement.querySelectorAll('[data-modal-hide]');
            closeModalButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    modal.hide();
                });
            });

            $('#dataki-table').on('click', '.edit', function() {
                modal.show();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#data-table').DataTable({
                pagingType: 'full_numbers',
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                searching: true,
                ordering: true,
                // Tambahan opsi lainnya...
            });

            var table = $('#dataki-table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                bDestroy: true,
                lengthChange: true,
                searching: false,
                ordering: false,
                info: true,
                autoWidth: false,
                responsive: true,
                pagingType: 'first_last_numbers',
                ajax: "{{ route('landing.jadwal_sidang') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: null,
                        render: (data, type, row) => renderAction(data, row)
                    }
                ]
            });

        });

        function renderAction(data, row) {
            var edit =
                '<button id="open-modal-button" type="button" class="edit text-yellowColor hover:text-blue-600 font-semibold text-xs uppercase leading-tight">[perbarui]</button>';
            var hapus =
                '<button href="google.com" class="text-themecolor-primary hover:text-blue-600 font-semibold text-xs uppercase leading-tight">[Hapus]</button>';
            return '<div class="w-full text-center">' + edit +
                '<span style="text-black text-lg font-semibold uppercase leading-tight"> </span>' +
                hapus + '</div>'
        }
    </script>
@endpush

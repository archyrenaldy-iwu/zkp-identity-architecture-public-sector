<div id="{{ $id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-6 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-lg p-6 text-center border-4 border-primary">
            <div class="flex flex-col items-center">
                <input type="hidden" id="{{ $hiddenInputId }}">

                @if ($type === 'cancel')
                    <p class="text-lg font-semibold text-primary mb-6">
                        Apakah Anda Yakin Akan Membatalkan Sengketa ini?
                    </p>
                    <div id="file_upload_container" class="mb-4">
                        <input type="file" id="file_akta_pembatalan" name="file_akta_pembatalan" class="hidden" />
                        <label for="file_akta_pembatalan" class="cursor-pointer inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                            Upload Akta Pembatalan
                        </label>
                    </div>
                    <span id="file_name" class="text-black"></span>
                @elseif ($type === 'cabut')
                    <p class="text-lg font-semibold text-primary mb-6">
                        Apakah Anda Yakin Akan Mencabut Sengketa ini?
                    </p>
                    <div id="file_upload_container_cabut" class="mb-4">
                        <input type="file" id="file_akta_pencabutan" name="file_akta_pencabutan" class="hidden" />
                        <label for="file_akta_pencabutan" class="cursor-pointer inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                            Upload Akta Pencabutan
                        </label>
                    </div>
                    <span id="file_name_cabut" class="text-black"></span>
                @elseif ($type === 'delete')
                    <h3 class="mb-5 text-lg font-normal text-black dark:text-gray-400">Anda yakin akan hapus data Sengketa ini?</h3>
                    <input type="text" id="alasan" name="alasan" placeholder="Masukkan Alasan" class="w-full p-2.5 mb-4 border border-gray-200 rounded-lg focus:ring-2 focus:ring-themecolor-primary focus:border-themecolor-primary dark:focus:ring-gray-600 dark:focus:border-gray-600 dark:bg-gray-800 dark:text-gray-400">
                @elseif ($type === 'perangkat-persidangan')
                    <h2 class="text-xl font-bold text-center text-gray-800 mb-4">Perangkat Persidangan</h2>
                    <div class="flex flex-col">
                        <div class="mb-4">
                            <label for="ketua_komisioner" class="block text-sm font-medium text-gray-800">Ketua Majelis Komisioner</label>
                            <select id="ketua_komisioner" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                                <option value="">Pilih Ketua Majelis Komisioner</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="anggota1_komisioner" class="block text-sm font-medium text-gray-800">Anggota Majelis Komisioner</label>
                            <select id="anggota1_komisioner" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                                <option value="">Pilih Anggota Majelis Komisioner</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="anggota2_komisioner" class="block text-sm font-medium text-gray-800">Anggota Majelis Komisioner</label>
                            <select id="anggota2_komisioner" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                                <option value="">Pilih Anggota Majelis Komisioner</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="mediator" class="block text-sm font-medium text-gray-800">Mediator</label>
                            <select id="mediator" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                                <option value="">Pilih Mediator</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="panitera_pengganti" class="block text-sm font-medium text-gray-800">Panitera Pengganti</label>
                            <select id="panitera_pengganti" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                                <option value="">Pilih Panitera Pengganti</option>
                            </select>
                        </div>
                    </div>
                @endif

                <div class="flex space-x-4 mt-4">
                    <button data-modal-hide="{{ $id }}" type="button"
                        class="px-6 py-2 bg-red-300 text-white rounded-md hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Kembali
                    </button>
                    <button type="button" id="btn_{{ $type }}"
                        class="px-6 py-2 bg-primary text-white rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Iya
                    </button>
                    <button id="btn_loading_{{ $type }}" hidden
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

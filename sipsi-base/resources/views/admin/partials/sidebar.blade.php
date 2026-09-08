<aside id="logo-sidebar"
    class="fixed sm:static top-0 left-0 z-40 sm:w-56 lg:w-64 h-screen -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0
flex-shrink-0 transition-all duration-300 ease-in-out opacity-1
"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto overflow-x-hidden bg-themecolor-primary pt-5">
        <div class="flex ml-2">
            <img class="size-9" src="{{ asset('dashboard/logo/garuda.png') }}" alt="logo" />
            <div class="ml-2 text-white text-xs ">
                <span class="font-bold text">KOMISI INFORMASI PUSAT</span>
                <span class="block text">REPUBLIK INDONESIA</span>
            </div>
        </div>
        <ul class="space-y-2 font-medium text-white mt-5 ml-1 mini-sidebar">
            @if (in_array(Permissions::MENU_BERANDA, $permissions))
                <li>
                    <a href="{{ route(Permissions::MENU_BERANDA) }}"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary group @sidebarActive('beranda')">
                        <svg class="w-6 h-6 flex-shrink-0 text-white transition group-hover:text-gray-900"
                            aria-hidden="true" xmlns="SVG namespace " width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ms-3 text">Beranda</span>
                    </a>
                </li>
            @endif
            @if (
                (getActiveRole() == Roles::ROLE_PEMOHON && Auth::user()->email_verified_at != null) ||
                    getActiveRole() != Roles::ROLE_PEMOHON)
                @if (in_array(Permissions::MENU_SENGKETA, $permissions))
                    <li>
                        <a href="{{ route(Permissions::MENU_SENGKETA) }}"
                            class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary group @sidebarActive('sengketa')">
                            <svg class="w-6 h-6 flex-shrink-0 text-white transition group-hover:text-gray-900"
                                aria-hidden="true" xmlns="SVG namespace " width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap text">Sengketa</span>
                        </a>
                    </li>
                @endif
                @if (in_array(Permissions::MENU_JADWAL, $permissions))
                    <li>
                        <a href="{{ route(Permissions::MENU_JADWAL) }}"
                            class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary group @sidebarActive('jadwal_sidang')">
                            <svg class="w-6 h-6 flex-shrink-0 text-white transition group-hover:text-gray-900"
                                aria-hidden="true" xmlns="SVG namespace " width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap text">Jadwal Sidang</span>
                            {{-- <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300 text">3</span> --}}
                        </a>
                    </li>
                @endif
                @if (in_array(Permissions::MENU_PANDUAN, $permissions))
                    <li>
                        <a href="{{ route(Permissions::MENU_PANDUAN) }}"
                            class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary group @sidebarActive('panduan')">
                            <svg class="w-6 h-6 flex-shrink-0 text-white transition group-hover:text-gray-900"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007 2.759-.038 4.5.16 6.956.791V4.717Zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71v15.081Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap text">Panduan</span>
                        </a>
                    </li>
                @endif
                @if (in_array(Permissions::MENU_PUTUSAN, $permissions))
                    @php
                        $isDropdownActive = request()->routeIs(Permissions::MENU_PUTUSAN);
                    @endphp
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-white transition rounded-lg group hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-putusan" data-collapse-toggle="dropdown-putusan"
                            aria-expanded="{{ $isDropdownActive ? 'true' : 'false' }}">
                            <svg class="flex-shrink-0 w-6 h-6 text-white transition group-hover:text-gray-900"
                                aria-hidden="true" xmlns="SVG namespace " fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12 4a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm-2.952.462c-.483.19-.868.432-1.19.71-.363.315-.638.677-.831.93l-.106.14c-.21.268-.36.418-.574.527C6.125 6.883 5.74 7 5 7a1 1 0 0 0 0 2c.364 0 .696-.022 1-.067v.41l-1.864 4.2a1.774 1.774 0 0 0 .821 2.255c.255.133.538.202.825.202h2.436a1.786 1.786 0 0 0 1.768-1.558 1.774 1.774 0 0 0-.122-.899L8 9.343V8.028c.2-.188.36-.38.495-.553.062-.079.118-.15.168-.217.185-.24.311-.406.503-.571a1.89 1.89 0 0 1 .24-.177A3.01 3.01 0 0 0 11 7.829V20H5.5a1 1 0 1 0 0 2h13a1 1 0 1 0 0-2H13V7.83a3.01 3.01 0 0 0 1.63-1.387c.206.091.373.19.514.29.31.219.532.465.811.78l.025.027.02.023v1.78l-1.864 4.2a1.774 1.774 0 0 0 .821 2.255c.255.133.538.202.825.202h2.436a1.785 1.785 0 0 0 1.768-1.558 1.773 1.773 0 0 0-.122-.899L18 9.343v-.452c.302.072.633.109 1 .109a1 1 0 1 0 0-2c-.48 0-.731-.098-.899-.2-.2-.12-.363-.293-.651-.617l-.024-.026c-.267-.3-.622-.7-1.127-1.057a5.152 5.152 0 0 0-1.355-.678 3.001 3.001 0 0 0-5.896.04Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap text">Putusan</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul id="dropdown-putusan" class="{{ $isDropdownActive ? '' : 'hidden' }} py-2 space-y-2">
                            <li>
                                <a href="{{ route(Permissions::MENU_PUTUSAN) }}"
                                    class="flex items-center w-full p-2 text-white transition rounded-lg sub-menu pl-7 group hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary @sidebarActive('putusan')">
                                    <svg class="w-6 h-6 flex-shrink-0 text-white transition group-hover:text-gray-900"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 4a1 1 0 0 1 1 1v5h5a1 1 0 0 1 0 2h-5v5a1 1 0 0 1-2 0v-5H7a1 1 0 0 1 0-2h5V5a1 1 0 0 1 1-1z" />
                                    </svg>
                                    <span class="flex-1 ms-3 whitespace-nowrap text">Tambah Putusan</span>
                                </a>

                            </li>
                            <li>
                                <a href="{{ route('rekomendasi-informasi') }}"
                                    class="flex items-center w-full p-2 text-white transition rounded-lg sub-menu pl-7 group hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary ">
                                    <svg class="w-6 h-6 flex-shrink-0 text-white transition group-hover:text-gray-900"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm-9 14H6v-1h4v1zm0-3H6v-1h4v1zm0-3H6V9h4v2zm8 6H7v-1h11v1zm0-3H7v-1h11v1zm0-3H7V9h11v2z" />
                                    </svg>

                                    <span class="flex-1 ms-3 whitespace-nowrap text">Konsultasi <br/>Perkara Sengketa</span>
                                </a>
                            </li>
                            <!-- Hide Validasi Informasi Menu -->
                            <!-- <li>
                                <a href="{{ route('validasi-informasi') }}"
                                    class="flex items-center w-full p-2 text-white transition rounded-lg sub-menu pl-7 group hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary">
                                    <svg class="w-6 h-6 flex-shrink-0 text-white transition group-hover:text-gray-900"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M10 2H5a2 2 0 0 0-2 2v4h2V4h5V2zm8 0h-5v2h5v2h2V4a2 2 0 0 0-2-2zm-7 16H5v-5h6v5zm8 0h-6v-5h6v5zm-8-9H5v-2h6v2zm8 0h-6v-2h6v2z" />
                                    </svg>



                                    <span class="flex-1 ms-3 whitespace-nowrap text">Validasi Informasi</span>
                                </a>
                            </li> -->
                            <li>
                                <a href="{{ route('verifikasi-putusan') }}"
                                    class="flex items-center w-full p-2 text-white transition rounded-lg sub-menu pl-7 group hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary">
                                    <svg class="w-6 h-6 flex-shrink-0 text-white transition group-hover:text-gray-900"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M10 16.172l-4.95-4.95a1.5 1.5 0 0 1 0-2.12l1.415-1.415a1.5 1.5 0 0 1 2.121 0L10 11.415l6.707-6.707a1.5 1.5 0 0 1 2.12 2.121l-8 8a1.5 1.5 0 0 1-2.121 0z" />
                                    </svg>


                                    <span class="flex-1 ms-3 whitespace-nowrap text">Validasi Putusan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (in_array(Permissions::MENU_DATA_KI, $permissions))
                    <li>
                        <a href="{{ route(Permissions::MENU_DATA_KI) }}"
                            class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary @sidebarActive('data_ki') group">
                            <svg class="w-6 h-6 flex-shrink-0 text-white transition group-hover:text-gray-900"
                                aria-hidden="true" xmlns="SVG namespace " width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M4 4a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2v14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2V5a1 1 0 0 1-1-1Zm5 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-1Zm-5 4a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1h-1Zm-3 4a2 2 0 0 0-2 2v3h2v-3h2v3h2v-3a2 2 0 0 0-2-2h-2Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap text">Data KI</span>
                        </a>
                    </li>
                @endif
                @if (in_array(Permissions::MENU_USER_INTERNAL, $permissions) ||
                        in_array(Permissions::MENU_USER_PEMOHON, $permissions) ||
                        in_array(Permissions::MENU_ROLE, $permissions))
                    @php
                        $isDropdownActive =
                            request()->routeIs(Permissions::MENU_ROLE) ||
                            request()->routeIs(Permissions::MENU_USER_INTERNAL) ||
                            request()->routeIs(Permissions::MENU_USER_PEMOHON);
                    @endphp
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-white transition rounded-lg group hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-kontrol-akses" data-collapse-toggle="dropdown-kontrol-akses"
                            aria-expanded="{{ $isDropdownActive ? 'true' : 'false' }}">
                            <svg class="flex-shrink-0 w-6 h-6 text-white transition group-hover:text-gray-900"
                                aria-hidden="true" xmlns="SVG namespace " fill="currentColor" viewBox="0 0 24 21">
                                <path fill-rule="evenodd"
                                    d="M17 10v1.126c.367.095.714.24 1.032.428l.796-.797 1.415 1.415-.797.796c.188.318.333.665.428 1.032H21v2h-1.126c-.095.367-.24.714-.428 1.032l.797.796-1.415 1.415-.796-.797a3.979 3.979 0 0 1-1.032.428V20h-2v-1.126a3.977 3.977 0 0 1-1.032-.428l-.796.797-1.415-1.415.797-.796A3.975 3.975 0 0 1 12.126 16H11v-2h1.126c.095-.367.24-.714.428-1.032l-.797-.796 1.415-1.415.796.797A3.977 3.977 0 0 1 15 11.126V10h2Zm.406 3.578.016.016c.354.358.574.85.578 1.392v.028a2 2 0 0 1-3.409 1.406l-.01-.012a2 2 0 0 1 2.826-2.83ZM5 8a4 4 0 1 1 7.938.703 7.029 7.029 0 0 0-3.235 3.235A4 4 0 0 1 5 8Zm4.29 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h6.101A6.979 6.979 0 0 1 9 15c0-.695.101-1.366.29-2Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap text">Kontrol
                                Akses</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul id="dropdown-kontrol-akses"
                            class="{{ $isDropdownActive ? '' : 'hidden' }} py-2 space-y-2">
                            @if (in_array(Permissions::MENU_ROLE, $permissions))
                                <li>
                                    <a href="{{ route(Permissions::MENU_ROLE) }}"
                                        class="flex items-center w-full p-2 text-white transition rounded-lg sub-menu pl-7 group hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary @sidebarActive('role')">
                                        <svg class="w-6 h-6 flex-shrink-0 text-white transition group-hover:text-gray-900"
                                            aria-hidden="true" xmlns="SVG namespace " width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="flex-1 ms-3 whitespace-nowrap text">Role</span>
                                    </a>
                                </li>
                            @endif

                            @if (in_array(Permissions::MENU_USER_INTERNAL, $permissions))
                                <li>
                                    <a href="{{ route(Permissions::MENU_USER_INTERNAL) }}"
                                        class="flex items-center w-full p-2 text-white transition rounded-lg sub-menu pl-7 group hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary @sidebarActive('akun_admin')">
                                        <svg class="w-6 h-6 flex-shrink-0 text-white transition group-hover:text-gray-900"
                                            aria-hidden="true" xmlns="SVG namespace " width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="flex-1 ms-3 whitespace-nowrap text">Akun Admin</span>
                                    </a>
                                </li>
                            @endif
                            @if (in_array(Permissions::MENU_USER_PEMOHON, $permissions))
                                <li>
                                    <a href="{{ route(Permissions::MENU_USER_PEMOHON) }}"
                                        class="flex items-center w-full p-2 text-white transition rounded-lg sub-menu pl-7 group hover:bg-themecolor-secondary hover:bg-opacity-75 hover:text-themecolor-primary @sidebarActive('akun_pemohon')">
                                        <svg class="w-6 h-6 flex-shrink-0 text-white transition group-hover:text-gray-900"
                                            aria-hidden="true" xmlns="SVG namespace " width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="flex-1 ms-3 whitespace-nowrap text">Akun Pemohon</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endif
        </ul>
    </div>
</aside>

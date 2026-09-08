@php
    $roles = Auth::user()->getListRole();
    $activeRole = getActiveRole();
@endphp
<nav class="fixed sm:static top-0 z-40 w-full mb-6 bg-white border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="flex flex-1 ml-0 transition-opacity duration-1000 ease-in-out">
                <button id="toggleSidebar" class="focus:outline-none lg:block hidden md:block sm:block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-themecolor-primary" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button" class="flex text-sm rounded-full" aria-expanded="false"
                            data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-9 h-w-9 rounded-full ring-2 ring-themecolor-primary"
                                src="{{ asset('img/icons/avatar-1.png') }}" alt="user photo">
                            <span
                                class="hidden text-sm font-bold text-themecolor-primary sm:block my-auto ml-2">{{ Auth::user()->name }}</span>
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow"
                        id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-themecolor-primary" role="none" id="active-role">
                                {{ getActiveRole() }}
                            </p>
                            <p class="text-sm font-medium text-themecolor-primary truncate" role="none">
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                        <ul class="py-1 font-medium" role="none">
                            @if ($activeRole != 'pemohon' && $activeRole != 'super-admin')
                                <li>
                                    <form class="max-w-sm mx-auto block px-4 py-2" id="switch-role-form">
                                        <label for="roles"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Switch
                                            Role</label>
                                        <select id="roles"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-themecolor-primary focus:border-themecolor-primary block w-full p-2.5 dark:focus:ring-themecolor-primary">
                                            @foreach ($roles as $role => $value)
                                                <option value="{{ $value }}"
                                                    {{ $value == $activeRole ? 'selected' : '' }}>{{ $role }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </li>
                            @endif
                            <a href="{{ route('informasi-akun') }}"
                                class="block px-4 py-2 text-sm text-themecolor-primary hover:bg-themecolor-secondary dark:hover:text-themecolor-primary"
                                role="menuitem">Akun Saya</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('auth.logout') }}">
                                    @csrf
                                    <button id="btn-logout"
                                        class="w-full  text-left px-4 py-4 text-sm text-themecolor-primary hover:bg-themecolor-secondary dark:hover:text-themecolor-primary"
                                        role="menuitem">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<section id="nav">
    <nav class="flex px-4 py-5 mx-auto  items-center justify-between flex-wrap bg-white p-6 md:px-24 ">
        <div class="flex items-center flex-shrink-0 text-white mr-6">
            <img class="w-14" src="../../img/logo2.png" alt="" />
            <div class="inline-block items-center">
                <div>
                    <span class="ml-2 mb-0 text-sm font-bold text-black uppercase font-lato">KOMISI INFORMASI
                        PUSAT</span>
                    <br class="hidden md:block" />
                    <p class="ml-2 mt-0 text-sm font-normal text-black uppercase font-lato">
                        Republik Indonesia
                    </p>
                </div>
            </div>
        </div>
        <div class="" id="navbar-btn">
            <button class="flex items-center px-3 py-2  rounded text-primary hover:text-primary">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                </svg>
            </button>
        </div>
        <div class="w-full block flex-grow xl:flex xl:items-center xl:w-auto " id="navbar">
            <div class="text-md xl:flex-grow text-center xl:text-right">
                <a href="{{ route('landing.beranda') }}"
                    class="block mt-4 xl:inline-block xl:mt-0 text-primary font-lato hover:text-gray-700 text-lg">
                    <div class="mx-3 my-1 flex-col">
                        <div>Beranda</div>
                        @if (Route::currentRouteNamed('landing.beranda'))
                            <div style="height: 4px; width: 65px" class=" mx-auto bg-primary rounded-md">
                            </div>
                        @endif
                    </div>
                </a>
                <a href="{{ Route::currentRouteNamed('landing.beranda') ? '#about' : route('landing.beranda', ['section' => 'about']) }}"
                    onclick="scrollToSection(event, 'about')"
                    class="block mt-6 xl:inline-block xl:mt-0 text-primary font-lato hover:text-gray-700 text-lg ">
                    <div class="mx-3 my-1">Tentang-SISE</div>
                </a>
                <a href="{{ Route::currentRouteNamed('landing.beranda') ? '#content' : route('landing.beranda', ['section' => 'content']) }}"
                    onclick="scrollToSection(event, 'content')"
                    class="block mt-6 xl:inline-block xl:mt-0 text-primary font-lato hover:text-gray-700 text-lg ">
                    <div class="mx-3 my-1">Layanan</div>
                </a>
                <a href="{{ route('landing.jadwal_sidang') }}"
                    class="block mt-6 xl:inline-block xl:mt-0 text-primary font-lato hover:text-gray-700 text-lg">

                    <div class="mx-3 my-1 flex-col">
                        <div>Jadwal Sidang</div>
                        @if (Route::currentRouteNamed('landing.jadwal_sidang'))
                            <div style="height: 4px; width: 112px" class=" mx-auto bg-primary rounded-md">
                            </div>
                        @endif
                    </div>
                </a>
                <a href="{{ route('direktori_putusan') }}"
                    class="block mt-6 xl:inline-block xl:mt-0 text-primary font-lato hover:text-gray-700 text-lg">

                    <div class="mx-3 my-1 flex-col">
                        <div>Direktori Putusan</div>
                        @if (Route::currentRouteNamed('direktori_putusan'))
                            <div style="height: 4px; width: 138px" class=" mx-auto bg-primary rounded-md">
                            </div>
                        @endif
                    </div>
                </a>
                <br hidden id="enter">
                @if (auth()->check())
                    <a href="{{ route(Permissions::MENU_BERANDA) }}"
                        class="inline-flex items-center font-lato justify-center h-10 px-6 font-semibold tracking-wide text-white transition duration-200 rounded-xl shadow-md bg-primary hover:bg-primaryTransparent focus:shadow-outline focus:outline-none">
                        <div class="mx-3 my-1">Beranda</div>
                    </a>
                @endif
                @guest
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center font-lato justify-center h-10 px-6 font-semibold tracking-wide text-accent border border-primary transition duration-200 rounded-xl shadow-md bg-white hover:stroke-white focus:shadow-outline focus:outline-none"
                        aria-label="Masuk" title="Masuk">
                        Masuk
                    </a>

                    <a href="{{ route('register') }}"
                        class="inline-flex items-center font-lato justify-center h-10 px-6 font-semibold tracking-wide text-white transition duration-200 rounded-xl shadow-md bg-primary hover:bg-primaryTransparent focus:shadow-outline focus:outline-none"
                        aria-label="Daftar" title="Daftar">
                        Daftar
                    </a>
                @endguest
            </div>
        </div>
    </nav>
</section>

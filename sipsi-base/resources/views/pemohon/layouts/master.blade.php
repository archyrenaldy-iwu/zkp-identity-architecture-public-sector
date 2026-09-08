<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en"

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ asset('img/icons/garuda.ico') }}">
    <title>@yield('title')</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    @vite(['resources/css/app.css','resources/js/app.js', 'resources/css/custom-css.css'])
    {{-- Style --}}
    @stack('prepend-style')
    @stack('addon-style')
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  </head>
  <body>
    <div
      class="flex h-screen bg-gray-50 dark:bg-gray-900"
    >
    {{-- sidebar --}}
    @include('admin.partials.sidebar')
      <div class="flex flex-col flex-1 w-full">
        {{-- navbar --}}
        @include('admin.partials.navbar')

        {{-- main content --}}
        
        <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            @yield('content')
          </div>
        </main>
        
      </div>
    </div>
    {{-- Script --}}
    @stack('prepend-script')
    @stack('addon-script')
  </body>
  <script>
    document.getElementById('toggleSidebar').addEventListener('click', function() {
        const sidebar = document.getElementById('logo-sidebar');
        sidebar.classList.toggle('sidebar-collapsed');
    });
</script>
</html>
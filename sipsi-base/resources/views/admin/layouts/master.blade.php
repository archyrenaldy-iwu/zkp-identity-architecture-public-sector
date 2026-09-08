<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en" <head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf_token" content="{{ csrf_token() }}" />
<link rel="icon" href="{{ asset('img/icons/garuda.ico') }}">
<title>@yield('title')</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/custom-css.css'])
{{-- Style --}}
@stack('prepend-style')
@stack('addon-style')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    @php
        $permissions = getPermissionsForActiveRole();
    @endphp
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
        {{-- sidebar --}}
        @include('admin.partials.sidebar')
        <div class="flex flex-col flex-1 w-full">
            {{-- navbar --}}
            @include('admin.partials.navbar')

            {{-- main content --}}

            <main class="h-full overflow-y-auto">
                @include('components.notification')
                <div id="loading-progress" class="fixed hidden z-50 ease-out inset-0 items-center justify-center">
                    <div class=" flex items-center justify-center w-56 h-56">
                        <div
                            class="px-3 py-1 text-xl font-medium leading-none text-center text-themecolor-secondary bg-themecolor-primary rounded-full animate-pulse">
                            Loading...</div>
                    </div>
                </div>
                <div id="role-change-indicator"
                    class="fixed hidden z-50 ease-out inset-0 items-center justify-center bg-gray-900 bg-opacity-75">
                    <div class="bg-red-500 p-4 rounded-lg shadow-lg flex items-center justify-center space-x-4">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" id="icon-loading">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24" id="icon-check">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 11.917 9.724 16.5 19 7.5" />
                        </svg>
                        <span class="text-white" id="role-change-text">Logging out...</span>
                    </div>
                </div>


                <div class="flex flex-col justify-between h-full">
                    <div class="container px-6 mx-auto grid">
                        @yield('content')
                    </div>
                    <div class="mt-10">
                        @include('admin.partials.footer')
                    </div>
                </div>
            </main>

        </div>
    </div>
    {{-- Script --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            'closeButton': true,
            'positionClass': 'top-24 right-6',
        }

        function showNotificationError(errorMessage) {
            toastr.error(errorMessage)
        }

        function showNotificationSuccess(successMessage) {
            toastr.success(successMessage)
        }

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

        function formatDate(dateString) {
            // Parse the original date string
            const originalDate = new Date(dateString);

            // Define the desired format options
            const options = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                timeZone: 'Asia/Jakarta', // Adjust if needed based on your location
            };

            // Format the date according to the options
            let formattedDate = originalDate.toLocaleDateString('id-ID', options);

            if (dateString === null) {
                formattedDate = "-"
            }

            return formattedDate;
        }

        function formatDateToWIB(dateString) {
            // Parse the original date string
            const originalDate = new Date(dateString);

            // Convert the date to WIB time zone (GMT+7)
            originalDate.setHours(originalDate.getHours() + 7);

            // Define the desired format options
            const options = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                timeZone: 'UTC', // Use UTC for consistent formatting
            };

            // Format the date according to the options with WIB time
            const formattedDate = originalDate.toLocaleDateString('id-ID', options);

            return formattedDate + " WIB"; // Append WIB to the formatted string
        }

        function formatDateNoHour(dateString) {
            // Parse the original date string
            const originalDate = new Date(dateString);

            // Convert the date to WIB time zone (GMT+7)
            originalDate.setHours(originalDate.getHours() + 7);

            // Define the desired format options
            const options = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                timeZone: 'UTC', // Use UTC for consistent formatting
            };

            // Format the date according to the options with WIB time
            const formattedDate = originalDate.toLocaleDateString('id-ID', options);

            return formattedDate; // Append WIB to the formatted string
        }
    </script>
    @stack('prepend-script')
    @stack('addon-script')
</body>

<script>
    document.getElementById('toggleSidebar').addEventListener('click', function() {
        const sidebar = document.getElementById('logo-sidebar');
        sidebar.classList.toggle('sidebar-collapsed');
    });
</script>
{{-- logout --}}
<script type="text/javascript">
    $(document).ready(function() {
        $('#btn-logout').click(function(event) {
            event.preventDefault();

            $('#btn-logout').prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
            $('#role-change-indicator').removeClass('hidden').addClass('flex');
            $('#icon-check').addClass('hidden');

            $.ajax({
                url: "{{ route('auth.logout') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = "{{ route('landing.beranda') }}";
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    $('#btn-logout').prop('disabled', false).removeClass(
                        'opacity-50 cursor-not-allowed');
                    $('#role-change-indicator').removeClass('flex').addClass('hidden');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#roles').on('change', function() {
            var role = $(this).val();

            $('#role-change-indicator').removeClass('hidden').addClass('flex');
            $('#role-change-indicator').find('.bg-red-500').removeClass('bg-red-500').addClass(
                'bg-green-500');
            $('#role-change-text').text('Ganti Role...');
            $('#icon-check').addClass('hidden');

            $.ajax({
                url: '{{ route('auth.switch-role') }}',
                type: 'POST',
                data: {
                    role: role,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.success) {
                        $('#role-change-text').text('Berhasil Mengganti Role.');
                        $('#active-role').text(role);
                        $('#icon-loading').addClass('hidden');

                        $('#icon-check').removeClass('hidden');
                        setTimeout(function() {
                            $('#role-change-indicator').addClass('hidden');
                        }, 1000);

                        window.location.href = "{{ route('admin.beranda') }}";
                    } else {
                        showNotificationError(data.message);
                        $('#role-change-indicator').addClass('hidden');
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                    showNotificationError('Terjadi kesalahan saat mengganti role');
                    $('#role-change-indicator').addClass('hidden');
                }
            });
        });
    });
</script>

</html>

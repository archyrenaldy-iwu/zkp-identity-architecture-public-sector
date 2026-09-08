<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('img/icons/garuda.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/custom-css.css'])
    @stack('css')
</head>

<body>
    <header class="sticky top-0 z-50">
        @include('layouts.front.header')
    </header>
    <main class=relative>
        @include('components.notification')
        <div id="loading-progress" class="fixed hidden z-50 ease-out inset-0 items-center justify-center">
            <div class=" flex items-center justify-center w-56 h-56">
                <div
                    class="px-3 py-1 text-xl font-medium leading-none text-center text-themecolor-secondary bg-themecolor-primary rounded-full animate-pulse">
                    Loading...</div>
            </div>
        </div>
        @yield('content')
    </main>
    <footer>
        @include('layouts.front.footer')
    </footer>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        $(document).ready(function() {
            toastr.options = {
                'closeButton': true,
                'positionClass': 'top-24 right-6',
            }

            var $window = $(window);

            function checkWindowWidth() {

                var windowsize = $window.width();

                if (windowsize > 1280) {

                    $('#navbar').css('display', 'block');
                    $('#navbar-btn').css('display', 'none');
                    $('#enter').hide();

                } else {

                    $('#navbar').css('display', 'none');
                    $('#navbar-btn').css('display', 'block');
                    $('#enter').show();

                }
            }

            checkWindowWidth();

            $(window).resize(checkWindowWidth);

        });


        $('#navbar-btn').click(function() {
            $('#navbar').toggle();
        });

        function showNotificationError(errorMessage) {
            toastr.error(errorMessage)
        }

        function showNotificationSuccess(successMessage) {
            toastr.success(successMessage)
        }
    </script>

    @stack('js')
</body>

</html>

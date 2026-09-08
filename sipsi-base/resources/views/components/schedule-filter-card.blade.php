<div class="mx-auto md:max-w-xl lg:max-w-6xl rounded schedule-filter-form" data-action="{{ $action }}">
    <div class="block max-w-full mt-2 p-6 border text-white border-gray-200 rounded-2xl shadow-2xl bg-themecolor-primary">
        <form action="#" method="GET">
            {{ $slot }}
        </form>
    </div>
</div>


@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.schedule-filter-form');
            const action = form.dataset.action;
            form.setAttribute('action', action);
        });
    </script>
@endpush
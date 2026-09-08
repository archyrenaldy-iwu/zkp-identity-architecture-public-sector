@unless ($breadcrumbs->isEmpty())
    <nav class="container mx-auto mt-24 sm:mt-0 pb-2">
        <ol class="rounded flex flex-wrap text-sm text-gray-800">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                    <li>
                        <a href="{{ $breadcrumb->url }}" class="text-primary hover:text-red-900 hover:underline focus:text-red-900 focus:underline font-medium">
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                @else
                    <li class="font-medium">
                        {{ $breadcrumb->title }}
                    </li>
                @endif

                @unless($loop->last)
                    <li class="text-gray-500 px-2 font-medium">
                        /
                    </li>
                @endif

            @endforeach
        </ol>
    </nav>
@endunless
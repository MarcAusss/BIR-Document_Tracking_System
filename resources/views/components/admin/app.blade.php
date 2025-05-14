<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Include Alpine.js -->

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="ml-[18%]">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

            <script>
    $(document).ready(function () {
        var table = $('#documentTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            dom: '<"custom-search"f>t<"bottom"p>', 
            language: {
                search: '', 
                searchPlaceholder: 'Search Documents...', 
            },
        });

        $('.dataTables_filter input')
            .addClass('custom-search-input !border-none')
            .attr('placeholder', 'Search Documents...');
    });
</script>

<style>
    .custom-search-input {
        width: 100%;
        padding: 10px;
        border-bottom: 2px solid black !important;
        outline: none;
        margin-bottom: 10px; 
    }

    .custom-search {
        margin-bottom: 10px; 
        text-align: left; 
    }
    .dataTables_filter{
        width: 100%;

    }
    
</style>
    </body>
</html>

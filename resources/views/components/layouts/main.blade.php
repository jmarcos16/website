<!DOCTYPE html>
<html lang={{ str_replace('_', '-', app()->getLocale()) }}>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,
        initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Albert+Sans:200,
        600" type="text/css">
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans">
        <div class="min-h-screen bg-gray-100">
            @include('components.layouts.navigation')
            <!-- Page Content-->
            <main>                    
                {{ $slot }}
            </main>

            @include('components.layouts.footer')
        </div>
    </body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel Vue CRUD</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <style>
            [role="dialog"] > div > div[aria-hidden="true"] {
                z-index: 0;
            }

            [role="dialog"] > div > div:not([aria-hidden="true"]) {
                position: relative;
                z-index: 1;
            }

            .fixed.inset-0.z-10.overflow-y-auto > div > .fixed.inset-0,
            .fixed.inset-0.z-10.overflow-y-auto > div > .absolute.inset-0 {
                z-index: 0;
            }

            .fixed.inset-0.z-10.overflow-y-auto > div > .inline-block {
                position: relative;
                z-index: 1;
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div id="app"></div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Solar ACE') }}</title>

        <!-- Inter Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-zinc-950 antialiased bg-[#fafafa]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/" class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 rounded-lg bg-zinc-900 flex items-center justify-center shadow-sm">
                        <img src="https://6mwxm9jt.dev.cdn.imgeng.in/wp-content/uploads/2024/10/cropped-Favicon-300x300.png" alt="Logo" class="h-6 w-6 object-contain invert">
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-[400px] mt-8 px-8 py-8 bg-white border border-zinc-200 shadow-sm sm:rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

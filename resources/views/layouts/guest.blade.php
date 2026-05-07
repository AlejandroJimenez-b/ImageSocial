<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script type="text/javascript" src="../../../public/js/main.js"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-800">
            <div>
                <a href="/">
                    <div>
                        <a href="/">
                            <svg width="480" viewBox="0 0 680 200" role="img">
                                <title>ImageSocial logo</title>
                                <polygon points="340,48 390,76 390,132 340,160 290,132 290,76" fill="#1e293b" stroke="#6366f1" stroke-width="2.5"/>
                                <polygon points="340,58 382,82 382,128 340,152 298,128 298,82" fill="#0f172a" stroke="#4f46e5" stroke-width="1"/>
                                <rect x="316" y="78" width="22" height="6" rx="3" fill="#6366f1"/>
                                <rect x="324" y="84" width="6" height="40" rx="3" fill="#818cf8"/>
                                <rect x="316" y="124" width="22" height="6" rx="3" fill="#6366f1"/>
                                <path d="M344 84 Q344 78 352 78 Q364 78 364 90 Q364 100 352 103 Q340 106 340 116 Q340 130 352 130 Q364 130 364 124" fill="none" stroke="#a5b4fc" stroke-width="5.5" stroke-linecap="round"/>
                                <circle cx="385" cy="72" r="4" fill="#6366f1" opacity="0.7"/>
                                <circle cx="393" cy="80" r="2.5" fill="#818cf8" opacity="0.5"/>
                                <circle cx="390" cy="65" r="2" fill="#4f46e5" opacity="0.6"/>
                                <circle cx="295" cy="138" r="4" fill="#6366f1" opacity="0.7"/>
                                <circle cx="287" cy="130" r="2.5" fill="#818cf8" opacity="0.5"/>
                            </svg>
                        </a>
                    s</div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-900 shadow-md overflow-hidden sm:rounded-lg border border-gray-500">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

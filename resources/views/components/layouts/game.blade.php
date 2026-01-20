<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerdas Cermat K3 - Live Stage</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .bg-animate {
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>

<body
    class="antialiased overflow-hidden bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-900 bg-animate min-h-screen text-white">

    <div class="fixed inset-0 opacity-10 pointer-events-none"
        style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;">
    </div>

    <div class="relative z-10 w-full h-full flex flex-col items-center justify-center">
        {{ $slot }}
    </div>

    @livewireScripts
</body>

</html>
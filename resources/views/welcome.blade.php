<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS - Coming Soon</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white min-h-screen flex items-center justify-center">

    <div class="text-center px-6">
        <!-- Logo / Title -->
        <div class="flex-col flex justify-center items-center gap-5">
            <img src="{{ asset('images/bcplogo2.png') }}" class="" alt="">
            <h1 class="text-4xl md:text-5xl font-bold tracking-tight">
                Hotel Management System
            </h1>
        </div>

        <!-- Subtitle -->
        <p class="mt-4 text-slate-300 text-lg">
            🚧 Our landing page is currently under development.
        </p>

        <p class="mt-2 text-slate-400">
            We're working hard to bring you a better experience.
        </p>

        <!-- Divider -->
        <div class="mt-6 h-px w-24 mx-auto bg-slate-600"></div>

        <!-- Button -->
        <div class="mt-8">
            <a href="{{ route('login') }}"
               class="inline-block px-6 py-3 rounded-2xl bg-indigo-500 hover:bg-indigo-600 transition text-white font-semibold shadow-lg shadow-indigo-500/30">
                Go to Login
            </a>
        </div>

        <!-- Footer text -->
        <p class="mt-10 text-sm text-slate-500">
            © {{ date('Y') }} HMS. All rights reserved.
        </p>
    </div>

</body>
</html>
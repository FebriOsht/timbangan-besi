<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex bg-white">

    {{-- Kiri --}}
    <div class="hidden md:flex w-1/2 bg-green-600 items-center justify-center p-10">
        <img src="{{ asset('images/machine.png') }}" class="max-w-lg" alt="Illustration">
    </div>

    {{-- Kanan --}}
    <div class="flex w-full md:w-1/2 items-center justify-center p-10">
        <div class="max-w-sm w-full">

            {{-- Tombol Back --}}
            <a href="{{ url('/') }}" class="flex items-center text-gray-600 mb-6 hover:text-black">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor"
                     class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.5L7.5 12 15 4.5" />
                </svg>
                Back
            </a>

            {{-- Tempat konten --}}
            {{ $slot ?? '' }}
        </div>
    </div>

</body>
</html>

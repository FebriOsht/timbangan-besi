<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Auth' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white flex">

    {{-- KIRI --}}
    <div class="hidden md:flex w-1/2 bg-green-600 items-center justify-center p-10">
        <img src="{{ asset('images/machine.png') }}" class="max-w-lg" alt="">
    </div>

    {{-- KANAN --}}
    <div class="flex w-full md:w-1/2 items-center justify-center p-10">
        <div class="max-w-sm w-full">
            {{ $slot }}
        </div>
    </div>

</body>
</html>

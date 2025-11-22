<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Auth' }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex">

    <!-- LEFT SIDE (Green + Image) -->
    <div class="hidden lg:flex w-1/2 bg-green-600 items-center justify-center">
        <img src="/images/machine.png" alt="Machine" class="w-3/4">
    </div>

    <!-- RIGHT SIDE (Content / Form) -->
    <div class="flex w-full lg:w-1/2 items-center justify-center p-8">
        <div>
            {{ $slot }}
        </div>

    </div>

</body>
</html>

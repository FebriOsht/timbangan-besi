@props(['title' => 'Dashboard'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="flex">

    {{-- Sidebar --}}
    <x-sidebar />

    {{-- MAIN CONTENT --}}
    <div class="flex-1">

        {{-- TOP NAV --}}
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold">
                {{ $title }}
            </h2>

            <div class="flex items-center space-x-3">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="w-10 h-10 rounded-full" />
                <div>
                    <p class="font-bold text-sm">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-600">Admin</p>
                </div>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="p-6">
            {{ $slot }}
        </main>

    </div>

</div>
@stack('scripts')
</body>
</html>

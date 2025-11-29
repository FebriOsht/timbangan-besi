@props(['title' => 'Dashboard'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
<header class="bg-white shadow px-6 py-4 flex justify-between items-center sticky top-0 z-50">
    <h2 class="text-xl font-semibold">
        {{ $title }}
    </h2>

    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="w-10 h-10 rounded-full" />
            <div class="text-left">
                <p class="font-bold text-sm">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-600">{{ ucfirst(Auth::user()->role) }}</p>
            </div>
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        {{-- Dropdown --}}
        <div x-show="open" @click.outside="open = false"
             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 z-50"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-1">
             
            <a href="{{ route('user.settings') }}" 
               class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-t-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A4.992 4.992 0 0112 15a4.992 4.992 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Profile Settings
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="flex items-center gap-2 w-full px-4 py-2 text-red-600 hover:bg-red-100 rounded-b-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                    </svg>
                    Logout
                </button>
            </form>
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

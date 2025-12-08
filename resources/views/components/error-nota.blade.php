<x-admin-layout title="Error Nota">
    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
        <!-- Logo / Icon memohon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-red-500 mb-4" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 8c.828 0 1.5-.672 1.5-1.5S12.828 5 12 5 10.5 5.672 10.5 6.5 11.172 8 12 8zM12 12v4m0 4h.01M12 16a4 4 0 100-8 4 4 0 000 8z"/>
        </svg>

        <h1 class="text-2xl font-bold mb-2">Oops!</h1>
        <p class="mb-6 text-gray-600">
            Silahkan pilih data besi di menu input timbangan
        </p>

        <a href="{{ route('timbangan') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
           Pilih Data Timbangan
        </a>
    </div>
</x-admin-layout>

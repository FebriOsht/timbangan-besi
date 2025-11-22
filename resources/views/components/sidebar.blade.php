<aside class="w-64 bg-green-700 text-white min-h-screen p-5">
    <h1 class="text-2xl font-bold mb-8">LOGO</h1>

    <ul class="space-y-3">

        <li>
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 hover:bg-green-600 rounded">
                Dashboard
            </a>
        </li>

        <li x-data="{ open: false }" class="mt-4 text-sm uppercase opacity-70">
    <button 
        @click="open = !open" 
        class="w-full flex justify-between items-center px-3 py-2 hover:bg-green-600 rounded"
    >
        <span>Master Data</span>
        <span x-text="open ? '▲' : '▼'"></span>
    </button>

    <ul x-show="open" x-transition class="mt-2 space-y-1 pl-3 text-sm">
        <li>
            <a href="{{ route('master.user') }}" 
               class="block px-3 py-2 hover:bg-green-600 rounded">
                User
            </a>
        </li>

        <li>
            <a href="{{ route('master.pabrik') }}" class="block px-3 py-2 hover:bg-green-600 rounded">Pabrik</a>
        </li>

        <li>
            <a href="{{ route('master.customer') }}" class="block px-3 py-2 hover:bg-green-600 rounded">Customer</a>
        </li>

        <li>
            <a href="{{ route('master.diskon') }}" class="block px-3 py-2 hover:bg-green-600 rounded">Diskon</a>
        </li>

        <li>
            <a href="{{ route('master.besi') }}" class="block px-3 py-2 hover:bg-green-600 rounded">Besi</a>
        </li>
    </ul>
</li>


        <li class="mt-4"><a href="{{ route('timbangan') }}" class="block px-3 py-2 hover:bg-green-600 rounded">Input Timbangan</a></li>
        <li><a href="#" class="block px-3 py-2 hover:bg-green-600 rounded">Nota</a></li>
        <li><a href="#" class="block px-3 py-2 hover:bg-green-600 rounded">Mutasi Stok</a></li>
        <li><a href="#" class="block px-3 py-2 hover:bg-green-600 rounded">Stok Opname</a></li>
        <li><a href="#" class="block px-3 py-2 hover:bg-green-600 rounded">Laporan</a></li>

    </ul>

    <div class="absolute bottom-5 left-5 text-sm opacity-70">
        Pengaturan Akun
    </div>
</aside>

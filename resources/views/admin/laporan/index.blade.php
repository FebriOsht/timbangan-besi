<x-admin-layout title="Rekap Harian">

<div 
    x-data="{}"
    class="p-6 bg-white rounded-xl shadow-sm"
>

    {{-- ======================== --}}
    {{-- FILTER RANGE TANGGAL --}}
    {{-- ======================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        {{-- Tanggal Mulai --}}
        <div>
            <label class="block font-semibold mb-1">Tanggal Mulai</label>
            <input 
                type="date"
                class="w-full border rounded-lg p-2"
            >
        </div>

        {{-- Tanggal Selesai --}}
        <div>
            <label class="block font-semibold mb-1">Tanggal Selesai</label>
            <input 
                type="date"
                class="w-full border rounded-lg p-2"
            >
        </div>

        {{-- Tombol Cari --}}
        <div class="flex items-end">
            <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                CARI
            </button>
        </div>
    </div>

    {{-- ======================== --}}
    {{-- TOMBOL LAPORAN PEMBELIAN --}}
    {{-- ======================== --}}
    <div class="mb-6">
        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            Laporan Pembelian
        </button>
    </div>

    {{-- ======================== --}}
    {{-- TABEL REKAP --}}
    {{-- ======================== --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-green-600 text-white text-left">
                    <th class="p-3">ID penjualan</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Total Berat</th>
                    <th class="p-3">Total Barang</th>
                    <th class="p-3">Total Penjualan</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                {{-- Contoh Data 1 --}}
                <tr class="border-b">
                    <td class="p-3 text-green-700 font-semibold">
                        12563987563
                    </td>
                    <td class="p-3">1/11/2025</td>
                    <td class="p-3">20kg</td>
                    <td class="p-3">20</td>
                    <td class="p-3">Rp. 20.000.00</td>
                    <td class="p-3">
                        <button class="text-green-700 hover:text-green-900">
                            {{-- ICON DOWNLOAD --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5 7.5m0 0l7.5-7.5m-7.5 7.5V3" />
                            </svg>
                        </button>
                    </td>
                </tr>

                {{-- Contoh Data 2 --}}
                <tr class="border-b">
                    <td class="p-3 text-green-700 font-semibold">
                        12563987563
                    </td>
                    <td class="p-3">1/11/2025</td>
                    <td class="p-3">20kg</td>
                    <td class="p-3">20</td>
                    <td class="p-3">Rp. 20.000.00</td>
                    <td class="p-3">
                        <button class="text-green-700 hover:text-green-900">
                            {{-- ICON DOWNLOAD --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5 7.5m0 0l7.5-7.5m-7.5 7.5V3" />
                            </svg>
                        </button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</div>

</x-admin-layout>

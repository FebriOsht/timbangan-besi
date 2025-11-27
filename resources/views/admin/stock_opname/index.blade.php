<x-admin-layout title="Stock Opname">

<div 
    x-data="{
        selisihModal: false
    }"
    class="p-6 bg-white rounded-xl shadow-sm"
>

    {{-- FORM INPUT --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

        {{-- Jenis Besi --}}
        <div>
            <label class="block font-semibold mb-1">Jenis Besi</label>
            <select class="w-full border rounded-lg p-2">
                <option value="">Pilih Jenis Besi</option>
                <option>Besi</option>
                <option>Besi Plat</option>
                <option>Besi Siku</option>
            </select>
        </div>

        {{-- Stok Fisik --}}
        <div>
            <label class="block font-semibold mb-1">Stok Fisik</label>
            <input type="text" class="w-full border rounded-lg p-2" placeholder="Masukkan stok fisik">
        </div>

        {{-- Stok Sistem --}}
        <div>
            <label class="block font-semibold mb-1">Stok Sistem</label>
            <input type="text" class="w-full border rounded-lg p-2" placeholder="Masukkan stok sistem">
        </div>

        {{-- Lokasi --}}
        <div>
            <label class="block font-semibold mb-1">Lokasi</label>
            <select class="w-full border rounded-lg p-2">
                <option>Gudang A</option>
                <option>Gudang B</option>
            </select>
        </div>

        {{-- Selisih --}}
        <div>
            <label class="block font-semibold mb-1">Selisih</label>
            <input type="text" class="w-full border rounded-lg p-2" placeholder="Selisih otomatis">
        </div>

        {{-- Keterangan --}}
        <div class="md:col-span-2">
            <label class="block font-semibold mb-1">Keterangan</label>
            <input type="text" class="w-full border rounded-lg p-2" placeholder="Tambahkan keterangan">
        </div>

    </div>

    {{-- Tombol --}}
    <div class="flex gap-4 mb-8">
        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            Simpan
        </button>

        <button 
            @click="selisihModal = true"
            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700"
        >
            Selisih
        </button>
    </div>

    {{-- TABEL --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-green-600 text-white">
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Jenis</th>
                    <th class="p-3 text-left">Stok Sistem</th>
                    <th class="p-3 text-left">Stok Fisik</th>
                    <th class="p-3 text-left">Selisih</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <tr class="border-b">
                    <td class="p-3">1.</td>
                    <td class="p-3">2025-05-01</td>
                    <td class="p-3">Besi</td>
                    <td class="p-3">1.800 kg</td>
                    <td class="p-3">1.850 kg</td>
                    <td class="p-3 text-green-600 font-bold">+50</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Tombol Export --}}
    <div class="flex justify-center gap-4 mt-8">
        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            Eksport PDF
        </button>

        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            Eksport Excel
        </button>

        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            Kirim ke Pabrik
        </button>
    </div>




    {{-- ========================= --}}
    {{--         MODAL SELISIH     --}}
    {{-- ========================= --}}
    <div 
        x-show="selisihModal"
        x-transition
        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
    >
        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative">

            {{-- Close Button --}}
            <button 
                @click="selisihModal = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">
                &times;
            </button>

            <h2 class="text-xl font-semibold mb-4">Hitung Selisih Stock</h2>

            {{-- FORM DALAM MODAL --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
    <label class="block font-semibold mb-1">Jenis Besi</label>
    <select class="w-full border rounded-lg p-2 bg-white">
        <option value="">-- Pilih Jenis Besi --</option>
        <option value="Besi Beton">Besi Beton</option>
        <option value="Besi Hollow">Besi Hollow</option>
        <option value="Besi Siku">Besi Siku</option>
        <option value="Besi Plat">Besi Plat</option>
    </select>
</div>


                {{-- Stok Fisik --}}
                <div>
                    <label class="block font-semibold mb-1">Stok Fisik</label>
                    <input type="number" class="w-full border rounded-lg p-2" placeholder="Stok Fisik">
                </div>

                {{-- Stok Sistem --}}
                <div>
                    <label class="block font-semibold mb-1">Stok Sistem</label>
                    <input type="number" class="w-full border rounded-lg p-2" placeholder="Stok Sistem">
                </div>

                {{-- Hasil Selisih --}}
                <div class="col-span-2">
                    <label class="block font-semibold mb-1">Hasil Selisih</label>
                    <input type="text" class="w-full border rounded-lg p-2 bg-gray-100" placeholder="+/- otomatis" disabled>
                </div>

            </div>

            {{-- BUTTON --}}
            <div class="mt-6 flex justify-end gap-3">
                <button 
                    @click="selisihModal = false"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                    Batal
                </button>

                <button 
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Simpan
                </button>
            </div>

        </div>
    </div>




</div>
</x-admin-layout>

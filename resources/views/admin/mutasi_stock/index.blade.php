<x-admin-layout title="Form Mutasi Besi">

<div x-data class="max-w-4xl mx-auto">

    <!-- TITLE -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold">Form Mutasi Besi</h1>
        <p class="text-gray-600">Form untuk menyimpan data mutasi besi</p>
    </div>

    <!-- CARD WRAPPER -->
    <div class="bg-white shadow rounded-xl p-6 space-y-10">

        <!-- FORM INPUT -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Input Data</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block font-medium">Jenis Besi</label>
                    <input type="text"
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="Besi Siku">
                </div>

                <div>
                    <label class="block font-medium">Berat (kg)</label>
                    <input type="number"
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="100">
                </div>

                <div>
                    <label class="block font-medium">Dari</label>
                    <select class="w-full border rounded-lg px-3 py-2">
                        <option>Gudang A</option>
                        <option>Gudang B</option>
                        <option>Pabrik A</option>
                        <option>Pabrik B</option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium">Ke</label>
                    <select class="w-full border rounded-lg px-3 py-2">
                        <option>Pabrik A</option>
                        <option>Pabrik B</option>
                        <option>Rumah</option>
                        <option>Gedung</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block font-medium">Keterangan</label>
                    <input type="text"
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="Catatan tambahan">
                </div>

            </div>

            <button class="mt-5 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Simpan
            </button>
        </div>


        <!-- TABEL DATA -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Data Mutasi</h2>

            <div class="overflow-x-auto rounded-lg border">
                <table class="min-w-full text-left border-collapse">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Jenis</th>
                            <th class="px-4 py-2">Total Berat</th>
                            <th class="px-4 py-2">Dari</th>
                            <th class="px-4 py-2">Ke</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        <tr>
                            <td class="px-4 py-2">2025-05-01</td>
                            <td class="px-4 py-2">Besi</td>
                            <td class="px-4 py-2">1.890 kg</td>
                            <td class="px-4 py-2">Gudang A</td>
                            <td class="px-4 py-2">Pabrik A</td>
                        </tr>

                        <tr>
                            <td class="px-4 py-2">2025-09-03</td>
                            <td class="px-4 py-2">Seng</td>
                            <td class="px-4 py-2">1.800 kg</td>
                            <td class="px-4 py-2">Rumah</td>
                            <td class="px-4 py-2">Pabrik</td>
                        </tr>

                        <tr>
                            <td class="px-4 py-2">2025-07-06</td>
                            <td class="px-4 py-2">Besi B</td>
                            <td class="px-4 py-2">1.600 kg</td>
                            <td class="px-4 py-2">Gedung</td>
                            <td class="px-4 py-2">Pabrik B</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

</x-admin-layout>

<x-admin-layout title="Dashboard">

    <!-- RINGKASAN / SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">

        <div class="bg-green-600 text-white p-5 rounded-lg">
            <p class="text-sm">Total Stok Saat Ini</p>
            <h3 class="text-3xl font-bold mt-2">0</h3>
            <p class="text-xs opacity-80">besi</p>
        </div>

        <div class="bg-green-600 text-white p-5 rounded-lg">
            <p class="text-sm">Total Pembelian Hari Ini</p>
            <h3 class="text-3xl font-bold mt-2">0</h3>
            <p class="text-xs opacity-80">kg</p>
        </div>

        <div class="bg-green-600 text-white p-5 rounded-lg">
            <p class="text-sm">Total Penjualan Hari Ini</p>
            <h3 class="text-3xl font-bold mt-2">0</h3>
            <p class="text-xs opacity-80">kg</p>
        </div>

        <div class="bg-green-600 text-white p-5 rounded-lg">
            <p class="text-sm">Total Mutasi</p>
            <h3 class="text-3xl font-bold mt-2">0</h3>
        </div>

        <div class="bg-green-600 text-white p-5 rounded-lg">
            <p class="text-sm">Nilai Total Stok</p>
            <h3 class="text-3xl font-bold mt-2">Rp 0</h3>
        </div>

    </div>

    <!-- CHARTS -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        <div class="bg-white p-5 rounded-lg shadow">
            <h3 class="font-semibold mb-3">Berat Masuk vs Berat Keluar</h3>
            <div class="w-full h-64 flex items-center justify-center text-gray-400 border border-dashed rounded">
                Chart Placeholder
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow">
            <h3 class="font-semibold mb-3">Proporsi Jenis Besi</h3>
            <div class="w-full h-64 flex items-center justify-center text-gray-400 border border-dashed rounded">
                Donut Chart Placeholder
            </div>
        </div>

    </div>

    <div class="bg-white p-5 rounded-lg shadow">
        <h3 class="font-semibold mb-4">Transaksi Terbaru</h3>

        <table class="w-full table-auto text-left border-collapse">
            <thead>
                <tr class="border-b text-sm text-gray-500">
                    <th class="py-2">Order Number</th>
                    <th class="py-2">Date</th>
                    <th class="py-2">Product</th>
                    <th class="py-2">Customer</th>
                    <th class="py-2">Total Amount</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-400">
                        Belum ada transaksi
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</x-admin-layout>

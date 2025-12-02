<x-admin-layout title="Rekap Harian">

<div 
    x-data="laporanData()"
    class="p-6 bg-white rounded-xl shadow-sm"
>

    {{-- ======================== --}}
    {{-- SWITCHING CARD --}}
    {{-- ======================== --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        
        {{-- Card Pembelian --}}
        <div @click="activeTab = 'pembelian'; fetchData()"
            :class="activeTab === 'pembelian' 
                ? 'bg-green-600 text-white' 
                : 'bg-gray-100 text-gray-700'"
            class="p-5 rounded-xl shadow cursor-pointer transition">
            <h2 class="text-xl font-semibold">Laporan Pembelian</h2>
            <p class="text-sm opacity-80">Barang Masuk</p>
        </div>

        {{-- Card Penjualan --}}
        <div @click="activeTab = 'penjualan'; fetchData()"
            :class="activeTab === 'penjualan' 
                ? 'bg-green-600 text-white' 
                : 'bg-gray-100 text-gray-700'"
            class="p-5 rounded-xl shadow cursor-pointer transition">
            <h2 class="text-xl font-semibold">Laporan Penjualan</h2>
            <p class="text-sm opacity-80">Barang Keluar</p>
        </div>

    </div>

    {{-- ======================== --}}
    {{-- FILTER RANGE TANGGAL --}}
    {{-- ======================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        {{-- Tanggal Mulai --}}
        <div>
            <label class="block font-semibold mb-1">Tanggal Mulai</label>
            <input 
                type="date"
                x-model="date_start"
                class="w-full border rounded-lg p-2"
            >
        </div>

        {{-- Tanggal Selesai --}}
        <div>
            <label class="block font-semibold mb-1">Tanggal Selesai</label>
            <input 
                type="date"
                x-model="date_end"
                class="w-full border rounded-lg p-2"
            >
        </div>

        {{-- Tombol Cari --}}
        <div class="flex items-end">
            <button @click="fetchData()" 
                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                CARI
            </button>
        </div>
    </div>

    {{-- ======================== --}}
    {{-- TABEL REKAP --}}
    {{-- ======================== --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-green-600 text-white text-left">
                    <th class="p-3">Kode</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Customer / Pabrik</th>
                    <th class="p-3">Besi</th>
                    <th class="p-3">Berat</th>
                    <th class="p-3">Harga/Kg</th>
                    <th class="p-3">Total</th>
                </tr>
            </thead>

            <tbody class="text-gray-700" x-show="items.length > 0">
                <template x-for="row in items" :key="row.id">
                    <tr class="border-b">
                        <td class="p-3 text-green-700 font-semibold" x-text="row.kode"></td>
                        <td class="p-3" x-text="row.tanggal"></td>

                        <td class="p-3" x-text="
                            activeTab === 'pembelian' 
                                ? (row.pabrik?.nama ?? '-') 
                                : (row.customer?.nama ?? '-')
                        "></td>

                        <td class="p-3" x-text="row.besi?.nama ?? '-'"></td>

                        <td class="p-3" x-text="formatNumber(row.berat) + ' kg'"></td>

                        <td class="p-3" x-text="formatRupiah(row.harga)"></td>

                        <td class="p-3" x-text="formatRupiah(row.berat * row.harga)"></td>
                    </tr>
                </template>
            </tbody>

            <tbody x-show="items.length === 0">
                <tr>
                    <td colspan="7" class="p-5 text-center text-gray-500">
                        Tidak ada data.
                    </td>
                </tr>
            </tbody>

        </table>
    </div>

</div>

<script>
function laporanData() {
    return {
        activeTab: 'pembelian',
        date_start: '',
        date_end: '',
        items: [],

        fetchData() {
            let url = this.activeTab === 'pembelian'
                ? '{{ route("admin.laporan.pembelian") }}'
                : '{{ route("admin.laporan.penjualan") }}';

            fetch(url + '?date_start=' + this.date_start + '&date_end=' + this.date_end)
                .then(res => res.json())
                .then(data => this.items = data);
        },

        formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        },

        formatRupiah(num) {
            return "Rp " + new Intl.NumberFormat('id-ID').format(num);
        }
    };
}
</script>

</x-admin-layout>

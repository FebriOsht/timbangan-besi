<x-admin-layout title="Form Nota">

<div x-data="nota()" class="max-w-5xl mx-auto">

    <!-- TITLE -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold">Form Nota</h1>
        <p class="text-gray-600">Form pencatatan transaksi</p>
    </div>

    <!-- CARD WRAPPER -->
    <div class="bg-white shadow rounded-xl p-6 space-y-10">

        <!-- DATA NOTA -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Data Nota</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <div>
                    <label class="block font-medium">Nomor Nota</label>
                    <input type="text" 
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="Auto Generate"
                        disabled>
                </div>

                <div>
                    <label class="block font-medium">Tanggal Nota</label>
                    <input type="date" 
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block font-medium">Supplier / Pabrik</label>
                    <input type="text" 
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="Nama Supplier">
                </div>

                <div>
                    <label class="block font-medium">Customer</label>
                    <input type="text" 
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="Nama Customer">
                </div>

            </div>
        </div>

        <!-- TABEL BARANG -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">Data Barang</h2>
                <button 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
                    @click="openAddModal = true">
                    + Tambah Barang
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-3 py-2">Nama</th>
                            <th class="border px-3 py-2">Berat (kg)</th>
                            <th class="border px-3 py-2">Harga/kg</th>
                            <th class="border px-3 py-2">Potongan</th>
                            <th class="border px-3 py-2">Total</th>
                            <th class="border px-3 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- LOOP ITEM (isi dari timbangan -->
                        <template x-for="(item, index) in items" :key="index">
                            <tr>
                                <td class="border px-3 py-2" x-text="item.nama"></td>
                                <td class="border px-3 py-2" x-text="item.berat"></td>
                                <td class="border px-3 py-2" x-text="item.harga"></td>
                                <td class="border px-3 py-2" x-text="item.potongan"></td>
                                <td class="border px-3 py-2" x-text="item.total"></td>
                                <td class="border px-3 py-2">
                                    <button 
                                        @click="hapusItem(index)"
                                        class="bg-red-500 text-white px-2 py-1 rounded">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        </template>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- PEMBAYARAN -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Pembayaran</h2>

            <div class="flex gap-6 mb-4">
                <label class="flex items-center gap-2">
                    <input type="radio" name="pay" checked>
                    <span>Tunai</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="pay">
                    <span>Transfer</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="pay">
                    <span>Tempo</span>
                </label>
            </div>

            <div>
                <label class="block font-medium">Total Bayar (Rp)</label>
                <input type="text" 
                    class="w-full border rounded-lg px-3 py-2"
                    placeholder="20,000">
            </div>
        </div>

        <!-- BUTTONS -->
        <div class="flex flex-wrap items-center gap-4">

            <!-- SIMPAN -->
            <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Simpan
            </button>

            <!-- DROPDOWN ACTION -->
            <div class="relative" x-data="nota()">

                <button 
                    @click="toggleActionPlan()"
                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    <span x-text="selected"></span>
                </button>

                <div 
                    class="absolute right-0 bottom-full mb-2 w-44 bg-white border rounded-lg shadow-md p-2 z-20 space-y-1"
                    x-show="actionPlan"
                    @click.outside="actionPlan = false"
                    x-transition
                >
                    <button 
                        @click="pilih('Nota Pembelian')" 
                        class="block w-full bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 text-sm">
                        Nota Pembelian
                    </button>

                    <button 
                        @click="pilih('Nota Penjualan')" 
                        class="block w-full bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 text-sm">
                        Nota Penjualan
                    </button>
                </div>

            </div>

            <!-- CETAK -->
            <a href="{{ route('admin.nota.cetak') }}"
            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 inline-block">
                Simpan & Cetak Nota
            </a>

        </div>

    </div>


    <!-- MODAL TAMBAH BARANG -->
    <div 
        x-show="openAddModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
        x-transition
    >
        <div class="bg-white p-6 rounded-xl w-full max-w-md shadow">
            <h3 class="text-lg font-semibold mb-4">Tambah Barang Manual</h3>

            <div class="space-y-3">
                <input type="text" class="w-full border rounded-lg px-3 py-2" placeholder="Nama Barang" x-model="newItem.nama">
                <input type="number" class="w-full border rounded-lg px-3 py-2" placeholder="Berat" x-model="newItem.berat">
                <input type="number" class="w-full border rounded-lg px-3 py-2" placeholder="Harga per kg" x-model="newItem.harga">
                <input type="number" class="w-full border rounded-lg px-3 py-2" placeholder="Potongan" x-model="newItem.potongan">
            </div>

            <div class="flex justify-end mt-4 gap-2">
                <button 
                    @click="openAddModal = false"
                    class="px-4 py-2 border rounded-lg">
                    Batal
                </button>

                <button 
                    @click="tambahItem()"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Tambah
                </button>
            </div>
        </div>
    </div>

</div>

<script>
function nota() {
    // Data timbangan yang dikirim dari controller
    const timbangan = @json($timbangan ?? []);
    
    // Konversi timbangan ke format items
    const initialItems = timbangan.map(t => ({
        id: t.id,
        nama: t.besi?.nama || 'Besi',
        berat: t.berat,
        harga: t.harga,
        potongan: 0,
        total: (t.berat * t.harga)
    }));

    return {
        actionPlan: false,
        selected: 'Action',

        openAddModal: false,

        // list barang - populated dari timbangan
        items: initialItems,

        // barang baru
        newItem: { nama: '', berat: '', harga: '', potongan: '' },

        toggleActionPlan() {
            this.actionPlan = !this.actionPlan;
        },

        pilih(value) {
            this.selected = value;
            this.actionPlan = false;
        },

        tambahItem() {
            const total = (this.newItem.berat * this.newItem.harga) - (this.newItem.potongan || 0);

            this.items.push({
                ...this.newItem,
                total: total,
            });

            this.newItem = { nama: '', berat: '', harga: '', potongan: '' };
            this.openAddModal = false;
        },

        hapusItem(index) {
            this.items.splice(index, 1);
        }
    }
}
</script>

</x-admin-layout>

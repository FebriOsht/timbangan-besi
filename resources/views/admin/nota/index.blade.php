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

                <!-- NOMOR NOTA -->
                <div>
                    <label class="block font-medium">Nomor Nota</label>
                    <input type="text" 
                        class="w-full border rounded-lg px-3 py-2 bg-gray-100"
                        placeholder="Auto Generate"
                        disabled>
                </div>

                <!-- TANGGAL -->
                <div>
                    <label class="block font-medium">Tanggal Nota</label>
                    <input type="date" 
                        class="w-full border rounded-lg px-3 py-2"
                        x-model="tanggal_nota">
                </div>

                <!-- SUPPLIER / PABRIK -->
                <div class="relative">
                    <label class="block font-medium">Supplier / Pabrik</label>

                    <input type="text"
                        x-model="supplierQuery"
                        @input="searchSupplier"
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="Cari supplier (min. 3 huruf)">

                    <input type="hidden" name="supplier_id" x-model="supplier_id">

                    <div x-show="supplierResults.length > 0"
                        class="absolute border rounded bg-white shadow w-full max-h-40 overflow-y-auto z-50 mt-1">
                        
                        <template x-for="item in supplierResults" :key="item.id">
                            <div class="p-2 hover:bg-gray-200 cursor-pointer"
                                @click="selectSupplier(item)">
                                <span x-text="item.nama"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- CUSTOMER -->
                <div class="relative">
                    <label class="block font-medium">Customer</label>

                    <input type="text"
                        x-model="customerQuery"
                        @input="searchCustomer"
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="Cari customer (min. 3 huruf)">

                    <input type="hidden" name="customer_id" x-model="customer_id">

                    <div x-show="customerResults.length > 0"
                        class="absolute border rounded bg-white shadow w-full max-h-40 overflow-y-auto z-50 mt-1">

                        <template x-for="item in customerResults" :key="item.id">
                            <div class="p-2 hover:bg-gray-200 cursor-pointer"
                                @click="selectCustomer(item)">
                                <span x-text="item.nama"></span>
                            </div>
                        </template>
                    </div>
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
                        <tr class="text-center">
                            <th class="border px-3 py-2">Nama</th>
                            <th class="border px-3 py-2">Berat (kg)</th>
                            <th class="border px-3 py-2">Harga/kg</th>
                            <th class="border px-3 py-2">Potongan</th>
                            <th class="border px-3 py-2">Total</th>
                            <th class="border px-3 py-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <template x-for="(item, index) in items" :key="index">
                            <tr class="text-center">
                                <td class="border px-3 py-2 text-left" x-text="item.nama"></td>
                                <td class="border px-3 py-2" x-text="item.berat"></td>
                                <td class="border px-3 py-2" x-text="rupiah(item.harga)"></td>
                                <td class="border px-3 py-2" x-text="rupiah(item.potongan)"></td>
                                <td class="border px-3 py-2" x-text="rupiah(item.total)"></td>

                                <td class="border px-3 py-2 space-x-1">

                                    <!-- EDIT -->
                                    <button 
                                        @click="openEdit(index)"
                                        class="bg-yellow-500 text-white px-2 py-1 rounded">
                                        Edit
                                    </button>

                                    <!-- HAPUS -->
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
                    <input type="radio" name="pay" value="tunai" x-model="jenis_pembayaran">
                    <span>Tunai</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="pay" value="transfer" x-model="jenis_pembayaran">
                    <span>Transfer</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="pay" value="tempo" x-model="jenis_pembayaran">
                    <span>Tempo</span>
                </label>
            </div>

            <div>
                <label class="block font-medium">Total Bayar (Rp)</label>
                <input type="text"
                    x-model="total_bayar_display"
                    @input="updateTotalBayar"
                    class="w-full border rounded-lg px-3 py-2"
                    placeholder="Rp.0">
            </div>
        </div>

        <!-- BUTTONS -->
        <div class="flex flex-wrap items-center gap-4">

            <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Simpan
            </button>

            <div class="relative">

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
                        class="block w-full bg-green-500 text-white px-3 py-1 rounded-lg">
                        Nota Pembelian
                    </button>

                    <button 
                        @click="pilih('Nota Penjualan')" 
                        class="block w-full bg-green-500 text-white px-3 py-1 rounded-lg">
                        Nota Penjualan
                    </button>
                </div>

            </div>

            <a href="{{ route('admin.nota.cetak') }}"
                class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 inline-block">
                Simpan & Cetak Nota
            </a>

        </div>

    </div>

    <!-- ============================= -->
    <!-- MODAL TAMBAH BARANG -->
    <!-- ============================= -->
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
                <button @click="openAddModal = false" class="px-4 py-2 border rounded-lg">Batal</button>
                <button @click="tambahItem()" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Tambah</button>
            </div>
        </div>
    </div>




    <!-- ============================= -->
    <!-- MODAL EDIT BARANG -->
    <!-- ============================= -->
    <div 
        x-show="openEditModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
        x-transition
    >
        <div class="bg-white p-6 rounded-xl w-full max-w-md shadow">

            <h3 class="text-lg font-semibold mb-4">Edit Barang</h3>

            <div class="space-y-3">

                <!-- NAMA (READONLY) -->
                <input type="text"
                    class="w-full border rounded-lg px-3 py-2 bg-gray-200"
                    x-model="editItem.nama"
                    readonly>

                <!-- BERAT -->
                <input type="number"
                    class="w-full border rounded-lg px-3 py-2"
                    x-model="editItem.berat">

                <!-- HARGA (READONLY AWALNYA) -->
                <div>
                    <input 
                        type="number"
                        class="w-full border rounded-lg px-3 py-2"
                        :readonly="!editHargaEnabled"
                        x-model="editItem.harga">
                    
                    <button 
                        class="mt-2 px-3 py-1 bg-yellow-500 text-white rounded"
                        @click="editHargaEnabled = !editHargaEnabled">
                        Ubah Data Besi
                    </button>
                </div>

                <!-- POTONGAN -->
                <input type="number"
                    class="w-full border rounded-lg px-3 py-2"
                    x-model="editItem.potongan">

                <!-- TOTAL (READONLY) -->
                <input type="text"
                    class="w-full border rounded-lg px-3 py-2 bg-gray-200"
                    :value="rupiah(editItem.berat * editItem.harga - editItem.potongan)"
                    readonly>

            </div>

            <div class="flex justify-end mt-4 gap-2">
                <button @click="openEditModal = false" class="px-4 py-2 border rounded-lg">Batal</button>
                <button @click="simpanEdit()" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
            </div>

        </div>
    </div>

</div>



<script>
function nota() {

    const timbangan = @json($timbangan ?? []);

    const initialItems = timbangan.map(t => ({
        id: t.id,
        nama: t.besi?.nama || 'Besi',
        berat: t.berat,
        harga: t.harga,
        potongan: 0,
        total: (t.berat * t.harga),
    }));

    return {

        // FORM
        tanggal_nota: '{{ date("Y-m-d") }}',
        jenis_pembayaran: 'tunai',
        total_bayar: 0,
        total_bayar_display: "Rp.0",

        // MODAL
        openAddModal: false,
        openEditModal: false,

        // ITEMS
        items: initialItems,
        newItem: { nama: '', berat: '', harga: '', potongan: '' },

        editIndex: null,
        editItem: {},
        editHargaEnabled: false,

        // SEARCH SUPPLIER
        supplierQuery: "",
        supplierResults: [],
        supplier_id: "",
        searchSupplier() {
            if (this.supplierQuery.length < 3) {
                this.supplierResults = [];
                return;
            }
            let list = @json($pabrik);
            this.supplierResults = list.filter(item =>
                item.nama.toLowerCase().includes(this.supplierQuery.toLowerCase())
            );
        },
        selectSupplier(item) {
            this.supplierQuery = item.nama;
            this.supplier_id = item.id;
            this.supplierResults = [];
        },

        // SEARCH CUSTOMER
        customerQuery: "",
        customerResults: [],
        customer_id: "",
        searchCustomer() {
            if (this.customerQuery.length < 3) {
                this.customerResults = [];
                return;
            }
            let list = @json($customer);
            this.customerResults = list.filter(item =>
                item.nama.toLowerCase().includes(this.customerQuery.toLowerCase())
            );
        },
        selectCustomer(item) {
            this.customerQuery = item.nama;
            this.customer_id = item.id;
            this.customerResults = [];
        },

        // ACTION PLAN
        actionPlan: false,
        selected: "Action",
        toggleActionPlan() {
            this.actionPlan = !this.actionPlan;
        },
        pilih(value) {
            this.selected = value;
            this.actionPlan = false;
        },

        // TABLE ITEM
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
        },

        openEdit(index) {
            this.editIndex = index;
            this.editHargaEnabled = false;
            this.editItem = JSON.parse(JSON.stringify(this.items[index]));
            this.openEditModal = true;
        },

        simpanEdit() {
            this.editItem.total = (this.editItem.berat * this.editItem.harga) - (this.editItem.potongan || 0);
            this.items[this.editIndex] = this.editItem;
            this.openEditModal = false;
        },

        // TOTAL BAYAR FORMAT RUPIAH
        updateTotalBayar(e) {
            let angka = e.target.value.replace(/[^0-9]/g, '');
            this.total_bayar = angka;
            this.total_bayar_display = this.rupiah(angka);
        },

        rupiah(angka) {
            if (!angka) return "Rp.0";
            return "Rp." + new Intl.NumberFormat('id-ID').format(angka);
        },

    }
}
</script>

</x-admin-layout>

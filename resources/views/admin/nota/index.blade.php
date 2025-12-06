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

                {{-- PABRIK --}}
                @foreach ($timbangan->unique('pabrik_id') as $d)
                <div class="mb-3">
                    <label class="block font-medium">Pabrik</label>

                    <input type="text"
                        class="w-full border rounded-lg px-3 py-2 bg-gray-100"
                        value="{{ $d->pabrik->nama ?? '-' }}"
                        readonly>

                    <input type="hidden" name="pabrik_id" value="{{ $d->pabrik->id }}">
                </div>
                @endforeach

                {{-- CUSTOMER --}}
                @foreach ($timbangan->unique('customer_id') as $d)
                <div class="mb-3">
                    <label class="block font-medium">Customer</label>

                    <input type="text"
                        class="w-full border rounded-lg px-3 py-2 bg-gray-100"
                        value="{{ $d->customer->nama ?? '-' }}"
                        readonly>

                    <input type="hidden" name="customer_id" value="{{ $d->customer->id }}">
                </div>
                @endforeach

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

                    <!-- TOTAL ROW -->
                    <tfoot>
                        <tr class="text-center font-bold bg-gray-100">
                            <td colspan="4" class="border px-3 py-2 text-right">Total Barang</td>
                            <td class="border px-3 py-2" x-text="rupiah(totalBarang())"></td>
                            <td class="border px-3 py-2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- DISKON GLOBAL -->
<div class="mb-6">
    <h2 class="text-xl font-semibold mb-2">Diskon Global</h2>

    <div class="flex gap-3 items-center">

        <button 
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
            @click="openDiskonModal = true; cariDiskonTerdaftar()">
            Pilih Diskon
        </button>

        <div class="text-gray-700">
            <template x-if="diskonNama">
                <span x-text="diskonNama + ' (' + diskonPersen + '%)'"></span>
            </template>
            <template x-if="!diskonNama">
                <span class="text-gray-400">Belum memilih diskon</span>
            </template>
        </div>

    </div>
</div>


        <!-- RINGKASAN TOTAL -->
        <div class="mb-6 border p-4 rounded-lg bg-gray-50 space-y-2">
            <h2 class="text-xl font-semibold mb-2">Ringkasan</h2>

            <div class="flex justify-between">
                <span>Total Barang:</span>
                <span x-text="rupiah(totalBarang())"></span>
            </div>

            <div class="flex justify-between items-center gap-2">
                <span>Diskon Global:</span>
                <span x-text="rupiah(totalBarang() * diskonPersen/100)"></span>
            </div>

            <div class="flex justify-between items-center gap-2">
                <span>PPN 11%:</span>
                <button 
                    class="px-3 py-1 rounded text-white"
                    :class="ppn ? 'bg-green-600' : 'bg-gray-400'"
                    @click="ppn = !ppn">
                    <span x-text="ppn ? 'Ada' : 'Tidak'"></span>
                </button>
                <span x-text="rupiah(pajak())"></span>
            </div>

            <div class="flex justify-between font-bold text-lg">
                <span>Grand Total:</span>
                <span x-text="rupiah(grandTotal())"></span>
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

    <!-- ============================= -->
<!-- MODAL DISKON GLOBAL -->
<!-- ============================= -->
<div 
    x-show="openDiskonModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
    x-transition>

    <div class="bg-white p-6 rounded-xl w-full max-w-md shadow space-y-4">

        <h3 class="text-lg font-semibold">Pilih Diskon Global</h3>

        <!-- MODE -->
        <div>
            <label class="block font-medium">Jenis Diskon</label>
            <select x-model="diskonMode" class="w-full border px-3 py-2 rounded">
                <option value="terdaftar">Diskon Terdaftar</option>
                <option value="manual">Diskon Manual</option>
            </select>
        </div>

        <!-- ====================== -->
        <!-- DISKON TERDAFTAR -->
        <!-- ====================== -->
        <template x-if="diskonMode === 'terdaftar'">
            <div class="relative">

                <label class="block font-medium">Cari Diskon</label>
                <input type="text" x-model="searchDiskon"
                       @input.debounce.300="cariDiskonTerdaftar"
                       class="w-full border px-3 py-2 rounded"
                       placeholder="Ketik untuk mencari diskon... (nama atau persen)">

                <div x-show="listDiskon.length > 0"
                     class="absolute bg-white border mt-1 rounded shadow w-full max-h-40 overflow-y-auto z-50">

                    <template x-for="item in listDiskon" :key="item.id">
                        <div class="px-3 py-2 cursor-pointer hover:bg-gray-100"
                             @click="pilihDiskon(item)">
                            <span x-text="item.nama + ' (' + item.potongan + '%)'"></span>
                        </div>
                    </template>

                </div>
            </div>
        </template>

        <!-- ====================== -->
        <!-- DISKON MANUAL -->
        <!-- ====================== -->
        <template x-if="diskonMode === 'manual'">
            <div class="space-y-3">

                <input type="text" class="w-full border px-3 py-2 rounded"
                       placeholder="Nama Diskon" x-model="manualNama">

                <input type="number" class="w-full border px-3 py-2 rounded"
                       placeholder="Potongan (%)" x-model.number="manualPotongan">

                <button class="bg-green-600 text-white px-4 py-2 rounded w-full"
                        @click="simpanDiskonManual">
                    Simpan Diskon
                </button>

            </div>
        </template>

        <!-- CLOSE -->
        <div class="flex justify-end mt-4">
            <button @click="openDiskonModal = false" 
                    class="px-4 py-2 border rounded">
                Tutup
            </button>
        </div>

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
        // ==========================
        // DATA AWAL
        // ==========================
        tanggal_nota: '{{ date("Y-m-d") }}',
        jenis_pembayaran: 'tunai',

        total_bayar: 0,
        total_bayar_display: "Rp.0",

        // MODAL BARANG
        openAddModal: false,
        openEditModal: false,

        items: initialItems,
        newItem: { nama: '', berat: '', harga: '', potongan: '' },

        editIndex: null,
        editItem: {},
        editHargaEnabled: false,

        // ACTION PLAN
        actionPlan: false,
        selected: "Action",

        // ==========================
        // DISKON
        // ==========================
        openDiskonModal: false,
        diskonMode: "terdaftar",  // terdaftar | manual

        // terdaftar
        listDiskon: [],
        searchDiskon: "",
        diskonTerpilih: null,

        // fetch registered discounts (AJAX)
        cariDiskonTerdaftar() {
            // show all when empty or search
            var q = this.searchDiskon || '';
            fetch("{{ route('master.diskon.search') }}?q=" + encodeURIComponent(q))
                .then(res => res.json())
                .then(data => {
                    // normalize field names (nama, potongan)
                    this.listDiskon = data.map(d => ({ id: d.id, nama: d.nama, potongan: d.potongan }));
                })
                .catch(err => {
                    console.error('Gagal mengambil data diskon', err);
                });
        },

        // manual
        manualNama: "",
        manualPotongan: 0,

        // digunakan total
        diskonPersen: 0,
        diskonNama: "",

        // ==========================
        // FUNGSI DISKON
        // ==========================
        pilihDiskon(d) {
            // d = { id, nama, potongan }
            this.diskonTerpilih = d;
            this.diskonNama = d.nama;
            this.diskonPersen = d.potongan;
            this.openDiskonModal = false;
        },

        simpanDiskonManual() {
    fetch("{{ route('master.diskon.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            nama: this.manualNama,
            potongan: this.manualPotongan,
        })
    })
    .then(res => res.json())
    .then(data => {
        this.listDiskon.push(data); // langsung nambah ke list
        this.diskonNama = data.nama;
        this.diskonPersen = data.potongan;
        this.openDiskonModal = false;
    });
},


        // ==========================
        // FUNGSI ITEM BARANG
        // ==========================
        tambahItem() {
            const total = (this.newItem.berat * this.newItem.harga) - (this.newItem.potongan || 0);
            this.items.push({ ...this.newItem, total });
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
            this.editItem.total =
                (this.editItem.berat * this.editItem.harga) -
                (this.editItem.potongan || 0);

            this.items[this.editIndex] = this.editItem;
            this.openEditModal = false;
        },

        // ==========================
        // HITUNG TOTAL
        // ==========================
        totalBarang() {
            return this.items.reduce((sum, i) => sum + i.total, 0);
        },

        pajak() {
            const subtotal = this.totalBarang() - (this.totalBarang() * this.diskonPersen / 100);
            return this.ppn ? subtotal * 0.11 : 0;
        },

        grandTotal() {
            const subtotal = this.totalBarang() - (this.totalBarang()*this.diskonPersen/100);
            return subtotal + this.pajak();
        },

        // ==========================
        // PEMBAYARAN
        // ==========================
        updateTotalBayar(e) {
            let angka = e.target.value.replace(/[^0-9]/g, '');
            this.total_bayar = angka;
            this.total_bayar_display = this.rupiah(angka);
        },

        // ==========================
        // FORMAT RUPIAH
        // ==========================
        rupiah(angka) {
            if (!angka) return "Rp.0";
            return "Rp." + new Intl.NumberFormat('id-ID').format(angka);
        },

        hitungTotal() {}, // trigger reactivity jika diperlukan

        // ==========================
        // UI TOGGLE
        // ==========================
        toggleActionPlan() { 
            this.actionPlan = !this.actionPlan;
        },

        pilih(value) {
            this.selected = value;
            this.actionPlan = false;
        },
    };
}
</script>


</x-admin-layout>

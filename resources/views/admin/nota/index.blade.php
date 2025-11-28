<x-admin-layout title="Form Nota">

<div x-data="nota()" class="max-w-5xl mx-auto">

    <!-- TITLE -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold">Form Nota</h1>
        <p class="text-gray-600">Form pencatatan</p>
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
                        placeholder="12345">
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

        <!-- DATA TIMBANGAN -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Data Timbangan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block font-medium">Nama Barang</label>
                    <input type="text" 
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="Besi">
                </div>

                <div>
                    <label class="block font-medium">Harga per kg (Rp)</label>
                    <input type="text" 
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="20,000">
                </div>

                <div>
                    <label class="block font-medium">Total Berat (kg)</label>
                    <input type="text" 
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="1,000">
                </div>

                <div>
                    <label class="block font-medium">Potongan / Diskon</label>
                    <input type="text" 
                        class="w-full border rounded-lg px-3 py-2">
                </div>

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

            <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Simpan
            </button>

<div class="relative" x-data="nota()">

    <!-- TOMBOL UTAMA -->
    <button 
        @click="toggleActionPlan()"
        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
        <span x-text="selected"></span>
    </button>
    

    <!-- DROPDOWN KE ATAS -->
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



           <a href="{{ route('admin.nota.cetak') }}"
   class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 inline-block">
    Simpan & Cetak Nota
</a>


        </div>

    </div>
</div>

<script>
function nota() {
    return {
        actionPlan: false,
        selected: 'Action', // default text

        toggleActionPlan() {
            this.actionPlan = !this.actionPlan;
        },

        pilih(value) {
            this.selected = value;
            this.actionPlan = false; // tutup dropdown
        }
    }
}
</script>

</x-admin-layout>

<x-admin-layout title="Data Besi">

<div x-data="besiData()" class="pb-20">

    <!-- TITLE + BUTTON -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Data Besi</h2>

        <button @click="openAdd()"
            class="bg-green-600 text-white px-4 py-2 rounded">
            + New Stock
        </button>
    </div>

    <!-- SEARCH -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
        <input type="text" placeholder="Cari nama / jenis..."
            x-model="search"
            class="border p-2 rounded w-full">
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="py-3 px-2">No</th>
                    <th class="py-3 px-2">Kode</th>
                    <th class="py-3 px-2">Nama</th>
                    <th class="py-3 px-2">Jenis</th>
                    <th class="py-3 px-2">Lokasi</th>
                    <th class="py-3 px-2">Harga/kg</th>
                    <th class="py-3 px-2">Stok</th>
                    <th class="py-3 px-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <template x-for="(b, index) in filteredData()" :key="b.id">
                <tr class="border-b">
                    <td class="py-3 px-2" x-text="index + 1"></td>
                    <td class="py-3 px-2" x-text="b.kode"></td>
                    <td class="py-3 px-2" x-text="b.nama"></td>
                    <td class="py-3 px-2" x-text="b.jenis"></td>
                    <td class="py-3 px-2" x-text="b.pabrik ? b.pabrik.nama : '-'"></td>
                    <td class="py-3 px-2" x-text="formatRupiah(b.harga)"></td>
                    <td class="py-3 px-2" x-text="b.stok"></td>

                    <td class="py-3 px-2 text-center">
                        <div class="flex justify-center gap-2">

                            <button @click="openEdit(b)"
                                class="bg-blue-600 text-white p-2 rounded">
                                Edit
                            </button>

                            <form :id="'delete-'+b.id"
                                  :action="`/master/besi/${b.id}`"
                                  method="POST">
                                @csrf @method('DELETE')
                                <button type="button"
                                    @click="confirmDelete('delete-'+b.id)"
                                    class="bg-red-600 text-white p-2 rounded">
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- ================= MODAL TAMBAH ================= -->
    <div x-show="addModal" x-transition
        class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">

        <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="closeAdd()">
            <h2 class="font-bold mb-4">Tambah Besi</h2>

            <form action="{{ route('master.besi.store') }}" method="POST">
                @csrf

                <div class="grid gap-3">

                    <!-- CARI PABRIK -->
                    <div class="relative">
                        <label class="font-semibold">Cari Pabrik</label>
                        <input type="text"
                            x-model="searchPabrikQuery"
                            @input.debounce.300="searchPabrik"
                            class="w-full border p-2 rounded"
                            placeholder="Ketik nama pabrik...">

                        <input type="hidden" name="pabrik_id" x-model="pabrik_id">

                        <div x-show="searchPabrikResults.length"
                             class="absolute bg-white border rounded shadow w-full max-h-40 overflow-y-auto z-50">
                            <template x-for="item in searchPabrikResults" :key="item.id">
                                <div class="p-2 hover:bg-gray-200 cursor-pointer"
                                     @click="selectPabrik(item)">
                                    <span x-text="item.nama"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <input type="text" name="nama" required placeholder="Nama"
                        class="border p-2 rounded">

                    <input type="text" name="jenis" required placeholder="Jenis"
                        class="border p-2 rounded">

                    <input type="number" name="harga" required placeholder="Harga/kg"
                        class="border p-2 rounded">

                    <input type="number" name="stok" required placeholder="Stok"
                        class="border p-2 rounded">

                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="closeAdd()">Tutup</button>
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= MODAL EDIT ================= -->
    <div x-show="editModal" x-transition
        class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">

        <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="closeEdit()">
            <h2 class="font-bold mb-4">Edit Besi</h2>

            <form :action="`/master/besi/${editId}`" method="POST">
                @csrf @method('PUT')

                <div class="grid gap-3">

                    <!-- CARI PABRIK -->
                    <div class="relative">
                        <label class="font-semibold">Cari Pabrik</label>
                        <input type="text"
                            x-model="searchPabrikQuery"
                            @input.debounce.300="searchPabrik"
                            class="w-full border p-2 rounded">

                        <input type="hidden" name="pabrik_id" x-model="pabrik_id">

                        <div x-show="searchPabrikResults.length"
                             class="absolute bg-white border rounded shadow w-full max-h-40 overflow-y-auto z-50">
                            <template x-for="item in searchPabrikResults" :key="item.id">
                                <div class="p-2 hover:bg-gray-200 cursor-pointer"
                                     @click="selectPabrik(item)">
                                    <span x-text="item.nama"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <input type="number" name="harga" x-model="editHarga"
                        class="border p-2 rounded">

                    <input type="number" name="stok" x-model="editStok"
                        class="border p-2 rounded">

                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="closeEdit()">Tutup</button>
                    <button type="submit"
                        class="bg-orange-500 text-white px-4 py-2 rounded">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function besiData() {
    return {
        addModal: false,
        editModal: false,

        search: '',
        data: @json($data),

        searchPabrikQuery: '',
        searchPabrikResults: [],
        pabrik_id: null,

        editId: null,
        editHarga: '',
        editStok: '',

        openAdd() {
            this.resetPabrik();
            this.addModal = true;
        },
        closeAdd() { this.addModal = false; },

        openEdit(b) {
            this.editId = b.id;
            this.editHarga = b.harga;
            this.editStok = b.stok;
            this.pabrik_id = b.pabrik_id;
            this.searchPabrikQuery = b.pabrik ? b.pabrik.nama : '';
            this.editModal = true;
        },
        closeEdit() { this.editModal = false; },

        resetPabrik() {
            this.searchPabrikQuery = '';
            this.searchPabrikResults = [];
            this.pabrik_id = null;
        },

        searchPabrik(){
    if(this.searchPabrikQuery.length < 3){
        this.searchPabrikResults = [];
        return;
    }

    fetch("{{ route('pabrik.search') }}?q=" + encodeURIComponent(this.searchPabrikQuery))
        .then(res => res.json())
        .then(data => this.searchPabrikResults = data);
},


        selectPabrik(item) {
            this.searchPabrikQuery = item.nama;
            this.pabrik_id = item.id;
            this.searchPabrikResults = [];
        },

        filteredData() {
            return this.data.filter(x =>
                x.nama.toLowerCase().includes(this.search.toLowerCase()) ||
                x.jenis.toLowerCase().includes(this.search.toLowerCase())
            );
        },

        formatRupiah(n) {
            return "Rp" + new Intl.NumberFormat('id-ID').format(n);
        }
    }
}

function confirmDelete(id) {
    Swal.fire({
        title: "Yakin?",
        text: "Data akan dihapus permanen",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        confirmButtonText: "Hapus"
    }).then(res => {
        if (res.isConfirmed) document.getElementById(id).submit();
    });
}
</script>
@endpush

</x-admin-layout>

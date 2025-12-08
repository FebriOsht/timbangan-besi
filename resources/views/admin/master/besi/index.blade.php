<x-admin-layout title="Data Besi">

<div x-data="besiData()">

    <!-- TITLE + BUTTON -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Data Besi</h2>

        <button 
            @click="openAdd()"
            class="bg-green-600 text-white px-4 py-2 rounded">
            + New Stock
        </button>
    </div>

    <!-- SEARCH & FILTER -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">

        <input type="text" placeholder="Cari nama / jenis..."
            x-model="search"
            class="border p-2 rounded w-full">

        <div class="flex gap-2">
            <input type="number" placeholder="Harga min" x-model="minHarga" class="border p-2 rounded w-full">
            <input type="number" placeholder="Harga max" x-model="maxHarga" class="border p-2 rounded w-full">
        </div>

        <div class="flex gap-2">
            <input type="number" placeholder="Stok min" x-model="minStok" class="border p-2 rounded w-full">
            <input type="number" placeholder="Stok max" x-model="maxStok" class="border p-2 rounded w-full">
        </div>

    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-100">

                    <th class="py-3 px-2 cursor-pointer" @click="sort('no')">No</th>
                    <th class="py-3 px-2 cursor-pointer" @click="sort('kode')">ID</th>
                    <th class="py-3 px-2 cursor-pointer" @click="sort('nama')">Nama</th>
                    <th class="py-3 px-2 cursor-pointer" @click="sort('jenis')">Jenis</th>
                    <th class="py-3 px-2 cursor-pointer" @click="sort('harga')">Harga/kg</th>
                    <th class="py-3 px-2 cursor-pointer" @click="sort('stok')">Stok</th>
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
                    <td class="py-3 px-2" x-text="formatRupiah(b.harga)"></td>
                    <td class="py-3 px-2" x-text="b.stok"></td>

                    <td class="py-3 px-2 text-center">
                        <div class="flex justify-center items-center gap-2">

                            <button 
                                title="Edit"
                                @click="openEdit(b)"
                                class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4L18.5 2.5z" />
                                </svg>
                            </button>

                            <form :id="'delete-'+b.id" :action="`/master/besi/${b.id}`" method="POST">
                                @csrf @method('DELETE')
                                <button 
                                    type="button"
                                    @click="confirmDelete('delete-'+b.id)"
                                    title="Hapus"
                                    class="bg-red-600 text-white p-2 rounded hover:bg-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                </template>
            </tbody>
        </table>
    </div>


    <!-- MODAL TAMBAH -->
    <div 
        x-show="addModal"
        x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50"
    >
        <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="closeAdd()">

            <h2 class="font-bold mb-4">Tambah Besi</h2>

            <form action="{{ route('master.besi.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-3">

                    <p class="text-sm text-gray-600">Kode besi dibuat otomatis saat disimpan.</p>

                    <div>
                        <label class="block text-sm font-medium">Nama</label>
                        <input type="text" name="nama" required class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Jenis</label>
                        <input type="text" name="jenis" required class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Harga/kg</label>
                        <input type="number" name="harga" required class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Stok</label>
                        <input type="number" name="stok" required class="w-full border p-2 rounded">
                    </div>

                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="closeAdd()" class="px-4 py-2 border rounded bg-white text-gray-700">Tutup</button>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>

        </div>
    </div>



    <!-- MODAL EDIT -->
    <div 
        x-show="editModal"
        x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50"
    >
        <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="closeEdit()">

            <h2 class="font-bold mb-4">Edit Besi</h2>

            <form :action="`/master/besi/${editId}`" method="POST">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 gap-3">

                    <div>
                        <label class="block text-sm font-medium">Kode</label>
                        <input type="text" x-model="editKode" disabled class="w-full border p-2 rounded bg-gray-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Nama</label>
                        <input type="text" x-model="editNama" disabled class="w-full border p-2 rounded bg-gray-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Jenis</label>
                        <input type="text" x-model="editJenis" disabled class="w-full border p-2 rounded bg-gray-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Harga/kg</label>
                        <input type="number" name="harga" x-model="editHarga" class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Stok</label>
                        <input type="number" name="stok" x-model="editStok" class="w-full border p-2 rounded">
                    </div>

                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="closeEdit()" class="px-4 py-2 border rounded bg-white text-gray-700">Tutup</button>
                    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Update</button>
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
        minHarga: '',
        maxHarga: '',
        minStok: '',
        maxStok: '',

        sortField: '',
        sortAsc: true,

        data: @json($data),

        editId: null,
        editKode: '',
        editNama: '',
        editJenis: '',
        editHarga: '',
        editStok: '',

        openAdd() { this.addModal = true; },
        closeAdd() { this.addModal = false; },

        openEdit(b) {
            this.editId = b.id;
            this.editKode = b.kode;
            this.editNama = b.nama;
            this.editJenis = b.jenis;
            this.editHarga = b.harga;
            this.editStok = b.stok;
            this.editModal = true;
        },
        closeEdit() { this.editModal = false; },

        sort(field) {
            this.sortAsc = (this.sortField === field) ? !this.sortAsc : true;
            this.sortField = field;
        },

        filteredData() {
            let d = this.data;

            if (this.search) {
                d = d.filter(x => 
                    x.nama.toLowerCase().includes(this.search.toLowerCase()) ||
                    x.jenis.toLowerCase().includes(this.search.toLowerCase())
                );
            }

            if (this.minHarga) d = d.filter(x => x.harga >= this.minHarga);
            if (this.maxHarga) d = d.filter(x => x.harga <= this.maxHarga);

            if (this.minStok) d = d.filter(x => x.stok >= this.minStok);
            if (this.maxStok) d = d.filter(x => x.stok <= this.maxStok);

            if (this.sortField) {
                d = d.sort((a, b) => {
                    let fa = a[this.sortField];
                    let fb = b[this.sortField];
                    if (typeof fa === 'string') fa = fa.toLowerCase();
                    if (typeof fb === 'string') fb = fb.toLowerCase();
                    return this.sortAsc ? fa > fb ? 1 : -1 : fa < fb ? 1 : -1;
                });
            }

            return d;
        },

        formatRupiah(n) {
            return "Rp" + new Intl.NumberFormat('id-ID').format(n);
        }
    };
}

function confirmDelete(id) {
    Swal.fire({
        title: "Yakin ingin menghapus?",
        text: "Data tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((res) => {
        if (res.isConfirmed) document.getElementById(id).submit();
    });
}
</script>


@if(session('success_kode'))
<script>
Swal.fire({ title: "Kode Besi Dibuat!", text: "Kode: {{ session('success_kode') }}", icon: "success" });
</script>
@endif

@if(session('success_update'))
<script>
Swal.fire({ title: "Berhasil Diperbarui!", text: "Kode {{ session('success_update') }} berhasil diupdate!", icon: "success" });
</script>
@endif

@endpush

</x-admin-layout>

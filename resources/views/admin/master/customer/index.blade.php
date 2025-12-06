<x-admin-layout title="Data Customer">

<div x-data="customerPage()" class="pb-10">

    <!-- HEADER & ACTION -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Data Customer</h2>

        <button 
            @click="openAdd()"
            class="bg-green-600 text-white px-4 py-2 rounded flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            + Tambah Customer
        </button>
    </div>

    <!-- SEARCH & FILTER -->
    <div class="bg-white p-4 shadow rounded mb-4 flex flex-wrap items-center gap-3">
        <input 
            type="text" 
            placeholder="Cari nama / alamat / kontak..." 
            x-model="search"
            class="border p-2 rounded w-72"
        >

        <select x-model="filterHuruf" class="border p-2 rounded">
            <option value="">Filter: Semua huruf</option>
            @foreach(range('A','Z') as $h)
                <option value="{{ $h }}">{{ $h }}</option>
            @endforeach
        </select>

        <div class="ml-auto flex items-center gap-2">
            <span class="text-sm text-gray-500">Sort:</span>
            <button @click="setSort('nama')" class="px-2 py-1 border rounded text-sm">Nama</button>
            <button @click="setSort('kode_customer')" class="px-2 py-1 border rounded text-sm">Kode</button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="py-3 px-2 cursor-pointer" @click="setSort('kode_customer')">Kode <span x-text="sortField==='kode_customer' ? (sortDir==='asc' ? '↑' : '↓') : ''"></span></th>
                    <th class="py-3 px-2 cursor-pointer" @click="setSort('nama')">Nama Customer <span x-text="sortField==='nama' ? (sortDir==='asc' ? '↑' : '↓') : ''"></span></th>
                    <th class="py-3 px-2">Alamat</th>
                    <th class="py-3 px-2">Rekening Bank</th>
                    <th class="py-3 px-2">Kontak</th>
                    <th class="py-3 px-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <!-- use template x-for to render client-side filtered/sorted list FROM server page -->
                <template x-for="(c, i) in pagedList()" :key="c.id">
                    <tr class="border-b">
                       <td class="py-3 px-2 font-semibold text-blue-700" x-text="c.kode_customer"></td>
                        <td class="py-3 px-2" x-text="c.nama"></td>
                        <td class="py-3 px-2" x-text="c.alamat"></td>
                        <td class="py-3 px-2" x-text="c.rekening"></td>
                        <td class="py-3 px-2" x-text="c.kontak"></td>

                        <td class="py-3 px-2 text-center">
                            <div class="flex justify-center items-center gap-2">

                                <!-- EDIT -->
                                <button 
                                    title="Edit"
                                    @click="openEdit(c)"
                                    class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                                    <!-- pencil icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4L18.5 2.5z" />
                                    </svg>
                                </button>

                                <!-- DELETE -->
                                <form :id="'delete-'+c.id" :action="`/master/customer/${c.id}`" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button 
                                        type="button"
                                        @click="confirmDelete('delete-'+c.id)"
                                        title="Hapus"
                                        class="bg-red-600 text-white p-2 rounded hover:bg-red-700">
                                        <!-- trash icon -->
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

        <!-- PAGINATION (server) -->
        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div 
        x-show="addModal" 
        x-transition.opacity 
        class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50"
    >
        <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="closeAdd()">
            <h2 class="font-bold mb-4">Tambah Customer</h2>

            <form action="{{ route('master.customer.store') }}" method="POST" @submit="onSubmitAdd($event)">
                @csrf

                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <label class="block text-sm font-medium">Nama Customer</label>
                        <input type="text" name="nama" required class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Alamat</label>
                        <input type="text" name="alamat" class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Rekening Bank</label>
                        <input type="text" name="rekening" class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Kontak</label>
                        <input type="text" name="kontak" class="w-full border p-2 rounded">
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
            <h2 class="font-bold mb-4">Edit Customer</h2>

            <form :action="`/master/customer/${editId}`" method="POST">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <label class="block text-sm font-medium">Kode Customer</label>
                        <input type="text" x-model="editKode" disabled class="w-full border p-2 rounded bg-gray-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Nama Customer</label>
                        <input type="text" name="nama" x-model="editNama" required class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Alamat</label>
                        <input type="text" name="alamat" x-model="editAlamat" class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Rekening Bank</label>
                        <input type="text" name="rekening" x-model="editRekening" class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Kontak</label>
                        <input type="text" name="kontak" x-model="editKontak" class="w-full border p-2 rounded">
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="closeEdit()" class="px-4 py-2 border rounded bg-white text-gray-700">Tutup</button>
                    <button type="submit" class="bg-amber-500 text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function customerPage() {
    return {
        // modal & state
        addModal: false,
        editModal: false,
        editId: null,
        editKode: '',
        editNama: '',
        editAlamat: '',
        editRekening: '',
        editKontak: '',

        // filter / sort / search
        search: '',
        filterHuruf: '',
        sortField: '',
        sortDir: 'asc',

        // list from server (current page)
        list: @json($customers->items()),

        // helpers
        openAdd() {
            this.addModal = true;
        },
        closeAdd() {
            this.addModal = false;
        },
        openEdit(item) {
            this.editModal = true;
            this.editId = item.id;
            this.editKode = item.kode_customer ?? '';
            this.editNama = item.nama ?? '';
            this.editAlamat = item.alamat ?? '';
            this.editRekening = item.rekening ?? '';
            this.editKontak = item.kontak ?? '';
            // scroll modal top (optional)
        },
        closeEdit() {
            this.editModal = false;
        },

        // Search + Filter + Sort applied on client-side (current page)
        filteredList() {
            return this.list.filter(c => {
                const s = this.search.toLowerCase();
                const matchSearch = c.nama?.toLowerCase().includes(s) || c.alamat?.toLowerCase().includes(s) || c.kontak?.toLowerCase().includes(s);
                const matchHuruf = this.filterHuruf ? (c.nama && c.nama.toUpperCase().startsWith(this.filterHuruf)) : true;
                return matchSearch && matchHuruf;
            });
        },

        setSort(field) {
            if (this.sortField === field) {
                this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortField = field;
                this.sortDir = 'asc';
            }
        },

        sortedList() {
            const arr = [...this.filteredList()];
            if (!this.sortField) return arr;
            arr.sort((a,b) => {
                const fa = (a[this.sortField] ?? '').toString().toLowerCase();
                const fb = (b[this.sortField] ?? '').toString().toLowerCase();
                if (fa < fb) return this.sortDir === 'asc' ? -1 : 1;
                if (fa > fb) return this.sortDir === 'asc' ? 1 : -1;
                return 0;
            });
            return arr;
        },

        // for x-for rendering (paged current page)
        pagedList() {
            return this.sortedList();
        },

        // on submit add -> let server generate kode; allow normal POST
        onSubmitAdd(e) {
            // default submit allowed; kept hook for future client validations
        },

        confirmDelete(formId) {
            // wrapper to call global function in blade
            confirmDelete(formId);
        }
    }
}

// sweetalert delete function (global)
function confirmDelete(formId) {
    Swal.fire({
        title: "Yakin ingin menghapus?",
        text: "Data tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
                       const f = document.getElementById(formId);
            if (f) f.submit();
        }
    });
}
</script>
@endpush

</x-admin-layout>

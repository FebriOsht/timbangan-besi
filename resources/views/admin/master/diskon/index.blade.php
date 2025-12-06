<x-admin-layout title="Data Diskon">

<div x-data="{ 
    addModal: false, 
    editModal: false,
    editId: null,
    editKode: '',
    editNama: '',
    editPotongan: ''
}">
    
    <!-- HEADER -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Data Diskon</h2>

        <button 
            @click="addModal = true" 
            class="bg-green-600 text-white px-4 py-2 rounded">
            + Tambah Diskon
        </button>
    </div>


    <!-- SEARCH -->
    <form method="GET" action="" class="mb-4 flex gap-2">
        <input 
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama diskon..."
            class="border p-2 rounded w-64"
        />

        <button class="bg-blue-600 text-white px-4 rounded">
            Cari
        </button>

        <a href="{{ route('master.diskon') }}" 
           class="bg-gray-400 text-white px-4 rounded">
            Reset
        </a>
    </form>


    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">

                    <th class="py-3 px-2">No</th>

                    <th class="py-3 px-2">
                        <a href="?sort_by=kode_diskon&sort_dir={{ request('sort_dir') == 'asc' ? 'desc' : 'asc' }}">
                            Kode Diskon
                        </a>
                    </th>

                    <th class="py-3 px-2">
                        <a href="?sort_by=nama&sort_dir={{ request('sort_dir') == 'asc' ? 'desc' : 'asc' }}">
                            Nama Diskon
                        </a>
                    </th>

                    <th class="py-3 px-2">
                        <a href="?sort_by=potongan&sort_dir={{ request('sort_dir') == 'asc' ? 'desc' : 'asc' }}">
                            Potongan
                        </a>
                    </th>

                    <th class="py-3 px-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $d)
                <tr class="border-b">

                    <!-- NOMOR -->
                    <td class="py-3 px-2">
                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                    </td>

                    <td class="py-3 px-2">{{ $d->kode_diskon }}</td>
                    <td class="py-3 px-2">{{ $d->nama }}</td>
                    <td class="py-3 px-2">{{ $d->potongan }}%</td>

<td class="py-3 px-2 text-center">
    <div class="flex justify-center items-center gap-2">

        <!-- EDIT -->
        <button 
            title="Edit"
            @click="
                editModal = true;
                editId = '{{ $d->id }}';
                editKode = '{{ $d->kode_diskon }}';
                editNama = '{{ $d->nama }}';
                editPotongan = '{{ $d->potongan }}';
            "
            class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">

            <!-- pencil icon -->
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4L18.5 2.5z" />
            </svg>
        </button>


        <!-- DELETE -->
        <form 
            id="delete-{{ $d->id }}" 
            action="{{ route('master.diskon.destroy', $d->id) }}" 
            method="POST"
            class="inline">
            @csrf
            @method('DELETE')

            <button 
                type="button"
                @click="confirmDelete('delete-{{ $d->id }}')"
                title="Hapus"
                class="bg-red-600 text-white p-2 rounded hover:bg-red-700">
                
                <!-- trash icon -->
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </form>

    </div>
</td>

                </tr>
                @endforeach
            </tbody>

        </table>

        <div class="mt-4">
            {{ $data->links() }}
        </div>

    </div>


<!-- MODAL TAMBAH -->
<div 
    x-show="addModal" 
    x-transition.opacity 
    class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50"
>
    <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="addModal = false">
        <h2 class="font-bold mb-4">Tambah Diskon</h2>

        <form action="{{ route('master.diskon.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-3">

                <div>
                    <label class="block text-sm font-medium">Kode Diskon</label>
                    <input type="text" 
                           value="{{ $kodeBaru }}"
                           disabled
                           class="w-full border p-2 rounded bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-medium">Nama Diskon</label>
                    <input type="text" 
                           name="nama" 
                           required
                           class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Potongan (%)</label>
                    <input type="number" 
                           name="potongan" 
                           required
                           class="w-full border p-2 rounded">
                </div>

            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" 
                        @click="addModal = false" 
                        class="px-4 py-2 border rounded bg-white text-gray-700">
                    Tutup
                </button>

                <button type="submit" 
                        class="bg-green-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
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
    <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="editModal = false">
        <h2 class="font-bold mb-4">Edit Diskon</h2>

        <form :action="`/master/diskon/${editId}`" method="POST">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 gap-3">

                <div>
                    <label class="block text-sm font-medium">Kode Diskon</label>
                    <input type="text" 
                           x-model="editKode" 
                           disabled 
                           class="w-full border p-2 rounded bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-medium">Nama Diskon</label>
                    <input type="text" 
                           name="nama" 
                           x-model="editNama" 
                           required
                           class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Potongan (%)</label>
                    <input type="number" 
                           name="potongan" 
                           x-model="editPotongan" 
                           required
                           class="w-full border p-2 rounded">
                </div>

            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" 
                        @click="editModal = false" 
                        class="px-4 py-2 border rounded bg-white text-gray-700">
                    Tutup
                </button>

                <button type="submit" 
                        class="bg-amber-500 text-white px-4 py-2 rounded">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>


</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush

</x-admin-layout>

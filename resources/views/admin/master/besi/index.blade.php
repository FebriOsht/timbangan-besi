<x-admin-layout title="Data Besi">

<div x-data="{
    addModal: false,
    editModal: false,
    editId: null,
    editKode: '',
    editNama: '',
    editJenis: '',
    editHarga: '',
    editStok: ''
}">

    <!-- TITLE + BUTTON -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Data Besi</h2>

        <button 
            @click="addModal = true" 
            class="bg-green-600 text-white px-4 py-2 rounded">
            + New Stock
        </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-3 px-2">No</th>
                    <th class="py-3 px-2">ID</th>
                    <th class="py-3 px-2">Nama</th>
                    <th class="py-3 px-2">Jenis</th>
                    <th class="py-3 px-2">Harga/kg</th>
                    <th class="py-3 px-2">Stok</th>
                    <th class="py-3 px-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $b)
                <tr class="border-b">
                    <td class="py-3 px-2">{{ $loop->iteration }}</td>
                    <td class="py-3 px-2">{{ $b->kode }}</td>
                    <td class="py-3 px-2">{{ $b->nama }}</td>
                    <td class="py-3 px-2">{{ $b->jenis }}</td>
                    <td class="py-3 px-2">Rp{{ number_format($b->harga,0,',','.') }}</td>
                    <td class="py-3 px-2">{{ $b->stok }}</td>

                    <td class="py-3 px-2 flex justify-center gap-2">

                        <!-- EDIT -->
                        <button 
                            class="bg-blue-600 text-white px-3 py-1 rounded"
                            @click="
                                editModal = true;
                                editId = '{{ $b->id }}';
                                editKode = '{{ $b->kode }}';
                                editNama = '{{ $b->nama }}';
                                editJenis = '{{ $b->jenis }}';
                                editHarga = '{{ $b->harga }}';
                                editStok = '{{ $b->stok }}';
                            ">
                            ✎
                        </button>

                        <!-- DELETE -->
                        <form id="delete-{{ $b->id }}" action="{{ route('master.besi.destroy', $b->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button 
                                type="button"
                                onclick="confirmDelete('delete-{{ $b->id }}')" 
                                class="bg-red-600 text-white px-3 py-1 rounded">
                                🗑
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- MODAL TAMBAH -->
    <div x-show="addModal" 
         x-transition.opacity 
         class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">

        <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="addModal = false">
            <h2 class="font-bold mb-4">Tambah Besi</h2>

            <form action="{{ route('master.besi.store') }}" method="POST">
                @csrf

                <label>ID / Kode</label>
                <input type="text" name="kode" class="w-full border p-2 rounded mb-3" required>

                <label>Nama</label>
                <input type="text" name="nama" class="w-full border p-2 rounded mb-3" required>

                <label>Jenis</label>
                <input type="text" name="jenis" class="w-full border p-2 rounded mb-3" required>

                <label>Harga/kg</label>
                <input type="number" name="harga" class="w-full border p-2 rounded mb-3" required>

                <label>Stok</label>
                <input type="number" name="stok" class="w-full border p-2 rounded mb-3" required>

                <button class="bg-green-600 text-white px-3 py-2 rounded w-full">
                    Simpan
                </button>
            </form>

            <button @click="addModal = false" class="mt-2 text-sm text-gray-500">Tutup</button>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div x-show="editModal"
         x-transition.opacity 
         class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">

        <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="editModal = false">
            <h2 class="font-bold mb-4">Edit Besi</h2>

            <form :action="'/master/besi/' + editId" method="POST">
                @csrf @method('PUT')

                <label>ID / Kode</label>
                <input type="text" name="kode" x-model="editKode" class="w-full border p-2 rounded mb-3">

                <label>Nama</label>
                <input type="text" name="nama" x-model="editNama" class="w-full border p-2 rounded mb-3">

                <label>Jenis</label>
                <input type="text" name="jenis" x-model="editJenis" class="w-full border p-2 rounded mb-3">

                <label>Harga/kg</label>
                <input type="number" name="harga" x-model="editHarga" class="w-full border p-2 rounded mb-3">

                <label>Stok</label>
                <input type="number" name="stok" x-model="editStok" class="w-full border p-2 rounded mb-3">

                <button class="bg-blue-600 text-white px-3 py-2 rounded w-full">
                    Update
                </button>
            </form>

            <button @click="editModal = false" class="mt-2 text-sm text-gray-500">Tutup</button>
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

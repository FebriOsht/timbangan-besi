<x-admin-layout title="Input Timbangan">

<div x-data="{
    addModal: false,
    editModal: false,
    editId: null,
    editKode: '',
    editJenis: '',
    editBerat: '',
    editHarga: '',
    editStatus: '',

    openEdit(id, kode, jenis, berat, harga, status) {
        this.editId = id;
        this.editKode = kode;
        this.editJenis = jenis;
        this.editBerat = berat;
        this.editHarga = harga;
        this.editStatus = status;
        this.editModal = true;
    }
}">
    <!-- TITLE + BUTTON -->
    <div class="flex justify-between mb-4">
    <h2 class="text-xl font-bold">Input Timbangan</h2>

    <div class="flex gap-2">
        <!-- Tombol Tambah -->
        <button 
            @click="addModal = true" 
            class="bg-green-600 text-white px-4 py-2 rounded">
            + Tambah Data
        </button>

        <!-- Tombol CETAK NOTA -->
        <a href="{{ route('timbangan.cetak') }}" 
           target="_blank"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            🖨 Cetak Nota
        </a>
    </div>
</div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-3 px-2">No</th>
                    <th class="py-3 px-2">Kode</th>
                    <th class="py-3 px-2">Jenis</th>
                    <th class="py-3 px-2">Berat (kg)</th>
                    <th class="py-3 px-2">Harga/kg</th>
                    <th class="py-3 px-2">Status</th>
                    <th class="py-3 px-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $t)
                <tr class="border-b">
                    <td class="py-3 px-2">{{ $loop->iteration }}</td>
                    <td class="py-3 px-2">{{ $t->kode }}</td>
                    <td class="py-3 px-2">{{ $t->jenis }}</td>
                    <td class="py-3 px-2">{{ $t->berat }}</td>
                    <td class="py-3 px-2">Rp{{ number_format($t->harga,0,',','.') }}</td>
                    <td class="py-3 px-2">{{ $t->status }}</td>

                    <td class="py-3 px-2 flex justify-center gap-2">

                        <!-- EDIT -->
                        <button 
                            @click="openEdit(
                                '{{ $t->id }}',
                                '{{ $t->kode }}',
                                '{{ $t->jenis }}',
                                '{{ $t->berat }}',
                                '{{ $t->harga }}',
                                '{{ $t->status }}'
                            )"
                            class="bg-blue-600 text-white px-3 py-1 rounded">
                            ✎
                        </button>

                        <!-- DELETE -->
                        <form id="delete-{{ $t->id }}" action="{{ route('timbangan.destroy', $t->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button 
                                type="button"
                                onclick="confirmDelete('delete-{{ $t->id }}')" 
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
            <h2 class="font-bold mb-4">Tambah Timbangan</h2>

            <form action="{{ route('timbangan.store') }}" method="POST">
                @csrf

                <label>Kode</label>
                <input type="text" name="kode" class="w-full border p-2 rounded mb-3" required>

                <label>Jenis</label>
                <input type="text" name="jenis" class="w-full border p-2 rounded mb-3" required>

                <label>Berat (kg)</label>
                <input type="number" name="berat" class="w-full border p-2 rounded mb-3" required>

                <label>Harga/kg</label>
                <input type="number" name="harga" class="w-full border p-2 rounded mb-3" required>

                <label>Status</label>
                <select name="status" class="w-full border p-2 rounded mb-3">
                    <option value="Barang Masuk">Barang Masuk</option>
                    <option value="Barang Keluar">Barang Keluar</option>
                </select>

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
            <h2 class="font-bold mb-4">Edit Timbangan</h2>

            <form :action="'/timbangan/' + editId" method="POST">
                @csrf 
                @method('PUT')

                <label>Kode</label>
                <input type="text" x-model="editKode" name="kode" class="w-full border p-2 rounded mb-3" required>

                <label>Jenis</label>
                <input type="text" x-model="editJenis" name="jenis" class="w-full border p-2 rounded mb-3" required>

                <label>Berat (kg)</label>
                <input type="number" x-model="editBerat" name="berat" class="w-full border p-2 rounded mb-3" required>

                <label>Harga/kg</label>
                <input type="number" x-model="editHarga" name="harga" class="w-full border p-2 rounded mb-3" required>

                <label>Status</label>
                <select x-model="editStatus" name="status" class="w-full border p-2 rounded mb-3">
                    <option value="Barang Masuk">Barang Masuk</option>
                    <option value="Barang Keluar">Barang Keluar</option>
                </select>

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

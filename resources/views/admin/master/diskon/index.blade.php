<x-admin-layout title="Data Diskon">

<div x-data="{ 
    addModal: false, 
    editModal: false,
    editId: null,
    editNama: '',
    editPotongan: ''
}">

    <!-- TITLE & BUTTON -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Data Diskon</h2>

        <button 
            @click="addModal = true" 
            class="bg-green-600 text-white px-4 py-2 rounded">
            + Tambah Diskon
        </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-3 px-2">No</th>
                    <th class="py-3 px-2">Nama Diskon</th>
                    <th class="py-3 px-2">Potongan</th>
                    <th class="py-3 px-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $d)
                <tr class="border-b">
                    <td class="py-3 px-2">{{ $loop->iteration }}</td>
                    <td class="py-3 px-2">{{ $d->nama }}</td>
                    <td class="py-3 px-2">{{ $d->potongan }}%</td>

                    <td class="py-3 px-2 flex justify-center gap-2">

                        <!-- EDIT BUTTON -->
                        <button 
                            class="bg-blue-600 text-white px-3 py-1 rounded"
                            @click="
                                editModal = true;
                                editId = '{{ $d->id }}';
                                editNama = '{{ $d->nama }}';
                                editPotongan = '{{ $d->potongan }}';
                            ">
                            ✎
                        </button>

                        <!-- DELETE BUTTON -->
                        <form id="delete-{{ $d->id }}" 
                              action="{{ route('master.diskon.destroy', $d->id) }}" 
                              method="POST">
                            @csrf @method('DELETE')

                            <button 
                                type="button"
                                onclick="confirmDelete('delete-{{ $d->id }}')" 
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

    <!-- MODAL ADD -->
    <div x-show="addModal" 
         x-transition.opacity 
         class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center">

        <div class="bg-white p-6 rounded shadow-lg w-96" 
             @click.outside="addModal = false">

            <h2 class="font-bold mb-4">Tambah Diskon</h2>

            <form action="{{ route('master.diskon.store') }}" method="POST">
                @csrf

                <label>Nama Diskon</label>
                <input type="text" name="nama" class="w-full border p-2 rounded mb-3">

                <label>Potongan (%)</label>
                <input type="number" name="potongan" class="w-full border p-2 rounded mb-3">

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
         class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center">

        <div class="bg-white p-6 rounded shadow-lg w-96" 
             @click.outside="editModal = false">

            <h2 class="font-bold mb-4">Edit Diskon</h2>

            <form :action="'/master/diskon/' + editId" method="POST">
                @csrf @method('PUT')

                <label>Nama Diskon</label>
                <input type="text" name="nama" x-model="editNama" 
                       class="w-full border p-2 rounded mb-3">

                <label>Potongan (%)</label>
                <input type="number" name="potongan" x-model="editPotongan" 
                       class="w-full border p-2 rounded mb-3">

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

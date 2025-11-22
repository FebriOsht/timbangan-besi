<x-admin-layout title="Data Customer">

<div x-data="{ 
    addModal: false, 
    editModal: false, 
    editId: null,
    editNama: '',
    editAlamat: '',
    editRekening: '',
    editKontak: ''
}">

    <!-- TITLE & BUTTON -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Data Customer</h2>

        <button 
            @click="addModal = true" 
            class="bg-green-600 text-white px-4 py-2 rounded">
            + Tambah Customer
        </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-3 px-2">No</th>
                    <th class="py-3 px-2">Nama Customer</th>
                    <th class="py-3 px-2">Alamat</th>
                    <th class="py-3 px-2">Rekening Bank</th>
                    <th class="py-3 px-2">Kontak</th>
                    <th class="py-3 px-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($customers as $c)
                <tr class="border-b">
                    <td class="py-3 px-2">{{ $loop->iteration }}</td>
                    <td class="py-3 px-2">{{ $c->nama }}</td>
                    <td class="py-3 px-2">{{ $c->alamat }}</td>
                    <td class="py-3 px-2">{{ $c->rekening }}</td>
                    <td class="py-3 px-2">{{ $c->kontak }}</td>

                    <td class="py-3 px-2 flex justify-center gap-2">

                        <!-- EDIT -->
                        <button 
                            class="bg-blue-600 text-white px-3 py-1 rounded"
                            @click="
                                editModal = true;
                                editId = '{{ $c->id }}';
                                editNama = '{{ $c->nama }}';
                                editAlamat = '{{ $c->alamat }}';
                                editRekening = '{{ $c->rekening }}';
                                editKontak = '{{ $c->kontak }}';
                            ">
                            ✎
                        </button>

                        <!-- DELETE -->
                        <form id="delete-{{ $c->id }}" action="{{ route('master.customer.destroy', $c->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button 
                                type="button"
                                onclick="confirmDelete('delete-{{ $c->id }}')" 
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
         class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center">

        <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="addModal = false">
            <h2 class="font-bold mb-4">Tambah Customer</h2>

            <form action="{{ route('master.customer.store') }}" method="POST">
                @csrf

                <label>Nama Customer</label>
                <input type="text" name="nama" class="w-full border p-2 rounded mb-3">

                <label>Alamat</label>
                <input type="text" name="alamat" class="w-full border p-2 rounded mb-3">

                <label>Rekening Bank</label>
                <input type="text" name="rekening" class="w-full border p-2 rounded mb-3">

                <label>Kontak</label>
                <input type="text" name="kontak" class="w-full border p-2 rounded mb-3">

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

        <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="editModal = false">
            <h2 class="font-bold mb-4">Edit Customer</h2>

            <form :action="'/master/customer/' + editId" method="POST">
                @csrf @method('PUT')

                <label>Nama Customer</label>
                <input type="text" name="nama" x-model="editNama" class="w-full border p-2 rounded mb-3">

                <label>Alamat</label>
                <input type="text" name="alamat" x-model="editAlamat" class="w-full border p-2 rounded mb-3">

                <label>Rekening Bank</label>
                <input type="text" name="rekening" x-model="editRekening" class="w-full border p-2 rounded mb-3">

                <label>Kontak</label>
                <input type="text" name="kontak" x-model="editKontak" class="w-full border p-2 rounded mb-3">

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

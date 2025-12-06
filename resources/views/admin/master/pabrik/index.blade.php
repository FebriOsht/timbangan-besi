<x-admin-layout title="Data Pabrik">

<div x-data="{ 
    addModal: false, 
    editModal: false, 
    editId: null,
    editKode: '',
    editNama: '',
    editAlamat: '',
    editRekening: '',
    editKontak: '',
    search: '',
}">
    
    <!-- HEADER -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Data Pabrik</h2>

        <button 
            @click="addModal = true" 
            class="bg-green-600 text-white px-4 py-2 rounded">
            + Tambah Pabrik
        </button>
    </div>

    <!-- SEARCH -->
    <div class="flex gap-3 mb-4">
        <input 
            type="text" 
            placeholder="Cari nama pabrik..." 
            x-model="search"
            class="border p-2 rounded w-64"
        >
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="py-3 px-2">Kode</th>
                    <th class="py-3 px-2">Nama Pabrik</th>
                    <th class="py-3 px-2">Alamat</th>
                    <th class="py-3 px-2">Rekening Bank</th>
                    <th class="py-3 px-2">Kontak PIC</th>
                    <th class="py-3 px-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($pabriks as $index => $p)
                <tr 
                    class="border-b"
                    x-show="
                        search === '' ||
                        '{{ strtolower($p->nama) }}'.includes(search.toLowerCase())
                    "
                >
                    <td class="py-3 px-2 font-semibold text-blue-700">{{ $p->kode_pabrik }}</td>
                    <td class="py-3 px-2">{{ $p->nama }}</td>
                    <td class="py-3 px-2">{{ $p->alamat }}</td>
                    <td class="py-3 px-2">{{ $p->rekening }}</td>
                    <td class="py-3 px-2">{{ $p->kontak }}</td>

                    <td class="py-3 px-2 text-center">
                        <div class="flex justify-center items-center gap-2">

                            <!-- EDIT -->
                            <button 
                                title="Edit"
                                @click="
                                    editModal = true;
                                    editId = '{{ $p->id }}';
                                    editKode = '{{ $p->kode_pabrik }}';
                                    editNama = '{{ $p->nama }}';
                                    editAlamat = '{{ $p->alamat }}';
                                    editRekening = '{{ $p->rekening }}';
                                    editKontak = '{{ $p->kontak }}';
                                "
                                class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4L18.5 2.5z" />
                                </svg>
                            </button>

                            <!-- DELETE -->
                            <form id="delete-{{ $p->id }}" action="{{ route('master.pabrik.destroy', $p->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button 
                                    type="button"
                                    onclick="confirmDelete('delete-{{ $p->id }}')"
                                    title="Hapus"
                                    class="bg-red-600 text-white p-2 rounded hover:bg-red-700"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
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
            {{ $pabriks->links() }}
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div 
        x-show="addModal" 
        x-transition.opacity 
        class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50"
    >
        <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="addModal = false">
            <h2 class="font-bold mb-4">Tambah Pabrik</h2>

            <form action="{{ route('master.pabrik.store') }}" method="POST">
                @csrf

                <label>Nama Pabrik</label>
                <input type="text" name="nama" class="w-full border p-2 rounded mb-3">

                <label>Alamat</label>
                <input type="text" name="alamat" class="w-full border p-2 rounded mb-3">

                <label>Rekening Bank</label>
                <input type="text" name="rekening" class="w-full border p-2 rounded mb-3">

                <label>Kontak PIC</label>
                <input type="text" name="kontak" class="w-full border p-2 rounded mb-3">

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="addModal = false" class="px-4 py-2 border rounded">Tutup</button>
                    <button class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
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
            <h2 class="font-bold mb-4">Edit Pabrik</h2>

            <form :action="'/master/pabrik/' + editId" method="POST">
                @csrf @method('PUT')

                <label class="font-semibold">Kode Pabrik</label>
                <input type="text" x-model="editKode" disabled class="w-full border p-2 rounded mb-3">

                <label>Nama Pabrik</label>
                <input type="text" name="nama" x-model="editNama" class="w-full border p-2 rounded mb-3">

                <label>Alamat</label>
                <input type="text" name="alamat" x-model="editAlamat" class="w-full border p-2 rounded mb-3">

                <label>Rekening Bank</label>
                <input type="text" name="rekening" x-model="editRekening" class="w-full border p-2 rounded mb-3">

                <label>Kontak PIC</label>
                <input type="text" name="kontak" x-model="editKontak" class="w-full border p-2 rounded mb-3">

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="editModal = false" class="px-4 py-2 border rounded">Tutup</button>
                    <button class="bg-amber-500 text-white px-4 py-2 rounded">Update</button>
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

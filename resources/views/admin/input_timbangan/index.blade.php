<x-admin-layout title="Data Timbangan Besi">

<div x-data="notaBesi()" class="pb-20">

    <!-- TITLE + ADD BUTTON -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Data Timbangan Besi</h2>

        <button @click="openAddModal()" 
            class="bg-green-600 text-white px-4 py-2 rounded shadow">
            + New Timbangan
        </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg p-6">
        <table id="tabel-besi" class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-100 text-sm">
                    <th class="py-3 px-2">No</th>
                    <th class="py-3 px-2">ID Timbangan</th>
                    <th class="py-3 px-2">Jenis</th>
                    <th class="py-3 px-2">Berat</th>
                    <th class="py-3 px-2">Harga/kg</th>
                    <th class="py-3 px-2">Status</th>
                    <th class="py-3 px-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $b)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-2">{{ $loop->iteration }}</td>
                    <td class="py-3 px-2">{{ $b->kode }}</td>
                    <td class="py-3 px-2">
    {{ $b->besi->nama ?? '-' }} | {{ $b->besi->jenis ?? '-' }}
</td>

                    <td class="py-3 px-2">{{ $b->berat }}</td>
                    <td class="py-3 px-2">Rp{{ number_format($b->harga,0,',','.') }}</td>
                    <td class="py-3 px-2">{{ $b->status }}</td>

                    <td class="py-3 px-2 flex justify-center gap-2">

                        <!-- EDIT -->
                        <button 
                            class="bg-blue-600 text-white px-3 py-1 rounded"
                            @click="openEditModal(
                                {{ $b->id }},
                                '{{ $b->kode }}',
                                '{{ $b->jenis }}',
                                '{{ $b->harga }}',
                                '{{ $b->berat }}',
                                '{{ $b->status }}',
                                {{ $b->besi_id }}
                            )">
                            ✎
                        </button>

                        <!-- DELETE -->
                        <form id="delete-{{ $b->id }}" action="{{ route('timbangan.destroy', $b->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button"
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




    <!-- ====================================================== -->
    <!-- =============== MODAL TAMBAH TIMBANGAN =============== -->
    <!-- ====================================================== -->
<div x-show="addModal"
    x-transition.opacity 
    class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded shadow-lg w-96 relative" @click.outside="addModal = false">

        <button @click="addModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-black">
            ✕
        </button>

        <h2 class="font-bold mb-4">Tambah Timbangan</h2>

        <form action="{{ route('timbangan.store') }}" method="POST">
            @csrf

            <!-- SEARCH BESI -->
            <label class="font-semibold">Cari Jenis Besi</label>
            <input type="text" 
                   x-model="searchQuery"
                   @input="searchBesi"
                   class="w-full border p-2 rounded mb-1"
                   placeholder="Ketik minimal 4 huruf...">

            <!-- Hidden input to hold selected besi id -->
            <input type="hidden" name="besi_id" x-model="besi_id">

            <!-- DROPDOWN -->
            <div x-show="searchResults.length > 0" 
                 class="border rounded bg-white shadow absolute w-80 max-h-40 overflow-y-auto z-50">
                <template x-for="item in searchResults" :key="item.id">
                    <div class="p-2 hover:bg-gray-200 cursor-pointer"
                         @click="selectBesi(item)">
                        <span x-text="item.nama + ' (' + item.jenis + ')'"></span>
                    </div>
                </template>
            </div>

            <!-- FORM FIELD -->
            <label class="mt-4 block font-semibold">Nama</label>
            <input type="text" name="nama" x-model="nama" 
                   class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>

            <label class="font-semibold">Jenis</label>
            <input type="text" name="jenis" x-model="jenis" 
                   class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>

            <label class="font-semibold">Harga/kg</label>
            <input type="number" name="harga" x-model="harga" 
                   class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>
            
            <label class="font-semibold">Sisa stok</label>
            <input type="number" name="stok" x-model="stok" 
                   class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>

            <label class="font-semibold">Berat (kg)</label>
            <input type="number" name="berat" class="w-full border p-2 rounded mb-3" required>

            <label class="font-semibold">Status</label>
            <select name="status" class="w-full border p-2 rounded mb-3" required>
                <option value="">-- Pilih Status --</option>
                <option value="Barang Masuk">Barang Masuk</option>
                <option value="Barang Keluar">Barang Keluar</option>
            </select>

            <button type="button"
                @click="enableEdit()"
                class="bg-yellow-500 text-white px-3 py-2 rounded w-full mb-2">
                Edit Kolom
            </button>

            <button class="bg-green-600 text-white px-3 py-2 rounded w-full">
                Simpan
            </button>

        </form>

    </div>
</div>





    <!-- ====================================================== -->
    <!-- ================ MODAL EDIT TIMBANGAN ================ -->
    <!-- ====================================================== -->
    <div x-show="editModal"
        x-transition.opacity 
        class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">

        <div class="bg-white p-6 rounded shadow-lg w-96 relative" @click.outside="editModal = false">

            <button @click="editModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-black">
                ✕
            </button>

            <h2 class="font-bold mb-4">Edit Timbangan</h2>

            <form :action="'/timbangan/' + editId" method="POST">
                @csrf @method('PUT')

                <!-- Hidden besi_id so controller receives which besi is associated -->
                <input type="hidden" name="besi_id" x-model="editBesiId">

                <label>ID Timbangan</label>
                <input type="text" x-model="editKode" class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>

                <label>Jenis</label>
                <input type="text" x-model="editJenis" name="jenis" class="w-full border p-2 rounded mb-3">

                <label>Harga/kg</label>
                <input type="number" x-model="editHarga" name="harga" class="w-full border p-2 rounded mb-3">

                <label>Berat</label>
                <input type="number" x-model="editBerat" name="berat" class="w-full border p-2 rounded mb-3">

                <label>Status</label>
                <select name="status" class="w-full border p-2 rounded mb-3" required>
                    <option :selected="editStatus === 'Barang Masuk'" value="Barang Masuk">Barang Masuk</option>
                    <option :selected="editStatus === 'Barang Keluar'" value="Barang Keluar">Barang Keluar</option>
                </select>

                <button class="bg-blue-600 text-white px-3 py-2 rounded w-full">
                    Update
                </button>
            </form>

        </div>
    </div>

</div>




@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
function confirmDelete(id){
    Swal.fire({
        title:"Yakin ingin menghapus?",
        icon:"warning",
        showCancelButton:true,
        confirmButtonColor:"#d33",
        cancelButtonColor:"#3085d6",
        confirmButtonText:"Hapus",
        cancelButtonText:"Batal",
    }).then(res=>{
        if(res.isConfirmed){
            document.getElementById(id).submit();
        }
    });
}


/* SWEETALERT TAMBAH */
@if(session('success_kode'))
Swal.fire({
    title:"Timbangan Baru!",
    text:"Kode: {{ session('success_kode') }}",
    icon:"success",
});
@endif

/* SWEETALERT UPDATE */
@if(session('success_update'))
Swal.fire({
    title:"Berhasil Diperbarui!",
    text:"Timbangan dengan ID {{ session('success_update') }} berhasil diupdate!",
    icon:"success",
});
@endif
</script>


<script>
$(document).ready(function() {
    $('#tabel-besi').DataTable({
        pageLength: 10,
        scrollCollapse: true,
    });
});
</script>


<!-- ALPINE.JS -->
<script>
function notaBesi(){
    return {
        addModal:false,
        editModal:false,

        // ADD FORM
        nama:'',
        jenis:'',
        harga:'',
        besi_id:'',
        berat:'',
        searchQuery:'',
        searchResults:[],

        // EDIT FORM
        editId:'',
        editKode:'',
        editJenis:'',
        editHarga:'',
        editBerat:'',
        editStatus:'',
        editBesiId:'',

        openAddModal(){
            this.addModal=true;
            this.nama='';
            this.jenis='';
            this.harga='';
            this.berat='';
            this.searchQuery='';
            this.searchResults=[];
        },

        openEditModal(id,kode,jenis,harga,berat,status,besiId){
            this.editModal=true;
            this.editId=id;
            this.editKode=kode;
            this.editJenis=jenis;
            this.editHarga=harga;
            this.editBerat=berat;
            this.editStatus=status;
            this.editBesiId = besiId;
        },

        enableEdit(){
            document.querySelectorAll('input[readonly]').forEach(el=>{
                el.removeAttribute('readonly');
                el.classList.remove('bg-gray-100', 'cursor-not-allowed');
            });
        },

        searchBesi(){
            if(this.searchQuery.length < 4){
                this.searchResults=[];
                return;
            }

            fetch("{{ route('besi.search') }}?q=" + encodeURIComponent(this.searchQuery))
            .then(res=>res.json())
            .then(data=>{
                this.searchResults=data;
            });
        },

        selectBesi(item){
            this.nama=item.nama;
            this.jenis=item.jenis;
            this.harga=item.harga;
            this.stok=item.stok;
            this.besi_id = item.id;
            this.searchQuery=item.nama;
            this.searchResults=[];
        }
    }
}
</script>

@endpush

</x-admin-layout>

<x-admin-layout title="Data Timbangan Besi">

<div x-data="notaBesi()" class="pb-20">

    <!-- HEADER + BUTTON -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Data Timbangan Besi</h2>

        <div class="flex gap-2">

            <!-- BUTTON TAMBAH -->
            <button 
                @click="openAddModal()" 
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                <span>New Timbangan</span>
            </button>

            <!-- BUTTON CETAK -->
<button 
    type="button"
    onclick="confirmCetakNota()"
    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">

    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M6 9V2h12v7m-2 4h-8v6h8v-6m4-2H4v10h4m8 0h4V11z" />
    </svg>

    <span>Cetak Nota Timbangan</span>
</button>

<!-- BUTTON TRANSFER -->
<button 
    type="button"
    onclick="confirmTransferKeNotaTransaksi()"
    class="flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg shadow transition">
    
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13 5l7 7-7 7M5 5l7 7-7 7" />
    </svg>

    <span>Transfer ke Nota Transaksi</span>
</button>


        </div>
    </div>


    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg p-6">
        <table id="tabel-besi" class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-100 text-sm">

                    <th class="py-3 px-2 text-center">
                        <input type="checkbox" id="checkAll" class="w-4 h-4 cursor-pointer">
                    <th class="py-3 px-2">Status</th>
                    

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

                    <td class="py-3 px-2 text-center">
                        <input 
                            type="checkbox" 
                            class="row-check w-4 h-4 cursor-pointer"
                            value="{{ $b->id }}">
                    </td>
                    <td class="py-3 px-2">

    {{-- Status Cetak --}}
    @if($b->is_cetak)
        <span class="px-2 py-1 text-xs rounded-lg bg-blue-100 text-blue-700">
            Sudah Cetak
        </span>
    @else
        <span class="px-2 py-1 text-xs rounded-lg bg-gray-200 text-gray-700">
            Belum Cetak
        </span>
    @endif

    {{-- Status Transfer --}}
    @if($b->is_transfer)
        <span class="px-2 py-1 text-xs rounded-lg bg-green-100 text-green-700 ml-1">
            Sudah Transfer
        </span>
    @else
        <span class="px-2 py-1 text-xs rounded-lg bg-amber-100 text-amber-700 ml-1">
            Belum Transfer
        </span>
    @endif

</td>


                    <td class="py-3 px-2">{{ $b->kode }}</td>
                    <td class="py-3 px-2">{{ $b->besi->nama ?? '-' }} | {{ $b->besi->jenis ?? '-' }}</td>
                    <td class="py-3 px-2">{{ $b->berat }}</td>
                    <td class="py-3 px-2">Rp{{ number_format($b->harga,0,',','.') }}</td>
                    <td class="py-3 px-2">{{ $b->status }}</td>

                    <td class="py-3 px-2 flex justify-center gap-2">

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

                        <form id="delete-{{ $b->id }}" 
                            action="{{ route('timbangan.destroy', $b->id) }}" 
                            method="POST">
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
    <!-- ================= MODAL TAMBAH ======================== -->
    <!-- ====================================================== -->
    <div x-show="addModal"
        x-transition.opacity 
        class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">

        <div class="bg-white p-6 rounded shadow-lg w-96 relative" @click.outside="addModal=false">

            <button @click="addModal=false" class="absolute top-2 right-2 text-gray-500 hover:text-black">
                ✕
            </button>

            <h2 class="font-bold mb-4">Tambah Timbangan</h2>

            <form action="{{ route('timbangan.store') }}" method="POST">
                @csrf

                <!-- SEARCH -->
                <label class="font-semibold">Cari Jenis Besi</label>
                <input type="text" 
                    x-model="searchQuery"
                    @input="searchBesi"
                    class="w-full border p-2 rounded mb-1"
                    placeholder="Ketik minimal 4 huruf...">

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

                <!-- FIELD OTOMATIS -->
                <label class="mt-4 block font-semibold">Nama</label>
                <input type="text" name="nama" x-model="nama"
                    class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>

                <label class="font-semibold">Jenis</label>
                <input type="text" name="jenis" x-model="jenis"
                    class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>

                <label class="font-semibold">Harga/kg</label>
                <input type="number" name="harga" x-model="harga"
                    class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>

                <label class="font-semibold">Sisa Stok</label>
                <input type="number" name="stok" x-model="stok"
                    class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>

                <!-- INPUT MANUAL -->
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
<!-- ====================== MODAL EDIT ===================== -->
<!-- ====================================================== -->
<div x-show="editModal"
    x-transition.opacity 
    class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded shadow-lg w-96 relative" @click.outside="editModal=false">

        <button @click="editModal=false" class="absolute top-2 right-2 text-gray-500 hover:text-black">
            ✕
        </button>

        <h2 class="font-bold mb-4">Edit Timbangan</h2>

        <form :action="'/timbangan/' + editId" method="POST">
            @csrf @method('PUT')

            <!-- ID TIMBANGAN -->
            <label class="font-semibold">ID Timbangan</label>
            <input type="text" x-model="editKode"
                class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>

            <!-- SEARCH -->
            <label class="font-semibold">Cari Jenis Besi</label>
            <input type="text" 
                x-model="editSearchQuery"
                @input="editSearchBesi"
                class="w-full border p-2 rounded mb-1"
                placeholder="Ketik minimal 4 huruf...">

            <input type="hidden" name="besi_id" x-model="editBesiId">

            <!-- DROPDOWN SEARCH -->
            <div x-show="editSearchResults.length > 0"
                class="border rounded bg-white shadow absolute w-80 max-h-40 overflow-y-auto z-50">
                <template x-for="item in editSearchResults" :key="item.id">
                    <div class="p-2 hover:bg-gray-200 cursor-pointer"
                        @click="editSelectBesi(item)">
                        <span x-text="item.nama + ' (' + item.jenis + ')'"></span>
                    </div>
                </template>
            </div>

            <!-- FIELD OTOMATIS (READONLY) -->
            <label class="mt-4 block font-semibold">Nama</label>
            <input type="text" name="nama" x-model="editNama"
                class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>

            <label class="font-semibold">Jenis</label>
            <input type="text" name="jenis" x-model="editJenis"
                class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>

            <label class="font-semibold">Harga/kg</label>
            <input type="number" name="harga" x-model="editHarga"
                class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>

            <label class="font-semibold">Sisa Stok</label>
            <input type="number" name="stok" x-model="editStok"
                class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>

            <!-- INPUT MANUAL -->
            <label class="font-semibold">Berat (kg)</label>
            <input type="number" x-model="editBerat" name="berat" class="w-full border p-2 rounded mb-3" required>

            <label class="font-semibold">Status</label>
            <select name="status" class="w-full border p-2 rounded mb-3" required>
                <option value="">-- Pilih Status --</option>
                <option :selected="editStatus === 'Barang Masuk'" value="Barang Masuk">Barang Masuk</option>
                <option :selected="editStatus === 'Barang Keluar'" value="Barang Keluar">Barang Keluar</option>
            </select>

            <!-- STATUS CETAK & TRANSFER -->
            <label class="font-semibold">Sudah Cetak?</label>
            <select name="is_cetak" class="w-full border p-2 rounded mb-3">
                <option :selected="editIsCetak == 0" value="0">Belum</option>
                <option :selected="editIsCetak == 1" value="1">Sudah</option>
            </select>

            <label class="font-semibold">Sudah Transfer?</label>
            <select name="is_transfer" class="w-full border p-2 rounded mb-3">
                <option :selected="editIsTransfer == 0" value="0">Belum</option>
                <option :selected="editIsTransfer == 1" value="1">Sudah</option>
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

@if(session('success_kode'))
Swal.fire({
    title:"Timbangan Baru!",
    text:"Kode: {{ session('success_kode') }}",
    icon:"success",
});
@endif

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

<script>
document.addEventListener('DOMContentLoaded', () => {

    // SELECT ALL
    document.getElementById('checkAll').addEventListener('change', function () {
        let status = this.checked;
        document.querySelectorAll('.row-check').forEach(chk => chk.checked = status);
    });

});
</script>


<!-- ALPINE JS -->
<script>
function notaBesi(){
    return {
        addModal:false,
        editModal:false,

        // ADD
        nama:'',
        jenis:'',
        harga:'',
        stok:'',
        besi_id:'',
        searchQuery:'',
        searchResults:[],

        // EDIT
        editId:'',
        editKode:'',
        editJenis:'',
        editHarga:'',
        editBerat:'',
        editStatus:'',
        editBesiId:'',
            editNama:'',
    editStok:'',
    editSearchQuery:'',

        openAddModal(){
            this.addModal = true;
            this.nama='';
            this.jenis='';
            this.harga='';
            this.stok='';
            this.searchQuery='';
            this.searchResults=[];
        },

        openEditModal(id,kode,jenis,harga,berat,status,besiId){
    this.editModal = true;

    this.editId     = id;
    this.editKode   = kode;
    this.editJenis  = jenis;
    this.editHarga  = harga;
    this.editBerat  = berat;
    this.editStatus = status;
    this.editBesiId = besiId;

    // AUTO ISI DATA BESI BERDASARKAN ID
    if(besiId){
        fetch(`/timbangan/get-besi/${besiId}`)
            .then(res => res.json())
            .then(res => {
                if(res.success){
                    let b = res.data;

                    // Set field agar langsung tampil
                    this.editNama  = b.nama;
                    this.editJenis = b.jenis;
                    this.editHarga = b.harga;
                    this.editStok  = b.stok;

                    // Isi kolom pencarian
                    this.editSearchQuery = b.nama;
                }
            });
    }
},


        enableEdit(){
            document.querySelectorAll('input[readonly]').forEach(el=>{
                el.removeAttribute('readonly');
                el.classList.remove('bg-gray-100','cursor-not-allowed');
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
            this.besi_id=item.id;
            this.searchQuery=item.nama;
            this.searchResults=[];
        }
    }
}
function confirmCetakNota() {
    let ids = [...document.querySelectorAll('.row-check:checked')]
        .map(chk => chk.value);

    if(ids.length === 0){
        Swal.fire("Info", "Pilih dulu data yang ingin dicetak!", "info");
        return;
    }

    Swal.fire({
        title: "Yakin ingin cetak nota?",
        text: "Nota akan dicetak dan data ditandai sebagai sudah cetak.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Cetak!",
        cancelButtonText: "Batal",
    }).then(res => {
        if(res.isConfirmed){
            // Cetak di halaman baru
            window.open('/timbangan/cetak?ids=' + encodeURIComponent(JSON.stringify(ids)), '_blank');
            
            // Mark sebagai sudah cetak
            setSudahCetak(ids);
        }
    });
}

function confirmTransferKeNotaTransaksi() {
    let ids = [...document.querySelectorAll('.row-check:checked')]
        .map(chk => chk.value);

    if(ids.length === 0){
        Swal.fire("Info", "Pilih dulu data yang ingin ditransfer!", "info");
        return;
    }

    Swal.fire({
        title: "Yakin ingin transfer ke Nota Transaksi?",
        text: "Data dipilih akan ditandai sebagai sudah transfer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#16a34a",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Transfer!",
        cancelButtonText: "Batal",
    }).then(res => {
        if(res.isConfirmed){
            setSudahTransfer(ids);
        }
    });
}
function confirmSudahCetak(selectedIds) {
    Swal.fire({
        title: "Tandai sebagai Sudah Cetak?",
        text: "Perubahan ini tidak bisa dibatalkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Cetak!",
        cancelButtonText: "Batal",
    }).then(res => {
        if(res.isConfirmed){
            setSudahCetak(selectedIds);
        }
    });
}

function confirmSudahTransfer(selectedIds) {
    Swal.fire({
        title: "Tandai sebagai Sudah Transfer?",
        text: "Perubahan ini tidak bisa dibatalkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#16a34a",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Transfer!",
        cancelButtonText: "Batal",
    }).then(res => {
        if(res.isConfirmed){
            setSudahTransfer(selectedIds);
        }
    });
}

function setSudahTransfer(selectedIds) {
    fetch("{{ route('timbangan.setTransfer') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ ids: selectedIds })
    })
    .then(res => res.json())
    .then(res => {

        Swal.fire({
            title: "Berhasil!",
            text: res.message || "Data telah ditransfer",
            icon: "success",
        }).then(() => {

            // ⬇️ REDIRECT KE HALAMAN NOTA
            let idString = selectedIds.join(",");
            window.location.href = "/nota/create?ids=" + idString;

        });
    })
    .catch(err => {
        Swal.fire("Error!", "Gagal memproses transfer", "error");
    });
}



</script>
<script>
function setCetak(ids) {
    fetch("{{ route('timbangan.setCetak') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ ids: ids })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        location.reload();
    });
}

function setTransfer(ids) {
    fetch("{{ route('timbangan.setTransfer') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ ids: ids })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        location.reload();
    });
}

function setSudahCetak(ids) {
    fetch("/timbangan/mark-cetak", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ ids: ids })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            Swal.fire("Berhasil!", "Status sudah diupdate menjadi Sudah Cetak.", "success")
            .then(() => location.reload());
        }
    });
}

</script>

@endpush

</x-admin-layout>

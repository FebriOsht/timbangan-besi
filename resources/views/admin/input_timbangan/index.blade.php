<x-admin-layout title="Data Timbangan Besi">

<div x-data="notaBesi()" class="pb-20">

    <!-- HEADER + BUTTON -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Data Timbangan Besi</h2>

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
        <!-- SEARCH & FILTER -->
    <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
        
        <!-- SEARCH INPUT -->
        <input
            id="globalSearch"
            type="text"
            placeholder="Cari..."
            class="border rounded px-3 py-2 w-full md:w-48"
        >

        <!-- COLUMN SELECTOR -->
        <select
            id="searchField"
            class="border rounded px-3 py-2 w-full md:w-48"
        >
            <option value="all">Cari di Semua Kolom</option>
            <option value="4">Jenis Besi</option>
            <option value="8">Supplier (Pabrik)</option>
            <option value="9">Customer</option>
        </select>

        <!-- FILTER STATUS -->
        <select
            id="statusFilter"
            class="border rounded px-3 py-2 w-full md:w-40"
        >
            <option value="">Semua Status</option>
            <option value="Barang Masuk">Barang Masuk</option>
            <option value="Barang Keluar">Barang Keluar</option>
        </select>

        <!-- RESET BUTTON -->
        <button
            id="clearFilters"
            class="border border-gray-400 rounded px-3 py-2 bg-gray-200 hover:bg-gray-300 w-full md:w-auto"
        >
            Reset
        </button>

    </div>
    <!-- GROUP TOMBOL -->
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

    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg p-6">
        <table id="tabel-besi" class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-100 text-sm">
                    <th class="py-3 px-2 text-center">
                        <input type="checkbox" id="checkAll" class="w-4 h-4 cursor-pointer">
                    </th>
                    <th class="py-3 px-2">Status</th>
                    <th class="py-3 px-2 cursor-pointer">Tanggal</th>
                    <th class="py-3 px-2 cursor-pointer">ID Timbangan</th>
                    <th class="py-3 px-2 cursor-pointer">Jenis</th>
                    <th class="py-3 px-2 cursor-pointer">Berat (kg)</th>
                    <th class="py-3 px-2 cursor-pointer">Harga/kg</th>
                    <th class="py-3 px-2 cursor-pointer">Status</th>
                    <th class="py-3 px-2 cursor-pointer">Supplier</th>
                    <th class="py-3 px-2 cursor-pointer">Customer</th>
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
                            <span class="px-2 py-1 text-xs rounded-lg bg-blue-100 text-blue-700">Sudah Cetak</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-lg bg-gray-200 text-gray-700">Belum Cetak</span>
                        @endif

                        {{-- Status Transfer --}}
                        @if($b->is_transfer)
                            <span class="px-2 py-1 text-xs rounded-lg bg-green-100 text-green-700 ml-1">Sudah Transfer</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-lg bg-amber-100 text-amber-700 ml-1">Belum Transfer</span>
                        @endif
                    </td>
                    <td class="py-3 px-2">{{ \Carbon\Carbon::parse($b->tanggal)->format('Y-m-d') }}</td>


                    <td class="py-3 px-2">{{ $b->kode }}</td>
                    <td class="py-3 px-2">{{ $b->besi->nama ?? '-' }} | {{ $b->besi->jenis ?? '-' }}</td>
                    <td class="py-3 px-2 text-right">{{ number_format($b->berat, fmod($b->berat, 1) == 0 ? 0 : 2, ',', '.') }}</td>
                    <td class="py-3 px-2 text-right">Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                    <td class="py-3 px-2">{{ $b->status }}</td>
                    <td class="py-3 px-2">{{ $b->pabrik->nama ?? '-' }}</td>
                    <td class="py-3 px-2">{{ $b->customer->nama ?? '-' }}</td>
<td class="py-3 px-2 text-center">
    <div class="flex justify-center items-center gap-2">

        <!-- EDIT BUTTON -->
        <button 
            title="Edit"
            @click="openEditModal({{ $b->id }})"
            class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4L18.5 2.5z" />
            </svg>
        </button>

        <!-- DELETE BUTTON -->
        <form id="delete-{{ $b->id }}" 
              action="{{ route('timbangan.destroy', $b->id) }}" 
              method="POST">
            @csrf 
            @method('DELETE')

            <button 
                type="button"
                title="Hapus"
                onclick="confirmDelete('delete-{{ $b->id }}')" 
                class="bg-red-600 text-white p-2 rounded hover:bg-red-700">
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
    </div>

    <!-- ==================== MODAL TAMBAH ==================== -->
    <div x-show="addModal"
        x-transition.opacity 
        class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">

        <div class="bg-white p-6 rounded-xl shadow-lg w-[650px] relative" 
             @click.outside="addModal=false">

            <button @click="addModal=false" class="absolute top-2 right-2 text-gray-500 hover:text-black">✕</button>

            <h2 class="font-bold mb-5 text-xl">Tambah Timbangan</h2>

            <form action="{{ route('timbangan.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-4">

                    <!-- TANGGAL -->
                    <div>
                        <label class="font-semibold">Tanggal</label>
                        <input type="date" name="tanggal" x-model="tanggal" class="w-full border p-2 rounded mb-3">
                    </div>

                    <!-- spacer -->
                    <div></div>

                    <!-- CARI PABRIK -->
                    <div class="col-span-2 relative">
                        <label class="font-semibold">Cari Supplier (Pabrik)</label>
                        <input type="text" x-model="searchPabrikQuery" @input.debounce.300="searchPabrik" class="w-full border p-2 rounded mb-1" placeholder="Ketik nama pabrik...">
                        <input type="hidden" name="pabrik_id" x-model="pabrik_id">

                        <div x-show="searchPabrikResults.length > 0" class="absolute border rounded bg-white shadow w-full max-h-40 overflow-y-auto z-50">
                            <template x-for="item in searchPabrikResults" :key="item.id">
                                <div class="p-2 hover:bg-gray-200 cursor-pointer" @click="selectPabrik(item)">
                                    <span x-text="item.nama + ' — ' + (item.alamat || '-')"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- CARI CUSTOMER -->
                    <div class="col-span-2 relative">
                        <label class="font-semibold">Cari Customer</label>
                        <input type="text" x-model="searchCustomerQuery" @input.debounce.300="searchCustomer" class="w-full border p-2 rounded mb-1" placeholder="Ketik nama customer...">
                        <input type="hidden" name="customer_id" x-model="customer_id">

                        <div x-show="searchCustomerResults.length > 0" class="absolute border rounded bg-white shadow w-full max-h-40 overflow-y-auto z-50">
                            <template x-for="item in searchCustomerResults" :key="item.id">
                                <div class="p-2 hover:bg-gray-200 cursor-pointer" @click="selectCustomer(item)">
                                    <span x-text="item.nama + ' — ' + (item.alamat || '-')"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- CARI BESI -->
                    <div class="col-span-2 relative">
                        <label class="font-semibold">Cari Jenis Besi</label>
                        <input type="text" x-model="searchQuery" @input.debounce.300="searchBesi" class="w-full border p-2 rounded mb-1" placeholder="Ketik minimal 3 huruf...">
                        <input type="hidden" name="besi_id" x-model="besi_id">

                        <div x-show="searchResults.length > 0" class="absolute border rounded bg-white shadow w-full max-h-40 overflow-y-auto z-50">
                            <template x-for="item in searchResults" :key="item.id">
                                <div class="p-2 hover:bg-gray-200 cursor-pointer" @click="selectBesi(item)">
                                    <span x-text="item.nama + ' (' + item.jenis + ')'"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- NAMA -->
                    <div>
                        <label class="font-semibold">Nama Besi</label>
                        <input type="text" name="nama" x-model="nama" class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- JENIS -->
                    <div>
                        <label class="font-semibold">Jenis</label>
                        <input type="text" name="jenis" x-model="jenis" class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- HARGA -->
                    <div>
                        <label class="font-semibold">Harga/kg</label>
                        <input type="number" name="harga" x-model="harga" class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- STOK -->
                    <div>
                        <label class="font-semibold">Sisa Stok</label>
                        <input type="number" name="stok" x-model="stok" class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- BERAT -->
                    <div>
                        <label class="font-semibold">Berat (kg)</label>
                        <input type="number" name="berat" class="w-full border p-2 rounded mb-3" required>
                    </div>

                    <!-- STATUS -->
                    <div>
                        <label class="font-semibold">Status</label>
                        <select name="status" class="w-full border p-2 rounded mb-3" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Barang Masuk">Barang Masuk</option>
                            <option value="Barang Keluar">Barang Keluar</option>
                        </select>
                    </div>

                </div>

                <div class="flex gap-3 mt-4">
    <button @click="addModal = false" class="bg-gray-500 text-white px-4 py-2 rounded w-full">
        Close
    </button>
    <button class="bg-green-600 text-white px-4 py-2 rounded w-full">
        Simpan
    </button>

    
</div>

            </form>

        </div>
    </div>

    <!-- ==================== MODAL EDIT ==================== -->
    <div x-show="editModal"
        x-transition.opacity 
        class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">

        <div class="bg-white p-6 rounded shadow-lg w-[650px] relative" @click.outside="editModal=false">
            <button @click="editModal=false" class="absolute top-2 right-2 text-gray-500 hover:text-black">✕</button>
            <h2 class="font-bold mb-4">Edit Timbangan</h2>

            <form :action="'/timbangan/' + editId" method="POST">
                @csrf @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <!-- TANGGAL -->
                    <div>
                        <label class="font-semibold">Tanggal</label>
                        <input type="date" name="tanggal" x-model="editTanggal" class="w-full border p-2 rounded mb-3">
                    </div>

                    <div></div>

                    <!-- PABRIK SEARCH -->
                    <div class="col-span-2 relative">
                        <label class="font-semibold">Cari Supplier (Pabrik)</label>
                        <input type="text" x-model="editSearchPabrikQuery" @input.debounce.300="editSearchPabrik" class="w-full border p-2 rounded mb-1" placeholder="Ketik nama pabrik...">
                        <input type="hidden" name="pabrik_id" x-model="editPabrikId">

                        <div x-show="editSearchPabrikResults.length > 0" class="absolute border rounded bg-white shadow w-full max-h-40 overflow-y-auto z-50">
                            <template x-for="item in editSearchPabrikResults" :key="item.id">
                                <div class="p-2 hover:bg-gray-200 cursor-pointer" @click="editSelectPabrik(item)">
                                    <span x-text="item.nama + ' — ' + (item.alamat || '-')"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- CUSTOMER SEARCH -->
                    <div class="col-span-2 relative">
                        <label class="font-semibold">Cari Customer</label>
                        <input type="text" x-model="editSearchCustomerQuery" @input.debounce.300="editSearchCustomer" class="w-full border p-2 rounded mb-1" placeholder="Ketik nama customer...">
                        <input type="hidden" name="customer_id" x-model="editCustomerId">

                        <div x-show="editSearchCustomerResults.length > 0" class="absolute border rounded bg-white shadow w-full max-h-40 overflow-y-auto z-50">
                            <template x-for="item in editSearchCustomerResults" :key="item.id">
                                <div class="p-2 hover:bg-gray-200 cursor-pointer" @click="editSelectCustomer(item)">
                                    <span x-text="item.nama + ' — ' + (item.alamat || '-')"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- BESI SEARCH -->
                    <div class="col-span-2 relative">
                        <label class="font-semibold">Cari Jenis Besi</label>
                        <input type="text" x-model="editSearchQuery" @input.debounce.300="editSearchBesi" class="w-full border p-2 rounded mb-1" placeholder="Ketik minimal 3 huruf...">
                        <input type="hidden" name="besi_id" x-model="editBesiId">

                        <div x-show="editSearchResults.length > 0" class="absolute border rounded bg-white shadow w-full max-h-40 overflow-y-auto z-50">
                            <template x-for="item in editSearchResults" :key="item.id">
                                <div class="p-2 hover:bg-gray-200 cursor-pointer" @click="editSelectBesi(item)">
                                    <span x-text="item.nama + ' (' + item.jenis + ')'"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- NAMA BESI -->
                    <div>
                        <label class="font-semibold">Nama Besi</label>
                        <input type="text" name="nama" x-model="editNama" class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- JENIS -->
                    <div>
                        <label class="font-semibold">Jenis</label>
                        <input type="text" name="jenis" x-model="editJenis" class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- HARGA -->
                    <div>
                        <label class="font-semibold">Harga/kg</label>
                        <input type="number" name="harga" x-model="editHarga" class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- STOK -->
                    <div>
                        <label class="font-semibold">Sisa Stok</label>
                        <input type="number" name="stok" x-model="editStok" class="w-full border p-2 rounded mb-3 bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- BERAT -->
                    <div>
                        <label class="font-semibold">Berat (kg)</label>
                        <input type="number" name="berat" x-model="editBerat" class="w-full border p-2 rounded mb-3" required>
                    </div>

                    <!-- STATUS -->
                    <div>
                        <label class="font-semibold">Status</label>
                        <select name="status" class="w-full border p-2 rounded mb-3" required>
                            <option value="">-- Pilih Status --</option>
                            <option :selected="editStatus === 'Barang Masuk'" value="Barang Masuk">Barang Masuk</option>
                            <option :selected="editStatus === 'Barang Keluar'" value="Barang Keluar">Barang Keluar</option>
                        </select>
                    </div>

                    <!-- STATUS CETAK & TRANSFER -->
                    <div>
                        <label class="font-semibold">Sudah Cetak?</label>
                        <select name="is_cetak" class="w-full border p-2 rounded mb-3">
                            <option :selected="editIsCetak == 0" value="0">Belum</option>
                            <option :selected="editIsCetak == 1" value="1">Sudah</option>
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold">Sudah Transfer?</label>
                        <select name="is_transfer" class="w-full border p-2 rounded mb-3">
                            <option :selected="editIsTransfer == 0" value="0">Belum</option>
                            <option :selected="editIsTransfer == 1" value="1">Sudah</option>
                        </select>
                    </div>

                </div>

 <div class="flex gap-3 mt-4">
    <button 
        type="button"
        @click="editModal = false"
        class="bg-gray-500 text-white px-3 py-2 rounded w-full">
        Close
    </button>

    <button 
        type="submit"
        class="bg-orange-500 text-white px-3 py-2 rounded w-full">
        Update
    </button>
</div>


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

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
$(document).ready(function() {
    console.log('=== DataTable Initialization ===');
    
    // Initialize DataTable
    var table = $('#tabel-besi').DataTable({
        pageLength: 10,
        paging: true,
        lengthChange: false,
        info: true,
        searching: true,
        columnDefs: [
            { orderable: false, targets: [0, 1, 7, 10] }
        ],
        order: [[2, 'desc']]
    });

    console.log('DataTable initialized successfully');
    console.log('Total columns:', table.settings()[0].aoColumns.length);

    // Make sure elements exist
    if($('#globalSearch').length === 0) console.error('globalSearch not found');
    if($('#searchField').length === 0) console.error('searchField not found');
    if($('#statusFilter').length === 0) console.error('statusFilter not found');
    if($('#clearFilters').length === 0) console.error('clearFilters not found');

    // SEARCH HANDLER
    var searchTimeout;
    $('#globalSearch').on('keyup', function(){
        clearTimeout(searchTimeout);
        var searchVal = $(this).val();
        var fieldVal = $('#searchField').val();
        
        console.log('Search - value:', searchVal, ', field:', fieldVal);
        
        searchTimeout = setTimeout(function(){
            try {
                if(fieldVal === 'all'){
                    // Global search across all columns
                    table.columns().search('');  // Clear column searches
                    table.search(searchVal).draw();
                } else {
                    // Search specific column
                    var colIdx = parseInt(fieldVal);
                    table.columns().search('');
                    table.column(colIdx).search(searchVal).draw();
                }
                console.log('Search executed');
            } catch(e) {
                console.error('Search error:', e);
            }
        }, 300);
    });

    // COLUMN SELECTOR
    $('#searchField').on('change', function(){
        console.log('Column changed to:', $(this).val());
        // Reset search and trigger new search with selected column
        $('#globalSearch').val('').trigger('keyup');
    });

    // STATUS FILTER
    $('#statusFilter').on('change', function(){
        var statusVal = $(this).val();
        console.log('Status filter:', statusVal);
        
        try {
            if(statusVal === ''){
                table.column(7).search('').draw();
            } else {
                // Exact match for status
                table.column(7).search('^' + statusVal + '$', true, false).draw();
            }
        } catch(e) {
            console.error('Status filter error:', e);
        }
    });

    // RESET BUTTON
    $('#clearFilters').on('click', function(){
        console.log('Reset filters clicked');
        
        try {
            $('#globalSearch').val('');
            $('#searchField').val('all');
            $('#statusFilter').val('');
            table.columns().search('').draw();
        } catch(e) {
            console.error('Reset error:', e);
        }
    });

    // CHECKBOX HANDLING
    $('#tabel-besi thead').on('click', '#checkAll', function(e){
        e.stopPropagation();
    });

    $(document).on('change', '#checkAll', function(){
        var isChecked = $(this).is(':checked');
        $('#tabel-besi tbody .row-check').prop('checked', isChecked);
    });

    $(document).on('change', '.row-check', function(){
        var totalRows = $('#tabel-besi tbody .row-check').length;
        var checkedRows = $('#tabel-besi tbody .row-check:checked').length;
        
        if(totalRows > 0 && totalRows === checkedRows){
            $('#checkAll').prop('checked', true);
        } else {
            $('#checkAll').prop('checked', false);
        }
    });

    table.on('draw', function(){
        $('#checkAll').prop('checked', false);
    });

    console.log('=== All handlers attached ===');
});
</script>

<!-- ALPINE JS -->
<script>
function notaBesi(){
    return {
        // modal
        addModal:false,
        editModal:false,

        // ADD fields
        tanggal: new Date().toISOString().slice(0,10),
        pabrik_id: '',
        customer_id: '',

        // search pabrik
        searchPabrikQuery: '',
        searchPabrikResults: [],

        // search customer
        searchCustomerQuery: '',
        searchCustomerResults: [],

        // search besi
        searchQuery:'',
        searchResults:[],

        // selected besi fields
        besi_id:'',
        nama:'',
        jenis:'',
        harga:'',
        stok:'',

        // EDIT fields
        editId:'',
        editTanggal:'',
        editPabrikId:'',
        editCustomerId:'',
        editSearchPabrikQuery:'',
        editSearchPabrikResults:[],
        editSearchCustomerQuery:'',
        editSearchCustomerResults:[],
        editSearchQuery:'',
        editSearchResults:[],
        editBesiId:'',
        editNama:'',
        editJenis:'',
        editHarga:'',
        editStok:'',
        editBerat:'',
        editStatus:'',
        editIsCetak:0,
        editIsTransfer:0,

        openAddModal(){
            this.addModal = true;
            this.tanggal = new Date().toISOString().slice(0,10);
            this.pabrik_id = '';
            this.customer_id = '';
            this.searchQuery = '';
            this.searchResults = [];
            this.searchPabrikQuery = '';
            this.searchPabrikResults = [];
            this.searchCustomerQuery = '';
            this.searchCustomerResults = [];
            this.nama = '';
            this.jenis = '';
            this.harga = '';
            this.stok = '';
            this.besi_id = '';
        },

        // open edit modal by fetching data via JSON endpoint
        openEditModal(id){
            this.editModal = true;
            this.editId = id;

            fetch(`/timbangan/get-timbangan/${id}`)
                .then(res => res.json())
                .then(res => {
                    if(res.success){
                        let d = res.data;

                        // set edit fields
                        this.editTanggal = d.tanggal ? d.tanggal.slice(0,10) : new Date().toISOString().slice(0,10);
                        this.editPabrikId = d.pabrik_id;
                        this.editCustomerId = d.customer_id;

                        // Besi fields
                        if(d.besi){
                            this.editBesiId = d.besi.id;
                            this.editNama = d.besi.nama;
                            this.editJenis = d.besi.jenis;
                            this.editHarga = d.besi.harga;
                            this.editStok = d.besi.stok;
                            this.editSearchQuery = d.besi.nama;
                        } else {
                            this.editBesiId = '';
                            this.editNama = '';
                            this.editJenis = '';
                            this.editHarga = '';
                            this.editStok = '';
                        }

                        this.editBerat = d.berat;
                        this.editStatus = d.status;
                        this.editIsCetak = d.is_cetak == true || d.is_cetak == 1 ? 1 : 0;
                        this.editIsTransfer = d.is_transfer == true || d.is_transfer == 1 ? 1 : 0;

                        // show current pabrik/customer text in search boxes (if present)
                        this.editSearchPabrikQuery = d.pabrik ? d.pabrik.nama : '';
                        this.editSearchCustomerQuery = d.customer ? d.customer.nama : '';
                    }
                });
        },

        // --------------- SEARCH PABRIK (ADD) ---------------
        searchPabrik(){
            if(this.searchPabrikQuery.length < 3){
                this.searchPabrikResults = [];
                return;
            }

            fetch("{{ route('pabrik.search') }}?q=" + encodeURIComponent(this.searchPabrikQuery))
            .then(res => res.json())
            .then(data => this.searchPabrikResults = data);
        },

        selectPabrik(item){
            this.pabrik_id = item.id;
            this.searchPabrikQuery = item.nama;
            this.searchPabrikResults = [];
        },

        // --------------- SEARCH CUSTOMER (ADD) ---------------
        searchCustomer(){
            if(this.searchCustomerQuery.length < 3){
                this.searchCustomerResults = [];
                return;
            }

            fetch("{{ route('customer.search') }}?q=" + encodeURIComponent(this.searchCustomerQuery))
            .then(res => res.json())
            .then(data => this.searchCustomerResults = data);
        },

        selectCustomer(item){
            this.customer_id = item.id;
            this.searchCustomerQuery = item.nama;
            this.searchCustomerResults = [];
        },

        // --------------- SEARCH BESI (ADD) ---------------
        searchBesi(){
            if(this.searchQuery.length < 3){
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
        },

        // --------------- EDIT SEARCH PABRIK ---------------
        editSearchPabrik(){
            if(this.editSearchPabrikQuery.length < 3){
                this.editSearchPabrikResults = [];
                return;
            }

            fetch("{{ route('pabrik.search') }}?q=" + encodeURIComponent(this.editSearchPabrikQuery))
            .then(res => res.json())
            .then(data => this.editSearchPabrikResults = data);
        },

        editSelectPabrik(item){
            this.editPabrikId = item.id;
            this.editSearchPabrikQuery = item.nama;
            this.editSearchPabrikResults = [];
        },

        // --------------- EDIT SEARCH CUSTOMER ---------------
        editSearchCustomer(){
            if(this.editSearchCustomerQuery.length < 3){
                this.editSearchCustomerResults = [];
                return;
            }

            fetch("{{ route('customer.search') }}?q=" + encodeURIComponent(this.editSearchCustomerQuery))
            .then(res => res.json())
            .then(data => this.editSearchCustomerResults = data);
        },

        editSelectCustomer(item){
            this.editCustomerId = item.id;
            this.editSearchCustomerQuery = item.nama;
            this.editSearchCustomerResults = [];
        },

        // --------------- EDIT SEARCH BESI ---------------
        editSearchBesi(){
            if(this.editSearchQuery.length < 3){
                this.editSearchResults = [];
                return;
            }

            fetch("{{ route('besi.search') }}?q=" + encodeURIComponent(this.editSearchQuery))
            .then(res=>res.json())
            .then(data=>{
                this.editSearchResults=data;
            });
        },

        editSelectBesi(item){
            this.editNama = item.nama;
            this.editJenis = item.jenis;
            this.editHarga = item.harga;
            this.editStok = item.stok;
            this.editBesiId = item.id;
            this.editSearchQuery = item.nama;
            this.editSearchResults = [];
        }
    }
}
</script>

<script>
function confirmCetakNota() {
    let ids = [...document.querySelectorAll('.row-check:checked')].map(chk => chk.value);
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
            window.open('/timbangan/cetak?ids=' + encodeURIComponent(JSON.stringify(ids)), '_blank');
            setSudahCetak(ids);
        }
    });
}

function confirmTransferKeNotaTransaksi() {
    let ids = [...document.querySelectorAll('.row-check:checked')].map(chk => chk.value);
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

function setSudahTransfer(selectedIds) {
    fetch("{{ route('timbangan.setTransfer') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content
        },
        body: JSON.stringify({ ids: selectedIds })
    })
    .then(res => res.json())
    .then(res => {
        Swal.fire({ title: "Berhasil!", text: res.message || "Data telah ditransfer", icon: "success" }).then(() => {
            let idString = selectedIds.join(",");
            window.location.href = "/nota/create?ids=" + idString;
        });
    })
    .catch(err => {
        Swal.fire("Error!", "Gagal memproses transfer", "error");
    });
}

function setSudahCetak(ids) {
    fetch("{{ route('timbangan.setCetak') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content
        },
        body: JSON.stringify({ ids: ids })
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire("Berhasil!", data.message || "Status sudah diupdate menjadi Sudah Cetak.", "success").then(()=>location.reload());
    });
}
</script>

@endpush

</x-admin-layout>

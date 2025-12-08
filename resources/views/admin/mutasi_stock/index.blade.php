    <x-admin-layout title="Mutasi Stock">

    <div x-data="mutasiStock()" class="pb-20">

        <!-- HEADER -->
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold">Mutasi Stock</h2>

            <!-- BUTTON TAMBAH -->
            <button 
                @click="openAddModal()" 
                class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Mutasi
            </button>
        </div>

        <!-- ============================ -->
        <!-- TABLE -->
        <!-- ============================ -->
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4">Data Mutasi</h2>

            <div class="overflow-x-auto border rounded-lg">
                <table class="min-w-full text-left border-collapse">
                    <thead class="bg-green-600 text-white text-sm">
                        <tr>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Jenis</th>
                            <th class="px-4 py-2 text-right">Berat (kg)</th>
                            <th class="px-4 py-2">Supplier</th>
                            <th class="px-4 py-2">Customer</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($mutasi as $m)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $m->tanggal }}</td>
                            <td class="px-4 py-2">{{ $m->besi->nama ?? '-' }}</td>
                            <td class="px-4 py-2 text-right">{{ number_format($m->berat, 0, ',', '.') }} kg</td>
                            <td class="px-4 py-2">{{ $m->Pabrik->nama ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $m->Customer->nama ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>


        <!-- ============== -->
        <!-- MODAL TAMBAH -->
        <!-- ============== -->
        <div 
            x-show="isAddModalOpen"
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
            <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl p-6"
                @click.outside="isAddModalOpen = false">

                <h2 class="text-xl font-bold mb-4">Tambah Mutasi</h2>

                <form action="{{ route('admin.mutasi_stock.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">

                        <!-- TANGGAL -->
                        <div>
                            <label class="font-semibold">Tanggal</label>
                            <input type="date" name="tanggal" class="w-full border p-2 rounded" value="{{ date('Y-m-d') }}">
                        </div>

                        <!-- BERAT -->
                        <div>
                            <label class="font-semibold">Berat (kg)</label>
                            <input type="number" name="berat" class="w-full border p-2 rounded" step="0.01">
                        </div>

                        <!-- JENIS BESI -->
                        <div class="col-span-2 relative">
                            <label class="font-semibold">Jenis Besi</label>
                            <input type="text" 
                                x-model="searchBesiQuery" 
                                @input.debounce.300="searchBesi"
                                class="w-full border p-2 rounded mb-1" 
                                placeholder="Cari besi...">

                            <input type="hidden" name="besi_id" x-model="besi_id">

                            <div 
                                x-show="searchBesiResults.length > 0"
                                class="absolute border rounded bg-white shadow w-full max-h-40 overflow-y-auto z-50"
                            >
                                <template x-for="item in searchBesiResults" :key="item.id">
                                    <div class="p-2 hover:bg-gray-200 cursor-pointer" 
                                        @click="selectBesi(item)">
                                        <span x-text="item.nama"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- SUPPLIER (DARI) -->
                        <div class="col-span-2 relative">
                            <label class="font-semibold">Supplier (Dari)</label>
                            <input type="text" 
                                x-model="searchDariQuery" 
                                @input.debounce.300="searchDari"
                                class="w-full border p-2 rounded mb-1" 
                                placeholder="Cari supplier...">
        
                            <input type="hidden" name="dari_id" x-model="dari_id">
        
                            <div 
                                x-show="searchDariResults.length > 0"
                                class="absolute border rounded bg-white shadow w-full max-h-40 overflow-y-auto z-50"
                            >
                                <template x-for="item in searchDariResults" :key="item.id">
                                    <div class="p-2 hover:bg-gray-200 cursor-pointer" 
                                        @click="selectDari(item)">
                                        <span x-text="item.nama"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- CUSTOMER (KE) -->
                        <div class="col-span-2 relative">
                            <label class="font-semibold">Customer (Ke)</label>
                            <input type="text" 
                                x-model="searchKeQuery" 
                                @input.debounce.300="searchKe"
                                class="w-full border p-2 rounded mb-1" 
                                placeholder="Cari customer...">
        
                            <input type="hidden" name="ke_id" x-model="ke_id">
        
                            <div 
                                x-show="searchKeResults.length > 0"
                                class="absolute border rounded bg-white shadow w-full max-h-40 overflow-y-auto z-50"
                            >
                                <template x-for="item in searchKeResults" :key="item.id">
                                    <div class="p-2 hover:bg-gray-200 cursor-pointer" 
                                        @click="selectKe(item)">
                                        <span x-text="item.nama"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-2">
                        <button 
                            type="button"
                            @click="isAddModalOpen = false"
                            class="px-4 py-2 bg-gray-300 rounded-lg">
                            Batal
                        </button>

                        <button 
                            type="submit"
                            class="px-4 py-2 bg-green-700 text-white rounded-lg">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>


    <!-- =========================== -->
    <!-- ALPINE.JS SCRIPT -->
    <!-- =========================== -->
    <script>
    function mutasiStock() {
        return {
            isAddModalOpen: false,

            // ================= SEARCH JENIS BESI =================
            searchBesiQuery: "",
            searchBesiResults: [],
            besi_id: "",

            searchBesi() {
                if (this.searchBesiQuery.length < 1) {
                    this.searchBesiResults = [];
                    return;
                }

                fetch(`/api/search-besi?q=${this.searchBesiQuery}`)
                    .then(res => res.json())
                    .then(data => this.searchBesiResults = data);
            },

            selectBesi(item) {
                this.searchBesiQuery = item.nama;
                this.besi_id = item.id;
                this.searchBesiResults = [];
            },

            // ================= SEARCH SUPPLIER =================
            searchDariQuery: "",
            searchDariResults: [],
            dari_id: "",

            searchDari() {
                if (this.searchDariQuery.length < 1) {
                    this.searchDariResults = [];
                    return;
                }

                fetch(`/api/search-gudang?q=${this.searchDariQuery}`)
                    .then(res => res.json())
                    .then(data => this.searchDariResults = data);
            },

            selectDari(item) {
                this.searchDariQuery = item.nama;
                this.dari_id = item.id;
                this.searchDariResults = [];
            },

            // ================= SEARCH CUSTOMER =================
            searchKeQuery: "",
            searchKeResults: [],
            ke_id: "",

            searchKe() {
                if (this.searchKeQuery.length < 1) {
                    this.searchKeResults = [];
                    return;
                }

                fetch(`/api/search-gudang?q=${this.searchKeQuery}`)
                    .then(res => res.json())
                    .then(data => this.searchKeResults = data);
            },

            selectKe(item) {
                this.searchKeQuery = item.nama;
                this.ke_id = item.id;
                this.searchKeResults = [];
            },

            // OPEN MODAL
            openAddModal() {
                this.isAddModalOpen = true;
            }
        }
    }
    </script>

    </x-admin-layout>

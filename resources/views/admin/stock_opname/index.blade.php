<x-admin-layout title="Stock Opname">

<div x-data="stockOpname()" class="pb-20">

    <!-- ============================ -->
    <!-- HEADER -->
    <!-- ============================ -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Stock Opname</h2>

        <button
            @click="openModal()"
            class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Stock Opname
        </button>
    </div>

    <!-- ============================ -->
    <!-- TABLE -->
    <!-- ============================ -->
    <div class="bg-white shadow rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-4">Data Stock Opname</h2>

        <div class="overflow-x-auto border rounded-lg">
            <table class="min-w-full text-left border-collapse">
                <thead class="bg-green-600 text-white text-sm">
                    <tr>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Jenis Besi</th>
                        <th class="px-4 py-2 text-right">Stok Sistem</th>
                        <th class="px-4 py-2 text-right">Stok Fisik</th>
                        <th class="px-4 py-2 text-right">Selisih</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($stockOpname as $row)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $row->tanggal }}</td>
                            <td class="px-4 py-2">
                                {{ $row->besi->nama ?? '-' }}
                                <span class="text-sm text-gray-500">
                                    ({{ $row->besi->jenis ?? '-' }})
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right">
                                {{ number_format($row->stok_sistem,0,',','.') }}
                            </td>
                            <td class="px-4 py-2 text-right">
                                {{ number_format($row->stok_fisik,0,',','.') }}
                            </td>
                            <td class="px-4 py-2 text-right font-bold
                                @if($row->selisih > 0) text-blue-600
                                @elseif($row->selisih < 0) text-red-600
                                @else text-green-600
                                @endif">
                                {{ $row->selisih }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                Belum ada data stock opname
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ============================ -->
    <!-- MODAL FORM -->
    <!-- ============================ -->
    <div
        x-show="isOpen"
        x-transition
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    >
        <div
            class="bg-white rounded-xl shadow-xl w-full max-w-3xl p-6"
            @click.outside="isOpen = false"
        >

            <h2 class="text-xl font-bold mb-4">Stock Opname</h2>

            <form action="{{ route('admin.stock-opname.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-4">

                    <!-- TANGGAL -->
                    <div>
                        <label class="font-semibold">Tanggal</label>
                        <input
                            type="date"
                            name="tanggal"
                            value="{{ date('Y-m-d') }}"
                            class="w-full border p-2 rounded"
                        >
                    </div>

                    <!-- STOK FISIK -->
                    <div>
                        <label class="font-semibold">Stok Fisik</label>
                        <input
                            type="number"
                            name="stok_fisik"
                            x-model="stokFisik"
                            @input="hitungSelisih"
                            class="w-full border p-2 rounded"
                        >
                    </div>

                    <!-- CARI BESI -->
                    <div class="col-span-2 relative">
                        <label class="font-semibold">Cari Jenis Besi</label>

                        <input
                            type="text"
                            x-model="searchQuery"
                            @input.debounce.300="searchBesi"
                            class="w-full border p-2 rounded mb-1"
                            placeholder="Ketik minimal 3 huruf..."
                        >

                        <input type="hidden" name="besi_id" x-model="besi_id">

                        <div
                            x-show="searchResults.length > 0"
                            class="absolute border rounded bg-white shadow w-full max-h-40 overflow-y-auto z-50"
                        >
                            <template x-for="item in searchResults" :key="item.id">
                                <div
                                    class="p-2 hover:bg-gray-200 cursor-pointer"
                                    @click="selectBesi(item)"
                                >
                                    <span x-text="item.jenis + ' | ' + item.nama"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- STOK SISTEM -->
                    <div>
                        <label class="font-semibold">Stok Sistem</label>
                        <input
                            type="number"
                            x-model="stokSistem"
                            readonly
                            class="w-full border p-2 rounded bg-gray-100"
                        >
                    </div>

                    <!-- SELISIH -->
                    <div>
                        <label class="font-semibold">Selisih</label>
                        <input
                            type="number"
                            name="selisih"
                            x-model="selisih"
                            readonly
                            class="w-full border p-2 rounded font-bold"
                            :class="{
                                'text-blue-600': selisih > 0,
                                'text-red-600': selisih < 0,
                                'text-green-600': selisih == 0
                            }"
                        >
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button
                        type="button"
                        @click="isOpen = false"
                        class="px-4 py-2 bg-gray-300 rounded-lg"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-green-700 text-white rounded-lg"
                    >
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

<!-- =========================== -->
<!-- ALPINE SCRIPT -->
<!-- =========================== -->
<script>
function stockOpname() {
    return {
        isOpen: false,

        searchQuery: '',
        searchResults: [],
        besi_id: null,

        stokSistem: 0,
        stokFisik: 0,
        selisih: 0,

        openModal() {
            this.resetForm()
            this.isOpen = true
        },

        resetForm() {
            this.searchQuery = ''
            this.searchResults = []
            this.besi_id = null
            this.stokSistem = 0
            this.stokFisik = 0
            this.selisih = 0
        },

        searchBesi() {
            if (this.searchQuery.length < 3) {
                this.searchResults = []
                return
            }

            fetch(`{{ route('besi.search') }}?q=${this.searchQuery}`)
                .then(res => res.json())
                .then(data => this.searchResults = data)
        },

        selectBesi(item) {
            this.searchQuery = `${item.jenis} | ${item.nama}`
            this.besi_id = item.id
            this.stokSistem = item.stok
            this.searchResults = []
            this.hitungSelisih()
        },

        hitungSelisih() {
            this.selisih = this.stokSistem - (this.stokFisik || 0)
        }
    }
}
</script>

</x-admin-layout>

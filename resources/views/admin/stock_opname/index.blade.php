<x-admin-layout title="Stock Opname">

<div x-data="stockOpname()" class="pb-20">

    <!-- HEADER -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Stock Opname</h2>

        <button
            @click="openModal()"
            class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg">
            + Stock Opname
        </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-4">Data Stock Opname</h2>

        <div class="overflow-x-auto border rounded-lg">
            <table class="min-w-full border-collapse">
                <thead class="bg-green-600 text-white text-sm">
                    <tr>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Pabrik</th>
                        <th class="px-4 py-2">Besi</th>
                        <th class="px-4 py-2 text-right">Stok Sistem</th>
                        <th class="px-4 py-2 text-right">Stok Fisik</th>
                        <th class="px-4 py-2 text-right">Selisih</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($stockOpname as $row)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $row->tanggal }}</td>
                            <td class="px-4 py-2">{{ $row->pabrik->nama ?? '-' }}</td>
                            <td class="px-4 py-2">
                                {{ $row->besi->nama ?? '-' }}
                                <span class="text-sm text-gray-500">
                                    ({{ $row->besi->jenis ?? '-' }})
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right">
    {{ number_format($row->besi->stok ?? 0) }}
</td>

                            <td class="px-4 py-2 text-right">{{ number_format($row->stok_fisik) }}</td>
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
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                Belum ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL -->
    <div x-show="isOpen" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-3xl p-6 rounded-xl"
             @click.outside="isOpen = false">

            <h2 class="text-xl font-bold mb-4">Stock Opname</h2>

            <form action="{{ route('admin.stock-opname.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-4">

                    <!-- TANGGAL -->
                    <div>
                        <label class="font-semibold">Tanggal</label>
                        <input type="date" name="tanggal"
                            value="{{ date('Y-m-d') }}"
                            class="w-full border p-2 rounded">
                    </div>

                    <!-- STOK FISIK -->
                    <div>
                        <label class="font-semibold">Stok Fisik</label>
                        <input type="number" name="stok_fisik"
                            x-model="stokFisik"
                            @input="hitungSelisih"
                            class="w-full border p-2 rounded">
                    </div>

                    <!-- PILIH PABRIK -->
                    <div class="col-span-2">
                        <label class="font-semibold">Pabrik</label>
                        <select x-model="pabrik_id"
                            @change="loadBesi()"
                            name="pabrik_id"
                            class="w-full border p-2 rounded">
                            <option value="">-- Pilih Pabrik --</option>
                            @foreach($pabrik as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- PILIH BESI (SEARCHABLE) -->
                    <div class="col-span-2">
                        <label class="font-semibold">Besi</label>
                        <select x-model="besi_id"
                            @change="selectBesi()"
                            name="besi_id"
                            class="w-full border p-2 rounded">
                            <option value="">-- Pilih Besi --</option>
                            <template x-for="item in besiList" :key="item.id">
                                <option :value="item.id"
                                    x-text="item.nama + ' (' + item.jenis + ')'">
                                </option>
                            </template>
                        </select>
                    </div>

                    <!-- STOK SISTEM -->
                    <div>
                        <label class="font-semibold">Stok Sistem</label>
                        <input type="number"
                            x-model="stokSistem"
                            readonly
                            class="w-full border p-2 rounded bg-gray-100">
                    </div>

                    <!-- SELISIH -->
                    <div>
                        <label class="font-semibold">Selisih</label>
                        <input type="number"
                            name="selisih"
                            x-model="selisih"
                            readonly
                            class="w-full border p-2 rounded font-bold"
                            :class="{
                                'text-blue-600': selisih > 0,
                                'text-red-600': selisih < 0,
                                'text-green-600': selisih == 0
                            }">
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" @click="isOpen = false"
                        class="px-4 py-2 bg-gray-300 rounded">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-700 text-white rounded">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
function stockOpname() {
    return {
        isOpen: false,

        pabrik_id: '',
        besi_id: '',
        besiList: [],

        stokSistem: 0,
        stokFisik: 0,
        selisih: 0,

        openModal() {
            this.reset()
            this.isOpen = true
        },

        reset() {
            this.pabrik_id = ''
            this.besi_id = ''
            this.besiList = []
            this.stokSistem = 0
            this.stokFisik = 0
            this.selisih = 0
        },

        loadBesi() {
            this.besi_id = ''
            this.besiList = []
            this.stokSistem = 0
            this.selisih = 0

            if (!this.pabrik_id) return

            fetch(`/api/besi-by-pabrik/${this.pabrik_id}`)
                .then(res => res.json())
                .then(data => this.besiList = data)
        },

        selectBesi() {
            const besi = this.besiList.find(b => b.id == this.besi_id)
            if (!besi) return

            this.stokSistem = besi.stok
            this.hitungSelisih()
        },

        hitungSelisih() {
            this.selisih = this.stokSistem - (this.stokFisik || 0)
        }
    }
}
</script>

</x-admin-layout>

<x-admin-layout title="Dashboard">

    <!-- RINGKASAN / SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-green-600 text-white p-5 rounded-lg">
            <p class="text-sm">Total Stok Saat Ini</p>
            <h3 class="text-3xl font-bold mt-2">{{ $totalBesiBerstock }}</h3>
            <p class="text-xs opacity-80">besi</p>
        </div>

        <div class="bg-green-600 text-white p-5 rounded-lg">
            <p class="text-sm">Total Pembelian Hari Ini</p>
            <h3 class="text-3xl font-bold mt-2">{{ number_format($totalPembelianHariIni) }}</h3>
            <p class="text-xs opacity-80">kg</p>
        </div>

        <div class="bg-green-600 text-white p-5 rounded-lg">
            <p class="text-sm">Total Penjualan Hari Ini</p>
            <h3 class="text-3xl font-bold mt-2">{{ number_format($totalPenjualanHariIni) }}</h3>
            <p class="text-xs opacity-80">kg</p>
        </div>

        <div class="bg-green-600 text-white p-5 rounded-lg">
            <p class="text-sm">Total Mutasi</p>
            <h3 class="text-3xl font-bold mt-2">{{ number_format($totalMutasiHariIni) }}</h3>
        </div>

        <div class="bg-green-600 text-white p-5 rounded-lg">
            <p class="text-sm">Nilai Total Stok</p>
            <h3 class="text-3xl font-bold mt-2">Rp {{ number_format($nilaiTotalStok, 0, ',', '.') }}</h3>
        </div>
    </div>


    <!-- CHARTS -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

    <!-- BAR CHART -->
    <div class="bg-white p-5 rounded-lg shadow">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-semibold text-gray-800">
                Berat Masuk vs Berat Keluar
            </h3>

            <select id="filterChart"
                class="border rounded px-3 py-1 text-sm focus:outline-none focus:ring focus:ring-green-300">
                <option value="harian" selected>Harian</option>
                <option value="mingguan">Mingguan</option>
                <option value="bulanan">Bulanan</option>
            </select>
        </div>

        <div class="relative w-full h-64">
            <canvas id="beratChart"></canvas>
        </div>
    </div>

    <!-- DONUT CHART -->
    <div class="bg-white p-5 rounded-lg shadow">
        <h3 class="font-semibold mb-3">Proporsi Jenis Besi</h3>
        <div class="relative w-full h-64">
            <canvas id="jenisBesiChart"></canvas>
        </div>
    </div>

</div>


    <!-- ===================== TRANSAKSI TERBARU ===================== -->
    <div class="bg-white p-5 rounded-lg shadow">
        <h3 class="font-semibold mb-4">Transaksi Terbaru</h3>

        <table class="w-full table-auto text-left border-collapse">
            <thead>
                <tr class="border-b text-sm text-gray-500">
                    <th class="py-2">Order Number</th>
                    <th class="py-2">Date</th>
                    <th class="py-2">Product</th>
                    <th class="py-2">Customer</th>
                    <th class="py-2">Total Amount</th>
                    <th class="py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksiTerbaru as $t)
                    <tr class="border-b text-sm">
                        <td class="py-2">{{ $t->kode }}</td>
                        <td class="py-2">{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                        <td class="py-2">{{ $t->besi->nama ?? '-' }}</td>
                        <td class="py-2">{{ $t->customer->nama ?? '-' }}</td>
                        <td class="py-2">Rp {{ number_format($t->harga * $t->berat, 0, ',', '.') }}</td>
                        <td class="py-2">{{ $t->status == 'Barang Masuk' ? 'Pembelian' : ($t->status == 'Barang Keluar' ? 'Penjualan' : $t->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-400">Belum ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const ctx = document.getElementById('beratChart').getContext('2d');
    const filterSelect = document.getElementById('filterChart');

    const beratChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Barang Masuk',
                    data: [],
                    backgroundColor: '#16a34a'
                },
                {
                    label: 'Barang Keluar',
                    data: [],
                    backgroundColor: '#dc2626'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    function loadChartData(filter = 'harian') {
        fetch(`/dashboard/chart-data?filter=${filter}`)
            .then(res => res.json())
            .then(data => {

                beratChart.data.labels = data.labels;
                beratChart.data.datasets[0].data = data.masuk;
                beratChart.data.datasets[1].data = data.keluar;

                // === AUTO Y MAX + 10% ===
                const allValues = [...data.masuk, ...data.keluar];
                const maxValue = Math.max(...allValues);

                beratChart.options.scales.y.max = maxValue > 0
                    ? Math.ceil(maxValue * 1.1)
                    : 10;

                beratChart.update();
            })
            .catch(err => console.error(err));
    }

    // LOAD DEFAULT
    loadChartData('harian');

    // EVENT FILTER CHANGE
    filterSelect.addEventListener('change', function () {
        loadChartData(this.value);
    });

});
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {

    // ===== DONUT CHART JENIS BESI =====
    const jenisCtx = document.getElementById('jenisBesiChart').getContext('2d');

    const jenisChart = new Chart(jenisCtx, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    '#16a34a',
                    '#22c55e',
                    '#4ade80',
                    '#86efac',
                    '#bbf7d0',
                    '#dcfce7'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    fetch('/dashboard/jenis-besi-chart')
        .then(res => res.json())
        .then(data => {
            console.log('JENIS BESI CHART:', data);
            jenisChart.data.labels = data.labels;
            jenisChart.data.datasets[0].data = data.data;
            jenisChart.update();
        })
        .catch(err => console.error(err));

});
</script>



</x-admin-layout>

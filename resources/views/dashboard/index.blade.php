@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- === TOP CARDS === --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Timbangan Hari Ini</p>
            <h2 class="text-3xl font-bold mt-2">0</h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Nota Hari Ini</p>
            <h2 class="text-3xl font-bold mt-2">0</h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Customer</p>
            <h2 class="text-3xl font-bold mt-2">0</h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Jenis Besi</p>
            <h2 class="text-3xl font-bold mt-2">0</h2>
        </div>

    </div>

    {{-- === CHART & SUMMARY === --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- CHART -->
        <div class="bg-white p-6 rounded-xl shadow lg:col-span-2">
            <h3 class="font-semibold mb-4">Grafik Timbangan</h3>
            
            {{-- Placeholder chart --}}
            <div class="w-full h-64 bg-gray-100 rounded flex items-center justify-center text-gray-400">
                Chart Kosong
            </div>
        </div>

        <!-- SUMMARY -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold mb-4">Ringkasan</h3>

            <ul class="space-y-3 text-gray-700">
                <li>• Belum ada data ditampilkan</li>
                <li>• Menunggu input timbangan</li>
                <li>• Sistem siap digunakan</li>
            </ul>
        </div>

    </div>

    {{-- === TABLE === --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-semibold mb-4">Data Timbangan Terbaru</h3>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left text-sm">
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Customer</th>
                    <th class="p-2 border">Jenis Besi</th>
                    <th class="p-2 border">Berat</th>
                    <th class="p-2 border">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">Belum ada data</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

@endsection

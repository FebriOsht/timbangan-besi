<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Nota Timbangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-10 text-gray-700">

    <!-- LOGO -->
    <h2 class="text-3xl font-bold text-[#0fa958]">LOGO</h2>

    <!-- HEADER RECEIPT -->
    <div class="flex justify-between mt-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="text-[#0fa958] text-2xl font-bold">Sales Receipt #</span>
                <span class="text-[#0fa958] text-2xl font-light">
                    {{ $nota->kode_nota ?? '-' }}
                </span>
            </div>

            <p class="mt-2">
                <span class="font-semibold text-gray-600">Customer :</span>
                {{ $customer->nama ?? '-' }} <br>

                <span class="font-semibold text-gray-600">Receipt by :</span> Nia
            </p>
        </div>

        <div class="text-right text-gray-500">
            {{ now()->format('F d, Y') }} <br>
            lapakbesitua@gmail.com <br>
            No. Order #001
        </div>
    </div>

    <!-- TABLE LIST ITEM -->
    <table class="w-full border border-gray-300 mt-6">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2 text-left">Nama Barang</th>
                <th class="border p-2 text-left">Banyak</th>
                <th class="border p-2 text-left">Harga Satuan</th>
                <th class="border p-2 text-left">Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($timbangan as $d)
            <tr>
                <td class="border p-2">
                    {{ $d->besi->nama ?? '-' }} | {{ $d->besi->jenis ?? '-' }}
                </td>
                <td class="border p-2">
                    {{ number_format($d->berat, fmod($d->berat,1)==0?0:2, ',', '.') }} kg
                </td>
                <td class="border p-2">
                    Rp {{ number_format($d->besi->harga ?? 0, 0, ',', '.') }}
                </td>
                <td class="border p-2">
                    Rp {{ number_format(($d->besi->harga ?? 0) * $d->berat, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- RINGKASAN TOTAL -->
    <div class="flex justify-end mt-4">
        <table class="w-1/2">
            <tbody>
                <tr>
                    <td class="py-1 font-bold text-[#0fa958]">SUBTOTAL</td>
                    <td class="py-1 text-right font-bold text-[#0fa958]">
                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                    </td>
                </tr>

                @foreach($diskonList as $diskon)
                <tr>
                    <td class="py-1 font-semibold text-gray-600">
                        Potongan / Diskon {{ $diskon['nama'] }}
                    </td>
                    <td class="py-1 text-right font-semibold text-red-600">
                        - Rp {{ number_format($diskon['nominal'], 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach

                @if($ppn > 0)
                <tr>
                    <td class="py-1 font-semibold text-gray-600">PPN (11%)</td>
                    <td class="py-1 text-right font-semibold text-gray-600">
                        Rp {{ number_format($ppn, 0, ',', '.') }}
                    </td>
                </tr>
                @endif

                <tr class="border-t">
                    <td class="py-2 font-bold text-lg">GRAND TOTAL</td>
                    <td class="py-2 text-right font-bold text-lg">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- BUTTONS -->
    <div class="flex space-x-4 mt-10 print:hidden">
        <button class="px-6 py-2 rounded-lg bg-[#0fa958] text-white hover:bg-green-700">
            Simpan Nota
        </button>

        <button onclick="window.print()"
                class="px-6 py-2 rounded-lg bg-[#0fa958] text-white hover:bg-green-700 flex items-center">
            <span class="mr-2">🖨️</span> Cetak PDF
        </button>
    </div>

</body>
</html>

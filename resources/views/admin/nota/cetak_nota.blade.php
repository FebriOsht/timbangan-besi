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
                <span class="text-[#0fa958] text-2xl font-light">202511-001</span>
            </div>

            <p class="mt-2">
                <span class="font-semibold text-gray-600">Customer :</span> Tn. Elang Damar <br>
                <span class="font-semibold text-gray-600">Receipt by :</span> Nia
            </p>
        </div>

        <div class="text-right text-gray-500">
            {{ now()->format('F d, Y') }} <br>
            lapakbesitua@gmail.com <br>
            No. Order #001
        </div>
    </div>

    <!-- TABLE -->
    <table class="w-full border border-gray-300 mt-6">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 p-2 text-left">Nama Barang</th>
                <th class="border border-gray-300 p-2 text-left">Banyak</th>
                <th class="border border-gray-300 p-2 text-left">Harga Satuan</th>
                <th class="border border-gray-300 p-2 text-left">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border p-2">Besi Beton</td>
                <td class="border p-2">120 kg</td>
                <td class="border p-2">Rp 10.000</td>
                <td class="border p-2">Rp 1.200.000</td>
            </tr>
            <tr>
                <td class="border p-2">Besi Hollow</td>
                <td class="border p-2">85 kg</td>
                <td class="border p-2">Rp 12.000</td>
                <td class="border p-2">Rp 1.020.000</td>
            </tr>
            <tr>
                <td class="border p-2">Besi Siku</td>
                <td class="border p-2">62 kg</td>
                <td class="border p-2">Rp 11.000</td>
                <td class="border p-2">Rp 682.000</td>
            </tr>
            <tr>
                <td class="border p-2">Besi Plat</td>
                <td class="border p-2">40 kg</td>
                <td class="border p-2">Rp 13.000</td>
                <td class="border p-2">Rp 520.000</td>
            </tr>
        </tbody>
    </table>

    <!-- SUBTOTAL & TOTAL -->
<!-- TABEL TOTAL TANPA BORDER -->
<table style="width: 100%; margin-top: 25px; border-collapse: collapse;">
    <tr>
        <td style="padding: 6px 0; font-weight: bold; color: #0fa958;">SUBTOTAL :</td>
        <td style="padding: 6px 0; text-align: right; font-weight: bold; color: #0fa958;">
            Rp. 700.000
        </td>
    </tr>

    <tr>
        <td style="padding: 4px 0; font-weight: 600; color: #444;">
            Potongan / Diskon
        </td>
        <td style="padding: 4px 0; text-align: right; font-weight: 600; color: #444;">
            Rp. 0
        </td>
    </tr>

    <tr>
        <td style="padding: 8px 0; font-weight: 600; color: #0fa958;">
            Tunai
        </td>
        <td style="padding: 8px 0; text-align: right; font-weight: 600; color: #0fa958;">
            -
        </td>
    </tr>

    <tr>
        <td style="padding: 12px 0; font-weight: bold; color: #0fa958; font-size: 18px;">
            TOTAL :
        </td>
        <td style="padding: 12px 0; text-align: right; font-weight: bold; color: #0fa958; font-size: 18px;">
            Rp. 700.000
        </td>
    </tr>
</table>



    <!-- BUTTONS -->
    <div class="flex space-x-4 mt-10">
        <button class="px-6 py-2 rounded-lg bg-[#0fa958] text-white hover:bg-green-700">
            Simpan Nota
        </button>

        <button onclick="window.print()" class="px-6 py-2 rounded-lg bg-[#0fa958] text-white hover:bg-green-700 flex items-center">
            <span class="mr-2">🖨️</span> Cetak PDF
        </button>
    </div>

</body>
</html>

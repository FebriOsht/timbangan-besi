<!DOCTYPE html>
<html>
<head>
    <title>Cetak Nota Timbangan</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 8px; text-align: left; }

        .header { display: flex; justify-content: space-between; }
        .green { color: #0fa958; font-weight: bold; }
        .footer { margin-top: 40px; display: flex; justify-content: space-between; }
        .center { text-align: center; }
    </style>
</head>
<body>

    <h2 class="green">LOGO</h2>

    <div class="header">
        <div>
            <h3 class="green">Nota Timbangan</h3>
            Customer :................................................<br>
            Alamat   :................................................
        </div>
        <div>
            {{ now()->format('F d, Y') }} <br>
            NTB-00{{ rand(10,999) }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Timbangan</th>
                <th>Jenis Besi</th>
                <th>Berat (kg)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $d)
            <tr>
                <td>{{ $d->kode }}</td>
                <td>{{ $d->jenis }}</td>
                <td>{{ $d->berat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 20px;">
        <strong>Catatan:</strong> <br>
        Besi telah ditimbang sesuai standart
    </p>

    <p style="text-align: right; margin-top: -40px;">
        <strong>Total Berat {{ $totalBerat }} KG</strong>
    </p>

    <div class="footer">
        <div class="center">
            Mengetahui <br><br><br>
            PT................................................
        </div>
        <div class="center">
            Penerima <br><br><br>
            PT................................................
        </div>
    </div>

    <script>
        window.print();
    </script>

</body>
</html>

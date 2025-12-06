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
        @foreach($data as $d)
        <div>
            <h3 class="green">Nota Timbangan</h3>
            Customer :{{ $d->customer->nama ?? '-' }}<br>
            Alamat   :{{ $d->customer->alamat ?? '-' }}
        </div>
        <div>
            {{ now()->format('F d, Y') }} <br>
            <h4 class="green">{{$d->kode}}</h4>
        </div>
        @endforeach
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
                <td>{{ $d->besi->nama ?? '-' }} | {{ $d->besi->jenis ?? '-' }}</td>
                <td>{{ number_format($d->berat, fmod($d->berat, 1) == 0 ? 0 : 2, ',', '.')}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 20px;">
        <strong>Catatan:</strong> <br>
        Besi telah ditimbang sesuai standart
    </p>

    <p style="text-align: right; margin-top: -40px;">
        <strong style="color: green;">Total Berat {{ $totalBerat }} KG</strong>

    </p>

    <div class="footer">
        <div class="center">
            Mengetahui <br><br><br>
            {{ $d->pabrik->nama ?? '-' }}
        </div>
        <div class="center">
            Penerima <br><br><br>
            {{ $d->customer->nama ?? '-' }}
        </div>
    </div>

    <script>
        window.print();
    </script>

</body>
</html>

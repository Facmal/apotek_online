<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Pengiriman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header p {
            margin: 5px 0;
            font-size: 13px;
        }
        .header h2 {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .footer {
            margin-top: 20px;
            font-size: 10px;
            text-align: right;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            color: white;
        }
        .badge-info { background-color: #17a2b8; }
        .badge-success { background-color: #28a745; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Daftar Pengiriman</h2>
        <p>Kurir: {{ $kurirName }}</p>
        <p>Filter: {{ $statusFilter === 'all' ? 'Semua Status' : $statusFilter }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Invoice</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Kirim</th>
                <th>Tanggal Tiba</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deliveries as $index => $delivery)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $delivery->no_invoice }}</td>
                <td>{{ $delivery->penjualan->pelanggan->nama_pelanggan }}</td>
                <td>{{ \Carbon\Carbon::parse($delivery->tgl_kirim)->format('d M Y H:i') }}</td>
                <td>
                    @if($delivery->tgl_tiba)
                        {{ \Carbon\Carbon::parse($delivery->tgl_tiba)->format('d M Y H:i') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <span class="badge badge-{{ $delivery->status_kirim == 'Sedang Dikirim' ? 'info' : 'success' }}">
                        {{ $delivery->status_kirim }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $currentDate }}
    </div>
</body>
</html>
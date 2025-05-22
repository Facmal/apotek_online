<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 22px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
            padding: 8px;
        }
        td {
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 30px;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .badge-primary {
            background-color: #007bff;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .badge-info {
            background-color: #17a2b8;
        }
        .badge-secondary {
            background-color: #6c757d;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Dihasilkan pada: {{ $today }}</p>
        @if($currentRole != 'all')
            <p>Filter: {{ ucfirst($currentRole) }}</p>
        @endif
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jabatan</th>
                <th>Tanggal Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @php
                        $badgeClass = 'badge-secondary';
                        if($user->jabatan == 'admin') $badgeClass = 'badge-danger';
                        elseif($user->jabatan == 'pemilik') $badgeClass = 'badge-primary';
                        elseif($user->jabatan == 'apoteker') $badgeClass = 'badge-success';
                        elseif($user->jabatan == 'kasir') $badgeClass = 'badge-warning';
                        elseif($user->jabatan == 'kurir') $badgeClass = 'badge-info';
                    @endphp
                    <span class="badge {{ $badgeClass }}">
                        {{ ucfirst($user->jabatan) }}
                    </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data user</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari sistem.</p>
    </div>
</body>
</html>
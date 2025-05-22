<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
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
        .badge-danger { background-color: #dc3545; }
        .badge-primary { background-color: #007bff; }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; }
        .badge-info { background-color: #17a2b8; }
        .badge-secondary { background-color: #6c757d; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Daftar Users</h2>
        <p>Filter: {{ $roleFilter === 'all' ? 'Semua Jabatan' : ucfirst($roleFilter) }}</p>
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
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->jabatan) }}</td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $currentDate }}
    </div>
</body>
</html>
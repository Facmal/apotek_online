
<!DOCTYPE html>
<html>
<head>
    <title>Pesan Kontak Baru</title>
</head>
<body>
    <h2>Pesan Kontak Baru</h2>
    <p><strong>Nama:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Telepon:</strong> {{ $data['phone'] }}</p>
    <p><strong>Pesan:</strong></p>
    <p>{{ $data['message'] }}</p>
</body>
</html>
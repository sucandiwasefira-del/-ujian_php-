<?php
include 'koneksi.php';

$id = $_GET['id'];

$q = mysqli_query($conn,"

");

$data = mysqli_fetch_assoc($q);

// CEK PREMIUM
if ($data['status_pengguna'] == 'premium') {
    http_response_code(503);
    echo "<h2>503</h2>";
    echo "<p>Artikel ini berbayar</p>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $data['judul']; ?></title>
</head>
<body>

<h2><?= $data['judul']; ?></h2>
<p><i><?= $data['tanggal']; ?></i></p>

<p>
Ini adalah isi artikel gratis.  
(Isi bisa kamu tambahkan nanti di DB)
</p>

<a href="index.php">← Kembali</a>

</body>
</html>

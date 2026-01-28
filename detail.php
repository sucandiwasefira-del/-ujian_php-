<?php
include 'koneksi.php';

// Validasi ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("Error: ID tidak valid.");
}

$id = intval($_GET['id']);

// Gunakan prepared statement
$stmt = $conn->prepare("SELECT * FROM artikel WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if(!$data){
    die("Error: Artikel tidak ditemukan.");
}

// CEK PREMIUM - redirect ke 503
if ($data['status'] == 'premium') {
    http_response_code(503);
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>503 - Service Unavailable</title>
        <style>
            body{font-family:Arial;background:#f2f2f2;text-align:center;padding:50px;}
            .box{background:white;padding:40px;border-radius:8px;max-width:500px;margin:auto;}
            h1{color:#e74c3c;font-size:72px;margin:0;}
            h2{color:#333;}
        </style>
    </head>
    <body>
        <div class='box'>
            <h1>503</h1>
            <h2>Artikel Premium</h2>
            <p>Artikel ini hanya tersedia untuk pengguna premium.</p>
            <a href='index.php' style='color:#007bff;text-decoration:none;'>← Kembali ke Beranda</a>
        </div>
    </body>
    </html>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $data['judul']; ?></title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <span class="badge bg-success mb-3">GRATIS</span>
                    <h1 class="card-title"><?= $data['judul']; ?></h1>
                    
                    <?php if(!empty($data['cover'])){ ?>
                        <img src="assets/cover/<?=$data['cover']?>" class="img-fluid rounded mb-4" alt="<?=$data['judul']?>">
                    <?php } ?>
                    
                    <p class="card-text" style="white-space:pre-line;"><?= $data['isi']; ?></p>
                    
                    <hr>
                    <a href="index.php" class="btn btn-primary">← Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

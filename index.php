<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Artikel</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<style>
body{background:#f8f9fa;padding:20px;}
.card-img-top{height:200px;object-fit:contain;background:#f8f9fa;}
.card-text{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;}
</style>
</head>
<body>

<div class="container">
    <div class="bg-white p-4 rounded shadow-sm mb-4">
        <h2 class="mb-3">Macam-Macam Artikel</h2>
        <a href="tambah.php" class="btn btn-success">+ Tambah Artikel</a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">

<?php
$q = mysqli_query($conn,"SELECT `id`, `judul`, `cover`, `isi`, `status` FROM artikel");

while($d = mysqli_fetch_assoc($q)){
?>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <?php if(!empty($d['cover'])){ ?>
                <img src="assets/cover/<?=$d['cover']?>" class="card-img-top" alt="<?=$d['judul']?>">
            <?php } else { ?>
                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white">No Image</div>
            <?php } ?>
            
            <div class="card-body">
                <?php if($d['status']=="gratis"){ ?>
                    <span class="badge bg-success mb-2">GRATIS</span>
                <?php } else { ?>
                    <span class="badge bg-danger mb-2">PREMIUM</span>
                <?php } ?>
                
                <h5 class="card-title"><?=$d['judul']?></h5>
                <p class="card-text text-muted"><?=$d['isi']?></p>
                
                <a href="detail.php?id=<?=$d['id']?>" class="btn btn-primary btn-sm w-100 mb-2">Baca Selengkapnya</a>
                
                <div class="d-flex gap-2">
                    <a href="edit.php?id=<?=$d['id']?>" class="btn btn-outline-primary btn-sm flex-fill">Edit</a>
                    <a href="hapus.php?id=<?=$d['id']?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-outline-danger btn-sm flex-fill">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
    </div>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</body>
</html>
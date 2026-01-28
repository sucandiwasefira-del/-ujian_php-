<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Artikel</title>
<style>
body{font-family:Arial;background:#f2f2f2;}
.box{width:800px;margin:auto;background:white;padding:20px;}
.badge{padding:4px 8px;border-radius:5px;color:white;font-size:12px;}
.gratis{background:green;}
.bayar{background:red;}
</style>
</head>
<body>

<div class="box">
<h2>Macam-Macam Artikel</h2>
<a href="tambah.php">+ Tambah Artikel</a>
<img src="Edbar collaboration.jpg" alt="Foto Mahasiswa">
<hr>

<?php
$q = mysqli_query($conn,"SELECT  `nama`, `tanggal_pinjam` FROM admin");


while($d = mysqli_fetch_assoc($q)){
?>
<h3>
<a href="detail.php?id=<?=$d['id_artikel']?>"><?=$d['judul']?></a>
</h3>
<small>Kategori: <?=$d['nama_kategori']?></small><br>

<?php if($d['status']=="gratis"){ ?>
<span class="badge gratis">GRATIS</span>
<?php } else { ?>
<span class="badge bayar">BERBAYAR</span>
<?php } ?>

<hr>
<?php } ?>

</div>
</body>
</html>
<?php
include ("koneksi.php");
if (isset($_POST['daftar'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
   
    // buat query
    $sql = "INSERT INTO admin (id, nama, tanggal_pinjam) VALUES ($id,$nama,$tanggal_pinjam)";
    $query = mysqli_query($db, $sql);
    //apakah query simpan berhasil?
    if($query) {
        // kalau berhasil alihkan ke halaman index.php dengan status=sukses
        header('Location: index.php?status=sukses');
    } else {
        // kalau gagal alihkan ke halaman index.php dengan status=gagal
        header('Location: index.php?status=gagal');
    }
} else {
    die ("Akses dilarang...");
}
?>
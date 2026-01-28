<?php
include 'koneksi.php';

// Validasi ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header("location:index.php");
    exit;
}

$id = intval($_GET['id']);

// Ambil nama file cover untuk dihapus menggunakan prepared statement
$stmt = $conn->prepare("SELECT cover FROM artikel WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$d = $result->fetch_assoc();
$stmt->close();

if($d){
    // Hapus file cover jika ada
    if(!empty($d['cover']) && file_exists("assets/cover/".$d['cover'])){
        unlink("assets/cover/".$d['cover']);
    }

    // Hapus data dari database menggunakan prepared statement
    $stmt = $conn->prepare("DELETE FROM artikel WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("location:index.php");
exit;
?>

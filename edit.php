<?php
include 'koneksi.php';

// Validasi ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("Error: ID tidak valid.");
}

$id = intval($_GET['id']);

// Gunakan prepared statement untuk mengambil data
$stmt = $conn->prepare("SELECT * FROM artikel WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$d = $result->fetch_assoc();
$stmt->close();

if(!$d){
    die("Error: Artikel tidak ditemukan.");
}

if(isset($_POST['update'])){
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi  = mysqli_real_escape_string($conn, $_POST['isi']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $cover_lama = mysqli_real_escape_string($conn, $_POST['cover_lama']);

    // Validasi status
    if(!in_array($status, ['gratis', 'premium'])){
        $status = 'gratis';
    }

    // Cek apakah ada file baru diupload
    if(isset($_FILES['cover']) && $_FILES['cover']['error'] == 0){
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['cover']['name'];
        $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        // Cek ekstensi file
        if(!in_array($filetype, $allowed)){
            die("Error: Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.");
        }
        
        // Cek ukuran file (max 5MB)
        if($_FILES['cover']['size'] > 5242880){
            die("Error: Ukuran file maksimal 5MB.");
        }
        
        // Generate nama file unik
        $cover = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "", $filename);
        
        if(!is_dir("assets/cover")){
            mkdir("assets/cover", 0777, true);
        }
        
        if(move_uploaded_file($_FILES['cover']['tmp_name'], "assets/cover/".$cover)){
            // Hapus cover lama jika ada
            if(!empty($cover_lama) && file_exists("assets/cover/".$cover_lama)){
                unlink("assets/cover/".$cover_lama);
            }
        } else {
            die("Error: Gagal mengupload file.");
        }
    } else {
        $cover = $cover_lama;
    }

    // Gunakan prepared statement
    $stmt = $conn->prepare("UPDATE artikel SET judul=?, cover=?, isi=?, status=? WHERE id=?");
    $stmt->bind_param("ssssi", $judul, $cover, $isi, $status, $id);
    
    if($stmt->execute()){
        $stmt->close();
        header("location:index.php");
        exit;
    } else {
        die("Error: Gagal mengupdate data.");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Artikel</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">Edit Artikel</h4>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="cover_lama" value="<?=$d['cover']?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Judul Artikel</label>
                            <input type="text" name="judul" value="<?=$d['judul']?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cover Saat Ini</label><br>
                            <?php if(!empty($d['cover'])){ ?>
                                <img src="assets/cover/<?=$d['cover']?>" class="img-thumbnail mb-2" style="max-width:200px;" id="currentCover">
                            <?php } ?>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Ganti Cover (kosongkan jika tidak ingin mengganti)</label>
                            <input type="file" name="cover" class="form-control" id="coverInput" accept="image/*">
                            <div id="imagePreview" class="mt-3" style="display:none;">
                                <p class="text-muted small">Preview gambar baru:</p>
                                <img id="preview" src="" class="img-thumbnail" style="max-width:300px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Isi Artikel</label>
                            <textarea name="isi" rows="6" class="form-control" required><?=$d['isi']?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="gratis" <?=$d['status']=='gratis'?'selected':''?>>Gratis</option>
                                <option value="premium" <?=$d['status']=='premium'?'selected':''?>>Premium</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button name="update" class="btn btn-primary">Update</button>
                            <a href="index.php" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
// Preview gambar sebelum upload
document.getElementById('coverInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        document.getElementById('imagePreview').style.display = 'none';
    }
});
</script>
</body>
</html>

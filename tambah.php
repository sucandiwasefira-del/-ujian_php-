<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi  = mysqli_real_escape_string($conn, $_POST['isi']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Validasi status
    if(!in_array($status, ['gratis', 'premium'])){
        $status = 'gratis';
    }

    // Validasi dan upload file
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
        
        // Create directory if it doesn't exist
        if(!is_dir("assets/cover")){
            mkdir("assets/cover", 0777, true);
        }
        
        if(!move_uploaded_file($_FILES['cover']['tmp_name'], "assets/cover/".$cover)){
            die("Error: Gagal mengupload file.");
        }
    } else {
        die("Error: File cover wajib diupload.");
    }

    // Gunakan prepared statement
    $stmt = $conn->prepare("INSERT INTO artikel (judul, cover, isi, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $judul, $cover, $isi, $status);
    
    if($stmt->execute()){
        $stmt->close();
        header("location:index.php");
        exit;
    } else {
        die("Error: Gagal menyimpan data.");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Artikel</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Tambah Artikel</h4>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Judul Artikel</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cover</label>
                            <input type="file" name="cover" class="form-control" id="coverInput" accept="image/*" required>
                            <div id="imagePreview" class="mt-3" style="display:none;">
                                <img id="preview" src="" class="img-thumbnail" style="max-width:300px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Isi Artikel</label>
                            <textarea name="isi" rows="6" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="gratis">Gratis</option>
                                <option value="premium">Premium</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button name="simpan" class="btn btn-success">Simpan</button>
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
    }
});
</script>
</body>
</html>

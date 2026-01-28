<!DOCTYPE html>
<html>
<head>
    <title>Artikel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow mx-auto" style="max-width: 600px;">
        
        <div class="card-header bg-primary text-white text-center fw-bold fs-5">
            Macam-macam artikel
        </div>

        <div class="card-body">
            <form action="proses-pendaftaran.php" method="POST">

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama lengkap">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="laki-laki">
                        <label class="form-check-label">Laki-Laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="perempuan">
                        <label class="form-check-label">Perempuan</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Agama</label>
                    <select name="agama" class="form-select">
                        <option value="">-- Pilih Agama --</option>
                        <option>Islam</option>
                        <option>Kristen</option>
                        <option>Hindu</option>
                        <option>Buddha</option>
                        <option>Atheis</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul buku</label>
                    <input type="text" name="judul_buku" class="form-control" placeholder="judul buku">
                </div>

                <div class="text-center">
                    <button type="submit" name="daftar" class="btn btn-primary px-4">
                        Daftar
                    </button>
                </div>

            </form>
        </div>

        <div class="card-footer text-center">
            <a href="index.php" class="btn btn-secondary">
                Kembali ke Menu Utama
            </a>
        </div>

    </div>
</div>

</body>
</html>

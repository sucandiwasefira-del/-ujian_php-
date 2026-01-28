<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){
    $nama = $_POST['nama_artikel'];
    $isi  = $_POST['isi'];

    $cover = $_FILES['cover']['name'];
    move_uploaded_file($_FILES['cover']['tmp_name'], "assets/cover/".$cover);

    mysqli_query($conn,"INSERT INTO tbl_artikel VALUES(
        NULL,'$nama','$cover','$isi'
    )");

    header("location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Artikel</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }

        .box{
            width: 500px;
            margin: 60px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2{
            text-align: center;
            margin-bottom: 20px;
        }

        label{
            font-weight: bold;
        }

        input[type=text],
        input[type=file],
        textarea{
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea{
            resize: vertical;
        }

        button{
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover{
            background: #0056b3;
        }

        .back{
            display: inline-block;
            margin-left: 10px;
            text-decoration: none;
            color: #555;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>Tambah Artikel</h2>

    <form method="post" enctype="multipart/form-data">
        <label>Nama Artikel</label>
        <input type="text" name="nama_artikel" required>

        <label>Cover</label>
        <input type="file" name="cover" required>

        <label>Isi Artikel</label>
        <textarea name="isi" rows="6" required></textarea>

        <br><br>
        <button name="simpan">Simpan</button>
        <a href="index.php" class="back">Kembali</a>
    </form>
</div>

</body>
</html>

<?php
include ('../koneksi.php');
session_start(); 

if (isset($_POST['login'])) {
    $nama_karyawan = mysqli_real_escape_string($koneksi, $_POST['Nama_Karyawan']);
    $id_karyawan = mysqli_real_escape_string($koneksi, $_POST['ID_Karyawan']);

    $query = "SELECT * FROM karyawan WHERE Nama_Karyawan='$nama_karyawan' AND ID_Karyawan='$id_karyawan'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['Nama_Karyawan'] = $nama_karyawan;
        $_SESSION['ID_Karyawan'] = $id_karyawan;
        header("Location: ../dashboard/initkode.php"); 
        exit;
    } else {
        echo "<script>alert('Nama atau ID Karyawan salah');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salford & CO | Login Karyawan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="loginkaryawan.css" rel="stylesheet">
</head>

<body>
<div class="container">
            <div class="left-section">
                <img src="sco.png" alt="Salford & Co Logo"> <!-- Replace with the actual logo source -->
                <h1>SALFORD & CO.</h1>
                <p>Fashion Terlengkap</p>
            </div>
            <div class="right-section">
                <h2>Login<br>Akun Karyawan</h2>
                <form method="POST" action="">
                <input type="text" class="nama" name="Nama_Karyawan" placeholder="Masukkan Username Karyawan" required><br>
                <input type="text" class="pw" name="ID_Karyawan" placeholder="Masukkan ID Karyawan" required><br>
                <button type="submit" name="login">LOGIN</button>
                </form>
            </div>
    </div>
</body>
</html>

<?php
include 'koneksi.php';
session_start(); 

if (isset($_POST['login'])) {
    $nama_karyawan = mysqli_real_escape_string($koneksi, $_POST['Nama_Karyawan']);
    $id_karyawan = mysqli_real_escape_string($koneksi, $_POST['ID_Karyawan']);

    $query = "SELECT * FROM karyawan WHERE Nama_Karyawan='$nama_karyawan' AND ID_Karyawan='$id_karyawan'";
    $result = mysqli_query($koneksi, $query);

    if ($nama_karyawan == 'admin' && $id_karyawan == '123') { 
        // Jika admin
        $_SESSION['Nama_Karyawan'] = $nama_karyawan; 
        $_SESSION['ID_Karyawan'] = $id_karyawan;
        header("Location: restock/restock.php"); 
    } else if (mysqli_num_rows($result) == 1) {
        // Jika login berhasil
        $_SESSION['Nama_Karyawan'] = $nama_karyawan;
        $_SESSION['ID_Karyawan'] = $id_karyawan;
        header("Location: dashboard/initkode.php"); 
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
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="blkng">
        <div class="bg">
            <div class="kiri">
                <div class="logo">
                    <img class="img1" src="logo.png" alt="Logo">
                    <img class="text" src="text.png" alt="Text">
                </div>
            </div>
            <div class="kanan">
                <h2>Login Karyawan</h2>
                <form method="POST" action="">
                    <input type="text" class="nama" name="Nama_Karyawan" placeholder="Nama" required><br>
                    <input type="text" class="pw" name="ID_Karyawan" placeholder="Password" required><br>
                    <button type="submit" name="login">Log In</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
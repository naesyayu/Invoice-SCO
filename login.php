<?php
include 'koneksi.php';
session_start(); 

if (isset($_POST['login'])) {
    $nama_karyawan = mysqli_real_escape_string($koneksi, $_POST['Nama_Karyawan']);
    $id_karyawan = mysqli_real_escape_string($koneksi, $_POST['ID_Karyawan']);

    $query = "SELECT * FROM karyawan WHERE Nama_Karyawan='$nama_karyawan' AND ID_Karyawan='$id_karyawan'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['Nama_Karyawan'] = $nama_karyawan;
        header("Location: dashboard.php"); 
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
    <link rel="stylesheet">
</head>
<style>
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .bg {
        display: flex;
        border-style: solid;
        border-radius: 7px;
        width: 500px;
        height: 306px;
        background-color: white;
        align-items: center;
        justify-content: center;
    }
    .blkng {
        display: flex;
        width: auto;
        height: 500px;
        justify-content: center;
        align-items: center;
    }
    .kiri {
        background-color: white;
        width: 300px;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .logo {
        display: flex;
        justify-content: center;
        flex-direction: column;
        width: 150px;
        height: 150px;
    }
    .kanan {
        background-color: rgb(132, 182, 240);
        border-top-left-radius: 7%;
        border-bottom-left-radius: 7%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 300px;
        height: 300px;
    }
    .kanan button {
        color: rgb(0, 89, 255);
        display: flex;
        justify-content: center;
        align-items: center;
        width: 160px;
        height: 30px;
        margin-top: 20px;
    }
    .nama {
        border: none;
        border-bottom: 1px solid white;
        outline: none;
        background: transparent;
        top: 0;
        margin-bottom: 30px;
    }
    .pw {
        border: none;
        border-bottom: 1px solid white;
        outline: none;
        background: transparent;
    }
    .kanan h2 {
        display: flex;
        color: white;
        padding-bottom: 30px;
        font-family: sans-serif;
    }
    .kanan p {
        color: white;
        font-family: sans-serif;
    }
    .kanan input::placeholder {
        color: white;
    }
</style>
<body>
    <div class="blkng">
        <div class="bg">
            <div class="kiri">
                <div class="logo">
                    <img class="img1" src="sco.png" alt="Logo">
                    <img class="text" src="text.jpg" alt="Text">
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

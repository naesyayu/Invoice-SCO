<?php
include('koneksi.php');

$nama_pelanggan = '';
$no_hp_pelanggan = '';
$email_pelanggan = '';
$alamat_pelanggan = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_hp_pelanggan = $_POST['no_hp_pelanggan'];
    $email_pelanggan = $_POST['email_pelanggan'];
    $alamat_pelanggan = $_POST['alamat_pelanggan'];

    $sql = "INSERT INTO pelanggan (Nama_Pelanggan, No_Hp_Pelanggan, Email_Pelanggan, Alamat_Pelanggan) 
            VALUES ('$nama_pelanggan', '$no_hp_pelanggan', '$email_pelanggan', '$alamat_pelanggan')";

    if ($koneksi->query($sql) === TRUE) {
        session_start();
        session_unset();
        session_destroy();

        header("Location: checkout.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Member Baru</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="tambahpelanggan.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="logo hitam.png" alt="Logo">
        </div>
        <div class="judul">Checkout</div>
    </div>

    <!-- Sidebar kiri -->
    <div class="sidebar">
        <ul>
            <li>
                <i class="fas fa-shopping-cart"></i>
                <span>Keranjang</span>
            </li>
            <li class="active">
                <i class="fas fa-clock"></i>
                <span>Proses</span>
            </li>
            <li>
                <i class="fas fa-print"></i>
                <span>Cetak</span>
            </li>
            <li>
                <i class="fas fa-bell"></i>
                <span>Invoice</span>
            </li>
        </ul>
        <ul class="logout">
            <li>
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Tambah Member Baru</h1>
        <form action="" method="POST">
            <table>
                <tr>
                    <td><label for="nama_pelanggan">Nama Pelanggan:</label></td>
                    <td><input type="text" name="nama_pelanggan" value="<?php echo htmlspecialchars($nama_pelanggan); ?>" required></td>
                </tr>
                <tr>
                    <td><label for="no_hp_pelanggan">No Telepon Pelanggan:</label></td>
                    <td><input type="text" name="no_hp_pelanggan" value="<?php echo htmlspecialchars($no_hp_pelanggan); ?>" required></td>
                </tr>
                <tr>
                    <td><label for="email_pelanggan">Email Pelanggan:</label></td>
                    <td><input type="email" name="email_pelanggan" value="<?php echo htmlspecialchars($email_pelanggan); ?>" required></td>
                </tr>
                <tr>
                    <td><label for="alamat_pelanggan">Alamat Pelanggan:</label></td>
                    <td><input type="text" name="alamat_pelanggan" value="<?php echo htmlspecialchars($alamat_pelanggan); ?>" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Simpan Data">
                    </td>                    
                </tr>
            </table>
        </form>
        <div class="tombol-wrapper">
            <button class="kembali" onclick="window.location.href='checkout.php'">Kembali ke Data Pelanggan</button>
        </div>
    </div>
</body>
</html>

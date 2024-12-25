<?php
include('../../koneksi.php');

$nama_pelanggan = '';
$no_hp_pelanggan = '';
$id_pelanggan = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_hp_pelanggan = $_POST['no_hp_pelanggan'];

    if (isset($_POST['edit'])) {
        $sql = "UPDATE pelanggan SET Nama_Pelanggan='$nama_pelanggan', No_Hp_Pelanggan='$no_hp_pelanggan' WHERE ID_Pelanggan='$id_pelanggan'";
    } else {
        $sql = "INSERT INTO pelanggan (Nama_Pelanggan, No_Hp_Pelanggan) VALUES ('$nama_pelanggan', '$no_hp_pelanggan')";
    }

    if ($koneksi->query($sql) === TRUE) {
        header("Location: crudpelanggan.php"); // Redirect ke halaman CRUD setelah berhasil
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

if (isset($_GET['edit'])) {
    $id_pelanggan = $_GET['edit'];
    $sql = "SELECT * FROM pelanggan WHERE ID_Pelanggan='$id_pelanggan'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $nama_pelanggan = $data['Nama_Pelanggan'];
        $no_hp_pelanggan = $data['No_Hp_Pelanggan'];
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Pelanggan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="crudpelanggan.css" rel="stylesheet">

</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="logo putih.png" alt="Logo">
        </div>
        <div class="judul">CRUD Pelanggan</div>
    </div>

    <!-- Sidebar kiri -->
    <div class="sidebar">
        <ul>
            <li>
                <a href="../produk/crudproduk.php">
                    <i class="fas fa-warehouse"></i>
                    <span>Produk</span>
                </a>
            </li>
            <li>
                <a href="../karyawan/crudkaryawan.php">
                    <i class="fas fa-id-badge"></i>
                    <span>Karyawan</span>
                </a>
            </li>
            <li class="active">
                <a href="crudpelanggan2.php">
                    <i class="fas fa-users"></i>
                    <span>Pelanggan</span>
                </a>
            </li>
            <li>
                <a href="../diskon/cruddiskon.php">
                    <i class="fas fa-id-badge"></i>
                    <span>Diskon</span>
                </a>
            </li>
            <li>
                <a href="../riwayati invoice admin/riwayatinvadmin.php">
                    <i class="fas fa-bell"></i>
                    <span>Invoice</span>
                </a>
            </li>
            <li>
                <a href="../rekapitulasi/rekapitulasiharian.php">
                    <i class="fas fa-align-justify"></i>
                    <span>Rekap</span>
                </a>
            </li>
        </ul>
        <ul class="logout">
            <li>
                <a href="../../logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- Main content -->
<div class="main">
    <!-- Form Input -->
    <h1><?php echo isset($_GET['edit']) ? "Edit" : "Tambah"; ?> Data Pelanggan</h1>
<form action="" method="POST">
    <table>
            <input type="hidden" name="id_pelanggan" value="<?php echo $id_pelanggan; ?>" required>
        <tr>
            <td><label for="nama_pelanggan">Nama Pelanggan:</label></td>
            <td><input type="text" name="nama_pelanggan" value="<?php echo htmlspecialchars($nama_pelanggan); ?>" required></td>
        </tr>
        <tr>
            <td><label for="no_hp_pelanggan">No Telepon Pelanggan:</label></td>
            <td><input type="text" name="no_hp_pelanggan" value="<?php echo htmlspecialchars($no_hp_pelanggan); ?>" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <?php if ($id_pelanggan != ''): ?>
                    <input type="hidden" name="edit" value="true">
                    <input type="submit" value="Update Data">
                <?php else: ?>
                    <input type="submit" value="Simpan Data">
                <?php endif; ?>
            </td>
        </tr>
    </table>
</form>
<div class="tombol-wrapper">
    <button class="kembali" onclick="window.location.href='crudpelanggan.php'">Kembali ke Data Pelanggan</button>
</div>
</div>
</body>
</html>

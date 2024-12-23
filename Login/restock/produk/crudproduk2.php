<?php
include "../../koneksi.php";

$kode_produk = '';
$nama_produk = '';
$brand_produk = '';
$harga_beli = '';
$harga_produk = '';
$jumlah_produk = '';
$gambar_produk = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_produk = $_POST['Kode_Produk'];
    $nama_produk = $_POST['Nama_Produk'];
    $brand_produk = $_POST['Brand_Produk'];
    $harga_beli = $_POST['Harga_Beli'];
    $harga_produk = $_POST['Harga_Produk'];
    $jumlah_produk = $_POST['Jumlah_Produk'];

    if (isset($_POST['edit'])) {
        if (isset($_FILES['Gambar']) && $_FILES['Gambar']['error'] == UPLOAD_ERR_OK) {
            $gambar = file_get_contents($_FILES['Gambar']['tmp_name']);

            $stmt = $koneksi->prepare("UPDATE produk SET Nama_Produk = ?, Brand_Produk = ?, Harga_Beli = ?, Harga_Produk = ?, Jumlah_Produk = ?, Gambar = ? WHERE Kode_Produk = ?");
            $stmt->bind_param("ssddiss", $nama_produk, $brand_produk, $harga_beli, $harga_produk, $jumlah_produk, $gambar, $kode_produk);
        } else {
            $stmt = $koneksi->prepare("UPDATE produk SET Nama_Produk = ?, Brand_Produk = ?, Harga_Beli = ?, Harga_Produk = ?, Jumlah_Produk = ? WHERE Kode_Produk = ?");
            $stmt->bind_param("ssddis", $nama_produk, $brand_produk, $harga_beli, $harga_produk, $jumlah_produk, $kode_produk);
        }

        if ($stmt->execute()) {
            header("Location: crudproduk.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        if (isset($_FILES['Gambar']) && $_FILES['Gambar']['error'] == UPLOAD_ERR_OK) {
            $gambar = file_get_contents($_FILES['Gambar']['tmp_name']);
        } else {
            $gambar = null;
        }

        $stmt = $koneksi->prepare("INSERT INTO produk (Kode_Produk, Nama_Produk, Brand_Produk, Harga_Beli, Harga_Produk, Jumlah_Produk, Gambar) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssddis", $kode_produk, $nama_produk, $brand_produk, $harga_beli, $harga_produk, $jumlah_produk, $gambar);

        if ($stmt->execute()) {
            header("Location: crudproduk.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

if (isset($_GET['edit'])) {
    $kode_produk = $_GET['edit'];
    $sql = "SELECT * FROM produk WHERE Kode_Produk = '$kode_produk'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $nama_produk = $data['Nama_Produk'];
        $brand_produk = $data['Brand_Produk'];
        $harga_beli = $data['Harga_Beli'];
        $harga_produk = $data['Harga_Produk'];
        $jumlah_produk = $data['Jumlah_Produk'];
        $gambar_produk = $data['Gambar'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Produk</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="crudproduk.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="logo putih.png" alt="Logo">
        </div>
        <div class="judul">CRUD Produk</div>
    </div>

    <!-- Sidebar kiri -->
    <div class="sidebar">
        <ul>
            <li class="active">
                <a href="crudproduk2.php">
                    <i class="fas fa-warehouse"></i>
                    <span>Produk</span>
                </a>
            </li>
            <li>
                <a href="../karyawan/crudkaryawan.php">
                    <i class="fas fa-id-badge"></i>
                    <span> Karyawan</span>
                </a>
            </li>
            <li>
                <a href="../pelanggan/crudpelanggan.php">
                    <i class="fas fa-users"></i>
                    <span>Pelanggan</span>
                </a>
            </li>
            <li>
                <a href="../riwayati invoice admin/riwayatinvadmin.php">
                    <i class="fas fa-bell"></i>
                    <span>Invoice</span>
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
    <h1><?php echo isset($_GET['edit']) ? "Edit" : "Tambah"; ?> Data Produk</h1>
    <!-- Tabel Data Produk -->
    <form action="" enctype="multipart/form-data" method="POST">
    <table>
        <tr>
            <td><label for="Kode_Produk">Kode Produk:</label></td>
            <td><input type="text" name="Kode_Produk" value="<?php echo $kode_produk; ?>" required></td>
        </tr>
        <tr>
            <td><label for="Nama_Produk">Nama Produk:</label></td>
            <td><input type="text" name="Nama_Produk" value="<?php echo $nama_produk; ?>" required></td>
        </tr>
        <tr>
            <td><label for="Brand_Produk">Brand Produk:</label></td>
            <td><input type="text" name="Brand_Produk" value="<?php echo $brand_produk; ?>" required></td>
        </tr>
        <tr>
            <td><label for="Harga_Beli">Harga Beli:</label></td>
            <td><input type="number" name="Harga_Beli" value="<?php echo $harga_beli; ?>" required></td>
        </tr>
        <tr>
            <td><label for="Harga_Produk">Harga Produk:</label></td>
            <td><input type="number" name="Harga_Produk" value="<?php echo $harga_produk; ?>" required></td>
        </tr>
        <tr>
            <td><label for="Jumlah_Produk">Jumlah Produk:</label></td>
            <td><input type="number" name="Jumlah_Produk" value="<?php echo $jumlah_produk; ?>" required></td>
        </tr>
        <tr>
            <td><label for="Gambar">Gambar:</label></td>
            <td>
                <?php if (!empty($gambar_produk)): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($gambar_produk) ?>" alt="Gambar Produk" style="width:100px;height:auto;" />
                <?php endif; ?>
                <input type="file" name="Gambar">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php if ($kode_produk != ''): ?>
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
    <button class="kembali" onclick="window.location.href='crudproduk.php'">Kembali</button>
</div>
    </div>
</body>
</html>
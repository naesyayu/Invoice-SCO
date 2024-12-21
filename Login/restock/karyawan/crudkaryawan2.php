<?php
include('../../koneksi.php');

$id_karyawan = '';
$nama_karyawan = '';
$no_tlp_karyawan = '';
$email_karyawan = '';
$alamat_karyawan = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_karyawan = $_POST['id_karyawan'];
    $nama_karyawan = $_POST['nama_karyawan'];
    $no_tlp_karyawan = $_POST['no_tlp_karyawan'];
    $email_karyawan = $_POST['email_karyawan'];
    $alamat_karyawan = $_POST['alamat_karyawan'];

    if (isset($_POST['edit'])) {
        $sql = "UPDATE karyawan SET Nama_Karyawan='$nama_karyawan', No_Tlp_Karyawan='$no_tlp_karyawan', Email_Karyawan='$email_karyawan', Alamat_Karyawan='$alamat_karyawan' WHERE ID_Karyawan='$id_karyawan'";
    } else {
        $sql = "INSERT INTO karyawan (ID_Karyawan, Nama_Karyawan, No_Tlp_Karyawan, Email_Karyawan, Alamat_Karyawan) VALUES ('$id_karyawan', '$nama_karyawan', '$no_tlp_karyawan', '$email_karyawan', '$alamat_karyawan')";
    }

    if ($koneksi->query($sql) === TRUE) {
        header("Location: crudkaryawan.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

if (isset($_GET['edit'])) {
    $id_karyawan = $_GET['edit'];
    $sql = "SELECT * FROM karyawan WHERE ID_Karyawan='$id_karyawan'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $nama_karyawan = $data['Nama_Karyawan'];
        $no_tlp_karyawan = $data['No_Tlp_Karyawan'];
        $email_karyawan = $data['Email_Karyawan'];
        $alamat_karyawan = $data['Alamat_Karyawan'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>crudkar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="crudkaryawan.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="logo putih.png" alt="Logo">
        </div>
        <div class="judul">CRUD Karyawan</div>
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
            <li class="active">
                <a href="crudkaryawan2.php">
                    <i class="fas fa-id-badge"></i>
                    <span>Karyawan</span>
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
    <h1><?php echo isset($_GET['edit']) ? "Edit" : "Tambah"; ?> Data Karyawan</h1>
    <form action="" method="POST">
        <table>
            <tr>
                <td><label for="id_karyawan">ID Karyawan:</label></td>
                <td><input type="text" name="id_karyawan" value="<?php echo $id_karyawan; ?>" required></td>
            </tr>
            <tr>
                <td><label for="nama_karyawan">Nama Karyawan:</label></td>
                <td><input type="text" name="nama_karyawan" value="<?php echo $nama_karyawan; ?>" required></td>
            </tr>
            <tr>
                <td><label for="no_tlp_karyawan">No Telepon:</label></td>
                <td><input type="text" name="no_tlp_karyawan" value="<?php echo $no_tlp_karyawan; ?>" required></td>
            </tr>
            <tr>
                <td><label for="email_karyawan">Email:</label></td>
                <td><input type="text" name="email_karyawan" value="<?php echo $email_karyawan; ?>" required></td>
            </tr>
            <tr>
                <td><label for="alamat_karyawan">Alamat:</label></td>
                <td><input type="text" name="alamat_karyawan" value="<?php echo $alamat_karyawan; ?>" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php if ($id_karyawan != ''): ?>
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
        <button class="kembali" onclick="window.location.href='crudkaryawan.php'">Kembali ke Daftar Karyawan</button>
    </div>
    </div>
</body>
</html>
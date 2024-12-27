<?php
include('../../koneksi.php');

$nama_diskon = '';
$diskon = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_diskon = $_POST['nama_diskon'];
    $diskon = $_POST['diskon']/100;

    if (isset($_POST['edit'])) {
        $sql = "UPDATE diskon SET Nama_Diskon='$nama_diskon', Diskon='$diskon' WHERE Nama_Diskon='$nama_diskon'";
    } else {
        $sql = "INSERT INTO diskon (Nama_Diskon, Diskon) VALUES ('$nama_diskon', '$diskon')";
    }

    if ($koneksi->query($sql) === TRUE) {
        header("Location: cruddiskon.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

if (isset($_GET['edit'])) {
    $nama_diskon = $_GET['edit'];
    $sql = "SELECT * FROM diskon WHERE Nama_Diskon='$nama_diskon'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $nama_diskon = $data['Nama_Diskon'];
        $diskon = $data['Diskon']*100;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>crud diskon</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="cruddiskon.css?v=<?php echo time(); ?>" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="logo putih.png" alt="Logo">
        </div>
        <div class="judul">CRUD Diskon</div>
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
            <li>
                <a href="../pelanggan/crudpelanggan.php">
                    <i class="fas fa-users"></i>
                    <span>Pelanggan</span>
                </a>
            </li>
            <li class="active">
                <a href="cruddiskon2.php">
                    <i class="fa-solid fa-tags"></i>
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
                <a href="../rekapitulasi/rekapitulasihariini.php">
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
    <h1><?php echo isset($_GET['edit']) ? "Edit" : "Tambah"; ?> Data Diskon</h1>
    <form action="" method="POST">
        <table>
            <tr>
                <td><label for="nama_diskon">Nama Diskon:</label></td>
                <td><input type="text" name="nama_diskon" value="<?php echo $nama_diskon; ?>" required></td>
            </tr>
            <tr>
                <td><label for="diskon">Diskon(dalam bentuk %):</label></td>
                <td><input type="text" name="diskon" value="<?php echo $diskon; ?>" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php if ($nama_diskon != ''): ?>
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
        <button class="kembali" onclick="window.location.href='cruddiskon.php'">Kembali ke Daftar Diskon</button>
    </div>
    </div>
</body>
</html>
<?php
include('../../koneksi.php');

if (isset($_GET['delete'])) {
    $nama_diskon = $_GET['delete'];
    $sql = "DELETE FROM diskon WHERE Nama_Diskon='$nama_diskon'";
    if ($koneksi->query($sql) === TRUE) {
        header("Location: cruddiskon.php");
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
    <title>CRUD Diskon</title>
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
                <a href="cruddiskon.php">
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
    <!-- Main content -->
    <div class="main">
        <div class="tombol-wrapper">
            <button class="tambah" onclick="window.location.href='cruddiskon2.php'">Tambahkan Diskon Baru</button>
        </div>
    <h1>Daftar Diskon</h1>
    <table border="1">
        <tr>
            <th>Nama Diskon</th>
            <th>Diskon</th>
            <th>Aksi</th>
        </tr>

        <?php
        $sql = "SELECT * FROM diskon ORDER BY Diskon ASC";
        $result = $koneksi->query($sql);

        if ($result->num_rows > 0): 
            // Mengambil semua hasil sebagai array
            $data = $result->fetch_all(MYSQLI_ASSOC);
        ?>
            <?php foreach ($data as $tampil): ?>
                <tr>
                    <td><?= $tampil['Nama_Diskon'] ?></td>
                    <td><?= $tampil['Diskon']*100 ?>%</td>
                    <td class="aksi">
                        <button class="edit" onclick="window.location.href='cruddiskon2.php?edit=<?= $tampil['Nama_Diskon'] ?>'">Edit</button>
                        <button class="hapus" onclick="if (confirm('Yakin ingin menghapus?')) window.location.href='cruddiskon.php?delete=<?= $tampil['Nama_Diskon'] ?>'">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Tidak ada data diskon</td>
            </tr>
        <?php endif; ?>
    </table>
    </div>
</body>
</html>
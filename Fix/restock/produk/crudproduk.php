<?php
include "../../koneksi.php";

// Fungsi delete data
if (isset($_GET['delete'])) {
    $kode_produk = $_GET['delete'];

    $stmt = $koneksi->prepare("DELETE FROM produk WHERE Kode_Produk = ?");
    $stmt->bind_param("s", $kode_produk);

    if ($stmt->execute()) {
        header("Location: crudproduk.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
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
    <link href="crudproduk.css?v=<?php echo time(); ?>" rel="stylesheet">
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
                <a href="crudproduk.php">
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
                <a href="../diskon/cruddiskon.php">
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
        <div class="tombol-wrapper">
            <!-- Tombol untuk menambahkan data produk -->
            <button class="tambah" onclick="window.location.href='crudproduk2.php'">Tambahkan Produk Baru</button>
        </div>
    <h1>Daftar Produk</h1>
    <!-- Tabel Data Produk -->
<table border="1">
    <tr>
        <th>Kode Produk</th>
        <th>Nama Produk</th>
        <th>Brand Produk</th>
        <th>Harga Beli</th>
        <th>Harga Produk</th>
        <th>Keuntungan</th>
        <th>Jumlah Produk</th>
        <th>Gambar</th>
        <th>Aksi</th>
    </tr>

    <?php
    $sql = "SELECT * FROM produk ORDER BY Kode_Produk ASC";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        while ($tampil = $result->fetch_assoc()) {
            $gambarBase64 = base64_encode($tampil['Gambar']);
    ?>
            <tr>
                <td><?= $tampil['Kode_Produk'] ?></td>
                <td><?= $tampil['Nama_Produk'] ?></td>
                <td><?= $tampil['Brand_Produk'] ?></td>
                <td>Rp<?= number_format($tampil['Harga_Beli']) ?></td>
                <td>Rp<?= number_format($tampil['Harga_Produk']) ?></td>
                <td>Rp<?= number_format($tampil['Keuntungan']) ?></td>
                <td><?= $tampil['Jumlah_Produk'] ?></td>
                <td>
                    <img src="data:image/jpeg;base64,<?= $gambarBase64 ?>" alt="Gambar Produk" width="100" height="100">
                </td>
                <td class="aksi">
                    <button class="edit" onclick="window.location.href='crudproduk2.php?edit=<?= $tampil['Kode_Produk'] ?>'">Edit</button>
                    <button class="hapus" onclick="if (confirm('Yakin ingin menghapus?')) window.location.href='crudproduk.php?delete=<?= $tampil['Kode_Produk'] ?>'">Hapus</button>
                </td>
            </tr>
    <?php
        }
    } else {
        echo "<tr><td colspan='8'>Tidak ada data produk</td></tr>";
    }
    ?>
</table>
    </div>
</body>
</html>
<?php
include('../../koneksi.php');

// Fungsi delete data
if (isset($_GET['delete'])) {
    $id_pelanggan = $_GET['delete'];
    $sql = "DELETE FROM pelanggan WHERE ID_Pelanggan='$id_pelanggan'";
    if ($koneksi->query($sql) === TRUE) {
        header("Location: crudpelanggan.php");
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
    <title>CRUD Pelanggan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="crudpelanggan.css?v=<?php echo time(); ?>" rel="stylesheet">

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
                <a href="crudpelanggan.php">
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
            <!-- Tombol untuk menambahkan data karyawan -->
            <button class="tambah" onclick="window.location.href='crudpelanggan2.php'">Tambahkan Pelanggan Baru</button>
        </div>
    <h1>Daftar Pelanggan</h1>
    <table border="1">
    <tr>
        <th>ID Pelanggan</th>
        <th>Nama Pelanggan</th>
        <th>No Telepon</th>
        <th>Aksi</th>
    </tr>

    <?php
    $sql = "SELECT * FROM pelanggan ORDER BY ID_Pelanggan ASC";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        while ($tampil = $result->fetch_assoc()) {
            echo "
            <tr>
                <td>" . htmlspecialchars($tampil['ID_Pelanggan']) . "</td>
                <td>" . htmlspecialchars($tampil['Nama_Pelanggan']) . "</td>
                <td>" . htmlspecialchars($tampil['No_Hp_Pelanggan']) . "</td>
                <td class='aksi'>
                    <button class='edit' onclick='window.location.href=\"crudpelanggan2.php?edit=" . urlencode($tampil['ID_Pelanggan']) . "\"'>Edit</button>
                    <button class='hapus' onclick='if (confirm(\"Yakin ingin menghapus?\")) window.location.href=\"?delete=" . urlencode($tampil['ID_Pelanggan']) . "\"'>Hapus</button>
                </td>
            </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='6'>Tidak ada data Pelanggan</td></tr>";
    }
    ?>
</table>
</div>
</body>
</html>
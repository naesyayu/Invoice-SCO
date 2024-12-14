<?php
include('koneksi.php');

if (isset($_GET['delete'])) {
    $id_karyawan = $_GET['delete'];
    $sql = "DELETE FROM karyawan WHERE ID_Karyawan='$id_karyawan'";
    if ($koneksi->query($sql) === TRUE) {
        header("Location: crudkaryawan.php");
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
    <title>Coba CRUD Karyawan</title>
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
                <a href="crudproduk.php">
                    <i class="fas fa-warehouse"></i>
                    <span>Produk</span>
                </a>
            </li>
            <li class="active">
                <a href="crudkaryawan.php">
                    <i class="fas fa-id-badge"></i>
                    <span>Karyawan</span>
                </a>
            </li>
            <li>
                <a href="crudpelanggan.php">
                    <i class="fas fa-users"></i>
                    <span>Pelanggan</span>
                </a>
            </li>
            <li>
                <a href="riwayatinvadmin.php">
                    <i class="fas fa-bell"></i>
                    <span>Invoice</span>
                </a>
            </li>
        </ul>
        <ul class="logout">
            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- Main content -->
    <div class="main">
    <h1>Daftar Karyawan</h1>
    <table border="1">
        <tr>
            <th>ID Karyawan</th>
            <th>Nama Karyawan</th>
            <th>No Telepon</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php
        $sql = "SELECT * FROM karyawan ORDER BY ID_Karyawan ASC";
        $result = $koneksi->query($sql);

        if ($result->num_rows > 0) {
            while ($tampil = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$tampil['ID_Karyawan']}</td>
                    <td>{$tampil['Nama_Karyawan']}</td>
                    <td>{$tampil['No_Tlp_Karyawan']}</td>
                    <td>{$tampil['Email_Karyawan']}</td>
                    <td>{$tampil['Alamat_Karyawan']}</td>
                    <td class='aksi'>
                        <button class='edit' onclick=\"window.location.href='crudkaryawan2.php?edit={$tampil['ID_Karyawan']}'\">Edit</button>
                        <button class='hapus' onclick=\"if (confirm('Yakin ingin menghapus?')) window.location.href='crudkaryawan.php?delete={$tampil['ID_Karyawan']}'\">Hapus</button>
                    </td>
                </tr>
                ";
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada data karyawan</td></tr>";
        }
        ?>
    </table>
    <div class="tombol-wrapper">
        <button class="tambah" onclick="window.location.href='crudkaryawan2.php'">Tambahkan Karyawan Baru</button>
    </div>
    </div>
</body>
</html>
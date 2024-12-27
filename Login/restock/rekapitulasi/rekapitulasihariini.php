<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Harian</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="rekapitulasi.css?v=<?php echo time(); ?>" rel="stylesheet">

</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="logo putih.png" alt="Logo">
        </div>
        <div class="judul">Rekapitulasi</div>
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
            <li class="active">
                <a href="rekapitulasihariini.php">
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
            <button class="tambah">Rekap Hari Ini</button>
            <button class="tambah" onclick="window.location.href='rekapitulasitahunan.php'" >Rekapan Lain</button>
        </div>

    <!-- isi -->
    <h1>Rekap hari ini</h1>
    <table border="1">
        <tr>
            <th>Hari / Tanggal</th>
            <th>Jumlah Item Terjual</th>
            <th>Pendapatan Toko</th>
            <th>Laba Toko</th>
        </tr>
    <?php
        include '../../koneksi.php';
        date_default_timezone_set('Asia/Jakarta');

        $produkterjual = 0;
        $pendapatantoko = 0;
        $laba = 0;
        $result = $koneksi->query("SELECT Tanggal_Invoice, NO_Invoice, Total_Harga FROM invoice WHERE Tanggal_Invoice = CURDATE()");
        if ($result->num_rows > 0) {
            foreach ($result as $row) {
                $tanggal = date('l, d F Y', strtotime($row['Tanggal_Invoice']));
                $ambildetail = $koneksi->query("SELECT SUM(Kuantitas_Produk) AS total, SUM(Keuntungan) AS laba FROM detail_transaksi WHERE NO_Invoice = '$row[NO_Invoice]'");
                $totaldetail = $ambildetail->fetch_assoc();
                $totalproduk = $totaldetail['total'];
                $totallaba = $totaldetail['laba'];

                $produkterjual += $totalproduk;
                $pendapatantoko += $row['Total_Harga'];
                $laba += $totallaba;
            }
    ?>
    <tr>
        <td><?= $row['Tanggal_Invoice'] ?></td>
        <td><?= $produkterjual ?> item</td>
        <td>Rp<?= number_format($pendapatantoko, 0, '.', '.') ?></td>
        <td>Rp<?= number_format($laba, 0, '.', '.') ?></td>
    </tr>
    <?php
        } else {
            echo "Tidak ada data";
        }
    ?>
    </table>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Invoice Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="riwayatinvadmin.css?v=<?php echo time(); ?>" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="logo putih.png" alt="Logo">
        </div>
        <div class="judul">Riwayat Invoice</div>
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
                    <i class="fa-solid fa-tags"></i>
                    <span>Diskon</span>
                </a>
            </li>
            <li class="active">
                <a href="riwayatinvadmin.php">
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
        <table border="1">
            <tr>
                <th>NO</th>
                <th>ID Inovice</th>
                <th>Tanggal Invoice</th>
                <th>ID Pelanggan</th>
                <th>Total Harga</th>
                <th>ID Karyawan</th>
                <th>Tampil Data</th>
            </tr>

            <?php
            include '../../koneksi.php';

            if (isset($_GET['tahun']) && isset($_GET['bulan']) && isset($_GET['tanggal'])) {
                $tahun = $_GET['tahun'];
                $bulan = $_GET['bulan'];
                $tanggal = $_GET['tanggal'];
                $sql = "SELECT * FROM invoice WHERE YEAR(Tanggal_Invoice) = $tahun AND MONTH(Tanggal_Invoice) = $bulan AND DAY(Tanggal_Invoice) = $tanggal ORDER BY NO_Invoice ASC";
            } else {
                $sql = "SELECT * FROM invoice ORDER BY NO_Invoice ASC";
            }

            
            $result = $koneksi->query($sql);
            $invoice = $result->fetch_all(MYSQLI_ASSOC);

            if (isset($_GET['tahun']) && isset($_GET['bulan']) && isset($_GET['tanggal'])) {
                $rekap = 1;
            } else {
                $rekap = '';
            }
            $no = 1;
            
            foreach($invoice as $show) {
                if ($show['Sub_Total_Harga'] != 0) {
                    $tanggal = date('d F Y,l', strtotime($show['Tanggal_Invoice']));
            ?>
            <tr>
                <td><?= $no ?></td>
                <td>INV <?= $show['NO_Invoice'] ?>/<?= $show['Tanggal_Invoice'] ?></td>
                <td><?= $tanggal ?></td>
                <td><?php if ($show['ID_Pelanggan']>1) {
                    echo $show['ID_Pelanggan'];
                } else {
                    echo "Tidak Ada";
                } ?></td>
                <td>Rp<?= number_format($show['Total_Harga'], 0, '.', '.') ?></td>
                <td><?= $show['ID_Karyawan'] ?></td>
                <td><a href="cetakinv.php?admin=1&input=0&no_invoice=<?= $show['NO_Invoice'] ?>&rekap=<?= $rekap ?>">Selengkapnya...</a></td>
            </tr>
            <?php
                $no++;
                }
            }
            ?>
            </table>
        <!-- Tambahkan data lain sesuai kebutuhan -->
    </div>
</body>
</html>
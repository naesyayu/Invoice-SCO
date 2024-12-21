<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="riwayat.css?v=<?php echo time(); ?>" rel="stylesheet">

</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="../logo hitam.png" alt="Logo">
        </div>
        <div class="judul">Riwayat Transaksi</div>
    </div>

    <!-- Sidebar kiri -->
    <div class="sidebar">
        <ul>
            <li>
                <button class="btn-nobg" onclick="window.location.href='../dashboard/dashboard(2).php'">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Keranjang</span>
                </button>
            </li>
            <li>
                <button class="btn-nobg" onclick="window.location.href='../checkout/checkout.php'">
                    <i class="fas fa-clock"></i>
                    <span>Proses</span>
                </button>
            </li>
            <li>
                <button class="btn-nobg" onclick="window.location.href='../cetakinv/cetakinv.php'">
                    <i class="fas fa-print"></i>
                    <span>Cetak</span>
                </button>
            </li>
            <li class="active">
                <i class="fas fa-bell"></i>
                <span>Invoice</span>
            </li>
        </ul>
        <ul class="logout">
            <li>
                <button class="btn-nobg" onclick="window.location.href='../logout.php'">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </li>
        </ul>
    </div>
    <!-- Main content -->
    <div class="main">
        <ul>
            <?php
            include '../koneksi.php';

            $sql = "SELECT * FROM invoice ORDER BY NO_Invoice ASC";
            $result = $koneksi->query($sql);
            $invoice = $result->fetch_all(MYSQLI_ASSOC);

            foreach($invoice as $show) {
            ?>
            <li>
                <button class="btn-action" onclick="window.location.href='../cetakinv/cetakinv.php?input=0&no_invoice=<?= $show['NO_Invoice'] ?>'">
                    <div class="tabel">
                        <i class="fas fa-check-circle"></i>
                        <div class="teks">
                            <span>INV <?= $show['NO_Invoice'] ?></span>
                        </div>
                    </div>
                </button>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
</body>
</html>
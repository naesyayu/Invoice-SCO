
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
                    <span> Karyawan</span>
                </a>
            </li>
            <li>
                <a href="../pelanggan/crudpelanggan.php">
                    <i class="fas fa-users"></i>
                    <span>Pelanggan</span>
                </a>
            </li>
            <li class="active">
                <a href="riwayatinvadmin.php">
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
        <ul>
            <?php
            include '../../koneksi.php';

            $sql = "SELECT * FROM invoice ORDER BY NO_Invoice ASC";
            $result = $koneksi->query($sql);
            $invoice = $result->fetch_all(MYSQLI_ASSOC);

            foreach($invoice as $show) {
            ?>
            <li>
                <button class="btn-action" onclick="window.location.href='../../cetakinv/cetakinv.php?input=0&no_invoice=<?= $show['NO_Invoice'] ?>&admin=1'">
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
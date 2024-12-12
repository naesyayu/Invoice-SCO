<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Coco+Gothic&display=swap" rel="stylesheet">
    <link href="checkout.css?v=<?php echo time(); ?>" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="../logo hitam.png" alt="Logo">
        </div>
        <div class="judul">Checkout</div>
    </div>

    <!-- Sidebar kiri -->
    <div class="sidebar">
        <ul>
            <li>
                <i class="fas fa-shopping-cart"></i>
                <span>Keranjang</span>
            </li>
            <li class="active">
                <i class="fas fa-clock"></i>
                <span>Proses</span>
            </li>
            <li>
                <i class="fas fa-print"></i>
                <span>Cetak</span>
            </li>
            <li>
                <i class="fas fa-bell"></i>
                <span>Invoice</span>
            </li>
        </ul>
        <ul class="logout">
            <li>
                <i class="fas fa-sign-out-alt"></i>
                <a href="logout.php" style="text-decoration: none; color: inherit;">
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
    
        <!-- List Produk -->
        <ul class="product-list">
            <?php
            include '../koneksi.php';

            $hasil = $koneksi->query("SELECT MAX(No_Invoice) AS MaxInvoice FROM invoice");
            $baris = $hasil->fetch_assoc();
            $no_invoice = $baris['MaxInvoice'];

            $sql = "SELECT * FROM detail_transaksi WHERE NO_Invoice = '$no_invoice' ORDER BY no ASC";
            $result = $koneksi->query($sql);
            $produklist = $result->fetch_all(MYSQLI_ASSOC);
            $no = 1;

            foreach($produklist as $show) {
                $queryProdukDetails = $koneksi->prepare("SELECT Nama_Produk, Brand_Produk, Harga_Produk, Gambar FROM produk WHERE Kode_Produk = ?");
                $queryProdukDetails->bind_param("s", $show['Kode_Produk']);
                $queryProdukDetails->execute();
                $resultProdukDetails = $queryProdukDetails->get_result();
                $produkDetails = $resultProdukDetails->fetch_assoc();

                $namaProduk = $produkDetails['Nama_Produk'];
                $brandProduk = $produkDetails['Brand_Produk'];
                $hargaproduk = $produkDetails['Harga_Produk'];
                $gambarproduk = base64_encode($produkDetails['Gambar']);
                $kodeProduk = $show['Kode_Produk'];
            ?>
            <li class="product-item">
                <img src="data:image/jpeg;base64,<?= $gambarproduk ?>" alt="Gambar Produk">
                <div class="product-details">
                    <p class="product-name"><?= $namaProduk ?> <?= $brandProduk ?></p>
                    <p class="product-price">Rp<?= number_format($hargaproduk) ?> x<?= $show['Kuantitas_Produk'] ?></p>
                </div>
                <div class="product-meta">
                    <p class="product-code">#<?= $kodeProduk ?></p>
                    <p class="product-price-right">Rp<?= number_format($show['Sub_Total_Kuantitas_Tiap_Produk']) ?></p>
                </div>
            </li>
            <?php
            }
            ?>
        </ul>
        
    </div>
    

    <div class="checkout-sidebar">
        <!-- Profil Karyawan -->
        
    
        <!-- Total dan Check Out -->
        <div class="checkout-summary">
            <div class="subtotal">
                <p>Sub Total: Rp800,000</p>
                <p>Disc: -Rp0</p>
                <p><strong>SUB TOTAL: Rp800,000</strong></p>
            </div>
        </div>

        <div class="checkout-button-container">
            <button class="checkout-button">Check Out</button>
        </div>
    </div>
    
</body>
</html>
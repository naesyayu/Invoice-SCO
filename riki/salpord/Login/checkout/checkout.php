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
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
                <button class="btn-nobg" onclick="window.location.href='../dashboard/dashboard(2).php'">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Keranjang</span>
                </button>
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
                <span>Riwayat</span>
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
        <div class="form-container">
            <!-- Nama Pelanggan -->
            <div class="form-group dropdown">
                <label for="nama-pelanggan">Nama Pelanggan</label>
                <input type="text" id="nama-pelanggan" placeholder="Masukkan Nama Pelanggan">
                <!-- Ikon Segitiga -->
                <span id="dropdown-toggle" class="dropdown-icon">&#9662;</span>
                <!-- Dropdown Menu -->
                <div id="dropdown-menu" class="dropdown-menu">
                    <a href="checkout.php">
                        <i class="fas fa-search"></i> Cari Nama Pelanggan
                    </a>
                    <a href="tambahpelanggan.php">
                        <i class="fas fa-user-plus"></i> Tambahkan Member
                    </a>
                </div>
            </div>
        
            <!-- No Telepon -->
            <div class="form-group">
                <label for="no-telepon">No Telepon</label>
                <input type="text" id="no-telepon" placeholder="Masukkan Nomer Telepon">
            </div>
            <!-- ID Pelanggan -->
            <div class="form-group">
                <label for="id-pelanggan">ID Pelanggan</label>
                <input type="text" id="id-pelanggan" placeholder="Masukkan ID Pelanggan">
            </div>
            <!-- Alamat Email -->
            <div class="form-group">
                <label for="alamat-email">Alamat Email</label>
                <input type="email" id="alamat-email" placeholder="Masukkan Alamat Email">
            </div>
            <div class="form-group">
                <label for="alamat-pelanggan">Alamat Pelanggan</label>
                <input type="text" id="alamat-pelanggan" placeholder="Masukkan Alamat Pelanggan">
            </div>
            <!-- Tanggal Transaksi -->
            <div class="form-group">
                <label for="tanggal-transaksi">Tanggal Transaksi</label>
                <p class="bold-text">28 Maret 2022</p>
            </div>
        </div>

        <!-- JavaScript Langsung di HTML -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const dropdownToggle = document.getElementById("dropdown-toggle");
                const dropdownMenu = document.getElementById("dropdown-menu");
        
                dropdownToggle.addEventListener("click", function(e) {
                    e.stopPropagation(); // Mencegah event bubbling
                    dropdownMenu.classList.toggle("open");
                });
        
                // Menutup dropdown ketika klik di luar area dropdown
                document.addEventListener("click", function() {
                    dropdownMenu.classList.remove("open");
                });
            });
            </script>
        <?php
            $result = $koneksi->query("SELECT SUM(Sub_Total_Kuantitas_Tiap_Produk) AS Total_Harga FROM detail_transaksi WHERE NO_Invoice = '$no_invoice'");
            $row = $result->fetch_assoc();
            $total_harga = $row['Total_Harga'];
            $pajak = $total_harga*0.1;
        ?>
        <!-- Total dan Check Out -->
        <div class="checkout-summary">
            <div class="subtotal">
                <p><span>Total Harga:</span> <span class="value">Rp<?= number_format($total_harga) ?></span></p>
                <p><span>Pajak(10%):</span> <span class="value">Rp<?= number_format($pajak) ?></span></p>
                <p><span>Diskon:</span> <span class="value">-Rp0</span></p>
                <p><span><strong>TOTAL:</span> <span class="value">Rp<?= number_format($total_harga+$pajak) ?></strong></span></p>
            </div>
        </div>

        <div class="checkout-button-container">
            <button class="checkout-button" onclick="window.location.href='../cetakinv/cetakinv.php?no_invoice=<?= $no_invoice ?>'">Cetak Invoice</button>
        </div>
    </div>
    
</body>

</html>
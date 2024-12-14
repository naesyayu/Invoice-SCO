<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Invoice</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="cetakinv.css?v=<?php echo time(); ?>" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="../logo hitam.png" alt="Logo">
        </div>
        <div class="judul">Invoice</div>
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
            <li class="active">
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
        <div class="invoice-container">
        <!-- Header -->
        <div class="headerinv">
            <div class="title">
                <h1>INVOICE</h1>
            </div>
            <div class="company">
                <h2>Salford & Co.</h2>
                <p>Fashion Terlengkap</p>
            </div>
        </div>

        <!-- Info -->
        <div class="info">
            <div class="left">
                <p><strong>KEPADA :</strong></p>
                <p>Ketut Susilo</p>
                <p>hello@reallygreatsite.com</p>
            </div>
            <div class="right">
                <p><strong>TANGGAL :</strong> Senin, 28 Maret 2022</p>
                <p><strong>NO INVOICE :</strong> 1/28/03/2022</p>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>KETERANGAN</th>
                        <th>HARGA</th>
                        <th>JML</th>
                        <th>SUB TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../koneksi.php';
                    $no_invoice = $koneksi->real_escape_string($_GET['no_invoice']);

                    $sql = "SELECT * FROM detail_transaksi WHERE NO_Invoice = '$no_invoice' ORDER BY no ASC";
                    $result = $koneksi->query($sql);
                    $produklist = $result->fetch_all(MYSQLI_ASSOC);

                    foreach($produklist as $show) {
                        $queryProdukDetails = $koneksi->prepare("SELECT Nama_Produk, Brand_Produk, Harga_Produk FROM produk WHERE Kode_Produk = ?");
                        $queryProdukDetails->bind_param("s", $show['Kode_Produk']);
                        $queryProdukDetails->execute();
                        $resultProdukDetails = $queryProdukDetails->get_result();
                        $produkDetails = $resultProdukDetails->fetch_assoc();

                        $namaProduk = $produkDetails['Nama_Produk'];
                        $brandProduk = $produkDetails['Brand_Produk'];
                        $hargaproduk = $produkDetails['Harga_Produk'];
                    ?>
                    <tr>
                        <td><?= $namaProduk ?> <?= $brandProduk ?></td>
                        <td>Rp<?= number_format($hargaproduk) ?></td>
                        <td><?= $show['Kuantitas_Produk'] ?></td>
                        <td>Rp<?= number_format($show['Sub_Total_Kuantitas_Tiap_Produk']) ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Payment Info -->
        <div class="payment-info">
            <div class="left">
                <p><strong>PEMBAYARAN :</strong></p>
                <p>Nama: Salford & Co.</p>
                <p>No Rek: +123-456-7890</p>
            </div>

            <?php
            $result = $koneksi->query("SELECT SUM(Sub_Total_Kuantitas_Tiap_Produk) AS Total_Harga FROM detail_transaksi WHERE NO_Invoice = '$no_invoice'");
            $row = $result->fetch_assoc();
            $total_harga = $row['Total_Harga'];
            $pajak = $total_harga*0.1;
            ?>
            <div class="right">
                <p>Total Harga: Rp<?= number_format($total_harga) ?></p>
                <p>Pajak(10%): Rp<?= number_format($pajak) ?></p>
                <p>Diskon: -Rp0</p>
                <p><strong>Total: Rp<?= number_format($total_harga+$pajak) ?></strong></p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>TERIMAKASIH ATAS PEMBELIAN ANDA</p>
            <div class="signature">
                <p>Juliana Silva</p>
                <span>Juliana Silva</span>
            </div>
        </div>
        </div>
        <div class="button-container">
            <button class="btn cetak">CETAK</button>
            <button class="btn selesai" onclick="window.location.href='riwayat.php'">SELESAI</button>
        </div>
    </div>
</body>
</html>

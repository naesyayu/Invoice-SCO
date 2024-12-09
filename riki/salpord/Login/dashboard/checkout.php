<?php
session_start();
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    $no_invoice = $_POST['no_invoice'];
    $sub_total_harga = $_POST['total_harga'];
    $tanggal = date('Y-m-d');
    $id_karyawan = $_SESSION['ID_Karyawan'];
    $pajak = $sub_total_harga * 0.05;
    $total_harga = $sub_total_harga + $pajak;
    $no_rekening_toko = '556790';

  
    $stmt = $koneksi->prepare("UPDATE invoice SET Tanggal_Invoice = ?, ID_Pelanggan = '1', Sub_Total_Harga = ?, Pajak = ?, Total_Harga = ?, ID_Karyawan = ?, No_Rekening_Toko = ? WHERE NO_Invoice = ?");
    $stmt->bind_param("sdddsis", $tanggal, $sub_total_harga, $pajak, $total_harga, $id_karyawan, $no_rekening_toko, $no_invoice);
    $stmt->execute();


    $queryProduk = $koneksi->prepare("SELECT Kode_Produk, Kuantitas_Produk, Sub_Total_Kuantitas_Tiap_Produk 
                                      FROM detail_transaksi 
                                      WHERE NO_Invoice = ?");
    $queryProduk->bind_param("i", $no_invoice);
    $queryProduk->execute();
    $resultProduk = $queryProduk->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .header {
            text-align: center;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
        }
        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button-container a {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007BFF;
            text-decoration: none;
            border-radius: 5px;
        }
        .button-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Invoice</h1>
            <p>Terima kasih atas transaksi Anda!</p>
        </div>

        <div class="invoice-details">
            <h3>Detail Invoice</h3>
            <p>No Invoice: <?= htmlspecialchars($no_invoice) ?></p>
            <p>Tanggal: <?= htmlspecialchars($tanggal) ?></p>
            <p>Nama Karyawan: <?= htmlspecialchars($_SESSION['Nama_Karyawan']) ?></p>
            <p>ID Karyawan: <?= htmlspecialchars($id_karyawan) ?></p>
        </div>

        <div class="product-details">
    <h3>Detail Produk</h3>
    <table>
        <thead>
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Brand Produk</th>
                <th>Kuantitas</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultProduk->num_rows > 0) {
                while ($rowProduk = $resultProduk->fetch_assoc()) {
                    // Ambil nama dan brand produk berdasarkan Kode_Produk
                    $queryProdukDetails = $koneksi->prepare("SELECT Nama_Produk, Brand_Produk FROM produk WHERE Kode_Produk = ?");
                    $queryProdukDetails->bind_param("s", $rowProduk['Kode_Produk']);
                    $queryProdukDetails->execute();
                    $resultProdukDetails = $queryProdukDetails->get_result();
                    $produkDetails = $resultProdukDetails->fetch_assoc();

                    $namaProduk = $produkDetails['Nama_Produk'];
                    $brandProduk = $produkDetails['Brand_Produk'];

                    echo "
                    <tr>
                        <td>" . htmlspecialchars($rowProduk['Kode_Produk']) . "</td>
                        <td>" . htmlspecialchars($namaProduk) . "</td>
                        <td>" . htmlspecialchars($brandProduk) . "</td>
                        <td>" . htmlspecialchars($rowProduk['Kuantitas_Produk']) . "</td>
                        <td>Rp" . number_format($rowProduk['Sub_Total_Kuantitas_Tiap_Produk'], 2, ',', '.') . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align: center;'>Tidak ada produk dalam invoice ini.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

        <div class="pricing">
            <p>Sub Total: Rp<?= number_format($sub_total_harga, 2, ',', '.') ?></p>
            <p>Pajak (5%): Rp<?= number_format($pajak, 2, ',', '.') ?></p>
            <p class="total">Total: Rp<?= number_format($total_harga, 2, ',', '.') ?></p>
        </div>

        <div class="button-container">
            <a href="initkode.php">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>

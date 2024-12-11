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
            <img src="../logo.png" alt="Logo">
        </div>
        <div class="judul">Invoice</div>
    </div>

    <!-- Sidebar kiri -->
    <div class="sidebar">
        <ul>
            <li>
                <i class="fas fa-shopping-cart"></i>
                <span>Keranjang</span>
            </li>
            <li>
                <i class="fas fa-clock"></i>
                <span>Proses</span>
            </li>
            <li class="active">
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
                <span>Logout</span>
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
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>KAOS</td>
                        <td>RP 100,000</td>
                        <td>1</td>
                        <td>RP 100,000</td>
                    </tr>
                    <tr>
                        <td>JAKET</td>
                        <td>RP 200,000</td>
                        <td>1</td>
                        <td>RP 200,000</td>
                    </tr>
                    <tr>
                        <td>KAOS POLO</td>
                        <td>RP 120,000</td>
                        <td>1</td>
                        <td>RP 120,000</td>
                    </tr>
                    <tr>
                        <td>SEPATU</td>
                        <td>RP 230,000</td>
                        <td>1</td>
                        <td>RP 230,000</td>
                    </tr>
                    <tr>
                        <td>SEPATU</td>
                        <td>RP 100,000</td>
                        <td>1</td>
                        <td>RP 100,000</td>
                    </tr>
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
            <div class="right">
                <p>SUB TOTAL: RP 800,000</p>
                <p>PAJAK: RP 80,000</p>
                <p><strong>TOTAL: RP 880,000</strong></p>
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
    </div>
</body>
</html>

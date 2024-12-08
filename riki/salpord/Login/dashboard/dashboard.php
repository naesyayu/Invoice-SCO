<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="bungkus">

        <div class="modul">
            <div class="atas">
                <div class="Logo">
                    <div class="kiri">
                        <img class="text" src="../text.png" width="100px">
                        <img class="gmbr" src="../logo.png" width="100px">
                    </div>
                    <div class="pencarian">
                        <input type="text" class="cari" placeholder="Cari">
                    </div>
                </div>
            </div>

            <div class="jenis2">
                <div class="produk">
                    <form action="input.php" method="post">
                        <table>
                            <tr>
                                <?php
                            include '../koneksi.php';

                            $hasil = $koneksi->query("SELECT MAX(No_Invoice) AS MaxInvoice FROM invoice");
                            $baris = $hasil->fetch_assoc();
                            $no_invoice = $baris['MaxInvoice'];
                            
                            $sql = "SELECT * FROM produk ORDER BY Kode_Produk ASC";
                            $result = $koneksi->query($sql);
                            $count = 1;
                            while ($tampil = $result->fetch_assoc()) {
                                $gambarBase64 = base64_encode($tampil['Gambar']);
                                echo "
                                    
                                    <td>
                                        <div class=\"produk1\">
                                            <img src=\"data:image/jpeg;base64,{$gambarBase64}\" alt=\"Gambar Produk\">
                                            <div class=\"txt\">
                                                <p>{$tampil['Nama_Produk']} {$tampil['Brand_Produk']}</p>
                                                <p>{$tampil['Harga_Produk']}</p>
                                                <input type='number' name='quantity[{$tampil['Kode_Produk']}]' min='1' value='1' style='width: 30px;' required>
                                                <input type='hidden' name='no_invoice' value='$no_invoice'>
                                                <button type=\"submit\" name=\"Kode_Produk\" value=\"{$tampil['Kode_Produk']}\">add</button>
                                            </div>
                                            
                                        </div>
                                    </td>"
                                ;

                                if ($count%3==0 && $count>0) {
                                    echo "
                                    </tr>
                                    <tr>";
                                };
                            $count++;
                            }
                            ?>
                            </tr>
                        </table>


                    </form>
                </div>
            </div>
        </div>
        <div class="konten">
            <div class="karyawan">
                <img src="../logo.png" width='100px'>
            </div>
            <div class="profil">
                <?php
                $id_karyawan = $_SESSION['ID_Karyawan'];
                $nama_karyawan = $_SESSION['Nama_Karyawan'];

                echo "
                <h4>$nama_karyawan<br>#$id_karyawan</h4>
                ";
                ?>
            </div>


            <div class="keranjang">
                <form action="delete.php" method="post">
                    <h4>Keranjang</h4>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Brand Produk</th>
                                <th>Kuantitas Produk</th>
                                <th>Sub Total Produk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../koneksi.php';

                            // cek no invoice skrg
                            $hasil = $koneksi->query("SELECT MAX(No_Invoice) AS MaxInvoice FROM invoice");
                            $baris = $hasil->fetch_assoc();
                            $no_invoice = $baris['MaxInvoice'];

                            // Query untuk mengambil detail transaksi berdasarkan No_Invoice
                            $sql = "SELECT * FROM detail_transaksi WHERE NO_Invoice = '$no_invoice' ORDER BY no ASC";
                            $result = $koneksi->query($sql);
                            $no = 1;

                            if ($result->num_rows > 0) {
                                while ($tampil = $result->fetch_assoc()) {
                                    $queryProdukDetails = $koneksi->prepare("SELECT Nama_Produk, Brand_Produk FROM produk WHERE Kode_Produk = ?");
                                    $queryProdukDetails->bind_param("s", $tampil['Kode_Produk']);
                                    $queryProdukDetails->execute();
                                    $resultProdukDetails = $queryProdukDetails->get_result();
                                    $produkDetails = $resultProdukDetails->fetch_assoc();

                                    $namaProduk = $produkDetails['Nama_Produk'];
                                    $brandProduk = $produkDetails['Brand_Produk'];

                                    echo "
                                    <tr>
                                        <td>{$no}</td>
                                        <td>{$tampil['Kode_Produk']}</td>
                                        <td>{$namaProduk}</td>
                                        <td>{$brandProduk}</td>
                                        <td>{$tampil['Kuantitas_Produk']}</td>
                                        <td class='aksi'>
                                            <button type='submit' name='delete' value='{$tampil['Kode_Produk']}'>Delete</button>
                                        </td>
                                    </tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='7'>Tidak ada data produk</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <br>
            <br>
            <br>

            <div class="checkout">
                <form action="checkout.php" method="POST">
                    <?php
                    $hasil = $koneksi->query("SELECT MAX(No_Invoice) AS MaxInvoice FROM invoice");
                    $baris = $hasil->fetch_assoc();
                    $no_invoice = $baris['MaxInvoice'];

                    $result = $koneksi->query("SELECT SUM(Sub_Total_Kuantitas_Tiap_Produk) AS Total_Harga FROM detail_transaksi WHERE NO_Invoice = '$no_invoice'");
                    $row = $result->fetch_assoc();
                    $total_harga = $row['Total_Harga'];

                    
                    
                    echo "
                    <h4>Total Harga : Rp{$total_harga}</h4>
                    <input type='hidden' name='total_harga' value='$total_harga'>
                    <input type='hidden' name='no_invoice' value='$no_invoice'>
                    <button type='submit' name='checkout'>checkout</button>
                    "
                    
                    ?>

                </form>
            </div>

        </div>
    </div>


</body>

</html>
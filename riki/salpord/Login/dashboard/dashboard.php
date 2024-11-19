<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="bungkus">

        <div class="modul">
            <div class="atas">
                <div class="Logo">
                    <div class="kiri">
                        <img class="text" src="text.jpg">
                        <img class="gmbr" src="logo.jpg">
                    </div>
                    <div class="pencarian">
                        <input type="text" class="cari" placeholder="Cari">
                    </div>
                </div>
            </div>

            <div class="jenis2">
                    <div class="dashboard">
                    </div>
                    <div class="button">
                        <button>kaos</button><button>polo</button><button>jaket</button><button>sepatu</button><button>celana</button><button>topi</button>
                    </div>
                    <div class="produk">
                    <form action="input.php" method="post">
                        <table>
                            <tr>
                            <?php
                            include '../koneksi.php';
                            
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
                <img src="logo.jpg">
            </div>
            <div class="profil">
                <h4>Juliana<br>#1010</h4>
            </div>

            <div class="keranjang">
                <form action="delete.php" method="post">
                    <h4>Keranjang</h4>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Produk</th>
                                <th>Sub total Produk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../koneksi.php'; // Pastikan file koneksi benar
                            $sql = "SELECT * FROM detail_transaksi ORDER BY no ASC";
                            $result = $koneksi->query($sql);
                            $no = 1;

                            if ($result->num_rows > 0) {
                                while ($tampil = $result->fetch_assoc()) {
                                    echo "
                                    <tr>
                                        <td>{$no}</td>
                                        <td>{$tampil['Kode_Produk']}</td>
                                        <td>{$tampil['Sub_Total_Kuantitas_Tiap_Produk']}</td>
                                        <td class='aksi'>
                                            <button type='submit' name='delete' value='{$tampil['Kode_Produk']}'>Delete</button>
                                        </td>
                                    </tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='3'>Tidak ada data produk</td></tr>";
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
            <?php
                $result = $koneksi->query("SELECT SUM(Sub_Total_Kuantitas_Tiap_Produk) AS Total_Harga FROM detail_transaksi");
                $row = $result->fetch_assoc();
                $total_harga = $row['Total_Harga'];

                echo "
                <h4>Total Harga : Rp{$total_harga}</h4>
                "
            ?>
            </div>

        </div>
    </div>
    

</body>
</html>
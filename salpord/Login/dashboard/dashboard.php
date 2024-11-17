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
                    <div class="pencariam">
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
                                                <img src=\"data:image/jpeg;base64,{$gambarBase64}\" alt=\"Gambar Produk\" width=\"100\" height=\"100\">
                                                <div class=\"txt\">
                                                    <p>kaos adidas airflow</p>
                                                    <p>Rp 150.000</p>
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

        </div>
    </div>


</body>
</html>
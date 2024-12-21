<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="dashboard(2).css?v=<?php echo time(); ?>" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="../logo hitam.png" alt="Logo">
        </div>
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input id = "searchInput" type="text" placeholder="Cari Produk" onkeyup="searchProducts()">
        </div>
        <script>
            function searchProducts(){
                let searchQuery = document.getElementById("searchInput").value.toLowerCase();
                let productCards = document.querySelectorAll(".product-card");
                productCards.forEach(function(card) {
                    let productName = card.querySelector(".product-info1 h4").textContent.toLowerCase();
                    if (productName.includes(searchQuery)){
                        card.style.display = "";
                    }else{
                        card.style.display = "none";
                    }
                });
            }
        </script>
    </div>

    <!-- Sidebar kiri -->
    <div class="sidebar">
        <ul>
            <li class="active">
                <i class="fas fa-shopping-cart"></i>
                <span>Keranjang</span>
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
            <li>
                <button class="btn-nobg" onclick="window.location.href='../riwayat/riwayat.php'">
                    <i class="fas fa-bell"></i>
                    <span>Riwayat</span>
                </button>
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
    <form action="input.php" method="post">
        <table class="product-grid">
            <?php
            include '../koneksi.php';
            $hasil = $koneksi->query("SELECT MAX(No_Invoice) AS MaxInvoice FROM invoice");
            $baris = $hasil->fetch_assoc();
            $no_invoice = $baris['MaxInvoice'];

            $sql = "SELECT * FROM produk ORDER BY Kode_Produk ASC";
            $result = $koneksi->query($sql);
            $produk = $result->fetch_all(MYSQLI_ASSOC);
            $count = 1;

            foreach ($produk as $tampil) {
                $gambarBase64 = base64_encode($tampil['Gambar']);
                ?>
                <td>
                    <div class="product-card">
                        <img src="data:image/jpeg;base64,<?= $gambarBase64 ?>" alt="Gambar Produk">
                        <div class="product-info1">
                            <h4><?= $tampil['Nama_Produk'] ?> <?= $tampil['Brand_Produk'] ?></h4>
                            <span class="product-stock">stok : <?= $tampil['Jumlah_Produk'] ?></span>
                            <p>Rp<?= number_format($tampil['Harga_Produk']) ?></p>
                            <div class="quantity">
                                <button type="button" class="btn btn-minus" onclick="handleCounterMin(this)">-</button>
                                <input type="number" name="quantity[<?= $tampil['Kode_Produk']?>]" class="counter" value="0" min="0" max="<?= $tampil['Jumlah_Produk'] ?>">
                                <button type="button" class="btn btn-plus" onclick="handleCounterPlus(this)">+</button>
                            </div>
                        </div>
                        
                        <input type='hidden' name='no_invoice' value='<?= $no_invoice ?>'>
                        <button type="submit" name="Kode_Produk" value="<?= $tampil['Kode_Produk'] ?>" class="add-to-cart">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </td>
                <?php
                if ($count % 3 == 0 && $count > 0) {
                    echo "</tr><tr>";
                }
                $count++;
            }
            ?>
            </tr>
        </table>
    </form>
    </div>
            
<script>
    function handleCounterPlus(button) {
        const counter = button.previousElementSibling;
        const max = parseInt(counter.max); // Ambil nilai maksimum dari atribut max
        if (parseInt(counter.value) < max) { // Periksa apakah nilai saat ini kurang dari maksimum
            counter.value = parseInt(counter.value) + 1;
        }
    }

    function handleCounterMin(button) {
        const counter = button.nextElementSibling;
        if (parseInt(counter.value) > 1) {
            counter.value = parseInt(counter.value) - 1;
        }
    }
</script>
    

    <div class="checkout-sidebar">
        <!-- Profil Karyawan -->
        <div class="profile">
            <div class="profile-info">
            <?php
                $id_karyawan = $_SESSION['ID_Karyawan'];
                $nama_karyawan = $_SESSION['Nama_Karyawan'];

                echo "
                <h4 class='profile-name'>$nama_karyawan</h4>
                <h4 class='profile-id'> #$id_karyawan</h4>
                "
            ?>
            </div>
        </div>
        <div class="profile-image-container">
            <img src="karyawan2.jpeg" alt="Profil Karyawan">
        </div>
        
        <div class="product-list">
    <table>
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
    <tr>
        <td>
            <div class="product-item">
                <div class="product-image">
                    <img src="data:image/jpeg;base64,<?= $gambarproduk ?>" alt="Gambar Produk">
                </div>
                <div class="product-details">
                    <p class="product-name"><?= $namaProduk ?> <?= $brandProduk ?></p>
                    <p class="product-code">#<?= $kodeProduk ?></p>
                    <p class="product-price">Rp<?= number_format($hargaproduk) ?> x<?= $show['Kuantitas_Produk'] ?></p>
                    <p class="product-subtotal">Sub Total : Rp<?= number_format($show['Sub_Total_Kuantitas_Tiap_Produk'])?></p>
                </div>
                <a href="delete.php?kode=<?= $kodeProduk ?>&invoice=<?= $no_invoice ?>" 
                class="product-remove" 
                onclick="return confirm('Yakin ingin menghapus produk ini?');">&times;</a>
            </div>
        </td>
    </tr>
    <?php
    }
    ?>
    </table>
</div>
    
        <!-- Total dan Check Out -->
        <div class="checkout-summary">
        <?php
            $result = $koneksi->query("SELECT SUM(Sub_Total_Kuantitas_Tiap_Produk) AS Total_Harga FROM detail_transaksi WHERE NO_Invoice = '$no_invoice'");
            $row = $result->fetch_assoc();
            $total_harga = $row['Total_Harga'];
            $pajak = $total_harga*0.1;
        ?>
            <div class="subtotal">
                <p><span>Total Harga:</span> <span class="value">Rp<?= number_format($total_harga) ?></span></p>
                <p><span>Pajak(10%):</span> <span class="value">Rp<?= number_format($pajak) ?></span></p>
                <p><span>Diskon:</span> <span class="value">-Rp0</span></p>
                <p><span><strong>TOTAL:</span> <span class="value">Rp<?= number_format($total_harga+$pajak) ?></strong></span></p>

            </div>
        </div>

        <div class="checkout-button-container">
            <button class="checkout-button" onclick="window.location.href='../checkout/checkout.php'">Check Out</button>
        </div>
    </div>
    
</body>
</html>

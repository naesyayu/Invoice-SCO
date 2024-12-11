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
    <link href="dashboard.css?v=<?php echo time(); ?>" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="../logo.png" alt="Logo">
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
                            <p><?= $tampil['Harga_Produk'] ?></p>
                            <div class="quantity">
                                <button type="button" class="btn" onclick="handleCounterPlus(this)">+</button>
                                <input type="number" name="quantity[<?= $tampil['Kode_Produk']?>]" class="counter" value="1">
                                <button type="button" class="btn" onclick="handleCounterMin(this)">-</button>
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
        const counter = button.nextElementSibling;
        counter.value = parseInt(counter.value) + 1;
    }

    function handleCounterMin(button) {
        const counter = button.previousElementSibling;
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
                <h4>$nama_karyawan</h4>
                <h4> #$id_karyawan</h4>
                <p class=\"location\">
                    <i class=\"fa fa-map-marker-alt\" aria-hidden=\"true\"></i> Bali, Indonesia
                </p>
                "
            ?>
            </div>
        </div>
        <div class="profile-image-container">
            <img src="karyawan.png" alt="Profil Karyawan">
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
                    <p class="product-info"><?= $kodeProduk ?></p>
                    <p class="product-price">Rp<?= number_format($hargaproduk) ?> x<?= $show['Kuantitas_Produk'] ?></p>
                </div>
                <!-- Ubah link hapus mengarah ke file hapus -->
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

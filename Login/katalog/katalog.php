<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Salford & CO</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="katalog.css?v=<?php echo time(); ?>" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="../restock/karyawan/logo putih.png" alt="Logo">
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
        <div class="title">
            <h1>Katalog</h1>
        </div>
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
                        <img src="data:image/jpeg;base64,<?= $gambarBase64 ?>" alt="Kaos NIKE Airstrike">
                        <div class="product-info1">
                            <h4><?= $tampil['Nama_Produk'] ?> <?= $tampil['Brand_Produk'] ?></h4>
                            <span class="product-size">Size : All size</span> 
                            <span class="product-stock">Stok : <?= $tampil['Jumlah_Produk'] ?></span>
                            <p>Rp <?= number_format($tampil['Harga_Produk']) ?></p>
                        </div>
                    </div>
                </td>
                <?php
                if ($count % 5 == 0 && $count > 0) {
                    echo "</tr><tr>";
                }
                $count++;
            }
            ?>
        </table>
    </form>    
    </div>
    
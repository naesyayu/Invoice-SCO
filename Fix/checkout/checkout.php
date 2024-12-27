<?php
include '../koneksi.php';
date_default_timezone_set('Asia/Jakarta');

if(isset($_GET['kodeqnty'])) {
    $kodeqnty = $_GET['kodeqnty'];
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['No_Hp_Pelanggan'])) {
    $No_Hp_Pelanggan = $_GET['No_Hp_Pelanggan'];
    $cari = $koneksi->query("SELECT ID_Pelanggan FROM pelanggan WHERE No_Hp_Pelanggan = '$No_Hp_Pelanggan'");
    $baris = $cari->fetch_assoc();
    $ID_Pelanggan = $baris['ID_Pelanggan'];

} else {
    $No_Hp_Pelanggan = "";
}
$tngglkode = date('Y/m/d');
$tanggal = date('l, d F Y', strtotime($tngglkode));

if(isset($_GET['Diskon'])) {
    $dskn = $_GET['Diskon'];
} else {
    $dskn = 0;
}
?>

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
        <ul class="product-list">
            <?php
            $hasil = $koneksi->query("SELECT MAX(No_Invoice) AS MaxInvoice FROM invoice");
            $baris = $hasil->fetch_assoc();
            $no_invoice = $baris['MaxInvoice'];

            $sql = "SELECT * FROM detail_transaksi WHERE NO_Invoice = '$no_invoice' ORDER BY no ASC";
            $result = $koneksi->query($sql);
            $produklist = $result->fetch_all(MYSQLI_ASSOC);
            $no = 1;

            // Cek apakah ada produk
            if (empty($produklist)) {
                echo "<h2 style='
                position: absolute; 
                top: 50%; 
                left: 50%; 
                transform: translate(-90%, -50%); 
                text-align: center; 
                color: #666;
                '>Tidak ada data produk</h2>";
            } else {
                foreach($produklist as $show) {
                    $queryProdukDetails = $koneksi->prepare("SELECT Nama_Produk, Jumlah_Produk, Brand_Produk, Harga_Produk, Gambar FROM produk WHERE Kode_Produk = ?");
                    $queryProdukDetails->bind_param("s", $show['Kode_Produk']);
                    $queryProdukDetails->execute();
                    $resultProdukDetails = $queryProdukDetails->get_result();
                    $produkDetails = $resultProdukDetails->fetch_assoc();

                    $namaProduk = $produkDetails['Nama_Produk'];
                    $brandProduk = $produkDetails['Brand_Produk'];
                    $hargaproduk = $produkDetails['Harga_Produk'];
                    $jumlah_produk = $produkDetails['Jumlah_Produk'];
                    $gambarproduk = base64_encode($produkDetails['Gambar']);
                    $kodeProduk = $show['Kode_Produk'];
            ?>
                <li class="product-item">
                    <img src="data:image/jpeg;base64,<?= $gambarproduk ?>" alt="Gambar Produk">
                    <div class="product-details">
                        <p class="product-name"><?= $namaProduk ?> <?= $brandProduk ?></p>
                        <p class="product-price">Rp<?= number_format($hargaproduk) ?> &nbsp;&nbsp;
                        <?php
                        if (isset($_GET['edit']) && $show['Kode_Produk'] == $kodeqnty) { 
                            $max=$jumlah_produk+$show['Kuantitas_Produk'];?>
                        <form action="editqnty.php" method="post">
                            <div class="kuantitas">
                            <button type="button" class="btn btn-minus" onclick="handleCounterMin(this)">-</button>
                            <input type="number" name="quantity[<?= $kodeProduk ?>]" class="counter" value="<?= $show['Kuantitas_Produk'] ?>" min="0" max="<?= $max ?>">
                            <button type="button" class="btn btn-plus" onclick="handleCounterPlus(this)">+</button>
                            <input type='hidden' name='Kode_Produk' value='<?= $kodeProduk ?>'>
                            <input type='hidden' name='No_Invoice' value='<?= $no_invoice ?>'>
                            </div>
                        <button type="submit" class="done">Done</button>
                        </form>
                        <?php
                        } else { ?>
                            x<?= $show['Kuantitas_Produk'] ?>
                            <button class="editqnty" onclick="window.location.href='checkout.php?edit=1&kodeqnty=<?= $kodeProduk ?>'">Edit</button>
                        <?php
                        } ?>
                        </p>
                    </div>
                    <div class="product-meta">
                        <div class="product-text">
                            <p class="product-code">#<?= $kodeProduk ?></p>
                            <p class="product-price-right">Rp<?= number_format($show['Sub_Total_Kuantitas_Tiap_Produk']) ?></p>
                        </div>
                        <a href="delete.php?kode=<?= $kodeProduk ?>&invoice=<?= $no_invoice ?>" 
                        class="product-remove" 
                        onclick="return confirm('Yakin ingin menghapus produk ini?');">&times;</a>
                    </div>
                </li>
            <?php
                }
            }
            ?>
        </ul>
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
        <form action="cekpelanggan.php" method="post">
        <div class="form-container">
            <input type="submit" class="btn-cari" value="Cari Pelanggan">
            <!-- No Telepon -->
            <div class="form-group dropdown">
                <label for="no-telepon">No Telepon</label>
                <input type="text" name="No_Hp_Pelanggan" value="<?= $No_Hp_Pelanggan ?>" id="no-telepon" placeholder="Masukkan Nomer Telepon">
                <?php
                $stmt = $koneksi->prepare("SELECT * FROM pelanggan WHERE No_Hp_Pelanggan = ?");
                $stmt->bind_param("s", $No_Hp_Pelanggan);
                $stmt->execute();
                $result = $stmt->get_result();
                $pelanggan = $result->fetch_assoc();
                ?>
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
            
            <!-- Nama Pelanggan -->
            <div class="form-group">
                <label for="nama-pelanggan">Nama Pelanggan</label>
                <input type="text" id="nama-pelanggan" value='<?= isset($pelanggan['Nama_Pelanggan']) ? htmlspecialchars($pelanggan['Nama_Pelanggan']) : '' ?>' readonly>
            </div>
            <!-- ID Pelanggan -->
            <div class="form-group">
                <label for="id-pelanggan">ID Pelanggan</label>
                <input type="text" id="id-pelanggan" value='<?= isset($pelanggan['ID_Pelanggan']) ? htmlspecialchars($pelanggan['ID_Pelanggan']) : '' ?>'  readonly>
            </div>
            <!-- Tanggal Transaksi -->
            <div class="form-group">
                <label for="tanggal-transaksi">Tanggal Transaksi</label>
                <p class="bold-text"><?= $tanggal ?></p>
            </div>
        </div>
        </form>

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
            $diskon = $dskn*$total_harga;
            
            if($No_Hp_Pelanggan>1) {
                $sql = "SELECT * FROM diskon";
                $result = $koneksi->query($sql);
        ?>

        <!-- Milih diskon -->
        <form method="GET" action="">
        <input type="hidden" name="No_Hp_Pelanggan" value="<?= $No_Hp_Pelanggan ?>">
        <label for="diskon" style="font-family: 'Poppins'; font-weight: 500; color: #042344; margin-right: 9px;">Pilih Diskon:  </label>
        <select class="pilihdisc" id="diskon" name="Diskon" onchange="this.form.submit()">
            <option value="">-- Pilih Diskon --</option>
        <?php
                foreach($result as $diskonlist) {
        ?>
            <option value="<?= $diskonlist['Diskon'] ?>"><?= $diskonlist['Nama_Diskon'] ?> <?= $diskonlist['Diskon']*100 ?>%</option>
        <?php
                }
                echo "</select></form>";
            }
        ?>
        <!-- Total dan Check Out -->
        <div class="checkout-summary">
            <div class="subtotal">
                <p><span>Total Harga:</span> <span class="value">Rp<?= number_format($total_harga) ?></span></p>
                <p><span>Pajak(10%):</span> <span class="value">Rp<?= number_format($pajak) ?></span></p>
                <p><span>Diskon(<?= $dskn*100 ?>%):</span> <span class="value">-Rp<?= number_format($diskon) ?></span></p>
                <p><span><strong>TOTAL:</span> <span class="value">Rp<?= number_format($total_harga+$pajak-$diskon) ?></strong></span></p>
            </div>
        </div>


        <?php
        if (empty($ID_Pelanggan)) {
            // Variabel ID_Pelanggan tidak kosong
            $ID_Pelanggan = 1;
        }
        ?>
        <div class="checkout-button-container">
            <button class="checkout-button" onclick="window.location.href='../cetakinv/cetakinv.php?input=1&no_invoice=<?= $no_invoice ?>&total_harga=<?= $total_harga ?>&tngglkode=<?= $tngglkode ?>&ID_Pelanggan=<?= $ID_Pelanggan ?>&diskon=<?= $diskon ?>'">Cetak Invoice</button>
        </div>
    </div>
    
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilihan Horizontal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>


    
<form>
    <div class="box">

            <h3 id="judul">Detail Produk</h3>
            <img src="adidas airflow.webp" id="foto">
            <div class="jenisproduk">
            <h5 id="jenisproduk">kaos</h5>
        </div>

        <h2 id="namabrg">Kaos Adidas</h2>
        <div class="hargastok">
            <h3 id="harga">Rp150.000</h3>
            <h5 id="stok">Stok : 25</h5>
        </div>
        <div class="warna1">
            <h5 id="warna1">warna</h5>
        </div>
        <div class="warna">
            <label class="choice">
                <input type="radio" name="option" value="merah">
                <span>merah</span>
            </label>
            <label class="choice">
                <input type="radio" name="option" value="biru">
                <span>biru</span>
            </label>
            <label class="choice">
                <input type="radio" name="option" value="hitam">
                <span>hitam</span>
            </label>
            <label class="choice">
                <input type="radio" name="option" value="putih">
                <span>putih</span>
            </label>
        </div>

        <div class="ukuran1">
            <h5 id="ukuran1">Ukuran</h5>
        </div>
        <div class="ukuran">
            <label class="choice">
                <input type="radio" name="option1" value="S">
                <span>S</span>
            </label>
            <label class="choice">
                <input type="radio" name="option1" value="M">
                <span>M</span>
            </label>
            <label class="choice">
                <input type="radio" name="option1" value="L">
                <span>L</span>
            </label>
            <label class="choice">
                <input type="radio" name="option1" value="XL">
                <span>XL</span>
            </label>
        </div>

        <div class="jumlah">
            <label class="jmlh">
                <input type="number" name="jmlh" placeholder="Masukkan Jumlah">
            </label>
        </div>
        
    </div>
    <div class="submit">
        <input type="submit" value="Masukkan">
    </div>
</form>
    
</body>
</html>

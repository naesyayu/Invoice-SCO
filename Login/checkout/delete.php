<?php
include '../koneksi.php';

if(isset($_GET['kode']) && isset($_GET['invoice'])) {
    $kode_produk = $koneksi->real_escape_string($_GET['kode']);
    $no_invoice = $koneksi->real_escape_string($_GET['invoice']);

    //mbalekne stok edisi jukuk jumlah pesenan e
    $hasil = $koneksi->query("SELECT Kuantitas_Produk FROM detail_transaksi WHERE NO_Invoice = '$no_invoice' AND Kode_Produk = '$kode_produk'");
    $baris = $hasil->fetch_assoc();
    $quantity = $baris['Kuantitas_Produk'];

    //mbalekne stok edisi ngitung
    $stok_stmt = $koneksi->prepare("UPDATE produk SET Jumlah_Produk = Jumlah_Produk + ? WHERE Kode_Produk = ?");
    $stok_stmt->bind_param("is", $quantity, $kode_produk);
    $stok_stmt->execute();

    $hapus_query = "DELETE FROM detail_transaksi 
                    WHERE NO_Invoice = '$no_invoice' 
                    AND Kode_Produk = '$kode_produk'";
    
    if($koneksi->query($hapus_query)) {
        header("Location: checkout.php?pesan=hapus_berhasil");
        exit();
    } else {
        header("Location: checkout.php?pesan=hapus_gagal");
        exit();
    }
} else {
    header("Location: checkout.php?pesan=parameter_tidak_valid");
    exit();
}
<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_invoice = $_POST['No_Invoice'];
    $kode_produk = $_POST['Kode_Produk'];

    //mbalekne stok edisi jukuk jumlah pesenan e
    $hasil = $koneksi->query("SELECT Kuantitas_Produk FROM detail_transaksi WHERE NO_Invoice = '$no_invoice' AND Kode_Produk = '$kode_produk'");
    $baris = $hasil->fetch_assoc();
    $qntitynow = $baris['Kuantitas_Produk'];

    $quantity = isset($_POST['quantity'][$kode_produk]) ? intval($_POST['quantity'][$kode_produk]) : 0; 

    if ($qntitynow > $quantity) {
        $kurang = $qntitynow - $quantity;
        $stok_stmt = $koneksi->prepare("UPDATE produk SET Jumlah_Produk = Jumlah_Produk + ? WHERE Kode_Produk = ?");
        $stok_stmt->bind_param("is", $kurang, $kode_produk);
        $stok_stmt->execute();
    } else if($qntitynow < $quantity) {
        $kurang = $quantity - $qntitynow;
        $stok_stmt = $koneksi->prepare("UPDATE produk SET Jumlah_Produk = Jumlah_Produk - ? WHERE Kode_Produk = ?");
        $stok_stmt->bind_param("is", $kurang, $kode_produk);
        $stok_stmt->execute();
    }

    $stmt = $koneksi->prepare("UPDATE detail_transaksi SET Kuantitas_Produk = ? WHERE Kode_Produk = ? AND No_Invoice = ? ");
    $stmt->bind_param("iss", $quantity, $kode_produk, $no_invoice);
    $stmt->execute();

    if ($stmt->execute()) {
        header("location: checkout.php");
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Metode tidak valid.";
}
?>
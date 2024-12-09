<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_invoice = $_POST['no_invoice'];
    $kode_produk = $_POST['Kode_Produk'];
    $quantity = isset($_POST['quantity'][$kode_produk]) ? intval($_POST['quantity'][$kode_produk]) : 0; 

    if ($quantity > 0) {
        // Ambil harga dari tabel produk
        $harga_stmt = $koneksi->prepare("SELECT Harga_Produk FROM produk WHERE Kode_Produk = ?");
        $harga_stmt->bind_param("s", $kode_produk);
        $harga_stmt->execute();
        $harga_stmt->bind_result($harga_produk);
        $harga_stmt->fetch();
        $harga_stmt->close();

        if (isset($harga_produk)) {
            // Hitung sub-total berdasarkan harga dan quantity
            $sub_total = $harga_produk * $quantity;

            // Masukkan data ke tabel detail_transaksi
            $insert_stmt = $koneksi->prepare("INSERT INTO detail_transaksi (NO_Invoice, Kode_Produk, Kuantitas_Produk, Sub_Total_Kuantitas_Tiap_Produk) VALUES (?, ?, ?, ?)");
            $insert_stmt->bind_param("isii", $no_invoice, $kode_produk, $quantity, $sub_total);

            if ($insert_stmt->execute()) {
                echo "Produk berhasil ditambahkan ke keranjang dengan harga Rp{$sub_total}.";
                header('location:dashboard.php');
            } else {
                echo "Gagal menambahkan produk: " . $insert_stmt->error;
            }
            $insert_stmt->close();
        } else {
            echo "Harga produk tidak ditemukan.";
        }
    } else {
        echo "Jumlah produk tidak valid.";
    }
} else {
    echo "Metode tidak valid.";
}

$koneksi->close();
?>

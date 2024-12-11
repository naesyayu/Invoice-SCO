<?php
include '../koneksi.php';

// Cek apakah parameter sudah terisi
if(isset($_GET['kode']) && isset($_GET['invoice'])) {
    // Escape string untuk keamanan
    $kode_produk = $koneksi->real_escape_string($_GET['kode']);
    $no_invoice = $koneksi->real_escape_string($_GET['invoice']);

    // Query untuk menghapus produk dari detail transaksi
    $hapus_query = "DELETE FROM detail_transaksi 
                    WHERE NO_Invoice = '$no_invoice' 
                    AND Kode_Produk = '$kode_produk'";
    
    // Jalankan query
    if($koneksi->query($hapus_query)) {
        // Redirect dengan pesan sukses
        header("Location: dashboard(2).php?pesan=hapus_berhasil");
        exit();
    } else {
        // Redirect dengan pesan error
        header("Location: dashboard(2).php?pesan=hapus_gagal");
        exit();
    }
} else {
    // Redirect jika parameter tidak lengkap
    header("Location: dashboard(2).php?pesan=parameter_tidak_valid");
    exit();
}
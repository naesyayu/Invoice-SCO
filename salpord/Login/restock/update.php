<?php
// koneksi database
include '../koneksi1.php';
// menangkap data yang di kirim dari form
$no = $_POST['no'];
$Kode_Produk = $_POST['Kode_Produk'];
$Nama_Produk = $_POST['Nama_Produk'];
$Brand_Produk = $_POST['Brand_Produk'];
$Harga_Produk = $_POST['Harga_Produk'];
$Jumlah_Produk = $_POST['Jumlah_Produk'];
// update data ke database
mysqli_query($koneksi,"update produk set Kode_Produk='$Kode_Produk', Nama_Produk='$Nama_Produk', Brand_Produk='$Brand_Produk', Harga_Produk='$Harga_Produk', Jumlah_Produk='$Jumlah_Produk' where no='$no'");
// mengalihkan halaman kembali ke index.php
header("location:restock.php");
?>
<?php
// koneksi database
include '../koneksi1.php';
// menangkap data yang di kirim dari form
//$no=$_POST['no'];
$Kode_Produk = $_POST['Kode_Produk'];
$Nama_Produk = $_POST['Nama_Produk'];
$Brand_Produk = $_POST['Brand_Produk'];
$Harga_Produk = $_POST['Harga_Produk'];
$Jumlah_Produk = $_POST['Jumlah_Produk'];
// menginput data ke database
mysqli_query($koneksi,"insert into produk values('$Kode_Produk','$Nama_Produk','$Brand_Produk','$Harga_Produk','$Jumlah_Produk')");
// mengalihkan halaman kembali ke index.php
header("location:restock.php");
?>

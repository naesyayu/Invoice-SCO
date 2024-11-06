<?php
// koneksi database
include '../koneksi1.php';
// menangkap data id yang di kirim dari url
$no = $_GET['no'];
// menghapus data dari database
mysqli_query($koneksi,"delete from produk where no='$no'");
// mengalihkan halaman kembali ke index.php
header("location:restock.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>CRUD PHP dan MySQLi</title>
</head>
<body>
<h2>CRUD ADMIN</h2>
<br/>
<a href="restock.php">KEMBALI</a>
<br/>
<br/>
<h3>EDIT DATA PRODUK</h3>
<?php
include '../koneksi1.php';
$no = $_GET['no'];
$data = mysqli_query($koneksi,"select * from produk where no ='$no'");
while($d = mysqli_fetch_array($data)){
?>
<form method="post" action="update.php">
<input type="hidden" name="no" value="<?php echo $d['no']; ?>">
<table>
<tr>
<td>Kode Produk</td>
<td>
<input type="text" name="Kode_Produk" value="<?php echo $d['Kode_Produk']; ?>">
</td>
</tr>
<tr>
<td>Nama Produk</td>
<td>
<input type="text" name="Nama_Produk" value="<?php echo $d['Nama_Produk'];?>">
</td>
</tr>
<tr>
<td>Brand Produk</td>
<td>
<input type="text" name="Brand_Produk" value="<?php echo $d['Brand_Produk'];?>">
</td>
</tr>
<tr>
<td>Harga Produk</td>
<td>
<input type="text" name="Harga_Produk" value="<?php echo $d['Harga_Produk'];?>">
</td>
</tr>
<tr>
<td>Jumlah Produk</td>
<td>
<input type="text" name="Jumlah_Produk" value="<?php echo $d['Jumlah_Produk'];?>">
</td>
</tr>
<tr>
<td></td>
<td><input type="submit" value="SIMPAN"></td>
</tr>
</table>
</form>
<?php
}
?>
</body>
</html>
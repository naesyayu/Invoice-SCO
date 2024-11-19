<?php 
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "salford.co"; 
$koneksi = mysqli_connect($host, $username, $password, $database); 
if ($koneksi->connect_error) { 
 die("Koneksi gagal: " . $koneksi->connect_error); 
} 
?>
<?php
$host = "localhost"; // Sesuaikan dengan konfigurasi server database Anda
$user = "root"; // Sesuaikan dengan username database Anda
$pass = ""; // Sesuaikan dengan password database Anda
$db = "salford_co";

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Mengecek koneksi
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
$sql = ("SELECT * FROM karyawan ORDER BY Nama_Karyawan ASC");
  $result = $koneksi->query($sql);
 
  //while ($tampil = $result->fetch_assoc()) {
    //echo "
    //<tr>
      //<td>$tampil[ID_Karyawan]</td>
      //<td>$tampil[Nama_Karyawan]</td>
      //<td>$tampil[No_Tlp_Karyawan]</td>
      //<td>$tampil[Email_Karyawan]</td>
      //<td>$tampil[Alamat_Karyawan]</td>
    //</tr>
    //";
  //}
?>

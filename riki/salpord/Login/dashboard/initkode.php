<?php
include '../koneksi.php';


$stmt = $koneksi->prepare("INSERT INTO invoice (Tanggal_Invoice, ID_Pelanggan, Sub_Total_Harga, Pajak, Total_Harga, ID_Karyawan, No_Rekening_Toko) VALUES (0, '1', 0, 0, 0, '2733', '0')");;


if ($stmt->execute()) {
    header('location:dashboard.php');
} else {
    echo "Gagal menambahkan invoice: " . $stmt->error;
}
?>
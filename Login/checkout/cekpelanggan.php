<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['No_Hp_Pelanggan'])) {
    $No_Hp_Pelanggan = $_POST['No_Hp_Pelanggan'];

    header("Location: checkout.php?No_Hp_Pelanggan=$No_Hp_Pelanggan");
    exit();
}
?>
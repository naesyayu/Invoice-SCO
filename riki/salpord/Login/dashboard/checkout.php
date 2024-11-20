<?php
session_start();
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['checkout'])) {
        
        $no_invoice = $_POST['no_invoice'];
        $sub_total_harga = $_POST['total_harga'];
        $tanggal = date('Y-m-d');
        $id_karyawan = $_SESSION['ID_Karyawan'];
        $pajak = $sub_total_harga*0.05;
        $total_harga=$sub_total_harga+$pajak;
        $no_rekening_toko='556790';

        $stmt = $koneksi->prepare("UPDATE invoice SET Tanggal_Invoice = ?, ID_Pelanggan ='1', Sub_Total_Harga = ?, Pajak = ?, Total_Harga=?, ID_Karyawan=?, No_Rekening_Toko=? WHERE NO_Invoice = ?");
        $stmt->bind_param("sdddsis", $tanggal, $sub_total_harga, $pajak, $total_harga, $id_karyawan, $no_rekening_toko, $no_invoice);

        if ($stmt->execute()) {
            echo "Data berhasil diupdate.";
        } else {
            echo "Gagal mengupdate data: " . $stmt->error;
        }


        echo"$no_invoice";
    } else {
        echo "Permintaan tidak valid.";
    }
} else {
    echo "Metode permintaan tidak valid.";
}

$koneksi->close();




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f4f4f4;
        }
        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .logout-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Logout</h1>
    <p>Klik tombol di bawah untuk logout.</p>
    <form action="logout.php" method="post">
        <button type="submit" class="logout-button">Logout</button>
    </form>
    <h1>dashboard</h1>
    <p>Klik tombol di bawah untuk kembali ke dashboard.</p>
    <form action="initkode.php" method="post">
        <button type="submit" class="logout-button">dashboard</button>
    </form>
</body>
</html>

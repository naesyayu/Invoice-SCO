<?php
include '../koneksi.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $kode_produk = $_POST['delete'];

        // Validasi untuk memastikan data yang dikirim
        if (!empty($kode_produk)) {
            $stmt = $koneksi->prepare("DELETE FROM detail_transaksi WHERE Kode_Produk = ?");
            $stmt->bind_param("s", $kode_produk);

            if ($stmt->execute()) {
                echo "Produk dengan Kode_Produk $kode_produk berhasil dihapus.";
                // Redirect kembali ke halaman sebelumnya
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            } else {
                echo "Gagal menghapus produk: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Kode Produk tidak valid.";
        }
    } else {
        echo "Permintaan tidak valid.";
    }
} else {
    echo "Metode permintaan tidak valid.";
}

$koneksi->close();
?>

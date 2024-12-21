<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_invoice = $_POST['no_invoice'];
    $kode_produk = $_POST['Kode_Produk'];
    $quantity = isset($_POST['quantity'][$kode_produk]) ? intval($_POST['quantity'][$kode_produk]) : 0; 

    if ($quantity > 0) {
        // Ambil harga dari tabel produk
        $harga_stmt = $koneksi->prepare("SELECT Harga_Produk FROM produk WHERE Kode_Produk = ?");
        $harga_stmt->bind_param("s", $kode_produk);
        $harga_stmt->execute();
        $harga_stmt->bind_result($harga_produk);
        $harga_stmt->fetch();
        $harga_stmt->close();

        // Mengurangi stok
        $stok_stmt = $koneksi->prepare("UPDATE produk SET Jumlah_Produk = Jumlah_Produk - ? WHERE Kode_Produk = ?");
        $stok_stmt->bind_param("is", $quantity, $kode_produk);
        $stok_stmt->execute();

        if (isset($harga_produk)) {
            // Hitung sub-total berdasarkan harga dan quantity
            $sub_total = $harga_produk * $quantity;

            // Cek apakah data sudah ada di detail_transaksi
            $check_stmt = $koneksi->prepare("SELECT Kuantitas_Produk FROM detail_transaksi WHERE NO_Invoice = ? AND Kode_Produk = ?");
            $check_stmt->bind_param("is", $no_invoice, $kode_produk);
            $check_stmt->execute();
            $check_stmt->bind_result($existing_quantity);
            $check_stmt->fetch();
            $check_stmt->close();

            if ($existing_quantity !== null) {
                // Jika sudah ada, update kuantitas dan subtotal
                $new_quantity = $existing_quantity + $quantity;
                $new_sub_total = $harga_produk * $new_quantity; // Hitung subtotal baru

                $update_stmt = $koneksi->prepare("UPDATE detail_transaksi SET Kuantitas_Produk = ?, Sub_Total_Kuantitas_Tiap_Produk = ? WHERE NO_Invoice = ? AND Kode_Produk = ?");
                $update_stmt->bind_param("iiss", $new_quantity, $new_sub_total, $no_invoice, $kode_produk);

                if ($update_stmt->execute()) {
                    echo "Produk berhasil diperbarui di keranjang dengan total kuantitas $new_quantity dan subtotal Rp{$new_sub_total}.";
                } else {
                    echo "Gagal memperbarui produk: " . $update_stmt->error;
                }
                $update_stmt->close();
            } else {
                // Jika belum ada, insert data baru
                $insert_stmt = $koneksi->prepare("INSERT INTO detail_transaksi (NO_Invoice, Kode_Produk, Kuantitas_Produk, Sub_Total_Kuantitas_Tiap_Produk) VALUES (?, ?, ?, ?)");
                $insert_stmt->bind_param("isii", $no_invoice, $kode_produk, $quantity, $sub_total);

                if ($insert_stmt->execute()) {
                    echo "Produk berhasil ditambahkan ke keranjang dengan harga Rp{$sub_total}.";
                } else {
                    echo "Gagal menambahkan produk: " . $insert_stmt->error;
                }
                $insert_stmt->close();
            }

            // Redirect ke halaman dashboard setelah operasi berhasil
            header('Location: dashboard(2).php');
            exit(); // Pastikan untuk keluar setelah header
        } else {
            echo "Harga produk tidak ditemukan.";
        }
    } else {
        echo "<script type='text/javascript'>alert('Jumlah Produk Tidak valid'); window.location.href='dashboard(2).php';</script>";
    }
} else {
    echo "Metode tidak valid.";
}

$koneksi->close();
exit();
?>
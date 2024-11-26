<!DOCTYPE html>
<html>
<head>
    <title>Data Produk</title>
    <style>
        .aksi button.edit {
            background-color: #FFFF00;
            color: #000000;
            width: 70px;
            height: 40px;
        }

        .aksi button.hapus {
            background-color: #FF0000;
            color: #FFFFFF;
            width: 70px;
            height: 40px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .logout-button {
            text-align: center;
            margin-top: 20px;
        }

        .logout-button input[type="submit"] {
            padding: 10px 20px;
            background-color: #ff5c5c;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .tombol button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="tombol">
    <a href="pelanggan/pelanggan.php">
        <button>tabel pelanggan</button>
    </a>
    <a href="karyawan/karyawan.php">
        <button>tabel karyawan</button>
    </a>
    <a href="logout.php">
        <button>logout</button>
    </a>
</div>

<?php
include "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_produk = $_POST['Kode_Produk'];
    $nama_produk = $_POST['Nama_Produk'];
    $brand_produk = $_POST['Brand_Produk'];
    $harga_produk = $_POST['Harga_Produk'];
    $jumlah_produk = $_POST['Jumlah_Produk'];
    

    if (isset($_POST['edit'])) {

        if (isset($_FILES['Gambar']) && $_FILES['Gambar']['error'] == UPLOAD_ERR_OK) {
            $gambar = file_get_contents($_FILES['Gambar']['tmp_name']);
            
            $stmt = $koneksi->prepare("UPDATE produk SET Nama_Produk = ?, Brand_Produk = ?, Harga_Produk = ?, Jumlah_Produk = ?,Gambar=? WHERE Kode_Produk = ?");
            $stmt->bind_param("ssdiss", $nama_produk, $brand_produk, $harga_produk, $jumlah_produk, $gambar, $kode_produk);
        } else {
            $stmt = $koneksi->prepare("UPDATE produk SET Nama_Produk = ?, Brand_Produk = ?, Harga_Produk = ?, Jumlah_Produk = ? WHERE Kode_Produk = ?");
            $stmt->bind_param("ssdis", $nama_produk, $brand_produk, $harga_produk, $jumlah_produk, $kode_produk);
        }
        
        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $stmt = $koneksi->prepare("INSERT INTO produk (Kode_Produk, Nama_Produk, Brand_Produk, Harga_Produk, Jumlah_Produk, Gambar) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdis", $kode_produk, $nama_produk, $brand_produk, $harga_produk, $jumlah_produk, $gambar);
        
        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

if (isset($_GET['delete'])) {
    $kode_produk = $_GET['delete'];
    
    $stmt = $koneksi->prepare("DELETE FROM produk WHERE Kode_Produk = ?");
    $stmt->bind_param("s", $kode_produk);
    
    if ($stmt->execute()) {
        echo " ";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$kode_produk = '';
$nama_produk = '';
$brand_produk = '';
$harga_produk = '';
$jumlah_produk = '';
$gambar_produk = ''; // Initialize a variable for the image data

if (isset($_GET['edit'])) {
    $kode_produk = $_GET['edit'];
    // Update the SQL query to select the 'gambar' field as well
    $sql = "SELECT * FROM produk WHERE Kode_Produk = '$kode_produk'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $nama_produk = $data['Nama_Produk'];
        $brand_produk = $data['Brand_Produk'];
        $harga_produk = $data['Harga_Produk'];
        $jumlah_produk = $data['Jumlah_Produk'];
        $gambar_produk = $data['Gambar']; // Get the image data
    }
}
?>

<form action="" enctype="multipart/form-data" method="POST">
    <table>
        <tr>
            <td><label for="Kode_Produk">Kode Produk:</label></td>
            <td><input type="text" name="Kode_Produk" value="<?php echo $kode_produk; ?>" required></td>
        </tr>
        <tr>
            <td><label for="Nama_Produk">Nama Produk:</label></td>
            <td><input type="text" name="Nama_Produk" value="<?php echo $nama_produk; ?>" required></td>
        </tr>
        <tr>
            <td><label for="Brand_Produk">Brand Produk:</label></td>
            <td><input type="text" name="Brand_Produk" value="<?php echo $brand_produk; ?>" required></td>
        </tr>
        <tr>
            <td><label for="Harga_Produk">Harga Produk:</label></td>
            <td><input type="number" name="Harga_Produk" value="<?php echo $harga_produk; ?>" required></td>
        </tr>
        <tr>
            <td><label for="Jumlah_Produk">Jumlah Produk:</label></td>
            <td><input type="number" name="Jumlah_Produk" value="<?php echo $jumlah_produk; ?>" required></td>
        </tr>
        <tr>
            <td><label for="Gambar">Gambar:</label></td>
            <td>
                <?php if (!empty($gambar_produk)): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($gambar_produk) ?>" alt="Gambar Produk" style="width:100px;height:auto;" />
                <?php endif; ?>
                <input type="file" name="Gambar">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php if ($kode_produk != ''): ?>
                    <input type="hidden" name="edit" value="true">
                    <input type="submit" value="Update Data">
                <?php else: ?>
                    <input type="submit" value="Simpan Data">
                <?php endif; ?>
            </td>
        </tr>
    </table>
</form>

<table>
    <tr>
        <th>Kode Produk</th>
        <th>Nama Produk</th>
        <th>Brand Produk</th>
        <th>Harga Produk</th>
        <th>Jumlah Produk</th>
        <th>Gambar</th>
        <th>Aksi</th>
    </tr>

    <?php
    $sql = "SELECT * FROM produk ORDER BY Kode_Produk ASC";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        while ($tampil = $result->fetch_assoc()) {
            $gambarBase64 = base64_encode($tampil['Gambar']);
        
            echo "
            <tr>
                <td>{$tampil['Kode_Produk']}</td>
                <td>{$tampil['Nama_Produk']}</td>
                <td>{$tampil['Brand_Produk']}</td>
                <td>{$tampil['Harga_Produk']}</td>
                <td>{$tampil['Jumlah_Produk']}</td>
                <td><img src='data:image/jpeg;base64,{$gambarBase64}' alt='Gambar Produk' width='100' height='100'></td>
                <td class='aksi'>
                    <button class='edit' onclick='window.location.href=\"?edit={$tampil['Kode_Produk']}\"'>Edit</button>
                    <button class='hapus' onclick='if (confirm(\"Yakin ingin menghapus?\")) window.location.href=\"?delete={$tampil['Kode_Produk']}\"'>Hapus</button>
                </td>
            </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='6'>Tidak ada data produk</td></tr>";
    }
    ?>
</table>

</body>
</html>

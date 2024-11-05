<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>
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

        input[type="text"] {
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

    </style>
</head>
<body>

<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_hp_pelanggan = $_POST['no_hp_pelanggan'];
    $email_pelanggan = $_POST['email_pelanggan'];
    $alamat_pelanggan = $_POST['alamat_pelanggan'];

    // Jika tombol edit ditekan, lakukan update data
    if (isset($_POST['edit'])) {
        $sql = "UPDATE pelanggan SET Nama_Pelanggan='$nama_pelanggan', No_Hp_Pelanggan='$no_hp_pelanggan', Email_Pelanggan='$email_pelanggan', Alamat_Pelanggan='$alamat_pelanggan' WHERE ID_Pelanggan='$id_pelanggan'";
        if ($koneksi->query($sql) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    } else { // Jika tidak, lakukan insert data baru
        $sql = "INSERT INTO pelanggan (ID_Pelanggan, Nama_Pelanggan, No_Hp_Pelanggan, Email_Pelanggan, Alamat_Pelanggan) VALUES ('$id_pelanggan', '$nama_pelanggan', '$no_hp_pelanggan', '$email_pelanggan', '$alamat_pelanggan')";
        if ($koneksi->query($sql) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    }
}

// Fungsi delete data
if (isset($_GET['delete'])) {
    $id_pelanggan = $_GET['delete'];
    $sql = "DELETE FROM pelanggan WHERE ID_Pelanggan='$id_pelanggan'";
    if ($koneksi->query($sql) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

// Fungsi untuk mendapatkan data edit
$id_pelanggan = '';
$nama_pelanggan = '';
$no_hp_pelanggan = '';
$email_pelanggan = '';
$alamat_pelanggan = '';
if (isset($_GET['edit'])) {
    $id_pelanggan = $_GET['edit'];
    $sql = "SELECT * FROM pelanggan WHERE ID_Pelanggan='$id_pelanggan'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $nama_pelanggan = $data['Nama_Pelanggan'];
        $no_hp_pelanggan = $data['No_Hp_Pelanggan'];
        $email_pelanggan = $data['Email_Pelanggan'];
        $alamat_pelanggan = $data['Alamat_Pelanggan'];
    }
}
?>

<!-- Form Input -->
<form action="" method="POST">
    <table>
        <tr>
            <td><label for="id_pelanggan">ID Pelanggan:</label></td>
            <td><input type="text" name="id_pelanggan" value="<?php echo htmlspecialchars($id_pelanggan); ?>" required></td>
        </tr>
        <tr>
            <td><label for="nama_pelanggan">Nama Pelanggan:</label></td>
            <td><input type="text" name="nama_pelanggan" value="<?php echo htmlspecialchars($nama_pelanggan); ?>" required></td>
        </tr>
        <tr>
            <td><label for="no_hp_pelanggan">No Telepon Pelanggan:</label></td>
            <td><input type="text" name="no_hp_pelanggan" value="<?php echo htmlspecialchars($no_hp_pelanggan); ?>" required></td>
        </tr>
        <tr>
            <td><label for="email_pelanggan">Email Pelanggan:</label></td>
            <td><input type="text" name="email_pelanggan" value="<?php echo htmlspecialchars($email_pelanggan); ?>" required></td>
        </tr>
        <tr>
            <td><label for="alamat_pelanggan">Alamat Pelanggan:</label></td>
            <td><input type="text" name="alamat_pelanggan" value="<?php echo htmlspecialchars($alamat_pelanggan); ?>" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <?php if ($id_pelanggan != ''): ?>
                    <input type="hidden" name="edit" value="true">
                    <input type="submit" value="Update Data">
                <?php else: ?>
                    <input type="submit" value="Simpan Data">
                <?php endif; ?>
            </td>
        </tr>
    </table>
</form>

<!-- Tabel Data Pelanggan -->
<table>
    <tr>
        <th>ID Pelanggan</th>
        <th>Nama Pelanggan</th>
        <th>No Telepon</th>
        <th>Email</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>

    <?php
    $sql = "SELECT * FROM pelanggan ORDER BY Nama_Pelanggan ASC";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        while ($tampil = $result->fetch_assoc()) {
            echo "
            <tr>
                <td>" . htmlspecialchars($tampil['ID_Pelanggan']) . "</td>
                <td>" . htmlspecialchars($tampil['Nama_Pelanggan']) . "</td>
                <td>" . htmlspecialchars($tampil['No_Hp_Pelanggan']) . "</td>
                <td>" . htmlspecialchars($tampil['Email_Pelanggan']) . "</td>
                <td>" . htmlspecialchars($tampil['Alamat_Pelanggan']) . "</td>
                <td class='aksi'>
                    <button class='edit' onclick='window.location.href=\"?edit=" . urlencode($tampil['ID_Pelanggan']) . "\"'>Edit</button>
                    <button class='hapus' onclick='if (confirm(\"Yakin ingin menghapus?\")) window.location.href=\"?delete=" . urlencode($tampil['ID_Pelanggan']) . "\"'>Hapus</button>
                </td>
            </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='6'>Tidak ada data Pelanggan</td></tr>";
    }
    ?>
</table>

</body>
</html>
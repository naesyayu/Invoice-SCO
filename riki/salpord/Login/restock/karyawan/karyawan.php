<!DOCTYPE html>
<html>
<head>
    <title>Data Karyawan</title>
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
    <a href="../pelanggan/pelanggan.php">
        <button>tabel pelanggan</button>
    </a>
    <a href="../restock.php">
        <button>tabel produk</button>
    </a>
    <a href="../../login.php">
        <button>logout</button>
    </a>
</div>

<?php
include "../../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_karyawan = $_POST['id_karyawan'];
    $nama_karyawan = $_POST['nama_karyawan'];
    $no_tlp_karyawan = $_POST['no_tlp_karyawan'];
    $email_karyawan = $_POST['email_karyawan'];
    $alamat_karyawan = $_POST['alamat_karyawan'];

    if (isset($_POST['edit'])) {
        $sql = "UPDATE karyawan SET Nama_Karyawan='$nama_karyawan', No_Tlp_Karyawan='$no_tlp_karyawan', Email_Karyawan='$email_karyawan', Alamat_Karyawan='$alamat_karyawan' WHERE ID_Karyawan='$id_karyawan'";
        if ($koneksi->query($sql) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    } else {
        $sql = "INSERT INTO karyawan (ID_Karyawan, Nama_Karyawan, No_Tlp_Karyawan, Email_Karyawan, Alamat_Karyawan) VALUES ('$id_karyawan', '$nama_karyawan', '$no_tlp_karyawan', '$email_karyawan', '$alamat_karyawan')";
        if ($koneksi->query($sql) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    }
}

if (isset($_GET['delete'])) {
    $id_karyawan = $_GET['delete'];
    $sql = "DELETE FROM karyawan WHERE ID_Karyawan='$id_karyawan'";
    if ($koneksi->query($sql) === TRUE) {
        echo " ";
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

$id_karyawan = '';
$nama_karyawan = '';
$no_tlp_karyawan = '';
$email_karyawan = '';
$alamat_karyawan = '';
if (isset($_GET['edit'])) {
    $id_karyawan = $_GET['edit'];
    $sql = "SELECT * FROM karyawan WHERE ID_Karyawan='$id_karyawan'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $nama_karyawan = $data['Nama_Karyawan'];
        $no_tlp_karyawan = $data['No_Tlp_Karyawan'];
        $email_karyawan = $data['Email_Karyawan'];
        $alamat_karyawan = $data['Alamat_Karyawan'];
    }
}
?>

<form action="" method="POST">
    <table>
        <tr>
            <td><label for="id_karyawan">ID Karyawan:</label></td>
            <td><input type="text" name="id_karyawan" value="<?php echo $id_karyawan; ?>" required></td>
        </tr>
        <tr>
            <td><label for="nama_karyawan">Nama Karyawan:</label></td>
            <td><input type="text" name="nama_karyawan" value="<?php echo $nama_karyawan; ?>" required></td>
        </tr>
        <tr>
            <td><label for="no_tlp_karyawan">No Telepon Karyawan:</label></td>
            <td><input type="text" name="no_tlp_karyawan" value="<?php echo $no_tlp_karyawan; ?>" required></td>
        </tr>
        <tr>
            <td><label for="email_karyawan">Email Karyawan:</label></td>
            <td><input type="text" name="email_karyawan" value="<?php echo $email_karyawan; ?>" required></td>
        </tr>
        <tr>
            <td><label for="alamat_karyawan">Alamat Karyawan:</label></td>
            <td><input type="text" name="alamat_karyawan" value="<?php echo $alamat_karyawan; ?>" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <?php if ($id_karyawan != ''): ?>
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
        <th>ID Karyawan</th>
        <th>Nama Karyawan</th>
        <th>No Telepon</th>
        <th>Email</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>

    <?php
    $sql = "SELECT * FROM karyawan ORDER BY ID_Karyawan ASC";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        while ($tampil = $result->fetch_assoc()) {
            echo "
            <tr>
                <td>{$tampil['ID_Karyawan']}</td>
                <td>{$tampil['Nama_Karyawan']}</td>
                <td>{$tampil['No_Tlp_Karyawan']}</td>
                <td>{$tampil['Email_Karyawan']}</td>
                <td>{$tampil['Alamat_Karyawan']}</td>
                <td class='aksi'>
                    <button class='edit' onclick='window.location.href=\"?edit={$tampil['ID_Karyawan']}\"'>Edit</button>
                    <button class='hapus' onclick='if (confirm(\"Yakin ingin menghapus?\")) window.location.href=\"?delete={$tampil['ID_Karyawan']}\"'>Hapus</button>
                </td>
            </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='6'>Tidak ada data karyawan</td></tr>";
    }
    ?>
</table>

</body>
</html>
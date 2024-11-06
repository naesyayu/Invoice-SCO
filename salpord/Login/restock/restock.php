<!DOCTYPE html>
<html>
<head>
<title>CRUD PHP dan MySQLi</title>
<link rel="stylesheet" href="desain.css">
</head>
<body>
    <div class="all">
    <h2>CRUD ADMIN</h2>
    <br/>
    <p><a href="logout.php">Logout</a></p>
    <br>
    <a href="tambah.php">+ TAMBAH PRODUK</a>
    <br/>
    <br/>
    <table border="1">
    <tr>
    <th>NO</th>
    <th>Kode Produk</th>
    <th>Nama Produk</th>
    <th>Brand Produk</th>
    <th>Harga Produk</th>
    <th>Jumlah Produk</th>
    <th>OPSI</th>
    </tr>
    <?php
    include '../koneksi1.php';
    $no = 1;
    $data = mysqli_query($koneksi,"select * from produk");
    while($d = mysqli_fetch_array($data)){
    ?>
    <tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $d['Kode_Produk']; ?></td>
    <td><?php echo $d['Nama_Produk']; ?></td>
    <td><?php echo $d['Brand_Produk']; ?></td>
    <td><?php echo $d['Harga_Produk']; ?></td>
    <td><?php echo $d['Jumlah_Produk']; ?></td>
    <td>
    <a href="edit.php?no=<?php echo $d['no']; ?>">EDIT</a>
    <a href="hapus.php?no=<?php echo $d['no']; ?>">HAPUS</a>
    </td>
    </tr>
    <?php
    }
    ?>
    </table>
</div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD PHP dan MySQLi</title>
</head>
<body>
    <h2>CRUD ADMIN</h2>
    <br/>
    <a href="restock.php">KEMBALI</a>
    <br/><br/>
    <h3>TAMBAH DATA PRODUK</h3>
    <form method="post" action="tambah_aksi.php">
        <table>
            <tr>
                <td>Kode Produk</td>
                <td><input type="number" name="Kode_Produk"></td>
            </tr>
            <tr>
                <td>Nama Produk</td>
                <td><input type="text" name="Nama_Produk"></td>
            </tr>
            <tr>
                <td>Brand Produk</td>
                <td><input type="text" name="Brand_Produk"></td>
            </tr>
            <tr>
                <td>Harga Produk</td>
                <td><input type="number" name="Harga_Produk"></td>
            </tr>
            <tr>
                <td>Jumlah Produk</td>
                <td><input type="number" name="Jumlah_Produk"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="SIMPAN"></td>
            </tr>
        </table>
    </form>
</body>
</html>
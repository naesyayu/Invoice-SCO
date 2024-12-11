<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salford & CO | Login Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="loginadmin.css" rel="stylesheet">
</head>
<body>
    <div class="container">
            <div class="left-section">
                <img src="sco.png" alt="Salford & Co Logo"> <!-- Replace with the actual logo source -->
                <h1>SALFORD & CO.</h1>
                <p>Fashion Terlengkap</p>
            </div>
            <div class="right-section">
                <h2>Login<br>Akun Admin</h2>
                <form method="POST" action="">
                 <input type="text" class="nama" name="Nama_Admin" placeholder="Masukkan Username Admin" required><br>
                 <input type="text" class="pw" name="ID_Admin" placeholder="Masukkan ID Admin" required><br>
                 <button type="submit" name="login">LOGIN</button>
                </form>
            </div>
    </div>

    <?php
// PHP Script untuk validasi login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['Nama_Admin']; // Ambil input username
    $id = $_POST['ID_Admin'];        // Ambil input ID Admin

    // Daftar admin yang valid
    $validAdmins = [
        "admin1" => "1212",
        "admin2" => "1313",
        "admin3" => "1414"
    ];

    // Cek validasi
    if (array_key_exists($username, $validAdmins) && $validAdmins[$username] === $id) {
        // Redirect ke dashboard jika login berhasil
        header("Location: crudproduk.php");
        exit;
    } else {
        // Jika login gagal, tampilkan pesan error
        echo "<script>alert('Username atau ID Admin salah!');</script>";
    }
}
?>

</body>
</html>

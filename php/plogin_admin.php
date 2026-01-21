<?php
session_start();
require("konfig.php");

// Username dan password admin (hardcoded untuk contoh - bisa diubah ke database)
$admin_username = "admin";
$admin_password = "admin123"; // Di production, gunakan password_hash()

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Cek kredensial admin
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin'] = true;
        $_SESSION['username'] = $username;
        header("Location: admin/admin.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Login Admin</title>
    <link rel="stylesheet" href="../css/login.css" />
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <p>Silahkan login sebagai admin</p>
    </header>

    <div class="container">
        <h3>Login Admin</h3>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="plogin_admin.php" method="post">
            <input type="text" name="username" placeholder="Username" />
            <input type="password" name="password" placeholder="Password" />
            <button type="submit">Login</button>
        </form>
        
        <p><a href="login.php">Kembali ke login user</a></p>
    </div>

    <script src="js/script.js"></script>
</body>
</html>

<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css" />
  </head>
  <body>
    <header>
      <h1>Selamat Datang</h1>
      <p>Silahkan login untuk mengunjungi website ragam budaya Indonesia</p>
    </header>

    <div class="container">
      <h3>Silakan Login</h3>
      <p>Untuk akses fitur <strong>CRUD</strong> silahkan <a href="admin/login_admin.html" target="_blank">Klik Disini</a>.</p>
      <?php if (isset($_GET['pesan'])) { ?>
        <div class="alert alert-custom mb-4">
            <?php echo $_GET['pesan']; ?>
        </div>
    <?php } ?>
      <form action="plogin.php" method="post">
        <input type="text" name="username" placeholder="Username" />
        <input type="password" name="password" placeholder="Password" />
        <button type="submit">Login</button>
      </form>
      
      <p>Tidak punya akun? Silahkan registrasi di bawah</p>
      <a href="registrasi.php" class="btn-register">Registrasi</a>
      <p id="loginMsg" style="color: red"></p>
    </div>

    <script src="js/script.js"></script>
  </body>
</html>

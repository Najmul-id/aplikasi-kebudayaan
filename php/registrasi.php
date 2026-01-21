<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Registrasi</title>
    <link rel="stylesheet" href="../css/login.css" />
    <style>
        .error-msg {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
    </style>
  </head>
  <body>
    <header>
      <h1>Selamat Datang</h1>
      <p>Silahkan registrasi untuk membuat akun</p>
    </header>

    <div class="container">
      <h3>Silakan Registrasi</h3>
      <?php if (isset($_GET['pesan'])) { ?>
        <div class="alert alert-custom mb-4">
            <?php echo htmlspecialchars($_GET['pesan']); ?>
        </div>
      <?php } ?>
      <form action="pregistrasi.php" method="post">
        <input type="text" name="username" placeholder="Username (minimal 3 karakter)" required />
        <input type="password" name="password" placeholder="Password (minimal 6 karakter)" required />
        <button type="submit">Registrasi</button>
      </form>

      <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>

    <script src="../js/script.js"></script>
  </body>
</html>

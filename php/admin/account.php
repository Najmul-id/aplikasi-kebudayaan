<?php
session_start();
require '../konfig.php'; // file koneksi database

// Cek login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Hapus user
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $koneksi->prepare("DELETE FROM pengguna WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: account.php");
    exit;
}

// Update user
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($password)) {
        // hash password baru
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $koneksi->prepare("UPDATE pengguna SET username=?, pass=? WHERE id=?");
        $stmt->bind_param("ssi", $username, $hash, $id);
    } else {
        $stmt = $koneksi->prepare("UPDATE pengguna SET username=? WHERE id=?");
        $stmt->bind_param("si", $username, $id);
    }

    $stmt->execute();
    $stmt->close();
    header("Location: account.php");
    exit;
}

// Ambil data user
$result = $koneksi->query("SELECT * FROM pengguna");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Account Admin | Nusantara Budaya</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>

<body>
    <aside class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="budaya.php">Budaya Nusantara</a></li>
            <li><a href="festival.php">Festival Budaya</a></li>
            <li><a href="seniman.php">Seniman</a></li>
            <li><a href="../../user.html" class="view-website">View Website</a></li>
            <a href="logout.php" class="logout-btn">Logout</a>
        </ul>
    </aside>

    <main class="main">
        <header class="topbar">
            <h1>Manage Account</h1>
        </header>

        <section class="table-section">
            <h2>Data Admin</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Password (Hash)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= substr($row['pass'], 0, 20) . '...' ?></td>
                            <td>
                                <!-- EDIT menggunakan json_encode agar aman di JS -->
                                <a href="#" onclick='editUser(<?= $row['id'] ?>, <?= json_encode($row['username']) ?>)'
                                    class="edit">Edit</a>
                                <a href="account.php?delete=<?= $row['id'] ?>" class="delete"
                                    onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <!-- Form Edit User (Popup) -->
        <div id="editModal"
            style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;">
            <form method="POST" style="background:#fff;padding:30px;border-radius:12px;max-width:400px;width:90%;">
                <h3>Edit User</h3>
                <input type="hidden" name="id" id="editId">
                <label>Username:</label>
                <input type="text" name="username" id="editUsername" required>
                <label>Password baru (biarkan kosong jika tidak ingin mengganti):</label>
                <input type="password" name="password">
                <div style="margin-top:15px;">
                    <button type="submit" name="update" class="btn">Update</button>
                    <button type="button" onclick="closeModal()" class="btn"
                        style="background:#ccc;color:#000;">Batal</button>
                </div>
            </form>
        </div>

    </main>

    <script>
        function editUser(id, username) {
            const modal = document.getElementById('editModal');
            document.getElementById('editId').value = id;
            document.getElementById('editUsername').value = username;
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('show'), 10);
        }

        function closeModal() {
            const modal = document.getElementById('editModal');
            modal.classList.remove('show');
            setTimeout(() => modal.style.display = 'none', 300);
        }

    </script>
</body>

</html>
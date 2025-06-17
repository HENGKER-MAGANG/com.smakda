<?php
require_once 'config/db.php'; // Pastikan path ini sesuai struktur kamu

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $role = $_POST['role'];
    $plainPassword = $_POST['password'];
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (nisn, nama, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nisn, $nama, $hashedPassword, $role);

    if ($stmt->execute()) {
        $success = "User berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan user: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah User Manual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h4 class="card-title mb-4">Tambah User Manual</h4>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php elseif ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label>NISN</label>
                        <input type="text" name="nisn" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="sekretaris">Sekretaris</option>
                            <option value="bendahara">Bendahara</option>
                            <option value="ketua">Ketua</option>
                            <option value="anggota">Anggota</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="text" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w-100">Tambah User</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

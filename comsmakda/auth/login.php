<?php
session_start();
require_once '../config/db.php';
require_once '../config/functions.php'; // Untuk fungsi log aktivitas

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nisn = $_POST['nisn'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE nisn = ?");
    $stmt->bind_param("s", $nisn);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        log_aktivitas($conn, $user['id'], 'Login ke sistem');
        header("Location: ../dashboard/{$user['role']}.php");
        exit;
    } else {
        $error = "NISN atau password salah!";
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-4">Login <span class="text-primary">ComSMAKDA</span></h3>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="form-floating mb-3">
                <input type="text" name="nisn" id="nisn" class="form-control" placeholder="NISN" required>
                <label for="nisn">NISN</label>
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
            <button type="button" class="btn btn-danger w-100 mt-2">Kembali</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

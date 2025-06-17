<?php
include '../includes/auth.php';
include '../includes/header.php';
include '../includes/navbar.php';
include '../config/db.php';

// Ambil semua user
$users = $conn->query("SELECT id, nama FROM users WHERE status='aktif'");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $pesan = htmlspecialchars($_POST['pesan']);

    $stmt = $conn->prepare("INSERT INTO notifikasi (user_id, pesan) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $pesan);
    $stmt->execute();

    echo "<script>alert('Notifikasi dikirim!'); window.location.href='kirim.php';</script>";
}
?>

<div class="container mt-4">
    <h4>Kirim Notifikasi</h4>
    <form method="post">
        <div class="mb-3">
            <label>Untuk User</label>
            <select name="user_id" class="form-control" required>
                <?php while ($u = $users->fetch_assoc()): ?>
                    <option value="<?= $u['id'] ?>"><?= $u['nama'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Pesan</label>
            <textarea name="pesan" class="form-control" required></textarea>
        </div>
        <button class="btn btn-primary">Kirim</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>

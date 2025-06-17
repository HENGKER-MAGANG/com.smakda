<?php
session_start();
require_once '../config/db.php';

$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $project = $_POST['project'];
    $deskripsi = $_POST['deskripsi'];

    $stmt = $conn->prepare("INSERT INTO pemesanan (nama, email, project, deskripsi) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $email, $project, $deskripsi);
    if ($stmt->execute()) {
        $success = "Pemesanan berhasil dikirim!";
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">
    <h3>Form Pemesanan Jasa</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email Aktif</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Judul Proyek</label>
            <input type="text" name="project" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Pemesanan</button>
                <div class="col-md-3 mb-3">
            <a href="tracking.php" class="btn btn-outline-dark w-100">Tracking Pesanan</a>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>

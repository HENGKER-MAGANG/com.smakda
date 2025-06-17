<?php
session_start();
require_once '../config/db.php';
include '../includes/cek_login.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body text-center">
            <img src="../assets/images/<?= htmlspecialchars($user['foto']) ?>" class="rounded-circle mb-3" width="120" height="120" alt="Foto Profil">
            <h4><?= htmlspecialchars($user['nama']) ?></h4>
            <p class="text-muted"><?= htmlspecialchars($user['nisn']) ?></p>
            <ul class="list-group list-group-flush text-start mt-3">
                <li class="list-group-item"><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></li>
                <li class="list-group-item"><strong>Status:</strong> <?= htmlspecialchars($user['status']) ?></li>
                <li class="list-group-item"><strong>Tanggal Daftar:</strong> <?= $user['tanggal_daftar'] ?></li>
            </ul>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<?php
include '../includes/auth.php';
checkRole(['anggota']);
include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">
    <h3>Dashboard Anggota</h3>
    <p>Selamat datang, <?= $_SESSION['nama'] ?>!</p>
    <p>
        <a href="/comsmakda/profil/user.php" class="btn btn-outline-primary">Lihat Profil</a>
        <a href="/comsmakda/kegiatan/agenda.php" class="btn btn-outline-success">Lihat Kegiatan</a>
    </p>
</div>

<?php include '../includes/footer.php'; ?>

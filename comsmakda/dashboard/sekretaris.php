<?php
include '../includes/auth.php';
checkRole(['sekretaris']);
include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">
    <h3>Dashboard Sekretaris</h3>
    <p>Menu: 
        <a href="/comsmakda/kegiatan/agenda.php" class="btn btn-primary">Agenda Kegiatan</a>
        <a href="/comsmakda/kegiatan/tambah.php" class="btn btn-success">Tambah Kegiatan</a>
        <a href="/comsmakda/absensi/index.php" class="btn btn-warning">Kelola Absensi</a>
    </p>
</div>

<?php include '../includes/footer.php'; ?>

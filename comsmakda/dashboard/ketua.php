<?php
include '../includes/auth.php';
checkRole(['ketua']);
include '../config/db.php';
include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">
    <h3>Dashboard Ketua</h3>
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Anggota</h5>
                    <?php
                    $anggota = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='anggota'");
                    $total = $anggota->fetch_assoc()['total'];
                    ?>
                    <p class="card-text fs-3"><?= $total ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Kas Masuk</h5>
                    <?php
                    $kas = $conn->query("SELECT SUM(jumlah) as total FROM kas");
                    $total_kas = $kas->fetch_assoc()['total'] ?? 0;
                    ?>
                    <p class="card-text fs-3">Rp <?= number_format($total_kas, 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
        <p>
            <a href="/comsmakda/kegiatan/agenda.php" class="btn btn-primary">Agenda Kegiatan</a>
            <a href="/comsmakda/kegiatan/tambah.php" class="btn btn-success">Tambah Kegiatan</a>
            <a href="/comsmakda/absensi/index.php" class="btn btn-warning">Kelola Absensi</a>
            <a href="/comsmakda/absensi/index.php" class="btn btn-danger">Generate Sertifikat</a>
        </p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

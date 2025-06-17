
<?php
include '../includes/header.php';
include '../includes/navbar.php';
include '../config/db.php';

// Ambil semua dokumentasi
date_default_timezone_set('Asia/Jakarta');
$stmt = $conn->query("SELECT d.id, d.judul, d.gambar, d.tanggal_upload, k.nama_kegiatan FROM dokumentasi d LEFT JOIN kegiatan k ON d.kegiatan_id = k.id ORDER BY d.tanggal_upload DESC");
?>

<div class="container mt-5">
    <h2 class="mb-4">Dokumentasi Kegiatan</h2>
    <div class="row">
        <?php while ($row = $stmt->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="../assets/images/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['judul']) ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                        <p class="card-text"><small><?= htmlspecialchars($row['nama_kegiatan']) ?> - <?= htmlspecialchars($row['tanggal_upload']) ?></small></p>
                        <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>



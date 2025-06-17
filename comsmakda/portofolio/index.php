<?php
require_once '../config/db.php';
$portofolio = $conn->query("SELECT * FROM portofolio ORDER BY tanggal_upload DESC");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">
    <h3 class="mb-4">Portofolio Karya ComSMAKDA</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php while ($row = $portofolio->fetch_assoc()): ?>
        <div class="col">
            <div class="card h-100">
                <img src="../assets/images/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['judul']) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                    <p class="card-text"><?= substr(strip_tags($row['deskripsi']), 0, 80) ?>...</p>
                    <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

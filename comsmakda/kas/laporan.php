<?php
include '../includes/auth.php';
checkRole(['ketua', 'bendahara']);
include '../config/db.php';
include '../includes/header.php';
include '../includes/navbar.php';

$tgl_awal = $_GET['awal'] ?? date('Y-m-01');
$tgl_akhir = $_GET['akhir'] ?? date('Y-m-d');

// Ambil data
$stmt = $conn->prepare("
    SELECT u.nama, k.jumlah, k.keterangan, k.tanggal
    FROM kas k
    JOIN users u ON k.user_id = u.id
    WHERE k.tanggal BETWEEN ? AND ?
    ORDER BY k.tanggal DESC
");
$stmt->bind_param("ss", $tgl_awal, $tgl_akhir);
$stmt->execute();
$data = $stmt->get_result();
?>

<div class="container mt-4">
    <h3>Laporan Kas Masuk</h3>

    <form method="GET" class="row g-3 mb-3">
        <div class="col-auto">
            <input type="date" name="awal" value="<?= $tgl_awal ?>" class="form-control" required>
        </div>
        <div class="col-auto">
            <input type="date" name="akhir" value="<?= $tgl_akhir ?>" class="form-control" required>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Filter</button>
            <a href="export_pdf.php?awal=<?= $tgl_awal ?>&akhir=<?= $tgl_akhir ?>" class="btn btn-danger">Export PDF</a>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $data->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['nama'] ?></td>
                    <td>Rp <?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                    <td><?= $row['keterangan'] ?></td>
                    <td><?= $row['tanggal'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>

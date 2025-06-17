<?php
include '../includes/auth.php';
checkRole(['bendahara', 'ketua']);
include '../config/db.php';
include '../includes/header.php';
include '../includes/navbar.php';

$data = $conn->query("
    SELECT kas.*, users.nama 
    FROM kas 
    JOIN users ON kas.user_id = users.id 
    ORDER BY kas.tanggal DESC
");
?>

<div class="container mt-4">
    <h3>Riwayat Kas Masuk</h3>
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
            <td>
                <a href="detail_user.php?id=<?= $row['user_id'] ?>" class="btn btn-sm btn-info">Detail</a>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>

    </table>
</div>

<?php include '../includes/footer.php'; ?>

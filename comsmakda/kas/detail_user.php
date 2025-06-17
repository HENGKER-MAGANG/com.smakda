<?php
include '../includes/auth.php';
checkRole(['ketua', 'bendahara']);
include '../config/db.php';
include '../includes/header.php';
include '../includes/navbar.php';

$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil nama user
$stmtUser = $conn->prepare("SELECT nama FROM users WHERE id = ?");
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$stmtUser->bind_result($nama_user);
$stmtUser->fetch();
$stmtUser->close();

// Ambil data kas
$stmtKas = $conn->prepare("SELECT jumlah, keterangan, tanggal FROM kas WHERE user_id = ? ORDER BY tanggal DESC");
$stmtKas->bind_param("i", $user_id);
$stmtKas->execute();
$resultKas = $stmtKas->get_result();

// Hitung total kas
$stmtTotal = $conn->prepare("SELECT SUM(jumlah) FROM kas WHERE user_id = ?");
$stmtTotal->bind_param("i", $user_id);
$stmtTotal->execute();
$stmtTotal->bind_result($total_kas);
$stmtTotal->fetch();
$stmtTotal->close();
?>

<div class="container mt-4">
    <h3>Detail Kas: <?= htmlspecialchars($nama_user) ?></h3>
    <p><strong>Total Kas Masuk:</strong> Rp <?= number_format($total_kas, 0, ',', '.') ?></p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultKas->fetch_assoc()): ?>
                <tr>
                    <td>Rp <?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                    <td><?= $row['keterangan'] ?></td>
                    <td><?= $row['tanggal'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="riwayat.php" class="btn btn-secondary">← Kembali</a>
</div>

<?php include '../includes/footer.php'; ?>

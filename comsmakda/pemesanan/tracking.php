<?php
require_once '../config/db.php';

$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT * FROM pemesanan WHERE email = ? ORDER BY tanggal DESC");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">
    <h3>Lacak Pemesanan</h3>
    <form method="post" class="mb-4">
        <div class="input-group">
            <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" required>
            <button class="btn btn-primary">Cari</button>
        </div>
    </form>

    <?php if ($result && $result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['project']) ?></td>
                            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                            <td><span class="badge bg-info"><?= $row['status'] ?></span></td>
                            <td><?= $row['tanggal'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php elseif ($result): ?>
        <div class="alert alert-warning">Tidak ditemukan data pemesanan.</div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>

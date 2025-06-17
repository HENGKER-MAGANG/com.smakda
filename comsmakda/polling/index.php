<?php
session_start();
require_once '../config/db.php';

// Ambil topik voting aktif (satu saja untuk sederhana)
$voting = $conn->query("SELECT * FROM voting ORDER BY tanggal_buat DESC LIMIT 1")->fetch_assoc();

$pilihan = json_decode($voting['pilihan'], true);
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote'])) {
    $pilihan_dipilih = $_POST['vote'];

    $hasil = json_decode($voting['hasil'], true);
    if (isset($hasil[$pilihan_dipilih])) {
        $hasil[$pilihan_dipilih]++;
    } else {
        $hasil[$pilihan_dipilih] = 1;
    }

    $stmt = $conn->prepare("UPDATE voting SET hasil = ? WHERE id = ?");
    $hasil_json = json_encode($hasil);
    $stmt->bind_param("si", $hasil_json, $voting['id']);
    $stmt->execute();

    $success = "Voting berhasil! Terima kasih atas partisipasi Anda.";
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">
    <h3>Voting: <?= htmlspecialchars($voting['topik']) ?></h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="post">
        <?php foreach ($pilihan as $key => $val): ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="vote" value="<?= $val ?>" required>
                <label class="form-check-label"><?= $val ?></label>
            </div>
        <?php endforeach; ?>
        <button class="btn btn-primary mt-2">Kirim</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>

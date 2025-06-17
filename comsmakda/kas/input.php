<?php
include '../includes/auth.php';
checkRole(['bendahara']);
include '../config/db.php';
include '../includes/header.php';
include '../includes/navbar.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];
    $input_by = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO kas (user_id, jumlah, keterangan, input_by) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $user_id, $jumlah, $keterangan, $input_by);

    if ($stmt->execute()) {
        $success = "Kas berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan kas.";
    }
    $stmt->close();
}

// ambil user aktif
$result = $conn->query("SELECT id, nama FROM users WHERE status='aktif' AND role='anggota'");
?>

<div class="container mt-4">
    <h3>Input Kas</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="user_id" class="form-label">Nama Anggota</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Pilih Anggota --</option>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah (Rp)</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>

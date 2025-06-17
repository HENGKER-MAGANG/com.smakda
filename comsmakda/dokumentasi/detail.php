<?php
include '../includes/header.php';
include '../includes/navbar.php';
include '../config/db.php';

$galeri_id = $_GET['id'] ?? 0;
date_default_timezone_set('Asia/Jakarta');

// Ambil dokumentasi
$stmt = $conn->prepare("SELECT d.*, k.nama_kegiatan FROM dokumentasi d LEFT JOIN kegiatan k ON d.kegiatan_id = k.id WHERE d.id = ?");
$stmt->bind_param("i", $galeri_id);
$stmt->execute();
$dokumentasi = $stmt->get_result()->fetch_assoc();

if (!$dokumentasi) {
    echo "<div class='container mt-5'><h4>Dokumentasi tidak ditemukan.</h4></div>";
    include '../includes/footer.php';
    exit;
}

$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$now = time();

// === Proses Komentar ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['komentar'])) {
    $nama = htmlspecialchars(trim($_POST['nama']));
    $komentar = htmlspecialchars(trim($_POST['komentar']));

    if ($nama && $komentar && (!isset($_SESSION['last_comment']) || $now - $_SESSION['last_comment'] > 60)) {
        $stmt = $conn->prepare("INSERT INTO komentar (galeri_id, nama, komentar) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $galeri_id, $nama, $komentar);
        $stmt->execute();
        $_SESSION['last_comment'] = $now;
    }
}

// Ambil komentar
$komen = $conn->prepare("SELECT * FROM komentar WHERE galeri_id = ? ORDER BY tanggal DESC");
$komen->bind_param("i", $galeri_id);
$komen->execute();
$komentar_list = $komen->get_result();

// === Proses Like ===
$cek_like = $conn->prepare("SELECT id FROM like_dokumentasi WHERE galeri_id = ? AND ip_address = ?");
$cek_like->bind_param("is", $galeri_id, $ip);
$cek_like->execute();
$liked = $cek_like->get_result()->num_rows > 0;

if (isset($_GET['like']) && !$liked && (!isset($_SESSION['last_like']) || $now - $_SESSION['last_like'] > 60)) {
    $stmt = $conn->prepare("INSERT INTO like_dokumentasi (galeri_id, ip_address) VALUES (?, ?)");
    $stmt->bind_param("is", $galeri_id, $ip);
    $stmt->execute();
    $_SESSION['last_like'] = $now;
    header("Location: detail.php?id=$galeri_id");
    exit;
}

$total_like = $conn->query("SELECT COUNT(*) AS total FROM like_dokumentasi WHERE galeri_id = $galeri_id")->fetch_assoc()['total'];
?>

<div class="container mt-4">
    <h3><?= htmlspecialchars($dokumentasi['judul']) ?></h3>
    <p><?= htmlspecialchars($dokumentasi['nama_kegiatan']) ?> | <?= htmlspecialchars($dokumentasi['tanggal_upload']) ?></p>

    <img src="../assets/images/<?= htmlspecialchars($dokumentasi['gambar']) ?>" class="img-fluid mb-3 rounded" style="max-height:400px; object-fit:cover;">

    <!-- Like Button -->
    <div class="mb-3">
        <?php if (!$liked): ?>
            <a href="?id=<?= $galeri_id ?>&like=1" class="btn btn-outline-danger btn-sm">❤️ Like (<?= $total_like ?>)</a>
        <?php else: ?>
            <button class="btn btn-danger btn-sm" disabled>❤️ Disukai (<?= $total_like ?>)</button>
        <?php endif; ?>
    </div>

    <!-- Komentar Form -->
    <form method="post" class="mb-4">
        <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Anda" required>
        <textarea name="komentar" class="form-control" placeholder="Tulis komentar..." required></textarea>
        <button class="btn btn-primary mt-2">Kirim</button>
    </form>

    <!-- Daftar Komentar -->
    <div class="border-top pt-3">
        <h5>Komentar:</h5>
        <?php if ($komentar_list->num_rows == 0): ?>
            <p class="text-muted">Belum ada komentar.</p>
        <?php endif; ?>
        <?php while ($k = $komentar_list->fetch_assoc()): ?>
            <div class="mb-2">
                <strong><?= htmlspecialchars($k['nama']) ?></strong> 
                <small class="text-muted"><?= $k['tanggal'] ?></small><br>
                <?= nl2br(htmlspecialchars($k['komentar'])) ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
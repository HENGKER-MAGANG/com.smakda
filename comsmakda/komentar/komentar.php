<?php
include '../includes/auth.php';
include '../includes/header.php';
include '../includes/navbar.php';
include '../config/db.php';

$galeri_id = $_GET['id'] ?? 0;

// Ambil data dokumentasi
$stmt = $conn->prepare("
    SELECT d.*, k.nama_kegiatan 
    FROM dokumentasi d 
    LEFT JOIN kegiatan k ON d.kegiatan_id = k.id 
    WHERE d.id = ?
");
$stmt->bind_param("i", $galeri_id);
$stmt->execute();
$dokumentasi = $stmt->get_result()->fetch_assoc();

// Proses kirim komentar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $komentar = htmlspecialchars($_POST['komentar']);
    $nama = $_SESSION['user']['nama'];
    
    $stmt = $conn->prepare("INSERT INTO komentar (galeri_id, nama, komentar) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $galeri_id, $nama, $komentar);
    $stmt->execute();
}

// Ambil semua komentar
$komen = $conn->prepare("SELECT * FROM komentar WHERE galeri_id = ? ORDER BY tanggal DESC");
$komen->bind_param("i", $galeri_id);
$komen->execute();
$komentar_list = $komen->get_result();

// Cek apakah user sudah like
$user_id = $_SESSION['user']['id'];
$cek_like = $conn->prepare("SELECT id FROM like_dokumentasi WHERE galeri_id = ? AND user_id = ?");
$cek_like->bind_param("ii", $galeri_id, $user_id);
$cek_like->execute();
$liked = $cek_like->get_result()->num_rows > 0;

// Hitung total like
$total_like = $conn->query("SELECT COUNT(*) AS total FROM like_dokumentasi WHERE galeri_id = $galeri_id")->fetch_assoc()['total'];
?>

<div class="container mt-4">
    <h3><?= $dokumentasi['judul'] ?></h3>
    <p><?= $dokumentasi['nama_kegiatan'] ?> | <?= $dokumentasi['tanggal_upload'] ?></p>

    <img src="../assets/images/<?= $dokumentasi['gambar'] ?>" class="img-fluid mb-3" style="max-height:400px; object-fit:cover;">

    <!-- Like Button -->
    <form method="post" action="like.php" class="mb-3">
        <input type="hidden" name="galeri_id" value="<?= $galeri_id ?>">
        <button class="btn btn-<?= $liked ? 'danger' : 'outline-danger' ?> btn-sm" <?= $liked ? 'disabled' : '' ?>>
            ❤️ Like (<?= $total_like ?>)
        </button>
    </form>

    <!-- Komentar Form -->
    <form method="post" class="mb-4">
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
                <strong><?= $k['nama'] ?></strong> <small class="text-muted"><?= $k['tanggal'] ?></small><br>
                <?= nl2br(htmlspecialchars($k['komentar'])) ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

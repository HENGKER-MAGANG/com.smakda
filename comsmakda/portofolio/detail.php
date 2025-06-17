<?php
require_once '../config/db.php';
$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM portofolio WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">
    <h3><?= htmlspecialchars($data['judul']) ?></h3>
    <img src="../assets/images/<?= $data['gambar'] ?>" class="img-fluid mb-3" alt="<?= $data['judul'] ?>">
    <p><strong>Kategori:</strong> <?= $data['kategori'] ?></p>
    <p><strong>Teknologi:</strong> <?= $data['tech_stack'] ?></p>
    <p><?= nl2br(htmlspecialchars($data['deskripsi'])) ?></p>

    <a href="<?= $data['link_demo'] ?>" target="_blank" class="btn btn-success">🔗 Demo</a>
    <a href="<?= $data['link_github'] ?>" target="_blank" class="btn btn-dark">📂 GitHub</a>
</div>

<?php include '../includes/footer.php'; ?>

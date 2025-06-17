<?php
include '../includes/auth.php';
include '../config/db.php';

$galeri_id = $_POST['galeri_id'];
$user_id = $_SESSION['user']['id'];

// Cek apakah sudah like
$stmt = $conn->prepare("SELECT id FROM like_dokumentasi WHERE galeri_id = ? AND user_id = ?");
$stmt->bind_param("ii", $galeri_id, $user_id);
$stmt->execute();
$cek = $stmt->get_result();

if ($cek->num_rows == 0) {
    $stmt = $conn->prepare("INSERT INTO like_dokumentasi (galeri_id, user_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $galeri_id, $user_id);
    $stmt->execute();
}

header("Location: komentar.php?id=" . $galeri_id);
exit;

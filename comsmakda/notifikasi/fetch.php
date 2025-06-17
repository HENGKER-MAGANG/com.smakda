<?php
include '../includes/auth.php';
include '../config/db.php';

$user_id = $_SESSION['user']['id'];

$stmt = $conn->prepare("SELECT pesan, tanggal FROM notifikasi WHERE user_id = ? ORDER BY tanggal DESC LIMIT 5");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifikasi = [];
while ($row = $result->fetch_assoc()) {
    $notifikasi[] = $row;
}

header('Content-Type: application/json');
echo json_encode($notifikasi);

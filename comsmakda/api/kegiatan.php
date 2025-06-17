<?php
require_once '../config/db.php';
header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM kegiatan ORDER BY tanggal DESC");

$kegiatan = [];
while ($row = $result->fetch_assoc()) {
    $kegiatan[] = $row;
}

echo json_encode([
    'status' => 'success',
    'data' => $kegiatan
]);

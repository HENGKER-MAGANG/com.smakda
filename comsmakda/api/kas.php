<?php
require_once '../config/db.php';
header('Content-Type: application/json');

$result = $conn->query("SELECT k.id, k.jumlah, k.jenis, k.keterangan, k.tanggal, u.nama as nama_user 
                        FROM kas k 
                        JOIN users u ON k.user_id = u.id 
                        ORDER BY k.tanggal DESC");

$kas = [];
while ($row = $result->fetch_assoc()) {
    $kas[] = $row;
}

echo json_encode([
    'status' => 'success',
    'data' => $kas
]);

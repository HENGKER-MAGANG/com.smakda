<?php
require_once '../config/db.php';

header('Content-Type: application/json');

$query = $conn->query("
    SELECT d.id, d.judul, d.gambar, k.nama_kegiatan, d.tanggal_upload 
    FROM dokumentasi d 
    LEFT JOIN kegiatan k ON d.kegiatan_id = k.id 
    ORDER BY d.tanggal_upload DESC
");

$data = [];
while ($row = $query->fetch_assoc()) {
    $row['gambar'] = '/comsmakda/assets/images/dokumentasi/' . $row['gambar'];
    $data[] = $row;
}

echo json_encode([
    'status' => 'success',
    'total' => count($data),
    'data' => $data
], JSON_PRETTY_PRINT);

<?php
require_once '../config/db.php';

header('Content-Type: application/json');

$query = $conn->query("SELECT id, judul, deskripsi, gambar, link_demo, link_github, tech_stack, kategori, tanggal_upload FROM portofolio ORDER BY tanggal_upload DESC");

$data = [];
while ($row = $query->fetch_assoc()) {
    $row['gambar'] = '/comsmakda/assets/images/portofolio/' . $row['gambar'];
    $data[] = $row;
}

echo json_encode([
    'status' => 'success',
    'total' => count($data),
    'data' => $data
], JSON_PRETTY_PRINT);

<?php
include '../config/db.php';

$result = $conn->query("SELECT * FROM kegiatan");

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['nama_kegiatan'],
        'start' => $row['tanggal'],
        'url'   => 'edit.php?id=' . $row['id']
    ];
}

header('Content-Type: application/json');
echo json_encode($events);

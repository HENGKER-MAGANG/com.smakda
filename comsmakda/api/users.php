<?php
require_once '../config/db.php';
header('Content-Type: application/json');

$result = $conn->query("SELECT id, nama, nisn, role FROM users ORDER BY id DESC");

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode([
    'status' => 'success',
    'data' => $users
]);

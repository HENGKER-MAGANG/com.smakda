<?php
$host = getenv('DB_HOST') ?: 'bo0sw48s8ks0w4c00os8ogo4';
$user = getenv('DB_USER') ?: 'com';
$pass = getenv('DB_PASS') ?: 'comsmakda';
$db   = getenv('DB_NAME') ?: 'com_db';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

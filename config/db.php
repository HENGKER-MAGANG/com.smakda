<?php
// config/db.php

$host     = 'bo0sw48s8ks0w4c00os8ogo4'; // dari MySQL URL internal di Coolify
$dbname   = 'com_db';                   // Initial Database
$username = 'com';                      // Normal User
$password = 'comsmakda';               // Normal User Password

try {
    $db = new PDO("mysql:host=$host;port=3306;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

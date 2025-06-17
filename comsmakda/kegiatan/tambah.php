<?php
include '../config/db.php';
include '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_kegiatan'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $user_id = $_SESSION['user']['id'];

    $stmt = $conn->prepare("INSERT INTO kegiatan (nama_kegiatan, lokasi, deskripsi, tanggal, dibuat_oleh) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nama, $lokasi, $deskripsi, $tanggal, $user_id);
    $stmt->execute();
}

header('Location: agenda.php');

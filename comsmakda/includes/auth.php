<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /comsmakda/auth/login.php");
    exit;
}

function checkRole($allowedRoles = []) {
    if (!in_array($_SESSION['role'], $allowedRoles)) {
        echo "<script>alert('Akses ditolak!'); window.location.href = '/comsmakda/index.php';</script>";
        exit;
    }
}

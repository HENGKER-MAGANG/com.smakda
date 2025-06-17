<?php
// auth_guard.php
if (session_status() === PHP_SESSION_NONE) session_start();

/**
 * @param string|array $allowed  Role tunggal atau array role yang diizinkan
 */
function checkRole($allowed)
{
    // belum login → paksa login
    if (!isset($_SESSION['user'])) {
        header('Location: ../login.php');
        exit;
    }

    $role = $_SESSION['user']['role'];

    // role tidak di-allow → tendang ke login
    if (is_array($allowed) ? !in_array($role, $allowed) : $role !== $allowed) {
        header('Location: ../login.php');
        exit;
    }
}

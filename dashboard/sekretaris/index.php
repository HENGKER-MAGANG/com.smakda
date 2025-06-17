<?php
session_start();
require '../auth/auth_guard.php'; checkRole('sekretaris');
include('../partials/anggota/navbar.php');
$headerGradient = 'linear-gradient(135deg,#0d9488,#14b8a6)'; // hijau toska
$welcomeName = ucwords($_SESSION['user']['username']);
$role = 'sekretaris';
$cards = [
  [ 'title' => 'Kelola Absensi', 'href' => 'kelola_absensi.php'],
  [ 'title' => 'Kelola Agenda', 'href' => 'kelola_agenda.php'],
  [ 'title' => 'Kelola Dokumentasi', 'href' => 'kelola_dokumentasi.php'],
  [ 'title' => 'Lihat Projects', 'href' => 'lihat_projects.php'],
  [ 'title' => 'Lihat Users', 'href' => 'lihat_users.php'],
  [ 'title' => 'Lihat Kas', 'href' => 'lihat_kas.php'],
];
include('../partials/anggota/dashboard.php');

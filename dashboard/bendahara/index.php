<?php
session_start();
require '../auth/auth_guard.php'; checkRole('bendahara');
include('../partials/anggota/navbar.php');
$headerGradient = 'linear-gradient(135deg,#16a34a,#22c55e)'; // hijau uang
$welcomeName = ucwords($_SESSION['user']['username']);
$role = 'bendahara';
$cards = [
  [ 'title' => 'Kelola Projects', 'href' => 'kelola_projects.php'],
  [ 'title' => 'Kelola Kas', 'href' => 'kelola_kas.php'],
  [ 'title' => 'Lihat Users', 'href' => 'lihat_users.php'],
  [ 'title' => 'Lihat Absensi', 'href' => 'lihat_absensi.php'],
  [ 'title' => 'Lihat Agenda', 'href' => 'lihat_agenda.php'],
  [ 'title' => 'Lihat Dokumentasi', 'href' => 'lihat_dokumentasi.php'],
];
include('../partials/anggota/dashboard.php');

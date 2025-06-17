<?php
session_start();
require '../auth/auth_guard.php'; checkRole('anggota');
include('../partials/navbar.php');
$headerGradient = 'linear-gradient(135deg,#2563eb,#0ea5e9)';
$welcomeName = ucwords($_SESSION['user']['username']);
$role = 'anggota';
$cards = [
  [ 'title' => 'Lihat Projects', 'href' => 'lihat_projects.php'],
  [ 'title' => 'Lihat Users', 'href' => 'lihat_users.php'],
  [ 'title' => 'Lihat Kas', 'href' => 'lihat_kas.php'],
  [ 'title' => 'Lihat Absensi', 'href' => 'lihat_absensi.php'],
  [ 'title' => 'Lihat Agenda', 'href' => 'lihat_agenda.php'],
  [ 'title' => 'Lihat Dokumentasi', 'href' => 'lihat_dokumentasi.php'],
];
include('../partials/dashboard.php');

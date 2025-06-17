<?php
require '../../config/db.php';
require '../auth/auth_guard.php'; 
checkRole('ketua');

$welcomeName = ucwords($_SESSION['user']['username'] ?? 'Ketua');

// Data kartu navigasi
$cards = [
  [ 'title' => 'Kelola Projects', 'href' => 'kelola_projects.php'],
  [ 'title' => 'Kelola Users', 'href' => 'kelola_users.php'],
  [ 'title' => 'Kelola Kas', 'href' => 'kelola_kas.php'],
  [ 'title' => 'Kelola Absensi', 'href' => 'kelola_absensi.php'],
  [ 'title' => 'Kelola Agenda', 'href' => 'kelola_agenda.php'],
  [ 'title' => 'Kelola Dokumentasi', 'href' => 'kelola_dokumentasi.php'],
];

// Ambil statistik pengguna
$jumlahKetua      = $db->query("SELECT COUNT(*) FROM users WHERE role = 'ketua'")->fetchColumn();
$jumlahBendahara  = $db->query("SELECT COUNT(*) FROM users WHERE role = 'bendahara'")->fetchColumn();
$jumlahSekretaris = $db->query("SELECT COUNT(*) FROM users WHERE role = 'sekretaris'")->fetchColumn();
$jumlahAnggota    = $db->query("SELECT COUNT(*) FROM users WHERE role = 'anggota'")->fetchColumn();
$jumlahTotal = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Ketua</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Fira Code', monospace;
      background: radial-gradient(circle at top, #0f172a, #1e293b);
    }
    .neon-card {
      background: rgba(15, 23, 42, 0.9);
      border: 1px solid #334155;
      box-shadow: 0 0 12px rgba(56, 189, 248, 0.3);
      transition: all 0.3s ease;
    }
    .neon-card:hover {
      box-shadow: 0 0 10px #38bdf8, 0 0 20px #38bdf8;
      transform: scale(1.03);
    }
  </style>
</head>
<body class="text-white min-h-screen">

  <!-- Navbar -->
  <nav class="bg-gray-900 border-b border-cyan-600 shadow-lg p-4 flex justify-between items-center">
    <div class="text-xl font-bold text-cyan-400">👨‍💻 COM SMAKDA</div>
    <div class="flex items-center space-x-4">
      <a href="../../logout.php" class="text-sm text-red-400 hover:text-white transition">Logout</a>
    </div>
  </nav>

  <div class="p-6">
    <!-- Header -->
    <div class="text-center my-8">
      <h1 class="text-3xl font-bold text-cyan-400 animate-pulse">👋 Hai, <?= $welcomeName ?></h1>
      <p class="text-gray-400 mt-2">Selamat datang di Dashboard Ketua Community Programmer</p>
    </div>

    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto mt-6">
      <?php foreach ($cards as $card): ?>
        <a href="<?= htmlspecialchars($card['href']) ?>" class="neon-card p-6 rounded-xl text-center hover:scale-105">
          <h2 class="text-xl font-semibold text-cyan-300"><?= htmlspecialchars($card['title']) ?></h2>
          <p class="text-sm text-gray-400 mt-2">> Klik untuk mengelola</p>
        </a>
      <?php endforeach; ?>
    </div>

<!-- Statistik Pengguna -->
<div class="max-w-4xl mx-auto mt-12">
  <h2 class="text-xl font-bold text-cyan-400 mb-4">📊 Statistik Pengguna</h2>
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
    <div class="bg-gray-800 p-4 rounded-lg shadow">
      <p class="text-sm text-gray-400">Ketua</p>
      <h3 class="text-2xl text-cyan-400 font-bold"><?= $jumlahKetua ?></h3>
    </div>
    <div class="bg-gray-800 p-4 rounded-lg shadow">
      <p class="text-sm text-gray-400">Bendahara</p>
      <h3 class="text-2xl text-yellow-400 font-bold"><?= $jumlahBendahara ?></h3>
    </div>
    <div class="bg-gray-800 p-4 rounded-lg shadow">
      <p class="text-sm text-gray-400">Sekretaris</p>
      <h3 class="text-2xl text-blue-400 font-bold"><?= $jumlahSekretaris ?></h3>
    </div>
    <div class="bg-gray-800 p-4 rounded-lg shadow">
      <p class="text-sm text-gray-400">Anggota</p>
      <h3 class="text-2xl text-purple-400 font-bold"><?= $jumlahAnggota ?></h3>
    </div>
    <div class="bg-gray-800 p-4 rounded-lg shadow col-span-2 sm:col-span-4">
      <p class="text-sm text-gray-400">Total Pengguna Terdaftar</p>
      <h3 class="text-3xl text-white font-bold mt-1"><?= $jumlahTotal ?></h3>
    </div>
  </div>
</div>



  </div>
</body>
</html>

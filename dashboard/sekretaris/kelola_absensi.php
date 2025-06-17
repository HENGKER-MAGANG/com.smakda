<?php
session_start();
require '../auth/auth_guard.php';
checkRole('sekretaris');
include('../partials/navbar.php');
require '../../config/db.php';

$users = $db->query("SELECT username, role FROM users ORDER BY username ASC")->fetchAll(PDO::FETCH_ASSOC);
$tanggal_filter = $_GET['tanggal'] ?? date('Y-m-d');
$stmt = $db->prepare("SELECT * FROM absensi WHERE tanggal = ? ORDER BY id DESC");
$stmt->execute([$tanggal_filter]);
$absensi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Kelola Absensi | COM Programmer</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#0f172a',
            accent: '#1e293b',
            highlight: '#3b82f6',
            success: '#22c55e',
            danger: '#ef4444',
            warning: '#facc15',
            info: '#38bdf8'
          }
        }
      }
    }
  </script>
</head>
<body class="bg-primary text-white min-h-screen">
  <div class="max-w-6xl mx-auto px-4 py-8">
    <a href="index.php" class="inline-block mb-4 px-4 py-2 bg-accent rounded hover:bg-highlight transition">← Kembali ke Dashboard</a>

    <div class="bg-accent rounded-xl shadow-lg p-6">
      <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
        <h2 class="text-2xl font-semibold">Kelola Absensi</h2>
        <a href="tambah_absensi.php" class="bg-highlight hover:bg-blue-600 text-white px-4 py-2 rounded transition">+ Tambah Absensi</a>
      </div>

      <form method="GET" class="mb-6">
        <label for="tanggal" class="block mb-2 font-medium">Filter Tanggal</label>
        <input type="date" name="tanggal" id="tanggal"
               value="<?= htmlspecialchars($tanggal_filter) ?>"
               class="bg-gray-800 border border-gray-600 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-highlight"
               onchange="this.form.submit()">
      </form>

      <!-- Wrapper scrollable -->
      <div class="overflow-x-auto rounded-lg">
        <table class="min-w-[700px] w-full text-sm text-left text-gray-200">
          <thead class="bg-highlight text-white text-center">
            <tr>
              <th class="px-4 py-3">No</th>
              <th class="px-4 py-3">Username</th>
              <th class="px-4 py-3">Jabatan</th>
              <th class="px-4 py-3">Tanggal</th>
              <th class="px-4 py-3">Status</th>
            </tr>
          </thead>
          <tbody class="bg-primary text-white">
            <?php if (count($absensi) > 0): ?>
              <?php $no = 1; foreach ($absensi as $a): ?>
                <?php
                  $status = $a['status'];
                  $badgeColor = match($status) {
                    'Hadir' => 'bg-success',
                    'Izin' => 'bg-info',
                    'Sakit' => 'bg-warning text-black',
                    'Alpha' => 'bg-danger',
                    default => 'bg-gray-500'
                  };
                ?>
                <tr class="border-b border-gray-700 hover:bg-accent transition">
                  <td class="px-4 py-2 text-center"><?= $no++ ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($a['username']) ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($a['role']) ?></td>
                  <td class="px-4 py-2 text-center"><?= htmlspecialchars($a['tanggal']) ?></td>
                  <td class="px-4 py-2 text-center">
                    <span class="inline-block px-3 py-1 rounded-full text-sm <?= $badgeColor ?>">
                      <?= htmlspecialchars($status ?: 'Alpha') ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="5" class="text-center text-gray-400 py-4">Tidak ada data absensi pada tanggal ini.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>

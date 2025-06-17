<?php
session_start();
require '../auth/auth_guard.php';
checkRole('sekretaris');
include('../partials/navbar.php');
require '../../config/db.php';

$users = $db->query("SELECT username, role FROM users ORDER BY username ASC")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_absensi'])) {
  $tanggal = $_POST['tanggal'];

  foreach ($_POST['status'] as $username => $status) {
    $cek = $db->prepare("SELECT COUNT(*) FROM absensi WHERE username=? AND tanggal=?");
    $cek->execute([$username, $tanggal]);

    if ($cek->fetchColumn() == 0) {
      $stmtUser = $db->prepare("SELECT role FROM users WHERE username = ?");
      $stmtUser->execute([$username]);
      $role = $stmtUser->fetchColumn();

      $stmt = $db->prepare("INSERT INTO absensi (username, role, tanggal, status) VALUES (?, ?, ?, ?)");
      $stmt->execute([$username, $role, $tanggal, $status]);
    }
  }

  header("Location: kelola_absensi.php?success=1");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Absensi | COM Programmer</title>
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
    <a href="kelola_absensi.php" class="inline-block mb-4 px-4 py-2 bg-accent rounded hover:bg-highlight transition">← Kembali</a>

    <div class="bg-accent p-6 rounded-xl shadow-lg">
      <h2 class="text-2xl font-bold mb-6 text-center">Tambah Absensi Hari Ini</h2>

      <form method="POST">
        <div class="mb-6">
          <label for="tanggal" class="block font-medium mb-2">Tanggal</label>
          <input type="date" name="tanggal" id="tanggal"
                 value="<?= date('Y-m-d') ?>"
                 class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-highlight focus:outline-none"
                 required>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-[700px] w-full text-sm text-white">
            <thead class="bg-highlight text-center">
              <tr>
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Username</th>
                <th class="px-4 py-2">Jabatan</th>
                <th class="px-4 py-2">Status Kehadiran</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($users as $user): ?>
                <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                  <td class="px-4 py-2 text-center"><?= $no++ ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($user['username']) ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($user['role']) ?></td>
                  <td class="px-4 py-2">
                    <div class="flex flex-wrap gap-2">
                      <?php foreach (['Hadir', 'Izin', 'Sakit', 'Alpha'] as $status): ?>
                        <label class="inline-flex items-center gap-1">
                          <input type="radio"
                                 name="status[<?= $user['username'] ?>]"
                                 value="<?= $status ?>"
                                 required
                                 class="form-radio text-highlight focus:ring-0 focus:ring-offset-0 accent-highlight">
                          <span class="text-sm"><?= $status ?></span>
                        </label>
                      <?php endforeach; ?>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="mt-6 text-right">
          <button type="submit"
                  name="submit_absensi"
                  class="bg-highlight hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition">
            Simpan Absensi
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>

<?php
session_start();
require '../auth/auth_guard.php';
checkRole('ketua');
include('../partials/anggota/navbar.php');
require '../../config/db.php';

// Filter berdasarkan tanggal
$tanggal_filter = $_GET['tanggal'] ?? date('Y-m-d');
$stmt = $db->prepare("SELECT * FROM absensi WHERE tanggal = ? ORDER BY id DESC");
$stmt->execute([$tanggal_filter]);
$absensi = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Proses update data absensi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
  $id = $_POST['edit_id'];
  $status = $_POST['edit_status'];
  $stmt = $db->prepare("UPDATE absensi SET status = ? WHERE id = ?");
  $stmt->execute([$status, $id]);
  header("Location: ../ketua/kelola_absensi.php?tanggal=" . urlencode($tanggal_filter));
  exit;
}

// Proses hapus data absensi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  $id = $_POST['delete_id'];
  $stmt = $db->prepare("DELETE FROM absensi WHERE id = ?");
  $stmt->execute([$id]);
  header("Location: kelola_absensi.php?tanggal=" . urlencode($tanggal_filter));
  exit;
}
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
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Kelola Absensi</h2>
      </div>

      <form method="GET" class="mb-6">
        <label for="tanggal" class="block mb-2 font-medium">Filter Tanggal</label>
        <input type="date" name="tanggal" id="tanggal"
               value="<?= htmlspecialchars($tanggal_filter) ?>"
               class="bg-gray-800 border border-gray-600 text-white rounded px-4 py-2"
               onchange="this.form.submit()">
      </form>

      <div class="overflow-x-auto rounded-lg">
        <table class="min-w-[700px] w-full text-sm text-left text-gray-200">
          <thead class="bg-highlight text-white text-center">
            <tr>
              <th class="px-4 py-3">No</th>
              <th class="px-4 py-3">Username</th>
              <th class="px-4 py-3">Jabatan</th>
              <th class="px-4 py-3">Tanggal</th>
              <th class="px-4 py-3">Status</th>
              <th class="px-4 py-3 text-center">Aksi</th>
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
                  <td class="px-4 py-2"><?= htmlspecialchars($a['tanggal']) ?></td>
                  <td class="px-4 py-2">
                    <span class="inline-block px-3 py-1 rounded-full text-sm <?= $badgeColor ?>">
                      <?= htmlspecialchars($status ?: 'Alpha') ?>
                    </span>
                  </td>
                  <td class="px-4 py-2 text-center space-x-2">
                    <button
                      onclick="openModal(<?= $a['id'] ?>, '<?= $a['status'] ?>')"
                      class="bg-info hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition">
                      Edit
                    </button>
                    <form method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="inline-block">
                      <input type="hidden" name="delete_id" value="<?= $a['id'] ?>">
                      <button type="submit"
                        class="bg-danger hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition">
                        Hapus
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="6" class="text-center text-gray-400 py-4">Tidak ada data absensi pada tanggal ini.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- MODAL EDIT -->
  <div id="editModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden justify-center items-center">
    <form method="POST" class="bg-white text-black rounded-xl p-6 w-full max-w-md shadow-xl">
      <h3 class="text-xl font-bold mb-4">Edit Status Absensi</h3>
      <input type="hidden" name="edit_id" id="edit_id">

      <label for="edit_status" class="block mb-2">Status</label>
      <select name="edit_status" id="edit_status" class="w-full border px-3 py-2 rounded mb-4">
        <option value="Hadir">Hadir</option>
        <option value="Izin">Izin</option>
        <option value="Sakit">Sakit</option>
        <option value="Alpha">Alpha</option>
      </select>

      <div class="flex justify-end gap-2">
        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
      </div>
    </form>
  </div>

  <script>
    function openModal(id, status) {
      document.getElementById('edit_id').value = id;
      document.getElementById('edit_status').value = status;
      document.getElementById('editModal').classList.remove('hidden');
      document.getElementById('editModal').classList.add('flex');
    }

    function closeModal() {
      document.getElementById('editModal').classList.add('hidden');
      document.getElementById('editModal').classList.remove('flex');
    }
  </script>
</body>
</html>

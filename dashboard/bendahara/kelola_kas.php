<?php
session_start();
require '../auth/auth_guard.php';
checkRole('bendahara');
include('../partials/navbar.php');
require '../../config/db.php';

// === TAMBAH KAS ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_kas'])) {
  $tanggal = $_POST['tanggal'];
  $tipe = $_POST['tipe'];
  $jumlah = $_POST['jumlah'];
  $keterangan = $_POST['keterangan'];

  $stmt = $db->prepare("INSERT INTO kas (tanggal, tipe, jumlah, keterangan) VALUES (?, ?, ?, ?)");
  $stmt->execute([$tanggal, $tipe, $jumlah, $keterangan]);
}

// === HAPUS KAS ===
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $stmt = $db->prepare("DELETE FROM kas WHERE id = ?");
  $stmt->execute([$id]);
  header("Location: kelola_kas.php");
  exit;
}

// === EDIT KAS ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_kas'])) {
  $id = $_POST['id'];
  $tanggal = $_POST['tanggal'];
  $tipe = $_POST['tipe'];
  $jumlah = $_POST['jumlah'];
  $keterangan = $_POST['keterangan'];

  $stmt = $db->prepare("UPDATE kas SET tanggal=?, tipe=?, jumlah=?, keterangan=? WHERE id=?");
  $stmt->execute([$tanggal, $tipe, $jumlah, $keterangan, $id]);
}

$kas = $db->query("SELECT * FROM kas ORDER BY tanggal DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Kas | COM SMAKDA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
  font-family: 'Fira Code', monospace;
  background-color: #0f172a; /* biru kehitaman */
  color: #e0f2fe; /* biru pucat untuk teks */
}
.card-custom {
  background-color: #1e293b; /* dark navy */
  border-radius: 1rem;
  padding: 2rem;
  box-shadow: 0 0 20px rgba(59, 130, 246, 0.1); /* bayangan biru */
}
.btn-primary {
  background-color: #2563eb; /* biru terang */
  border: none;
}
.btn-primary:hover {
  background-color: #1d4ed8; /* biru gelap */
}
.btn-success {
  background-color: #0ea5e9; /* biru muda (untuk tombol simpan) */
  border: none;
}
.btn-success:hover {
  background-color: #0284c7;
}
.btn-warning {
  background-color: #38bdf8; /* biru langit */
  border: none;
  color: #0f172a;
}
.btn-warning:hover {
  background-color: #0ea5e9;
}
.btn-danger {
  background-color: #ef4444;
  border: none;
}
.btn-danger:hover {
  background-color: #b91c1c;
}
.table-dark {
  background-color: #1e293b;
  color: #e0f2fe;
}
.modal-content {
  background-color: #1e293b;
  color: #e0f2fe;
  border-radius: 1rem;
}
.form-control, .form-select, textarea {
  background-color: #334155;
  border: 1px solid #475569;
  color: #f1f5f9;
}
a.text-success {
  color: #60a5fa !important; /* biru muda */
}
.text-success {
  color: #60a5fa !important; /* biru muda */
}
.badge.bg-success {
  background-color: #22d3ee !important; /* badge masuk */
  color: #0f172a;
}
.badge.bg-danger {
  background-color: #f87171 !important; /* badge keluar */
  color: #0f172a;
}
  </style>
</head>
<body>

<div class="container py-5">
  <a href="index.php" class="text-success text-decoration-none mb-3 d-inline-block">
    ← Kembali ke Dashboard
  </a>

  <div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold text-success">Kelola Kas</h3>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Kas</button>
    </div>

    <div class="table-responsive">
      <table class="table table-dark table-bordered text-center">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php $no = 1; foreach ($kas as $k): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($k['tanggal']) ?></td>
            <td>
              <span class="badge bg-<?= $k['tipe'] === 'Masuk' ? 'success' : 'danger' ?>">
                <?= $k['tipe'] ?>
              </span>
            </td>
            <td>Rp <?= number_format($k['jumlah'], 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($k['keterangan']) ?></td>
            <td>
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $k['id'] ?>">Edit</button>
              <button onclick="confirmHapus(<?= $k['id'] ?>)" class="btn btn-danger btn-sm">Hapus</button>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <form method="POST">
        <h5 class="mb-3">Tambah Kas</h5>
        <div class="mb-3">
          <label class="form-label">Tanggal</label>
          <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Tipe</label>
          <select name="tipe" class="form-select" required>
            <option value="Masuk">Masuk</option>
            <option value="Keluar">Keluar</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Jumlah</label>
          <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Keterangan</label>
          <textarea name="keterangan" class="form-control" required></textarea>
        </div>
        <div class="d-flex justify-content-end gap-2">
          <button type="submit" name="submit_kas" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<?php foreach ($kas as $k): ?>
<div class="modal fade" id="editModal<?= $k['id'] ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <form method="POST">
        <input type="hidden" name="id" value="<?= $k['id'] ?>">
        <h5 class="mb-3">Edit Kas</h5>
        <div class="mb-3">
          <label class="form-label">Tanggal</label>
          <input type="date" name="tanggal" value="<?= $k['tanggal'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Tipe</label>
          <select name="tipe" class="form-select" required>
            <option value="Masuk" <?= $k['tipe'] === 'Masuk' ? 'selected' : '' ?>>Masuk</option>
            <option value="Keluar" <?= $k['tipe'] === 'Keluar' ? 'selected' : '' ?>>Keluar</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Jumlah</label>
          <input type="number" name="jumlah" value="<?= $k['jumlah'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Keterangan</label>
          <textarea name="keterangan" class="form-control" required><?= $k['keterangan'] ?></textarea>
        </div>
        <div class="d-flex justify-content-end gap-2">
          <button type="submit" name="update_kas" class="btn btn-warning">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>

<script>
  function confirmHapus(id) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: 'Data yang dihapus tidak dapat dikembalikan.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc2626',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?delete=' + id;
      }
    });
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

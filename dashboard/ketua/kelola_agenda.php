<?php
session_start();
require '../auth/auth_guard.php';
checkRole('ketua');
include('../partials/navbar.php');
require '../../config/db.php';

// === TAMBAH AGENDA ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_agenda'])) {
  $judul = $_POST['judul'];
  $deskripsi = $_POST['deskripsi'];
  $tanggal = $_POST['tanggal'];
  $tempat = $_POST['tempat'];

  $stmt = $db->prepare("INSERT INTO agenda (judul, deskripsi, tanggal, tempat) VALUES (?, ?, ?, ?)");
  $stmt->execute([$judul, $deskripsi, $tanggal, $tempat]);
}

// === HAPUS AGENDA ===
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $stmt = $db->prepare("DELETE FROM agenda WHERE id = ?");
  $stmt->execute([$id]);
  header("Location: kelola_agenda.php");
  exit;
}

// === UPDATE AGENDA ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_agenda'])) {
  $id = $_POST['id'];
  $judul = $_POST['judul'];
  $deskripsi = $_POST['deskripsi'];
  $tanggal = $_POST['tanggal'];
  $tempat = $_POST['tempat'];

  $stmt = $db->prepare("UPDATE agenda SET judul=?, deskripsi=?, tanggal=?, tempat=? WHERE id=?");
  $stmt->execute([$judul, $deskripsi, $tanggal, $tempat, $id]);
}
$agenda = $db->query("SELECT * FROM agenda ORDER BY tanggal DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Agenda | COM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: #0f172a;
      color: #f1f5f9;
      font-family: 'Fira Code', monospace;
    }
    .card-custom {
      background-color: #1e293b;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }
    .table-dark th {
      background-color: #334155;
    }
    .btn-primary {
      background-color: #3b82f6;
      border: none;
    }
    .btn-warning {
      background-color: #facc15;
      color: #000;
    }
    .btn-danger {
      background-color: #ef4444;
      color: #fff;
    }
    .modal-content {
      background-color: #1e293b;
      color: #f1f5f9;
      border: none;
    }
    .form-control, .form-select {
      background-color: #0f172a;
      border: 1px solid #475569;
      color: #f1f5f9;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-secondary mb-3">
    <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
  </a>
  <div class="card card-custom p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
      <h4 class="fw-bold m-0"><i class="bi bi-calendar-event-fill me-2"></i>Kelola Agenda</h4>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle me-1"></i> Tambah Agenda
      </button>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-dark table-striped align-middle">
        <thead class="text-center">
          <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Tanggal</th>
            <th>Tempat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($agenda as $a): ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= htmlspecialchars($a['judul']) ?></td>
            <td><?= htmlspecialchars($a['deskripsi']) ?></td>
            <td><?= htmlspecialchars($a['tanggal']) ?></td>
            <td><?= htmlspecialchars($a['tempat']) ?></td>
            <td class="text-center">
              <button class="btn btn-sm btn-warning mb-1" data-bs-toggle="modal" data-bs-target="#editModal<?= $a['id'] ?>">
                <i class="bi bi-pencil-square"></i> Edit
              </button>
              <button onclick="confirmDelete(<?= $a['id'] ?>)" class="btn btn-sm btn-danger mb-1">
                <i class="bi bi-trash"></i> Hapus
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title fw-bold"><i class="bi bi-calendar-plus me-2"></i>Tambah Agenda</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Tempat</label>
            <input type="text" name="tempat" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit_agenda" class="btn btn-success">
            <i class="bi bi-check-circle me-1"></i> Simpan
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<?php foreach ($agenda as $a): ?>
<div class="modal fade" id="editModal<?= $a['id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST">
        <input type="hidden" name="id" value="<?= $a['id'] ?>">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Agenda</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($a['judul']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required><?= htmlspecialchars($a['deskripsi']) ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $a['tanggal'] ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Tempat</label>
            <input type="text" name="tempat" class="form-control" value="<?= htmlspecialchars($a['tempat']) ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update_agenda" class="btn btn-success">
            <i class="bi bi-check2-square me-1"></i> Simpan Perubahan
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>

<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Yakin ingin menghapus agenda ini?',
    text: "Data akan dihapus secara permanen.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Ya, Hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '?delete=' + id;
    }
  })
}
</script>

</body>
</html>

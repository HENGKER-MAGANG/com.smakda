<?php
session_start();
require '../auth/auth_guard.php';
checkRole('sekretaris');
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
  <title>Kelola Agenda | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
  body {
    background-color: #0d1117; /* Hitam keabu - GitHub Dark */
    color: #ffffff;
    font-family: 'Fira Code', monospace;
  }

  .card-custom {
    background-color: #112240; /* Biru tua */
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    color: #e0f7ff; /* Biru muda */
  }

  .table thead {
    background-color: #0a192f; /* Lebih gelap */
    color: #ffffff;
  }

  .table tbody {
    background-color: #112240; /* Sama seperti card */
    color: #dceefc; /* Biru muda terang */
  }

  .modal-content {
    background-color: #0a192f;
    color: #e6f1ff;
  }

  .form-control, .form-select {
    background-color: #0d1b2a;
    color: #e0f7ff;
    border: 1px solid #1f4068;
  }

  .form-control:focus, .form-select:focus {
    border-color: #00bcd4; /* Biru neon */
    box-shadow: 0 0 0 0.2rem rgba(0, 188, 212, 0.25);
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #004ba0;
  }

  .btn-success {
    background-color: #00c4ff;
    border-color: #00a0d1;
    color: black;
  }

  .btn-success:hover {
    background-color: #00a6d6;
    border-color: #0092ba;
    color: white;
  }

  .btn-warning {
    background-color: #ffc107;
    border-color: #e0a800;
    color: black;
  }

  .btn-warning:hover {
    background-color: #e0a800;
    border-color: #c69500;
  }

  .btn-danger {
    border-radius: 8px;
  }

  .btn-secondary {
    background-color: #2c3e50;
    border-color: #2c3e50;
    color: white;
  }

  .btn-secondary:hover {
    background-color: #1a252f;
    border-color: #1a252f;
  }
</style>

</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard</a>
  <div class="card card-custom p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
      <h4 class="fw-bold m-0"><i class="bi bi-calendar2-week-fill"></i> Kelola Agenda</h4>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-circle"></i> Tambah Agenda</button>
    </div>

    <div class="table-responsive">
      <table class="table table-dark table-striped table-bordered align-middle text-center">
        <thead>
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
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($a['judul']) ?></td>
            <td><?= htmlspecialchars($a['deskripsi']) ?></td>
            <td><?= htmlspecialchars($a['tanggal']) ?></td>
            <td><?= htmlspecialchars($a['tempat']) ?></td>
            <td>
              <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#editModal<?= $a['id'] ?>"><i class="bi bi-pencil"></i></button>
              <a href="?delete=<?= $a['id'] ?>" onclick="return confirm('Yakin ingin menghapus agenda ini?')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
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
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Agenda</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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
          <button type="submit" name="submit_agenda" class="btn btn-success"><i class="bi bi-check-circle"></i> Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<?php foreach ($agenda as $a): ?>
<div class="modal fade" id="editModal<?= $a['id'] ?>" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST">
        <input type="hidden" name="id" value="<?= $a['id'] ?>">
        <div class="modal-header">
          <h5 class="modal-title">Edit Agenda</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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
          <button type="submit" name="update_agenda" class="btn btn-success"><i class="bi bi-save"></i> Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>

</body>
</html>

<?php
require '../auth/auth_guard.php';
checkRole('bendahara');
include('../partials/anggota/navbar.php');
require '../../config/db.php';

// === Tambah Project ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_project'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $status = $_POST['status'];
    $stmt = $db->prepare("INSERT INTO projects (nama, deskripsi, tanggal_mulai, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nama, $deskripsi, $tanggal_mulai, $status]);
    header("Location: kelola_projects.php");
    exit;
}

// === Hapus Project ===
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $db->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: kelola_projects.php");
    exit;
}

// === Update Project ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_project'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $status = $_POST['status'];
    $stmt = $db->prepare("UPDATE projects SET nama=?, deskripsi=?, tanggal_mulai=?, status=? WHERE id=?");
    $stmt->execute([$nama, $deskripsi, $tanggal_mulai, $status, $id]);
    header("Location: kelola_projects.php");
    exit;
}

// === Ambil Data ===
$projects = $db->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Kelola Projects | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
  body {
    font-family: 'Fira Code', monospace;
    background-color: #0d1117;
    color: #e6edf3;
  }

  .card-custom {
    background-color: #111827;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);
    padding: 20px;
  }

  .btn-primary {
    background-color: #2563eb;
    border: none;
  }

  .btn-primary:hover {
    background-color: #1e40af;
  }

  .btn-warning {
    background-color: #facc15;
    border: none;
    color: #000;
  }

  .btn-warning:hover {
    background-color: #eab308;
  }

  .btn-danger {
    background-color: #dc2626;
    border: none;
  }

  .btn-danger:hover {
    background-color: #b91c1c;
  }

  .btn-success {
    background-color: #10b981;
    border: none;
  }

  .btn-success:hover {
    background-color: #059669;
  }

  .btn-secondary {
    background-color: #334155;
    border: none;
  }

  .btn-secondary:hover {
    background-color: #1e293b;
  }

  .table-dark th, .table-dark td {
    background-color: #0d1117;
    border-color: #1f2937;
  }

  .desc-cell {
    max-width: 300px;
    white-space: pre-wrap;
    word-wrap: break-word;
    overflow-y: auto;
    max-height: 100px;
  }

  .badge.bg-success {
    background-color: #10b981 !important;
  }

  .badge.bg-primary {
    background-color: #3b82f6 !important;
  }

  .badge.bg-secondary {
    background-color: #64748b !important;
  }

  .modal-content.bg-dark {
    background-color: #1f2937 !important;
    border: 1px solid #334155;
  }

  .form-control.bg-dark,
  .form-select.bg-dark {
    background-color: #0f172a;
    border: 1px solid #334155;
    color: #e2e8f0;
  }

  .form-control.bg-dark:focus,
  .form-select.bg-dark:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
  }

  .modal-header,
  .modal-footer {
    border-color: #334155;
  }

</style>

</head>
<body>

<div class="container py-5">
  <a href="index.php" class="btn btn-secondary mb-3">← Dashboard</a>

  <div class="card card-custom">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="fw-bold text-white">💻 Kelola Projects</h4>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Project</button>
    </div>

    <div class="table-responsive">
      <table class="table table-dark table-bordered align-middle">
        <thead class="text-center">
          <tr>
            <th>No</th>
            <th>Nama Project</th>
            <th>Deskripsi</th>
            <th>Tanggal Mulai</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; foreach ($projects as $p): ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= htmlspecialchars($p['nama']) ?></td>
            <td class="desc-cell"><?= nl2br(htmlspecialchars($p['deskripsi'])) ?></td>
            <td class="text-center"><?= $p['tanggal_mulai'] ?></td>
            <td class="text-center">
              <span class="badge bg-<?= $p['status']=='Berjalan' ? 'success' : ($p['status']=='Selesai' ? 'primary' : 'secondary') ?>">
                <?= htmlspecialchars($p['status']) ?>
              </span>
            </td>
            <td class="text-center">
              <button class="btn btn-sm btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#editModal<?= $p['id'] ?>">Edit</button>
              <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Yakin ingin menghapus project ini?')" class="btn btn-sm btn-danger">Hapus</a>
            </td>
          </tr>

          <!-- Modal Edit -->
          <div class="modal fade" id="editModal<?= $p['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $p['id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content bg-dark text-light">
                <form method="POST">
                  <input type="hidden" name="id" value="<?= $p['id'] ?>">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Project</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label>Nama Project</label>
                      <input type="text" name="nama" class="form-control bg-dark text-light" value="<?= htmlspecialchars($p['nama']) ?>" required>
                    </div>
                    <div class="mb-3">
                      <label>Deskripsi</label>
                      <textarea name="deskripsi" class="form-control bg-dark text-light" rows="4" required><?= htmlspecialchars($p['deskripsi']) ?></textarea>
                    </div>
                    <div class="mb-3">
                      <label>Tanggal Mulai</label>
                      <input type="date" name="tanggal_mulai" class="form-control bg-dark text-light" value="<?= $p['tanggal_mulai'] ?>" required>
                    </div>
                    <div class="mb-3">
                      <label>Status</label>
                      <select name="status" class="form-select bg-dark text-light" required>
                        <option value="Berjalan" <?= $p['status']=='Berjalan' ? 'selected' : '' ?>>Berjalan</option>
                        <option value="Selesai" <?= $p['status']=='Selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="Tertunda" <?= $p['status']=='Tertunda' ? 'selected' : '' ?>>Tertunda</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="update_project" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark text-light">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Project</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Nama Project</label>
            <input type="text" name="nama" class="form-control bg-dark text-light" required>
          </div>
          <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control bg-dark text-light" rows="4" required></textarea>
          </div>
          <div class="mb-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control bg-dark text-light" required>
          </div>
          <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select bg-dark text-light" required>
              <option value="Berjalan">Berjalan</option>
              <option value="Selesai">Selesai</option>
              <option value="Tertunda">Tertunda</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit_project" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>

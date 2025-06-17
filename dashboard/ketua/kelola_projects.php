<?php
session_start();
require '../auth/auth_guard.php';
checkRole('ketua');
include('../partials/anggota/navbar.php');
require '../../config/db.php';

// Tambah project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_project'])) {
    $stmt = $db->prepare("INSERT INTO projects (nama, deskripsi, tanggal_mulai, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        htmlspecialchars($_POST['nama']),
        htmlspecialchars($_POST['deskripsi']),
        $_POST['tanggal_mulai'],
        $_POST['status']
    ]);
    echo "<script>localStorage.setItem('showSuccess', 'Project berhasil ditambahkan!'); location.href='kelola_projects.php';</script>";
    exit;
}

// Hapus project
if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    echo "<script>localStorage.setItem('showSuccess', 'Project berhasil dihapus!'); location.href='kelola_projects.php';</script>";
    exit;
}

// Update project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_project'])) {
    $stmt = $db->prepare("UPDATE projects SET nama=?, deskripsi=?, tanggal_mulai=?, status=? WHERE id=?");
    $stmt->execute([
        htmlspecialchars($_POST['nama']),
        htmlspecialchars($_POST['deskripsi']),
        $_POST['tanggal_mulai'],
        $_POST['status'],
        $_POST['id']
    ]);
    echo "<script>localStorage.setItem('showSuccess', 'Project berhasil diperbarui!'); location.href='kelola_projects.php';</script>";
    exit;
}

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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: radial-gradient(circle at top, #0f172a, #1e293b);
      color: #e2e8f0;
      font-family: 'Fira Code', monospace;
    }
    .card-custom {
      background: rgba(15, 23, 42, 0.95);
      border: 1px solid #334155;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(56, 189, 248, 0.2);
    }
    .btn-primary {
      background-color: #7c3aed;
      border: none;
    }
    .btn-primary:hover {
      background-color: #6d28d9;
    }
    .desc-cell {
      max-width: 300px;
      white-space: pre-wrap;
      word-wrap: break-word;
      overflow-y: auto;
      max-height: 100px;
    }
    .table-dark {
      background-color: #1e293b;
      color: #f8fafc;
    }
    .btn-warning { background-color: #facc15; color: #000; }
    .btn-danger { background-color: #ef4444; }
    .btn-success { background-color: #22c55e; border: none; }
    .btn-success:hover { background-color: #16a34a; }
    .btn-secondary { background-color: #64748b; }
    .btn-secondary:hover { background-color: #475569; }
    .modal-content {
      background: rgba(15, 23, 42, 0.95);
      border: 1px solid #334155;
      border-radius: 12px;
      color: #e2e8f0;
      font-family: 'Fira Code', monospace;
      box-shadow: 0 0 15px rgba(124, 58, 237, 0.3);
    }
    .modal-header, .modal-footer { border: none; }
    .modal-title { font-weight: bold; color: #38bdf8; }
    .form-label { color: #cbd5e1; }
    .form-control, .form-select {
      background-color: #0f172a;
      color: #e2e8f0;
      border: 1px solid #334155;
    }
    .form-control:focus, .form-select:focus {
      background-color: #1e293b;
      border-color: #7c3aed;
      box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.25);
    }
  </style>
</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-outline-light mb-3">← Kembali ke Dashboard</a>

  <div class="card card-custom p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold text-cyan-300">📁 Kelola Projects</h4>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Data</button>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-dark table-striped align-middle">
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
              <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $p['id'] ?>">
                <i class="bi bi-pencil-square"></i> Edit
              </button>
              <button onclick="confirmHapus(<?= $p['id'] ?>)" class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i> Hapus
              </button>
          </td>
          </tr>

          <!-- Modal Edit -->
          <div class="modal fade" id="editModal<?= $p['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <form method="POST">
                  <input type="hidden" name="id" value="<?= $p['id'] ?>">
                  <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Project</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label">Nama Project</label>
                      <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($p['nama']) ?>" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Deskripsi</label>
                      <textarea name="deskripsi" class="form-control" rows="4" required><?= htmlspecialchars($p['deskripsi']) ?></textarea>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Tanggal Mulai</label>
                      <input type="date" name="tanggal_mulai" class="form-control" value="<?= $p['tanggal_mulai'] ?>" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Status</label>
                      <select name="status" class="form-select" required>
                        <option <?= $p['status']=='Berjalan' ? 'selected' : '' ?>>Berjalan</option>
                        <option <?= $p['status']=='Selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option <?= $p['status']=='Tertunda' ? 'selected' : '' ?>>Tertunda</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="update_project" class="btn btn-success">Simpan Perubahan</button>
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
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Tambah Project</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Project</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
              <option>Berjalan</option>
              <option>Selesai</option>
              <option>Tertunda</option>
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

<!-- SweetAlert success on action -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const message = localStorage.getItem('showSuccess');
  if (message) {
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: message, timer: 2000, showConfirmButton: false });
    localStorage.removeItem('showSuccess');
  }
});

function confirmHapus(id) {
  Swal.fire({
    title: 'Yakin ingin menghapus?',
    text: 'Data project akan dihapus secara permanen!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Ya, hapus',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '?delete=' + id;
    }
  });
}
</script>

</body>
</html>

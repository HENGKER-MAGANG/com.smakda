<?php
session_start();
require '../auth/auth_guard.php';
checkRole('ketua');
include('../partials/navbar.php');
require '../../config/db.php';

// Tambah user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_user'])) {
  $username = trim($_POST['username']);
  $role = $_POST['role'];
  $status = $_POST['status'];
  $password = $_POST['password'];

  if ($username !== '' && $password !== '') {
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() == 0) {
      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $db->prepare("INSERT INTO users (username, password, role, status) VALUES (?, ?, ?, ?)");
      $stmt->execute([$username, $hashed, $role, $status]);
      $_SESSION['success'] = "User berhasil ditambahkan.";
    } else {
      $_SESSION['error'] = "Username sudah digunakan.";
    }
  } else {
    $_SESSION['error'] = "Username dan Password tidak boleh kosong.";
  }

  header("Location: kelola_users.php");
  exit;
}

// Hapus user
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
  $stmt->execute([$id]);
  $_SESSION['success'] = "User berhasil dihapus.";
  header("Location: kelola_users.php");
  exit;
}

// Update user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
  $id = $_POST['id'];
  $username = trim($_POST['username']);
  $role = $_POST['role'];
  $status = $_POST['status'];
  $password = $_POST['password'];

  if (!empty($password)) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("UPDATE users SET username=?, password=?, role=?, status=? WHERE id=?");
    $stmt->execute([$username, $hashed, $role, $status, $id]);
  } else {
    $stmt = $db->prepare("UPDATE users SET username=?, role=?, status=? WHERE id=?");
    $stmt->execute([$username, $role, $status, $id]);
  }

  $_SESSION['success'] = "User berhasil diperbarui.";
  header("Location: kelola_users.php");
  exit;
}

// Verifikasi user baru
if (isset($_GET['verifikasi'])) {
  $id = $_GET['verifikasi'];
  $stmt = $db->prepare("UPDATE users SET status = 'Aktif' WHERE id = ?");
  $stmt->execute([$id]);
  $_SESSION['success'] = "Akun berhasil divalidasi dan diaktifkan.";
  header("Location: kelola_users.php");
  exit;
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Pengguna | COM SMAKDA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
      color: #f1f1f1;
      font-family: 'Fira Code', monospace;
    }
    .card {
      background-color: #1c1c1e;
      border-radius: 16px;
      border: 1px solid #2c2c2e;
      box-shadow: 0 0 30px rgba(0,0,0,0.3);
    }
    .table {
      color: #ffffff;
    }
    .table th {
      background-color: #2c2c2e;
      color: #ffffff;
    }
    .btn {
      border-radius: 8px;
    }
    .modal-content {
      background-color: #1f1f1f;
      color: #f1f1f1;
    }
    .form-control, .form-select {
      background-color: #2a2a2e;
      color: #f1f1f1;
      border: 1px solid #444;
    }
    .btn-close {
      filter: invert(1);
    }
    a {
      color: #4dd0e1;
      text-decoration: none;
    }

    .table-responsive {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}
  </style>
</head>
<body>
<div class="container my-5">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-4">
    <h3 class="fw-bold text-info">Kelola Pengguna</h3>
    <a href="index.php" class="btn btn-outline-info"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
  </div>

  <div class="card mb-4">
    <div class="card-body">
      <div class="d-flex justify-content-between mb-3">
        <h5 class="fw-semibold">Daftar Pengguna</h5>
        <button class="btn btn-info fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambah">
          <i class="bi bi-plus-circle me-1"></i> Tambah Pengguna
        </button>
      </div>
      <div class="table-responsive">
        <table class="table table-dark table-hover align-middle text-center">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Role</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $users = $db->query("SELECT * FROM users WHERE status != 'Menunggu' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
          $no = 1;
          foreach ($users as $u): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($u['username']) ?></td>
              <td><?= htmlspecialchars($u['role']) ?></td>
              <td><span class="badge bg-<?= $u['status'] == 'Aktif' ? 'success' : 'secondary' ?>"><?= $u['status'] ?></span></td>
              <td>
                <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editModal<?= $u['id'] ?>"><i class="bi bi-pencil-square"></i></button>
                <a href="?delete=<?= $u['id'] ?>" class="btn btn-danger btn-sm btn-delete"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="fw-semibold text-warning mb-3">Validasi Pengguna Baru</h5>
      <div class="table-responsive">
        <table class="table table-dark table-hover align-middle text-center">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Role</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $pending_users = $db->query("SELECT * FROM users WHERE status = 'Menunggu' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
          $no_pending = 1;
          foreach ($pending_users as $p): ?>
            <tr>
              <td><?= $no_pending++ ?></td>
              <td><?= htmlspecialchars($p['username']) ?></td>
              <td><?= htmlspecialchars($p['role']) ?></td>
              <td><span class="badge bg-warning text-dark">Menunggu</span></td>
              <td>
                <a href="?verifikasi=<?= $p['id'] ?>" class="btn btn-success btn-sm"><i class="bi bi-check-circle me-1"></i> Terima</a>
                <a href="?delete=<?= $p['id'] ?>" class="btn btn-danger btn-sm btn-delete"><i class="bi bi-x-circle me-1"></i> Tolak</a>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (count($pending_users) == 0): ?>
            <tr>
              <td colspan="5" class="text-muted">Tidak ada akun yang menunggu validasi.</td>
            </tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow">
      <form method="POST">
        <div class="modal-header bg-primary text-white rounded-top-4">
          <h5 class="modal-title fw-semibold">Tambah Pengguna</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body px-4 py-3">
          <div class="mb-3">
            <label class="form-label fw-medium">Username</label>
            <input type="text" name="username" class="form-control rounded-3" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-medium">Role</label>
            <select name="role" class="form-select rounded-3" required>
              <option value="ketua">Ketua</option>
              <option value="sekretaris">Sekretaris</option>
              <option value="bendahara">Bendahara</option>
              <option value="anggota">Anggota</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-medium">Status</label>
            <select name="status" class="form-select rounded-3" required>
              <option value="Aktif">Aktif</option>
              <option value="Menunggu">Menunggu</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-medium">Password</label>
            <input type="password" name="password" class="form-control rounded-3" required>
          </div>
        </div>
        <div class="modal-footer px-4 pb-4">
          <button type="submit" name="submit_user" class="btn btn-primary px-4">Simpan</button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<?php foreach ($users as $u): ?>
<div class="modal fade" id="editModal<?= $u['id'] ?>" tabindex="-1">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow">
      <form method="POST">
        <input type="hidden" name="id" value="<?= $u['id'] ?>">
        <div class="modal-header bg-warning text-white rounded-top-4">
          <h5 class="modal-title fw-semibold">Edit Pengguna</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body px-4 py-3">
          <div class="mb-3">
            <label class="form-label fw-medium">Username</label>
            <input type="text" name="username" class="form-control rounded-3" value="<?= htmlspecialchars($u['username']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-medium">Role</label>
            <select name="role" class="form-select rounded-3" required>
              <option value="ketua" <?= $u['role'] == 'ketua' ? 'selected' : '' ?>>Ketua</option>
              <option value="sekretaris" <?= $u['role'] == 'sekretaris' ? 'selected' : '' ?>>Sekretaris</option>
              <option value="bendahara" <?= $u['role'] == 'bendahara' ? 'selected' : '' ?>>Bendahara</option>
              <option value="anggota" <?= $u['role'] == 'anggota' ? 'selected' : '' ?>>Anggota</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-medium">Status</label>
            <select name="status" class="form-select rounded-3" required>
              <option value="Aktif" <?= $u['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
              <option value="Menunggu" <?= $u['status'] == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-medium">Password (Kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control rounded-3" placeholder="Biarkan kosong jika tidak mengubah">
          </div>
        </div>
        <div class="modal-footer px-4 pb-4">
          <button type="submit" name="update_user" class="btn btn-success px-4">Simpan</button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>

<!-- SweetAlert Notifikasi -->
<?php if (isset($_SESSION['success'])): ?>
<script>Swal.fire('Berhasil!', '<?= $_SESSION['success'] ?>', 'success');</script>
<?php unset($_SESSION['success']); endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<script>Swal.fire('Gagal!', '<?= $_SESSION['error'] ?>', 'error');</script>
<?php unset($_SESSION['error']); endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    const url = this.getAttribute('href');
    Swal.fire({
      title: 'Yakin hapus pengguna?',
      text: 'Tindakan ini tidak dapat dibatalkan!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then(result => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  });
});
</script>
</body>
</html>

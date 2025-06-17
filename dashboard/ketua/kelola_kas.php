<?php
require '../auth/auth_guard.php';
checkRole('ketua');
include('../partials/anggota/navbar.php');
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
  echo "<script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: 'Data kas berhasil dihapus!',
      showConfirmButton: false,
      timer: 1500
    }).then(() => window.location.href='kelola_kas.php');
  </script>";
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

// === FILTER KAS ===
$filterTipe = isset($_GET['filter_tipe']) ? $_GET['filter_tipe'] : '';
if ($filterTipe == 'Masuk' || $filterTipe == 'Keluar') {
  $stmt = $db->prepare("SELECT * FROM kas WHERE tipe = ? ORDER BY tanggal DESC");
  $stmt->execute([$filterTipe]);
  $kas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  $kas = $db->query("SELECT * FROM kas ORDER BY tanggal DESC")->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Kas | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Fira Code', monospace;
      background-color: #0f172a;
      color: #f8fafc;
    }
    .card-custom {
      background-color: #1e293b;
      border-radius: 12px;
      padding: 24px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }
    .btn-primary {
      background-color: #6366f1;
      border: none;
    }
    .btn-primary:hover {
      background-color: #4f46e5;
    }
    .btn-secondary {
      background-color: #334155;
      color: #f8fafc;
    }
    .btn-secondary:hover {
      background-color: #475569;
    }
    .table-dark thead th {
      background-color: #334155;
    }
    .badge-success {
      background-color: #22c55e;
    }
    .badge-danger {
      background-color: #ef4444;
    }
    a {
      text-decoration: none;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-secondary mb-4">← Kembali ke Dashboard</a>
  <div class="card card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold text-white"><i class="bi bi-cash-coin me-1"></i> Kelola Kas</h4>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle me-1"></i> Tambah Kas
      </button>
    </div>

    <form method="GET" class="row g-3 align-items-center mb-3">
      <div class="col-auto">
        <label class="col-form-label">Filter Tipe:</label>
      </div>
      <div class="col-auto">
        <select name="filter_tipe" class="form-select bg-dark text-white border-0">
          <option value="">Semua</option>
          <option value="Masuk" <?= $filterTipe === 'Masuk' ? 'selected' : '' ?>>Masuk</option>
          <option value="Keluar" <?= $filterTipe === 'Keluar' ? 'selected' : '' ?>>Keluar</option>
        </select>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">Terapkan</button>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-dark table-hover text-white text-center align-middle">
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
              <span class="badge <?= $k['tipe'] === 'Masuk' ? 'badge-success' : 'badge-danger' ?>"><?= $k['tipe'] ?></span>
            </td>
            <td>Rp <?= number_format($k['jumlah'], 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($k['keterangan']) ?></td>
            <td>
              <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#editModal<?= $k['id'] ?>">
                <i class="bi bi-pencil-square me-1"></i> Edit
              </button>
              <a href="?delete=<?= $k['id'] ?>" onclick="return confirmDelete(event)" class="btn btn-sm btn-danger">
                <i class="bi bi-trash me-1"></i> Hapus
              </a>
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
    <div class="modal-content bg-dark text-white">
      <form method="POST">
        <div class="modal-header border-0">
          <h5 class="modal-title">Tambah Kas</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control bg-dark text-white" required>
          </div>
          <div class="mb-3">
            <label>Tipe</label>
            <select name="tipe" class="form-select bg-dark text-white" required>
              <option value="Masuk">Masuk</option>
              <option value="Keluar">Keluar</option>
            </select>
          </div>
          <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control bg-dark text-white" required>
          </div>
          <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control bg-dark text-white" required></textarea>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="submit" name="submit_kas" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<?php foreach ($kas as $k): ?>
<div class="modal fade" id="editModal<?= $k['id'] ?>" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <form method="POST">
        <input type="hidden" name="id" value="<?= $k['id'] ?>">
        <div class="modal-header border-0">
          <h5 class="modal-title">Edit Kas</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control bg-dark text-white" value="<?= $k['tanggal'] ?>" required>
          </div>
          <div class="mb-3">
            <label>Tipe</label>
            <select name="tipe" class="form-select bg-dark text-white" required>
              <option value="Masuk" <?= $k['tipe'] === 'Masuk' ? 'selected' : '' ?>>Masuk</option>
              <option value="Keluar" <?= $k['tipe'] === 'Keluar' ? 'selected' : '' ?>>Keluar</option>
            </select>
          </div>
          <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control bg-dark text-white" value="<?= $k['jumlah'] ?>" required>
          </div>
          <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control bg-dark text-white" required><?= $k['keterangan'] ?></textarea>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="submit" name="update_kas" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>

<script>
function confirmDelete(e) {
  e.preventDefault();
  const url = e.currentTarget.getAttribute('href');
  Swal.fire({
    title: 'Hapus Data?',
    text: 'Data yang dihapus tidak dapat dikembalikan.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e3342f',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
  return false;
}
</script>

</body>
</html>

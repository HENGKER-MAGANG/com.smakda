<?php
require '../auth/auth_guard.php';
checkRole('sekretaris');
include('../partials/anggota/navbar.php');
require '../../config/db.php';

$upload_dir = '../../assets/dokumentasi/';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_dokumentasi'])) {
  $keterangan = $_POST['keterangan'];
  $tanggal = $_POST['tanggal'];
  $file = $_FILES['gambar'];

  if ($file['error'] == 0) {
    $filename = time() . '_' . basename($file['name']);
    $target = $upload_dir . $filename;
    if (move_uploaded_file($file['tmp_name'], $target)) {
      $stmt = $db->prepare("INSERT INTO dokumentasi (nama_file, keterangan, tanggal) VALUES (?, ?, ?)");
      $stmt->execute([$filename, $keterangan, $tanggal]);
    }
  }
}

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $stmt = $db->prepare("SELECT nama_file FROM dokumentasi WHERE id = ?");
  $stmt->execute([$id]);
  $file = $stmt->fetchColumn();
  if ($file) {
    unlink($upload_dir . $file);
    $db->prepare("DELETE FROM dokumentasi WHERE id = ?")->execute([$id]);
  }
  header("Location: kelola_dokumentasi.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Dokumentasi | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-color: #0f172a;
      color: #f1f5f9;
      font-family: 'Segoe UI', sans-serif;
    }

    .card-custom {
      background-color: #1e293b;
      border: 1px solid #3b82f6;
      border-radius: 12px;
      transition: 0.3s;
    }

    .card-custom:hover {
      box-shadow: 0 0 10px #3b82f6aa;
    }

    .btn-primary {
      background-color: #3b82f6;
      border: none;
    }

    .btn-primary:hover {
      background-color: #2563eb;
    }

    .btn-success {
      background-color: #10b981;
      border: none;
    }

    .btn-success:hover {
      background-color: #059669;
    }

    .btn-danger {
      background-color: #ef4444;
      border: none;
    }

    .btn-danger:hover {
      background-color: #dc2626;
    }

    .btn-back {
      background-color: transparent;
      border: 1px solid #3b82f6;
      color: #3b82f6;
      transition: all 0.3s;
    }

    .btn-back:hover {
      background-color: #3b82f6;
      color: white;
    }

    .img-preview {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px 8px 0 0;
    }

    @media (max-width: 768px) {
      .img-preview {
        height: 150px;
      }
    }
  </style>
</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-back mb-4"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold text-info"><i class="bi bi-images me-2"></i>Kelola Dokumentasi</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUpload">
      <i class="bi bi-upload me-1"></i> Upload Dokumentasi
    </button>
  </div>

  <div class="row">
    <?php
    $stmt = $db->query("SELECT * FROM dokumentasi ORDER BY tanggal DESC");
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $dok): ?>
      <div class="col-md-4 col-sm-6 mb-4">
        <div class="card card-custom shadow-sm h-100">
          <img src="<?= $upload_dir . $dok['nama_file'] ?>" class="img-preview" alt="Dokumentasi">
          <div class="card-body">
            <p class="card-text"><?= htmlspecialchars($dok['keterangan']) ?></p>
            <p class="text-muted small">📅 <?= $dok['tanggal'] ?></p>
            <button onclick="confirmDelete(<?= $dok['id'] ?>)" class="btn btn-sm btn-danger">
              <i class="bi bi-trash"></i> Hapus
            </button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Modal Upload -->
<div class="modal fade" id="modalUpload" tabindex="-1" aria-labelledby="modalUploadLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form method="POST" enctype="multipart/form-data" class="modal-content card-custom text-light">
      <div class="modal-header border-0">
        <h5 class="modal-title"><i class="bi bi-upload me-1"></i> Upload Dokumentasi</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Gambar</label>
          <input type="file" name="gambar" accept="image/*" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Keterangan</label>
          <textarea name="keterangan" class="form-control" rows="2" required></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Tanggal</label>
          <input type="date" name="tanggal" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="submit" name="upload_dokumentasi" class="btn btn-success">
          <i class="bi bi-check-circle me-1"></i> Upload
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Script Konfirmasi Hapus -->
<script>
  function confirmDelete(id) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: "Dokumentasi akan dihapus permanen.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?delete=' + id;
      }
    });
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
session_start();
require '../auth/auth_guard.php';
checkRole('ketua');
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
  header("Location: kelola_dokumentasi.php");
  exit;
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
  header("Location: kelola_dokumentasi.php?deleted=1");
  exit;
}
?>

<!-- ... PHP logic tetap sama seperti sebelumnya ... -->

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Dokumentasi | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-color: #1e1e2f;
      color: #f0f0f0;
      font-family: 'Fira Code', monospace;
    }
    .card-custom {
      background-color: #2d2d3a;
      border: 1px solid #3d3d4d;
      border-radius: 12px;
      transition: 0.3s;
    }
    .card-custom:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 18px rgba(0,0,0,0.4);
    }
    .img-preview {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px 8px 0 0;
    }
    .form-control, .form-control:focus {
      background-color: #1e1e2f;
      color: #fff;
      border: 1px solid #555;
    }
    .modal-content {
      background-color: #2d2d3a;
      color: white;
    }
    .btn-close {
      filter: invert(1);
    }
    .text-muted {
      color: #aaa !important;
    }
    @media (max-width: 768px) {
      h4.fw-bold {
        font-size: 1.25rem;
      }
      .card-text, .text-muted {
        font-size: 0.9rem;
      }
      .modal-dialog {
        max-width: 95%;
        margin: 1rem auto;
      }
      .btn {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
      }
    }
  </style>
</head>
<body>

<div class="container my-4">
  <a href="index.php" class="btn btn-outline-light mb-3">
    <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
  </a>

  <div class="card card-custom p-4 shadow">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
      <h4 class="fw-bold mb-2 mb-md-0"><i class="bi bi-images"></i> Kelola Dokumentasi</h4>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUpload">
        <i class="bi bi-cloud-arrow-up"></i> Upload Dokumentasi
      </button>
    </div>

    <div class="row">
      <?php
      $stmt = $db->query("SELECT * FROM dokumentasi ORDER BY tanggal DESC");
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $dok): ?>
        <div class="col-12 col-sm-6 col-lg-4 mb-4">
          <div class="card card-custom h-100">
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
</div>

<!-- Modal Upload -->
<div class="modal fade" id="modalUpload" tabindex="-1" aria-labelledby="modalUploadLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form method="POST" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-upload"></i> Upload Dokumentasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
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
      <div class="modal-footer">
        <button type="submit" name="upload_dokumentasi" class="btn btn-success">
          <i class="bi bi-send-check"></i> Upload
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Yakin hapus dokumentasi ini?',
    text: "Tindakan ini tidak dapat dibatalkan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#666',
    confirmButtonText: 'Ya, hapus'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "?delete=" + id;
    }
  });
}

<?php if (isset($_GET['deleted'])): ?>
Swal.fire({
  icon: 'success',
  title: 'Berhasil!',
  text: 'Dokumentasi berhasil dihapus.',
  timer: 2000,
  showConfirmButton: false
});
<?php endif; ?>
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

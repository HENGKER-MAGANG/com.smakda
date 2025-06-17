<?php
session_start();
require '../auth/auth_guard.php';
checkRole('anggota');
include('../partials/navbar.php');
require '../../config/db.php';
$upload_dir = '../../assets/dokumentasi/';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lihat Dokumentasi | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- TailwindCSS + Bootstrap -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Fira Code Font -->
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #0f172a; /* biru tua */
      color: #f8fafc; /* putih kebiruan */
      font-family: 'Fira Code', monospace;
    }
    .card-custom {
      background-color: #1e293b;
      border: 1px solid #334155;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.1); /* merah */
    }
    .card-custom:hover {
      box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
      transform: translateY(-3px);
    }
    .btn-back {
      background-color: #ef4444;
      border: none;
      color: white;
      transition: 0.3s;
    }
    .btn-back:hover {
      background-color: #dc2626;
    }
    .section-title {
      color: #ef4444;
    }
    .img-preview {
      height: 200px;
      object-fit: cover;
      border-top-left-radius: 0.375rem;
      border-top-right-radius: 0.375rem;
    }
    .card-text {
      color: #e2e8f0;
    }
    .text-muted {
      color: #94a3b8 !important;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-back mb-4"><strong>←</strong> Kembali ke Dashboard</a>

  <div class="card p-4 card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="section-title fw-bold">📷 Dokumentasi Kegiatan</h3>
    </div>

    <div class="row">
      <?php
      $stmt = $db->query("SELECT * FROM dokumentasi ORDER BY tanggal DESC");
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $dok): ?>
        <div class="col-md-4 mb-4">
          <div class="card card-custom">
            <img src="<?= $upload_dir . $dok['nama_file'] ?>" class="img-preview w-100" alt="Dokumentasi">
            <div class="card-body">
              <p class="card-text"><?= htmlspecialchars($dok['keterangan']) ?></p>
              <p class="text-muted small">📅 <?= $dok['tanggal'] ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if ($stmt->rowCount() === 0): ?>
      <div class="text-center mt-5 text-muted">Belum ada dokumentasi yang diunggah.</div>
    <?php endif; ?>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

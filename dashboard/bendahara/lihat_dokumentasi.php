<?php
session_start();
require '../auth/auth_guard.php';
checkRole('bendahara');
include('../partials/anggota/navbar.php');
require '../../config/db.php';
$upload_dir = '../../assets/dokumentasi/';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lihat Dokumentasi | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
  <style>
    body {
      background: #0f0f0f;
      color: #e0e0e0;
      font-family: 'Fira Code', monospace;
    }

    .card-custom {
      background: #1a1a1a;
      border: 1px solid #333;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 255, 255, 0.1);
    }

    .card-custom img {
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      object-fit: cover;
      height: 200px;
      width: 100%;
    }

    .card-custom .card-body {
      color: #fff;
    }

    a.btn-secondary {
      background-color: #333;
      border: none;
    }

    a.btn-secondary:hover {
      background-color: #555;
    }

    .card-text, .text-muted {
      color: #ccc !important;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-secondary mb-4">← Kembali ke Dashboard</a>

  <div class="card card-custom p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="fw-bold text-info">📸 Dokumentasi Kegiatan</h4>
    </div>

    <div class="row">
      <?php
      $stmt = $db->query("SELECT * FROM dokumentasi ORDER BY tanggal DESC");
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $dok): ?>
        <div class="col-md-4 col-sm-6 mb-4">
          <div class="card card-custom h-100 shadow-sm">
            <img src="<?= $upload_dir . $dok['nama_file'] ?>" alt="Dokumentasi">
            <div class="card-body">
              <p class="card-text"><?= htmlspecialchars($dok['keterangan']) ?></p>
              <p class="text-muted small">📅 <?= date('d M Y', strtotime($dok['tanggal'])) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

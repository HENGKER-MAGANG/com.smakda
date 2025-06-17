<?php
require '../auth/auth_guard.php';
checkRole('anggota'); // hanya role anggota
include('../partials/anggota/navbar.php');
require '../../config/db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lihat Agenda | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Google Fonts: Programmer Style -->
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #0a0f2c;
      color: #ffffff;
      font-family: 'Fira Code', monospace;
    }
    .card-custom {
      background-color: #111827;
      border: 1px solid #3b82f6;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(59, 130, 246, 0.4);
    }
    .table thead {
      background-color: #3b82f6;
      color: white;
    }
    .table tbody tr {
      background-color: #1e293b;
      color: white;
    }
    .table tbody tr:hover {
      background-color: #1e40af;
    }
    .btn-custom {
      background-color: #3b82f6;
      color: white;
      border: none;
    }
    .btn-custom:hover {
      background-color: #2563eb;
    }
    .title {
      color: #3b82f6;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-outline-primary mb-4">← Kembali ke Dashboard</a>

  <div class="card card-custom p-4">
    <h4 class="fw-bold mb-4 title">📅 Agenda & Kegiatan Organisasi</h4>

    <div class="table-responsive">
      <table class="table table-dark table-bordered align-middle text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Tanggal</th>
            <th>Tempat</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $agenda = $db->query("SELECT * FROM agenda ORDER BY tanggal DESC");
          foreach ($agenda as $row): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['judul']) ?></td>
              <td><?= htmlspecialchars($row['deskripsi']) ?></td>
              <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
              <td><?= htmlspecialchars($row['tempat']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

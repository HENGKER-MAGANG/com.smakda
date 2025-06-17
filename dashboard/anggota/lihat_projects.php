<?php
require '../auth/auth_guard.php';
checkRole('anggota');
include('../partials/anggota/navbar.php');
require '../../config/db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lihat Projects | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Tailwind & Bootstrap -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font: Roboto Mono -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #0f172a; /* biru tua */
      font-family: 'Roboto Mono', monospace;
      color: #ffffff;
    }
    .card-custom {
      background-color: #1e293b;
      border: 1px solid #e11d48; /* merah solid */
      border-radius: 12px;
    }
    .table-dark-custom thead {
      background-color: #1e293b;
      color: #e11d48;
    }
    .table-dark-custom tbody tr:hover {
      background-color: #334155;
    }
    .badge-success {
      background-color: #10b981; /* hijau toska */
      color: white;
    }
    .badge-info {
      background-color: #e11d48;
      color: white;
    }
    .btn-red {
      background-color: #e11d48;
      border: none;
      color: white;
    }
    .btn-red:hover {
      background-color: #be123c;
    }
    a.btn-secondary {
      background-color: #334155;
      border: none;
      color: white;
    }
    a.btn-secondary:hover {
      background-color: #475569;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-secondary mb-4">← Kembali ke Dashboard</a>

  <div class="card card-custom p-4 shadow-lg">
    <h4 class="fw-bold text-danger mb-4">📁 Daftar Project</h4>

    <div class="table-responsive">
      <table class="table table-dark table-dark-custom table-bordered table-hover align-middle text-center">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Tanggal Mulai</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $data = $db->query("SELECT * FROM projects ORDER BY id ASC");
          foreach ($data as $row):
          ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= htmlspecialchars($row['deskripsi']) ?></td>
              <td><?= date('d M Y', strtotime($row['tanggal_mulai'])) ?></td>
              <td>
                <?php if ($row['status'] === 'selesai'): ?>
                  <span class="badge badge-success">Selesai</span>
                <?php else: ?>
                  <span class="badge badge-info">Proses</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

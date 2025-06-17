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
  <title>Lihat Users | COM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Tailwind & Bootstrap -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #0a0f2c;
      color: #f1f1f1;
      font-family: 'Fira Code', monospace;
    }
    .card-dark {
      background-color: #101426;
      border: 1px solid #1e3a8a;
      border-radius: 12px;
    }
    .table-dark th, .table-dark td {
      color: #dbeafe;
      vertical-align: middle;
    }
    .table thead {
      background-color: #1e3a8a;
    }
    .btn-back {
      background-color: #ef4444;
      color: white;
      transition: 0.3s;
    }
    .btn-back:hover {
      background-color: #dc2626;
    }
    .text-danger {
      color: #ef4444 !important;
    }
    .badge-success {
      background-color: #22c55e;
    }
    .badge-warning {
      background-color: #facc15;
      color: #000;
    }
    .badge-danger {
      background-color: #ef4444;
    }
    .text-warning {
      color: #facc15 !important;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-back mb-4 shadow-sm"><strong>←</strong> Kembali ke Dashboard</a>

  <div class="card card-dark p-4 shadow">
    <h3 class="fw-bold mb-4 text-danger">📋 Daftar Pengguna</h3>

    <div class="table-responsive">
      <table class="table table-dark table-bordered table-hover align-middle">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th>Username</th>
            <th>Jabatan</th>
            <th>Status</th>
            <th>Tanggal Daftar</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $data = $db->query("SELECT * FROM users ORDER BY id ASC");
          foreach ($data as $row):
          ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><span class="text-warning"><?= ucfirst($row['role']) ?></span></td>
            <td>
              <?php if ($row['status'] === 'aktif'): ?>
                <span class="badge badge-success">Aktif</span>
              <?php else: ?>
                <span class="badge badge-warning">Menunggu</span>
              <?php endif; ?>
            </td>
            <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
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

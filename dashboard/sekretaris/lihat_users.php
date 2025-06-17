<?php
session_start();
require '../auth/auth_guard.php';
checkRole('sekretaris');
include('../partials/anggota/navbar.php');
require '../../config/db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Pengguna | COM SMAKDA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
  body {
    background-color: #0d1b2a; /* Biru tua + hitam */
    color: #ffffff;
    font-family: 'Fira Code', monospace;
  }

  .card-custom {
    background-color: #1b263b; /* Biru tua pekat */
    border: 1px solid #415a77;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 180, 216, 0.1); /* efek biru muda */
  }

  .table-dark th,
  .table-dark td {
    background-color: #1b263b;
    color: #ffffff;
    vertical-align: middle;
  }

  .table-dark th {
    background-color: #0d1b2a;
  }

  .btn-back {
    background-color: #1a1b2f;
    color: #90e0ef;
    border: 1px solid #00b4d8;
  }

  .btn-back:hover {
    background-color: #00b4d8;
    color: #0e0e1a;
  }

  .badge.bg-success {
    background-color: #00b4d8;
    color: #0e0e1a;
  }

  .badge.bg-warning {
    background-color: #ffd166;
    color: #0e0e1a;
  }

  .fw-bold {
    color: #90e0ef;
  }

  .table-hover tbody tr:hover {
    background-color: #27496d;
  }
</style>

</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-back mb-4">← Kembali ke Dashboard</a>

  <div class="card card-custom p-4">
    <h4 class="fw-bold mb-4">📋 Daftar Pengguna</h4>

    <div class="table-responsive">
      <table class="table table-dark table-bordered table-hover rounded overflow-hidden">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Username</th>
            <th scope="col">Password</th>
            <th scope="col">Role</th>
            <th scope="col">Status</th>
            <th scope="col">Dibuat</th>
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
              <td><?= str_repeat('*', strlen($row['password'])) ?></td>
              <td><span class="text-capitalize"><?= $row['role'] ?></span></td>
              <td>
                <?php if ($row['status'] === 'aktif'): ?>
                  <span class="badge bg-success">Aktif</span>
                <?php else: ?>
                  <span class="badge bg-warning text-dark">Menunggu</span>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

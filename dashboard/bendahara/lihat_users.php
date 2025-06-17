<?php
session_start();
require '../auth/auth_guard.php';
checkRole('bendahara');
include('../partials/anggota/navbar.php');
require '../../config/db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Pengguna | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
  background-color: #0f172a; /* biru sangat gelap */
  color: #e2e8f0;
  font-family: 'Fira Code', monospace;
}
.card-custom {
  background-color: #1e293b; /* biru gelap */
  border: none;
  border-radius: 12px;
  box-shadow: 0 0 20px rgba(0, 132, 255, 0.08); /* biru neon lembut */
}
.table thead {
  background-color: #1e3a8a; /* biru kuat */
  color: #f8fafc;
}
.table-dark {
  background-color: #0f172a;
  color: #e2e8f0;
}
.table-striped > tbody > tr:nth-of-type(odd) {
  background-color: #172554; /* biru lebih terang */
}
.table-hover tbody tr:hover {
  background-color: #1d4ed8; /* biru terang saat hover */
  color: #ffffff;
}
.badge-success {
  background-color: #3b82f6; /* biru terang untuk aktif */
}
.badge-warning {
  background-color: #f59e0b; /* kuning gelap, tetap terlihat di biru */
  color: #1e293b;
}
.btn-back {
  background-color: #1e40af;
  color: #f1f5f9;
  border: none;
}
.btn-back:hover {
  background-color: #1d4ed8;
  color: white;
}
.badge.bg-info {
  background-color: #60a5fa; /* biru soft */
  color: #1e293b;
}

  </style>
</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-back mb-4">← Kembali ke Dashboard</a>

  <div class="card card-custom p-4">
    <h3 class="fw-bold mb-4">📋 Daftar Pengguna</h3>

    <div class="table-responsive">
      <table class="table table-dark table-striped table-hover rounded">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created At</th>
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
              <td>
                <span class="badge bg-info text-dark"><?= ucfirst($row['role']) ?></span>
              </td>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

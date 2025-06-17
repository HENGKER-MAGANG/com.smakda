<?php
require '../auth/auth_guard.php';
checkRole('sekretaris');
include('../partials/anggota/navbar.php');
require '../../config/db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lihat Kas | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #121212;
      color: #ffffff;
      font-family: 'Fira Code', monospace;
    }
    .card-custom {
      background-color: #1e1e2f;
      border: 1px solid #2e2e3e;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.4);
    }
    .table-dark-custom th {
      background-color: #2c2f4a;
      color: #fff;
    }
    .table-dark-custom td {
      background-color: #1e1e2f;
      color: #e0e0e0;
    }
    .badge-masuk {
      background-color: #198754;
      color: white;
      font-size: 0.85rem;
    }
    .badge-keluar {
      background-color: #dc3545;
      color: white;
      font-size: 0.85rem;
    }
    a.btn-back {
      background-color: #2c2f4a;
      color: white;
      border: none;
      transition: 0.3s;
    }
    a.btn-back:hover {
      background-color: #3a3e5c;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-back mb-4">
    ← Kembali ke Dashboard
  </a>

  <div class="card-custom p-4">
    <h3 class="fw-bold mb-4 text-warning">Riwayat Kas Organisasi</h3>

    <div class="table-responsive">
      <table class="table table-dark-custom table-bordered table-hover text-center align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $kas = $db->query("SELECT * FROM kas ORDER BY tanggal DESC");
          foreach ($kas as $row): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
              <td>
                <span class="badge <?= $row['tipe'] === 'masuk' ? 'badge-masuk' : 'badge-keluar' ?>">
                  <?= ucfirst($row['tipe']) ?>
                </span>
              </td>
              <td>Rp<?= number_format($row['jumlah'], 0, ',', '.') ?></td>
              <td><?= htmlspecialchars($row['keterangan']) ?></td>
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

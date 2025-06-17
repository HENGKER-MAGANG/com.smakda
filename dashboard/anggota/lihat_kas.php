<?php
session_start();
require '../auth/auth_guard.php';
checkRole('anggota');
include('../partials/navbar.php');
require '../../config/db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Riwayat Kas | COM SMAKDA</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #0a0f2c;
      color: #ffffff;
      font-family: 'Fira Code', monospace;
      font-size: 1rem;
    }
    .card-custom {
      background: #111827;
      border-radius: 10px;
      border: 1px solid #ef4444;
      box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
    }
    .table thead {
      background-color: #1e293b;
      color: #ef4444;
    }
    .table tbody tr {
      background-color: #0f172a;
      border-bottom: 1px solid #334155;
    }
    .badge-masuk {
      background-color: #22c55e;
      color: #fff;
      font-weight: bold;
    }
    .badge-keluar {
      background-color: #ef4444;
      color: #fff;
      font-weight: bold;
    }
    .btn-back {
      background-color: transparent;
      border: 1px solid #ef4444;
      color: #ef4444;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 1.1rem;
      padding: 10px 18px;
    }
    .btn-back:hover {
      background-color: #ef4444;
      color: #fff;
    }
    .table th, .table td {
      vertical-align: middle;
      font-size: 1rem;
      white-space: nowrap;
      word-break: break-word;
    }

    /* Scrollable Table Styling */
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    .table {
      min-width: 700px; /* agar bisa digeser di mobile */
    }

    /* Mobile Responsive Adjustments */
    @media (max-width: 576px) {
      .card-custom {
        padding: 1.2rem;
      }
      .btn-back {
        font-size: 1.2rem;
        padding: 10px 18px;
        width: 100%;
      }
      .table th, .table td {
        font-size: 1.05rem;
        padding: 0.75rem;
      }
      h3 {
        font-size: 1.5rem;
        text-align: center;
      }
    }
  </style>
</head>
<body>

<div class="container-fluid my-4 px-3">
  <a href="index.php" class="btn btn-back mb-3">← Kembali ke Dashboard</a>

  <div class="card card-custom p-4">
    <h3 class="mb-4 fw-bold" style="color: #ef4444;">📄 Riwayat Kas Organisasi</h3>

    <div class="table-responsive">
      <table class="table table-dark table-bordered text-white">
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

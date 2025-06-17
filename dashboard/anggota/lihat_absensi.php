<?php
session_start();
require '../auth/auth_guard.php';
checkRole('anggota');
include('../partials/anggota/navbar.php');
require '../../config/db.php';

$username = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Absensi | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      background-color: #0a0f2c;
      font-family: 'Fira Code', monospace;
      color: #ffffff;
    }

    .card-custom {
      background-color: #111827;
      border: 1px solid #3b82f6;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(59, 130, 246, 0.25);
    }

    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    .table {
      min-width: 600px;
    }

    .table thead {
      background: linear-gradient(to right, #3b82f6, #ef4444);
      color: white;
    }

    .table tbody tr {
      background-color: #0f172a;
      border-bottom: 1px solid #334155;
    }

    .table-hover tbody tr:hover {
      background-color: #1e293b;
    }

    .badge-hadir {
      background-color: #3b82f6;
      color: white;
      font-weight: bold;
    }

    .badge-izin {
      background-color: #facc15;
      color: #111827;
      font-weight: bold;
    }

    .badge-sakit {
      background-color: #0ea5e9;
      color: white;
      font-weight: bold;
    }

    .badge-alfa {
      background-color: #ef4444;
      color: white;
      font-weight: bold;
    }

    .btn-kembali {
      background-color: transparent;
      border: 1px solid #ef4444;
      color: #ef4444;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 1.1rem;
      padding: 10px 18px;
    }

    .btn-kembali:hover {
      background-color: #ef4444;
      color: white;
    }

    h4 {
      color: #3b82f6;
    }

    /* Responsive tweaks */
    @media (max-width: 576px) {
      h4 {
        font-size: 1.5rem;
        text-align: center;
      }

      .btn-kembali {
        width: 100%;
        font-size: 1.2rem;
      }

      .table th, .table td {
        font-size: 1rem;
        padding: 0.75rem;
        white-space: nowrap;
      }
    }
  </style>
</head>
<body>

<div class="container-fluid my-5 px-3">
  <a href="index.php" class="btn btn-kembali mb-3">← Kembali ke Dashboard</a>

  <div class="card card-custom p-4">
    <h4 class="fw-bold mb-4">📅 Riwayat Absensi Saya</h4>

    <div class="table-responsive">
      <table class="table table-dark table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $absen = $db->prepare("SELECT * FROM absensi WHERE username = ? ORDER BY tanggal DESC");
          $absen->execute([$username]);
          $no = 1;
          foreach ($absen as $row): 
              $status = strtolower($row['status']);
              $badgeClass = match($status) {
                'hadir' => 'badge-hadir',
                'izin'  => 'badge-izin',
                'sakit' => 'badge-sakit',
                default => 'badge-alfa'
              };
          ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
            <td><span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span></td>
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

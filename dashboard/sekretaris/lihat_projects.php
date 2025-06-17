<?php
session_start();
require '../auth/auth_guard.php';
checkRole('sekretaris');
include('../partials/navbar.php');
require '../../config/db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lihat Projects | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Fira Code Font -->
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">

  <!-- SweetAlert2 (jika nanti dibutuhkan untuk interaksi dinamis) -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
  body {
    background: linear-gradient(to right, #0f172a, #1e293b, #3b82f6); /* biru tua → muda */
    color: #e2e8f0; /* abu terang */
    font-family: 'Fira Code', monospace;
    min-height: 100vh;
  }

  .card-custom {
    background-color: #0f172a; /* biru-hitam */
    border: 1px solid #1e40af; /* biru tua */
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.25); /* biru terang */
  }

  .table-dark {
    background-color: #1e293b;
    color: #e2e8f0;
  }

  .table-dark th {
    background-color: #1e40af; /* biru tua */
    color: white;
  }

  .table-dark tbody tr:hover {
    background-color: #1d4ed8; /* biru muda hover */
    color: white;
  }

  .badge-status {
    font-size: 0.85em;
    padding: 5px 12px;
    border-radius: 20px;
    font-weight: 500;
  }

  .badge-selesai {
    background-color: #22c55e; /* hijau terang */
    color: white;
  }

  .badge-proses {
    background-color: #38bdf8; /* biru muda */
    color: #0f172a;
  }

  .btn-back {
    background-color: #1e3a8a; /* biru gelap */
    color: white;
    border: none;
    transition: all 0.3s ease-in-out;
  }

  .btn-back:hover {
    background-color: #3b82f6; /* biru terang */
    color: white;
  }

  .table-bordered td, .table-bordered th {
    border: 1px solid #334155; /* abu gelap */
  }
</style>

</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-back mb-4">← Kembali ke Dashboard</a>

  <div class="card card-custom p-4">
    <h3 class="fw-bold mb-4 text-white">📂 Daftar Project</h3>

    <div class="table-responsive">
      <table class="table table-dark table-hover table-bordered rounded shadow">
        <thead>
          <tr>
            <th scope="col">ID</th>
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
                  <span class="badge badge-status badge-selesai">Selesai</span>
                <?php else: ?>
                  <span class="badge badge-status badge-proses">Proses</span>
                <?php endif; ?>
              </td>
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

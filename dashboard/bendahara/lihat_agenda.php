<?php
require '../auth/auth_guard.php';
checkRole('bendahara');
include('../partials/anggota/navbar.php');
require '../../config/db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lihat Agenda | COM SMAKDA</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts: Fira Code -->
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">

  <style>
   body {
  background-color: #0d1117; /* hitam kebiruan */
  font-family: 'Fira Code', monospace;
  color: #e0f2ff;
}
.card-custom {
  background-color: #1c1f2b; /* biru gelap */
  border: 1px solid #2d3748;
  border-radius: 12px;
}
.table-dark-custom th,
.table-dark-custom td {
  color: #dbeafe; /* biru terang */
  background-color: #1e293b; /* biru navy tua */
  border-color: #334155;
}
.btn-custom {
  background-color: #2563eb; /* biru sedang */
  border: none;
  color: white;
}
.btn-custom:hover {
  background-color: #1e40af; /* biru lebih tua */
}
a.btn-secondary {
  background-color: #1e3a8a;
  border: none;
}
a.btn-secondary:hover {
  background-color: #1e40af;
}
.text-warning {
  color: #60a5fa !important; /* biru muda untuk heading */
}
  </style>
</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-secondary mb-4">
    ← Kembali ke Dashboard
  </a>

  <div class="card card-custom p-4 shadow-lg">
    <h4 class="fw-bold mb-4 text-warning">Agenda / Kegiatan Organisasi</h4>

    <div class="table-responsive">
      <table class="table table-dark table-bordered table-hover table-dark-custom">
        <thead>
          <tr class="text-center">
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

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
require '../auth/auth_guard.php';
checkRole('bendahara');
include('../partials/navbar.php');
require '../../config/db.php';

$username = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Absensi | COM SMAKDA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Tailwind -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fira Code -->
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
<style>
  body {
  background-color: #0a0f1a; /* Hitam kebiruan */
  color: #dbeafe; /* Biru terang */
  font-family: 'Fira Code', monospace;
}

.card-custom {
  background-color: #0f172a; /* Biru tua */
  border: 1px solid #1e293b;
  border-radius: 10px;
}

.table-dark-custom {
  background-color: #0a0f1a;
  color: #dbeafe;
}

.table-dark-custom th {
  background-color: #1e293b;
  color: #dbeafe;
}

.table-dark-custom tr td {
  background-color: #0f172a;
  border-color: #1e293b;
}

/* Badge dengan nuansa biru */
.badge-hadir { background-color: #2563eb; color: #ffffff; } /* biru cerah */
.badge-izin  { background-color: #3b82f6; color: #ffffff; }
.badge-sakit { background-color: #60a5fa; color: #ffffff; }
.badge-alfa  { background-color: #1e40af; color: #ffffff; }

.btn-back {
  background-color: #1e293b;
  color: #dbeafe;
  border: 1px solid #334155;
}

.btn-back:hover {
  background-color: #334155;
  color: #ffffff;
}
</style>
</head>
<body>

<div class="container my-5">
  <a href="index.php" class="btn btn-back mb-4">← Kembali ke Dashboard</a>

  <div class="card card-custom p-4 shadow-sm">
    <h4 class="fw-bold mb-4 text-white">Riwayat Absensi Saya</h4>

    <div class="table-responsive">
      <table class="table table-bordered table-dark-custom">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $absen = $db->prepare("SELECT * FROM absensi WHERE username = ? ORDER BY tanggal DESC");
          $absen->execute([$username]);
          foreach ($absen as $row): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
              <td>
                <?php
                  $status = strtolower($row['status']);
                  $badgeClass = match($status) {
                    'hadir' => 'badge-hadir',
                    'izin'  => 'badge-izin',
                    'sakit' => 'badge-sakit',
                    default => 'badge-alfa'
                  };
                ?>
                <span class="badge <?= $badgeClass ?> px-3 py-2 rounded"><?= ucfirst($status) ?></span>
              </td>
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

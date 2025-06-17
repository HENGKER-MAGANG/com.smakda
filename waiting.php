<?php
session_start();
require 'config/db.php';

// Cegah akses langsung jika tidak ada sesi pending_user
if (!isset($_SESSION['pending_user'])) {
    header("Location: register.php?error=akses-tidak-valid");
    exit;
}

$username = $_SESSION['pending_user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("SELECT status FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user) {
        session_destroy();
        header("Location: register.php?error=Akun tidak ditemukan");
        exit;
    }

    $status = $user['status'];

        if ($status === 'aktif') {
        unset($_SESSION['pending_user']);
        header("Location: diterima.php?username=" . urlencode($username));
        exit;
            } elseif ($status === 'ditolak') {
            header("Location: ditolak.php");
            exit;
        } else {
        // Jika masih menunggu, bisa tampilkan alert atau diam saja
        $message = "Status kamu masih menunggu persetujuan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Menunggu Persetujuan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
      background: radial-gradient(circle, #0f2027, #203a43, #2c5364);
      font-family: 'Poppins', sans-serif;
      color: white;
      height: 100vh;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card-wait {
      background: rgba(255, 255, 255, 0.06);
      border-radius: 1rem;
      padding: 2rem;
      text-align: center;
      max-width: 400px;
      box-shadow: 0 0 30px rgba(56, 189, 248, 0.3);
    }

    .card-wait h4 {
      font-weight: 600;
      margin-bottom: 0.8rem;
      color: #38bdf8;
    }

    .pulse-icon {
      font-size: 3rem;
      animation: pulse 1.5s infinite;
      margin-bottom: 1rem;
    }

    @keyframes pulse {
      0% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.1); opacity: 0.7; }
      100% { transform: scale(1); opacity: 1; }
    }

    .btn-check {
      margin-top: 1.5rem;
      padding: 0.6rem 1.4rem;
      border-radius: 50px;
      border: none;
      background-color: #38bdf8;
      color: #0f172a;
      font-weight: 600;
      width: 100%;
      transition: all 0.3s ease;
    }

    .btn-check:hover {
      background-color: #0ea5e9;
      color: white;
    }

    p {
      font-size: 0.95rem;
    }

    .alert-info {
      margin-top: 1rem;
    }
    .btn-cek-status {
  margin-top: 1.5rem;
  padding: 0.6rem 1.4rem;
  border-radius: 50px;
  border: none;
  background-color: #38bdf8;
  color: #0f172a;
  font-weight: 600;
  width: 100%;
  transition: all 0.3s ease;
}

.btn-cek-status:hover {
  background-color: #0ea5e9;
  color: white;
}
  </style>
</head>
<body>
  <div class="card-wait">
    <div class="pulse-icon">⏳</div>
    <h4>Menunggu Persetujuan</h4>
    <p>Akun kamu sedang diproses. Harap tunggu persetujuan dari ketua organisasi.</p>

    <?php if (isset($message)) : ?>
      <div class="alert alert-info" role="alert">
        <?= htmlspecialchars($message); ?>
      </div>
    <?php endif; ?>

    <form method="post">
      <button type="submit" class="btn-cek-status">🔄 Cek Status</button>
    </form>
  </div>
</body>
</html>

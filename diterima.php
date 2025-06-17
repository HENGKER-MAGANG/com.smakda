<?php
$username = $_GET['username'] ?? '';
$username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');

// Fallback jika tidak ada username
if (!$username) {
  $username = "akun kamu";
}

// Link WhatsApp default
$wa_link = "https://chat.whatsapp.com/Cs0qsmQmPggFVReWFsOT0b"; // Ganti dengan link grup WA asli
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Selamat Bergabung</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: radial-gradient(circle, #0f2027, #203a43, #2c5364);
      color: white;
      font-family: 'Poppins', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .success-card {
      background: rgba(255, 255, 255, 0.08);
      padding: 2rem;
      border-radius: 1rem;
      text-align: center;
      max-width: 420px;
      box-shadow: 0 0 20px rgba(56, 189, 248, 0.2);
    }

    .success-card h2 {
      color: #38bdf8;
      margin-bottom: 1rem;
    }

    .btn-login, .btn-wa {
      margin-top: 1rem;
      display: block;
      width: 100%;
      padding: 0.6rem;
      border-radius: 50px;
      font-weight: bold;
      text-decoration: none;
      transition: 0.3s ease;
    }

    .btn-login {
      background: #38bdf8;
      color: #0f172a;
    }

    .btn-login:hover {
      background: #0ea5e9;
    }

    .btn-wa {
      background: #25D366;
      color: white;
    }

    .btn-wa:hover {
      background: #1ebe5c;
    }
  </style>
</head>
<body>

<div class="success-card">
  <h2>🎉 Selamat, <?= $username ?>!</h2>
  <p>Akun kamu telah <strong>disetujui</strong>.<br>Silakan login dan gabung ke grup WhatsApp resmi organisasi.</p>
  <a href="login.php" class="btn-login">🔐 Login Sekarang</a>
  <a href="<?= $wa_link ?>" class="btn-wa" target="_blank">💬 Gabung Grup WhatsApp</a>
</div>

</body>
</html>

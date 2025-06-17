<?php
session_start();
require 'config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $passwordInput = $_POST['password'];

    if (strlen($username) < 3 || strlen($passwordInput) < 4) {
        $error = 'Username atau password terlalu pendek!';
    } else {
        $cek = $db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $cek->execute([$username]);

        if ($cek->fetchColumn() > 0) {
            $error = 'Username sudah digunakan!';
        } else {
            $password = password_hash($passwordInput, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (username, password, role, status) VALUES (?, ?, 'anggota', 'menunggu')");
            $stmt->execute([$username, $password]);

            $_SESSION['pending_user'] = $username;
            header("Location: waiting.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registrasi - COM SMKN 2 Pinrang</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      font-family: 'Fira Code', monospace;
      background: radial-gradient(circle at top, #0f172a, #1e293b);
      overflow-x: hidden;
      animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .neon-input:focus {
      box-shadow: 0 0 8px #38bdf8, 0 0 16px #38bdf8;
      transition: 0.3s ease;
    }

    .neon-btn {
      background-color: #38bdf8;
      color: #0f172a;
      transition: 0.4s ease;
    }

    .neon-btn:hover {
      background-color: #0ea5e9;
      box-shadow: 0 0 10px #38bdf8, 0 0 20px #38bdf8;
      transform: translateY(-2px) scale(1.03);
    }

    .terminal-card {
      background: rgba(15, 23, 42, 0.92);
      border: 1px solid #334155;
      box-shadow: 0 0 25px rgba(56, 189, 248, 0.2);
      animation: fadeInCard 0.9s ease;
    }

    @keyframes fadeInCard {
      0% { opacity: 0; transform: scale(0.95); }
      100% { opacity: 1; transform: scale(1); }
    }

    .back-link:hover {
      color: #0ea5e9;
      text-decoration: underline;
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4 text-white">

  <!-- Tombol kembali -->
  <div class="absolute top-6 left-6">
    <a href="index.php" class="text-cyan-400 transition duration-300 back-link">
      ← Kembali ke Beranda
    </a>
  </div>

  <!-- Form Registrasi -->
  <div class="w-full max-w-md p-8 rounded-xl terminal-card">
    <h2 class="text-2xl font-bold text-cyan-400 text-center mb-6 animate-pulse">📝 Registrasi Akun</h2>

    <form method="POST" class="space-y-5 relative" autocomplete="off">
      <div>
        <label for="username" class="block text-sm text-gray-300 mb-1">> Username</label>
        <input type="text" id="username" name="username" required autofocus
               class="w-full px-4 py-2 rounded-md bg-gray-800 text-white border border-gray-600 focus:outline-none neon-input">
      </div>

      <div class="relative">
        <label for="password" class="block text-sm text-gray-300 mb-1">> Password</label>
        <div class="flex items-center relative">
          <input type="password" id="password" name="password" required
                class="w-full px-4 py-2 pr-10 rounded-md bg-gray-800 text-white border border-gray-600 focus:outline-none neon-input">
          <span onclick="togglePassword()" id="toggleIcon"
                class="absolute right-3 text-cyan-400 cursor-pointer text-lg flex items-center h-full">👁️</span>
        </div>
      </div>

      <button type="submit"
              class="w-full py-2 rounded-md font-semibold neon-btn text-center text-sm">
        > Daftar Sekarang
      </button>
    </form>

    <div class="mt-6 text-xs text-gray-500 text-center">
      Sudah punya akun? <a href="login.php" class="text-cyan-400 hover:underline">Login di sini</a><br>
      &copy; <?= date("Y") ?> Community Programmer - SMKN 2 Pinrang
    </div>
  </div>

  <script>
    function togglePassword() {
      const passInput = document.getElementById('password');
      const icon = document.getElementById('toggleIcon');
      if (passInput.type === 'password') {
        passInput.type = 'text';
        icon.textContent = '🙈';
      } else {
        passInput.type = 'password';
        icon.textContent = '👁️';
      }
    }

    // SweetAlert error
    <?php if ($error): ?>
    Swal.fire({
      icon: 'error',
      title: 'Registrasi Gagal',
      text: '<?= htmlspecialchars($error) ?>',
      confirmButtonColor: '#38bdf8'
    });
    <?php endif; ?>
  </script>
</body>
</html>

<?php
session_start();
require_once 'config/db.php';

if (isset($_SESSION['user']['role'])) {
    header('Location: dashboard/' . $_SESSION['user']['role']);
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $stmt = $db->prepare('SELECT * FROM users WHERE username = :u LIMIT 1');
        $stmt->execute(['u' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id'       => $user['id'],
                'username' => $user['username'],
                'role'     => $user['role']
            ];
            header('Location: dashboard/' . $user['role']);
            exit;
        }
        $error = 'Username atau password salah!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - COM SMKN 2 Pinrang</title>

  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">

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

  <!-- Form Login -->
<div class="w-full max-w-md p-6 sm:p-8 rounded-xl terminal-card shadow-lg">
  <h2 class="text-2xl font-bold text-cyan-400 text-center mb-6 animate-pulse">👨‍💻 Login Sistem</h2>

  <form method="POST" class="space-y-5">
    <?php if ($error): ?>
      <div class="bg-red-600 text-white px-4 py-2 rounded-md text-sm border-l-4 border-red-400">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

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
      > Masuk Sistem
    </button>
  </form>

  <!-- Link Daftar -->
  <div class="mt-4 text-center text-sm text-gray-400">
    Belum punya akun? <a href="register.php" class="text-cyan-400 hover:underline">Daftar sekarang</a>
  </div>

  <div class="mt-6 text-xs text-gray-500 text-center">
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
  </script>
</body>
</html>

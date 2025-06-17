<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard <?= ucfirst($role) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Fira Code', monospace;
      background: radial-gradient(circle at top, #0f172a, #1e293b);
    }
    .neon-card {
      background: rgba(15, 23, 42, 0.9);
      border: 1px solid #334155;
      box-shadow: 0 0 12px rgba(34, 197, 94, 0.3);
      transition: all 0.3s ease;
    }
    .neon-card:hover {
      box-shadow: 0 0 10px #22c55e, 0 0 20px #22c55e;
      transform: scale(1.03);
    }
  </style>
</head>
<body class="text-white min-h-screen">

  <div class="p-6">
    <!-- Header -->
    <div class="text-center my-8">
      <h1 class="text-3xl font-bold text-green-400 animate-pulse">👋 Hai, <?= $welcomeName ?></h1>
      <p class="text-gray-400 mt-2">Selamat datang di Dashboard <?= $role ?> <strong>Community Programmer</strong>.</p>
    </div>

    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto mt-6">
      <?php foreach ($cards as $card): ?>
        <a href="<?= htmlspecialchars($card['href']) ?>" class="neon-card p-6 rounded-xl text-center hover:scale-105">
          <h2 class="text-xl font-semibold text-green-300"><?= htmlspecialchars($card['title']) ?></h2>
          <p class="text-sm text-gray-400 mt-2">> Klik untuk mengelola</p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>

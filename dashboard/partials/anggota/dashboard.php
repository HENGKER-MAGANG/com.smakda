<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard <?= ucfirst($role) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- TailwindCSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Fira Code', monospace;
      background: radial-gradient(circle at top, #0a0f2c, #111827);
    }

    .neon-card {
      background: rgba(10, 15, 35, 0.95);
      border: 1px solid #3b82f6; /* border biru */
      box-shadow: 0 0 12px rgba(59, 130, 246, 0.3); /* shadow biru */
      transition: all 0.3s ease;
    }

    .neon-card:hover {
      box-shadow: 0 0 10px #3b82f6, 0 0 20px #3b82f6;
      transform: scale(1.03);
    }

    .text-title {
      color: #3b82f6; /* biru */
    }
  </style>
</head>

<body class="text-white min-h-screen">

  <div class="p-6">
    <!-- Header -->
    <div class="text-center my-8">
      <h1 class="text-3xl font-bold text-blue-400 animate-pulse">👋 Hai, <?= $welcomeName ?></h1>
      <p class="text-gray-300 mt-2">Selamat datang di Dashboard <?= $role ?> <strong class="text-white">Community Programmer</strong>.</p>
    </div>

    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto mt-6">
      <?php foreach ($cards as $card): ?>
        <a href="<?= htmlspecialchars($card['href']) ?>" class="neon-card p-6 rounded-xl text-center hover:scale-105">
          <h2 class="text-xl font-semibold text-blue-300"><?= htmlspecialchars($card['title']) ?></h2>
          <p class="text-sm text-gray-400 mt-2">> Klik untuk mengelola</p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>

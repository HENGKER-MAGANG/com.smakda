<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Registrasi Ditolak</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap');

    body {
      background: linear-gradient(to right, #ef4444, #b91c1c);
      color: white;
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
    }

    .card-reject {
      background: rgba(255, 255, 255, 0.1);
      padding: 2rem;
      border-radius: 1rem;
      max-width: 400px;
      width: 90%;
      text-align: center;
      box-shadow: 0 0 25px rgba(239, 68, 68, 0.4);
    }

    .card-reject h2 {
      font-weight: 600;
      color: #f87171;
    }

    .emoji {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    .btn-back {
      margin-top: 1.5rem;
      padding: 0.6rem 1.4rem;
      border-radius: 50px;
      border: none;
      background-color: white;
      color: #b91c1c;
      font-weight: 600;
      width: 100%;
      transition: all 0.3s ease;
    }

    .btn-back:hover {
      background-color: #fca5a5;
      color: white;
    }

    p {
      font-size: 0.95rem;
    }
  </style>
</head>
<body>
  <div class="card-reject">
    <div class="emoji">❌</div>
    <h2>Registrasi Ditolak</h2>
    <p>Mohon maaf, akun kamu tidak disetujui oleh ketua organisasi.</p>
    <a href="register.php" class="btn-back">⬅ Kembali ke Pendaftaran</a>
  </div>
</body>
</html>

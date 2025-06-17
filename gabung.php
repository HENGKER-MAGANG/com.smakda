<?php
session_start();
require 'config/db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $_POST['nama'];

    // Insert user dengan role 'pending'
    $stmt = $db->prepare("INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, 'pending')");
    $stmt->execute([$username, $password, $nama]);

    // Kirim WA ke ketua via link API (WhatsApp API Web)
    $nomorKetua = '6281234567890'; // tanpa tanda '+', Indonesia format
    $pesan = urlencode("Ada permintaan bergabung dari $nama (username: $username). Cek dashboard COM untuk approve/reject.");

    // Redirect ke WA API link
    $waLink = "https://api.whatsapp.com/send?phone=$nomorKetua&text=$pesan";

    // Redirect ke halaman menunggu persetujuan
    $_SESSION['pending_user'] = $username; // simpan session username

    header("Location: waiting.php");
    exit;
}
?>

<style>
  /* Global body style */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: #121212; /* dark mode */
  color: #e0e0e0;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

/* Container utama buat form dan message */
.container {
  background: #1f1f1f;
  padding: 2.5rem 3rem;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.7);
  max-width: 420px;
  width: 90%;
  text-align: center;
}

/* Judul */
h1 {
  font-weight: 700;
  font-size: 2rem;
  margin-bottom: 1.5rem;
  color: #bb86fc;
}

/* Input form */
input[type="text"],
input[type="password"],
select {
  width: 100%;
  padding: 0.7rem 1rem;
  margin-bottom: 1.25rem;
  border-radius: 8px;
  border: none;
  font-size: 1rem;
  background: #2a2a2a;
  color: #e0e0e0;
  box-sizing: border-box;
  transition: background-color 0.3s ease;
}
input[type="text"]:focus,
input[type="password"]:focus,
select:focus {
  outline: none;
  background-color: #3a3a3a;
}

/* Button */
button {
  width: 100%;
  padding: 0.8rem 1rem;
  background-color: #bb86fc;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  font-size: 1.1rem;
  color: #121212;
  cursor: pointer;
  transition: background-color 0.25s ease;
  box-shadow: 0 4px 15px rgba(187, 134, 252, 0.5);
}
button:hover {
  background-color: #985eff;
}

/* Pesan feedback di halaman waiting */
.message {
  font-size: 1.2rem;
  margin-top: 1.25rem;
  color: #cf6679; /* merah lembut buat error */
}

.message.success {
  color: #03dac6; /* hijau buat success */
}

/* Link kecil */
.back-link {
  display: inline-block;
  margin-top: 1.5rem;
  font-size: 0.9rem;
  color: #bbb;
  text-decoration: none;
  transition: color 0.2s ease;
}
.back-link:hover {
  color: #bb86fc;
}

</style>

<!-- FORM REGISTER HTML -->
<form method="post" action="">
  <input type="text" name="username" placeholder="Nama Lengkap" required />
  <input type="text" name="nisn" placeholder="Nisn" required />
  <input type="password" name="password" placeholder="Password" required />
  <button type="submit">Register</button>
</form>

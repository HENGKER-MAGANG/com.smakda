<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Community Programmer - SMKN 2 Pinrang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      max-width: 100%;
      overflow-x: hidden;
      font-family: 'Fira Code', monospace;
      background-color: #0d1117;
      color: #c9d1d9;
    }

    .navbar {
      background-color: #161b22;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.6rem;
      color: #58a6ff;
    }

    .navbar-brand i {
      color: #0dcaf0;
      animation: spin 3s linear infinite;
    }

    .nav-link {
      color: #8b949e;
      font-weight: 500;
      transition: 0.3s;
    }

    .nav-link:hover,
    .nav-link.active {
      color: #ffffff;
      transform: scale(1.1);
    }

    .hero {
      padding: 140px 20px 80px;
      text-align: center;
      word-wrap: break-word;
      word-break: break-word;
    }

    .hero h1 {
      font-size: 2.5rem;
      color: #58a6ff;
      word-break: break-word;
      white-space: normal;
    }

    .hero p {
      color: #8b949e;
    }

    .btn-outline-info {
      border-color: #58a6ff;
      color: #58a6ff;
    }

    .btn-outline-info:hover {
      background-color: #58a6ff;
      color: #0d1117;
    }

    footer {
      background-color: #010409;
      color: #8b949e;
      font-size: 0.9rem;
      padding: 20px 0;
      text-align: center;
    }

    /* Tambahan: Responsif mobile */
    @media (max-width: 576px) {
      .hero h1 {
        font-size: 1.8rem;
      }

      .hero p.lead {
        font-size: 1rem;
      }

      .hero {
        padding: 100px 16px 60px;
      }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>

</head>
<body style="padding-top: 70px;">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow w-100">
  <div class="container-fluid px-3">
    <a class="navbar-brand" href="#">
      <i class="fas fa-code"></i> COM SMAKDA
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav text-center text-lg-start">
        <li class="nav-item">
          <a class="nav-link" href="#beranda"><i class="fas fa-home me-1"></i>Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#kenapa"><i class="fas fa-question-circle me-1"></i>Kenapa Gabung?</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#visi-misi"><i class="fas fa-bullseye me-1"></i>Visi & Misi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#projek"><i class="fas fa-project-diagram me-1"></i>Projek</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#dokumentasi"><i class="fas fa-images me-1"></i>Dokumentasi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#kontak"><i class="fas fa-envelope me-1"></i>Kontak</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero -->
<section id="beranda" class="hero min-vh-100 d-flex align-items-center bg-dark text-light" data-aos="fade-up">
  <div class="container text-center">
    <h1 class="display-4 fw-bold text-info mb-3">
      <span id="typed"></span>
    </h1>

    <p class="lead fs-4 text-light-emphasis" style="animation: fadeInUp 1.2s ease-in-out both; max-width: 600px; margin: 0 auto;">
      Satu komunitas, sejuta solusi digital.
    </p>

    <div class="mt-5">
      <a href="#kenapa" class="btn btn-outline-info btn-lg shadow-sm">Pelajari Lebih Lanjut</a>
    </div>
  </div>
</section>




  <!-- Section Kenapa -->
  <section id="kenapa" class="py-5 bg-dark text-light">
  <div class="container">
    <!-- Judul -->
    <h2 class="section-title text-center mb-3" data-aos="fade-down" data-aos-duration="800">
      Kenapa Harus Gabung?
    </h2>
    <!-- Deskripsi -->
    <p class="lead text-center mb-5" data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
      Karena masa depan teknologi dimulai dari sini. COM SMAKDA bukan hanya komunitas, tapi tempat bertumbuh bersama sebagai developer muda berbakat!
    </p>

    <!-- Kartu-kartu -->
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-right" data-aos-delay="200">
        <div class="project-card h-100 text-center p-4 rounded-3 border border-secondary shadow-sm">
          <i class="fas fa-laptop-code fa-3x text-info mb-3"></i>
          <h5 class="fw-bold">Belajar Langsung dari Praktisi</h5>
          <p>Kami menghadirkan pembelajaran berbasis proyek dan mentor yang berpengalaman di dunia IT nyata.</p>
        </div>
      </div>

      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="project-card h-100 text-center p-4 rounded-3 border border-secondary shadow-sm">
          <i class="fas fa-users fa-3x text-info mb-3"></i>
          <h5 class="fw-bold">Jaringan dan Kolaborasi</h5>
          <p>Temukan teman seperjuangan, bentuk tim, dan bangun project bareng. Kolaborasi adalah kunci sukses!</p>
        </div>
      </div>

      <div class="col-md-4" data-aos="fade-left" data-aos-delay="400">
        <div class="project-card h-100 text-center p-4 rounded-3 border border-secondary shadow-sm">
          <i class="fas fa-rocket fa-3x text-info mb-3"></i>
          <h5 class="fw-bold">Tingkatkan Skill & Portofolio</h5>
          <p>Bangun portofolio nyata dari project dan kegiatan kami, bekal untuk melanjutkan karier profesional kamu.</p>
        </div>
      </div>
    </div>

    <!-- Tombol -->
    <div class="text-center mt-5" data-aos="zoom-in" data-aos-delay="500">
      <a href="#kontak" class="btn btn-outline-info btn-lg">Ayo Gabung Sekarang</a>
    </div>
  </div>
</section>

  <!-- Section Visi Misi -->
<section id="visi-misi" class="py-5 bg-dark text-light">
    <div class="container">
      <h2 class="section-title text-center">Visi & Misi</h2>
      <div class="row">
        <div class="col-md-6 mb-4" data-aos="fade-right">
          <h5 class="text-info">Visi</h5>
          <p class="fst-italic">Menjadi komunitas unggulan yang mendorong siswa untuk berkembang sebagai programmer kreatif, kolaboratif, dan inovatif yang siap menghadapi tantangan digital masa depan.</p>
        </div>
        <div class="col-md-6" data-aos="fade-left">
          <h5 class="text-info">Misi</h5>
          <ul class="list-unstyled">
            <li class="mb-2"><i class="fas fa-code text-info me-2"></i>Memberikan pelatihan rutin di bidang pemrograman, desain, dan teknologi terkini.</li>
            <li class="mb-2"><i class="fas fa-users text-info me-2"></i>Membangun budaya kolaborasi dan kerja tim antaranggota dalam setiap proyek digital.</li>
            <li class="mb-2"><i class="fas fa-lightbulb text-info me-2"></i>Mendorong kreativitas dan inovasi dalam menciptakan solusi berbasis teknologi.</li>
            <li class="mb-2"><i class="fas fa-rocket text-info me-2"></i>Menyiapkan anggota untuk kompetisi, proyek nyata, dan dunia kerja teknologi.</li>
            <li class="mb-2"><i class="fas fa-folder-open text-info me-2"></i>Membangun portofolio dan dokumentasi digital setiap anggota secara profesional.</li>
          </ul>
        </div>
      </div>
    </div>
  </section>


  <!-- Section Projek -->
  <section id="projek" class="py-5 bg-dark text-white">
  <div class="container">
    <!-- Judul dengan animasi fade-down -->
    <h2 class="section-title text-center mb-5" data-aos="fade-down" data-aos-duration="1000">
      Projek Kami
    </h2>
    
    <div class="row g-4">
      <!-- Card 1 -->
      <div class="col-md-4" data-aos="fade-right" data-aos-delay="100" data-aos-duration="800">
        <div class="project-card p-4 bg-dark border border-secondary rounded-3 shadow-sm h-100">
          <h5 class="text-info">Panic Bully</h5>
          <p class="mb-0">Aplikasi pelaporan bullying realtime.</p>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200" data-aos-duration="800">
        <div class="project-card p-4 bg-dark border border-secondary rounded-3 shadow-sm h-100">
          <h5 class="text-info">Sistem Absensi</h5>
          <p class="mb-0">Absensi dan kas dengan manajemen role lengkap.</p>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-md-4" data-aos="fade-left" data-aos-delay="300" data-aos-duration="800">
        <div class="project-card p-4 bg-dark border border-secondary rounded-3 shadow-sm h-100">
          <h5 class="text-info">Buku Tamu Digital</h5>
          <p class="mb-0">Pencatatan kunjungan dengan dashboard realtime.</p>
        </div>
      </div>
    </div>
  </div>
</section>


  <!-- Section Dokumentasi -->
<section id="dokumentasi" class="py-5 bg-dark">
  <div class="container" data-aos="fade-up" data-aos-duration="1000">
    <h2 class="section-title text-center text-white mb-4" data-aos="fade-down" data-aos-delay="100">
      Dokumentasi Kegiatan
    </h2>
    <div class="row g-4">

      <!-- Kegiatan 1 - Muncul dari KIRI -->
      <div class="col-md-4" data-aos="fade-right" data-aos-delay="200">
        <div class="card bg-dark border-secondary text-light h-100 shadow rounded-3" style="transition: transform 0.4s ease;">
          <img src="patriot.JPG" class="card-img-top rounded-top" alt="Kegiatan 1" style="height: 250px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title text-info">Pelatihan Penerapan IoT</h5>
            <p class="card-text">
              Pelatihan dasar Internet of Things (IoT) untuk remaja SMKN 2 Pinrang dengan materi pembuatan kontrol lampu menggunakan mikrokontroler ESP32.
              Peserta belajar mengendalikan lampu melalui koneksi internet menggunakan ESP32, serta memahami konsep dasar pemrograman dan integrasi perangkat IoT.
            </p>
            <p class="text-muted small">Tanggal: 14-15 Nov 2024</p>
          </div>
        </div>
      </div>

      <!-- Kegiatan 2 - Muncul dari BAWAH -->
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card bg-dark border-secondary text-light h-100 shadow rounded-3" style="transition: transform 0.4s ease;">
          <img src="petir.jpg" class="card-img-top rounded-top" alt="Kegiatan 2" style="height: 250px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title text-info">Pelatihan IoT Remaja</h5>
            <p class="card-text">
              COM SMAKDA menyelenggarakan pelatihan IoT untuk beberapa SMP di Pinrang dengan proyek pembuatan smart home sederhana.
              Peserta belajar mengontrol perangkat seperti lampu dan kipas melalui internet menggunakan mikrokontroler ESP32.
              Pelatihan ini bertujuan mengenalkan konsep rumah pintar dan membangun dasar keterampilan teknologi sejak usia dini.
            </p>
            <p class="text-muted small">Tanggal: 5 Mei 2025</p>
          </div>
        </div>
      </div>

      <!-- Kegiatan 3 - Muncul dari KANAN -->
      <div class="col-md-4" data-aos="fade-left" data-aos-delay="400">
        <div class="card bg-dark border-secondary text-light h-100 shadow rounded-3" style="transition: transform 0.4s ease;">
          <img src="pertemuan.jpg" class="card-img-top rounded-top" alt="Kegiatan 3" style="height: 250px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title text-info">Pertemuan Rutin</h5>
            <p class="card-text">
              COM SMAKDA mengadakan pertemuan rutin setiap hari Rabu dan Jumat sebagai wadah belajar dan diskusi bagi anggota.
              Kegiatan ini mencakup pelatihan teknologi, pengembangan proyek, serta sharing ilmu seputar dunia pemrograman dan IT.
              Tujuannya adalah membangun budaya belajar aktif dan kolaboratif di lingkungan organisasi.
            </p>
            <p class="text-muted small">Setiap Hari Rabu dan Jumat</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<section id="kontak" class="py-5 bg-dark text-light">
  <div class="container">
    <h2 class="section-title text-center mb-5">Kontak Kami</h2>
    <div class="row g-4 align-items-stretch">

      <!-- Formulir Kontak -->
      <div class="col-lg-6" data-aos="fade-right">
        <div class="bg-dark text-white p-4 rounded shadow-sm border border-secondary h-100">
          <h5 class="mb-4"><i class="fas fa-paper-plane text-info me-2"></i> Kirim Pesan ke Admin</h5>
          <form id="formWa">
            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" id="nama" placeholder="Nama lengkap" required />
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" placeholder="Alamat email aktif" required />
            </div>
            <div class="mb-3">
              <label for="pesan" class="form-label">Pesan</label>
              <textarea class="form-control" id="pesan" placeholder="Tulis pesan kamu..." rows="5" required></textarea>
            </div>
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-outline-info btn-lg">
                <i class="fab fa-whatsapp me-2"></i> Kirim via WhatsApp
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Google Maps -->
      <div class="col-lg-6" data-aos="fade-left">
        <div class="rounded shadow-sm border border-secondary h-100 overflow-hidden">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3981.0883490593524!2d119.63751597352251!3d-3.790938143490454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d944d2155555555%3A0x2ad3ed495d4368e9!2sSMKN%20Negeri%202%20Pinrang!5e0!3m2!1sen!2sid!4v1749910295189!5m2!1sen!2sid"
            width="100%" height="100%" style="border:0; min-height: 420px;" allowfullscreen=""
            loading="lazy" referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>

    </div>
  </div>
</section>

  <!-- Footer -->
  <footer class="text-center" data-aos="fade-up" data-aos-offset="0">
    <div class="container">
      <p>&copy; 2025 Community Programmer - SMKN 2 Pinrang</p>
      <div>
        <a href="#" class="text-info me-2"><i class="fab fa-instagram"></i></a>
        <a href="#" class="text-info"><i class="fab fa-github"></i></a>
      </div>
    </div>
  </footer>

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    AOS.init({
  duration: 800, // durasi animasi
  once: true     // animasi hanya muncul sekali saat scroll ke bawah
});
    document.addEventListener("DOMContentLoaded", function () {
    new Typed("#typed", {
  strings: [
    "Selamat Datang di COM SMAKDA!",
    "Mari Coding & Berkreasi!",
    "Bergabunglah bersama Developer Masa Depan!"
  ],
  typeSpeed: 60,        // Jangan terlalu cepat
  backSpeed: 40,        // Hapus juga smooth
  backDelay: 2000,      // Kasih waktu sebelum hapus
  startDelay: 500,      // Delay sebelum animasi mulai
  loop: true,
  showCursor: true,
  cursorChar: '|',
  smartBackspace: true
});

  });

    const formWa = document.getElementById("formWa");
    formWa.addEventListener("submit", function (e) {
      e.preventDefault();
      const nama = document.getElementById("nama").value.trim();
      const email = document.getElementById("email").value.trim();
      const pesan = document.getElementById("pesan").value.trim();
      const noWa = "6288245014492";
      const url = `https://wa.me/${noWa}?text=Halo, saya *${nama}* (${email}) ingin menghubungi:%0A${pesan}`;
      window.open(url, "_blank");
      formWa.reset();
      Swal.fire({
        icon: 'success',
        title: 'Pesan terkirim!',
        text: 'Kami akan segera menghubungi kamu.',
        confirmButtonColor: '#3085d6'
      });
    });
  </script>
</body>
</html>

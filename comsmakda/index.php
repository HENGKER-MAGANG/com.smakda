<?php
session_start();
if (isset($_SESSION['role'])) {
    header("Location: dashboard/" . $_SESSION['role'] . ".php");
    exit;
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<section class="hero-section d-flex align-items-center justify-content-center text-center py-5">
    <div class="container">
        <h1 class="display-5 fw-bold">Selamat Datang di <span class="text-primary">ComSMAKDA</span></h1>
        <p class="lead mt-3">
            ComSMAKDA (Computer Club SMAKDA) adalah sistem informasi manajemen organisasi siswa di SMA Kristen Dian Harapan.
            Platform ini dibuat untuk memudahkan pengelolaan kegiatan, keuangan, dan keanggotaan organisasi.
        </p>
        <a href="auth/login.php" class="btn btn-primary btn-lg mt-4 px-4">Login Sekarang</a>
        <a href="pemesanan/tracking.php" class="btn btn-outline-secondary btn-lg mt-4 px-4 ms-2">Lihat Jasa Kami</a>
    </div>
</section>

<section class="container text-center my-5">
    <h2 class="mb-4">Fitur untuk Publik</h2>
    <div class="row justify-content-center">
        <div class="col-md-3 mb-3">
            <a href="portofolio/" class="btn btn-outline-dark w-100">Portofolio</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="pemesanan/pesan.php" class="btn btn-outline-dark w-100">Pemesanan Jasa</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="dokumentasi/index.php" class="btn btn-outline-dark w-100">Dokumentasi</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="komentar/komentar.php" class="btn btn-outline-dark w-100">Komentar & Like</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

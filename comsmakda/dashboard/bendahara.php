<?php
include '../includes/auth.php';
checkRole(['bendahara']);
include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">
    <h3>Dashboard Bendahara</h3>
    <p>Menu: <a href="/comsmakda/kas/input.php" class="btn btn-primary">Input Kas</a> 
             <a href="/comsmakda/kas/riwayat.php" class="btn btn-secondary">Riwayat Kas</a></p>
</div>

<?php include '../includes/footer.php'; ?>

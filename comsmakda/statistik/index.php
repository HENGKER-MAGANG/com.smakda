<?php
session_start();
require_once '../config/db.php';
include '../includes/cek_login.php';
include '../includes/header.php';
include '../includes/navbar.php';

// ===== Query Statistik =====

// Jumlah anggota per role
$roleData = $conn->query("SELECT role, COUNT(*) as jumlah FROM users GROUP BY role");

// Jumlah kas per bulan (tahun ini)
$kasData = $conn->query("
    SELECT MONTH(tanggal) as bulan, SUM(jumlah) as total 
    FROM kas 
    WHERE YEAR(tanggal) = YEAR(CURDATE())
    GROUP BY MONTH(tanggal)
");

// Jumlah kegiatan per bulan
$kegiatanData = $conn->query("
    SELECT MONTH(tanggal) as bulan, COUNT(*) as total 
    FROM kegiatan 
    WHERE YEAR(tanggal) = YEAR(CURDATE())
    GROUP BY MONTH(tanggal)
");

// Siapkan array untuk Chart.js
$roleLabels = $roleJumlah = [];
while ($row = $roleData->fetch_assoc()) {
    $roleLabels[] = $row['role'];
    $roleJumlah[] = $row['jumlah'];
}

$bulanNama = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
$kasBulanan = array_fill(1, 12, 0);
while ($row = $kasData->fetch_assoc()) {
    $kasBulanan[(int)$row['bulan']] = $row['total'];
}

$kegiatanBulanan = array_fill(1, 12, 0);
while ($row = $kegiatanData->fetch_assoc()) {
    $kegiatanBulanan[(int)$row['bulan']] = $row['total'];
}
?>

<div class="container mt-4">
    <h3 class="mb-4">Statistik Organisasi</h3>

    <div class="row">
        <div class="col-md-6 mb-4">
            <canvas id="chartAnggota"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="chartKas"></canvas>
        </div>
        <div class="col-md-12">
            <canvas id="chartKegiatan"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Anggota per role
const ctx1 = document.getElementById('chartAnggota').getContext('2d');
new Chart(ctx1, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($roleLabels) ?>,
        datasets: [{
            label: 'Jumlah Anggota',
            data: <?= json_encode($roleJumlah) ?>,
            backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545']
        }]
    }
});

// Kas masuk bulanan
const ctx2 = document.getElementById('chartKas').getContext('2d');
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: <?= json_encode($bulanNama) ?>,
        datasets: [{
            label: 'Total Kas Masuk',
            data: <?= json_encode(array_values($kasBulanan)) ?>,
            backgroundColor: '#0d6efd'
        }]
    }
});

// Kegiatan bulanan
const ctx3 = document.getElementById('chartKegiatan').getContext('2d');
new Chart(ctx3, {
    type: 'line',
    data: {
        labels: <?= json_encode($bulanNama) ?>,
        datasets: [{
            label: 'Jumlah Kegiatan',
            data: <?= json_encode(array_values($kegiatanBulanan)) ?>,
            borderColor: '#198754',
            backgroundColor: 'rgba(25, 135, 84, 0.2)',
            fill: true,
            tension: 0.3
        }]
    }
});
</script>

<?php include '../includes/footer.php'; ?>

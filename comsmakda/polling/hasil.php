<?php
require_once '../config/db.php';

$voting = $conn->query("SELECT * FROM voting ORDER BY tanggal_buat DESC LIMIT 1")->fetch_assoc();
$labels = json_decode($voting['pilihan'], true);
$data = json_decode($voting['hasil'], true);

$chart_labels = json_encode(array_values($labels));
$chart_data = json_encode(array_values($data));
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">
    <h3>Hasil Voting: <?= htmlspecialchars($voting['topik']) ?></h3>
    <canvas id="voteChart" width="400" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('voteChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= $chart_labels ?>,
            datasets: [{
                label: 'Jumlah Suara',
                data: <?= $chart_data ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

<?php include '../includes/footer.php'; ?>

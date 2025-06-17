<?php
session_start();
require_once '../config/db.php';
include '../includes/header.php';
include '../includes/navbar.php';

$result = $conn->query("
    SELECT l.*, u.nama 
    FROM log_aktivitas l 
    JOIN users u ON l.user_id = u.id 
    ORDER BY l.waktu DESC
");
?>

<div class="container mt-4">
    <h3>Log Aktivitas User</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['aktivitas']) ?></td>
                    <td><?= $row['waktu'] ?></td>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

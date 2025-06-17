<?php
session_start();
require_once '../config/db.php';
include '../includes/cek_login.php';
include '../includes/header.php';
include '../includes/navbar.php';

// Ambil data kegiatan dari database
$result = $conn->query("SELECT id, judul, tanggal FROM kegiatan");
$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['judul'],
        'start' => $row['tanggal'],
        'url' => 'detail.php?id=' . $row['id']
    ];
}
?>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

<div class="container mt-4">
    <h3 class="mb-4">Kalender Kegiatan</h3>
    <div id="calendar"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listWeek'
        },
        events: <?= json_encode($events) ?>,
        eventClick: function(info) {
            info.jsEvent.preventDefault(); // don't let browser open url
            if (info.event.url) {
                window.location.href = info.event.url;
            }
        }
    });
    calendar.render();
});
</script>

<?php include '../includes/footer.php'; ?>

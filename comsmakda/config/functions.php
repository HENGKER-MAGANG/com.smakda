<?php
function log_aktivitas($conn, $user_id, $aktivitas) {
    $stmt = $conn->prepare("INSERT INTO log_aktivitas (user_id, aktivitas) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $aktivitas);
    $stmt->execute();
    $stmt->close();
}

<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: /comsmakda/auth/login.php");
    exit;
}

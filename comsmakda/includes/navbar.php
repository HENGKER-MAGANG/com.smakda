<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/comsmakda/index.php">ComSMAKDA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <?php if (isset($_SESSION['user_id'])): ?>
                <ul class="navbar-nav ms-auto">

                    <!-- Notifikasi -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            🔔 Notifikasi <span class="badge bg-danger" id="notif-count">0</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" id="notif-list">
                            <li><span class="dropdown-item text-muted">Memuat...</span></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="/comsmakda/profil/user.php">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="/comsmakda/auth/logout.php">Logout</a></li>
                </ul>
            <?php else: ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/comsmakda/auth/login.php">Login</a></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>

<?php if (isset($_SESSION['user_id'])): ?>
<script>
function fetchNotifikasi() {
    fetch('/comsmakda/notifikasi/fetch.php')
        .then(res => res.json())
        .then(data => {
            let list = document.getElementById("notif-list");
            list.innerHTML = "";

            if (data.length === 0) {
                list.innerHTML = '<li><span class="dropdown-item text-muted">Tidak ada notifikasi</span></li>';
            } else {
                data.forEach(n => {
                    let item = `<li><span class="dropdown-item small">${n.pesan}<br><small class="text-muted">${n.tanggal}</small></span></li>`;
                    list.innerHTML += item;
                });
            }

            document.getElementById("notif-count").innerText = data.length;
        });
}

setInterval(fetchNotifikasi, 5000); // setiap 5 detik
fetchNotifikasi(); // fetch awal
</script>
<?php endif; ?>

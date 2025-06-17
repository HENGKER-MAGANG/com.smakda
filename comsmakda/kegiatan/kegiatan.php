<?php
include '../includes/auth.php';
checkRole(['ketua', 'sekretaris']);
include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">
    <h3>Agenda Kegiatan</h3>
    <div id='calendar'></div>
</div>

<!-- Modal Tambah Kegiatan -->
<div class="modal fade" id="modalKegiatan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="tambah.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kegiatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="tanggal" id="tanggal">
        <div class="mb-3">
          <label>Nama Kegiatan</label>
          <input type="text" name="nama_kegiatan" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Lokasi</label>
          <input type="text" name="lokasi" class="form-control">
        </div>
        <div class="mb-3">
          <label>Deskripsi</label>
          <textarea name="deskripsi" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    selectable: true,
    locale: 'id',
    events: 'fetch.php',
    dateClick: function(info) {
      document.getElementById('tanggal').value = info.dateStr;
      var modal = new bootstrap.Modal(document.getElementById('modalKegiatan'));
      modal.show();
    }
  });
  calendar.render();
});
</script>

<?php include '../includes/footer.php'; ?>

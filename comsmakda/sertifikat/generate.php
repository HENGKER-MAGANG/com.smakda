<?php
require '../libs/fpdf/fpdf.php';
require '../config/db.php';

if (!isset($_GET['user_id']) || !isset($_GET['kegiatan_id'])) {
    die("Parameter tidak lengkap");
}

$user_id = $_GET['user_id'];
$kegiatan_id = $_GET['kegiatan_id'];

// Ambil data user & kegiatan
$stmt = $conn->prepare("
    SELECT u.nama, k.nama_kegiatan, k.tanggal 
    FROM users u 
    JOIN keikutsertaan ki ON u.id = ki.user_id 
    JOIN kegiatan k ON k.id = ki.kegiatan_id 
    WHERE u.id = ? AND k.id = ?
");
$stmt->bind_param("ii", $user_id, $kegiatan_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Data tidak ditemukan");
}

$data = $result->fetch_assoc();

// =============================
// GENERATE PDF
// =============================
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Background (opsional)
// $pdf->Image('../assets/images/sertifikat_bg.png', 0, 0, 297, 210);

$pdf->SetFont('Arial', 'B', 24);
$pdf->Cell(0, 20, 'SERTIFIKAT KEIKUTSERTAAN', 0, 1, 'C');

$pdf->SetFont('Arial', '', 16);
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Diberikan kepada:', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 15, strtoupper($data['nama']), 0, 1, 'C');

$pdf->SetFont('Arial', '', 14);
$pdf->Ln(5);
$pdf->MultiCell(0, 10, "Atas partisipasinya dalam kegiatan:\n\"{$data['nama_kegiatan']}\"\nTanggal: " . date("d F Y", strtotime($data['tanggal'])), 0, 'C');

$pdf->Ln(20);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'SMK SMAKDA Ciamis, ' . date('d-m-Y'), 0, 1, 'R');
$pdf->Cell(0, 10, 'Ketua OSIS', 0, 1, 'R');
$pdf->Ln(15);
$pdf->Cell(0, 10, '___________________', 0, 1, 'R');

$pdf->Output("I", "sertifikat_{$data['nama']}.pdf");

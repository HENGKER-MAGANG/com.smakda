<?php
require '../vendor/fpdf/fpdf.php';
include '../config/db.php';

$tgl_awal = $_GET['awal'] ?? date('Y-m-01');
$tgl_akhir = $_GET['akhir'] ?? date('Y-m-d');

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,10,'Laporan Kas Masuk',0,1,'C');

$pdf->SetFont('Arial','',10);
$pdf->Cell(190,7,"Periode: $tgl_awal s/d $tgl_akhir",0,1,'C');

$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,10,'No',1,0);
$pdf->Cell(50,10,'Nama',1,0);
$pdf->Cell(40,10,'Jumlah',1,0);
$pdf->Cell(60,10,'Keterangan',1,0);
$pdf->Cell(30,10,'Tanggal',1,1);

$pdf->SetFont('Arial','',10);

$stmt = $conn->prepare("
    SELECT u.nama, k.jumlah, k.keterangan, k.tanggal
    FROM kas k
    JOIN users u ON k.user_id = u.id
    WHERE k.tanggal BETWEEN ? AND ?
    ORDER BY k.tanggal DESC
");
$stmt->bind_param("ss", $tgl_awal, $tgl_akhir);
$stmt->execute();
$result = $stmt->get_result();
$no = 1;

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10,8,$no++,1,0);
    $pdf->Cell(50,8,$row['nama'],1,0);
    $pdf->Cell(40,8,'Rp '.number_format($row['jumlah'], 0, ',', '.'),1,0);
    $pdf->Cell(60,8,$row['keterangan'],1,0);
    $pdf->Cell(30,8,$row['tanggal'],1,1);
}

$pdf->Output();

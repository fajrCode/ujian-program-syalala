<?php
// File: laporan_pdf.php
require('fpdf/fpdf.php');
include 'koneksi.php';

$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Laporan Nilai Mahasiswa',0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10,'Nama',1);
$pdf->Cell(30,10,'NIM',1);
$pdf->Cell(20,10,'Absen',1);
$pdf->Cell(20,10,'Tugas',1);
$pdf->Cell(20,10,'UTS',1);
$pdf->Cell(20,10,'UAS',1);
$pdf->Cell(30,10,'Nilai Akhir',1);
$pdf->Cell(30,10,'Nilai Huruf',1);
$pdf->Ln();

$data = mysqli_query($koneksi, "SELECT m.nama, m.nim, n.absen, n.tugas, n.uts, n.uas, n.nilai_akhir, n.nilai_huruf FROM nilai n JOIN mahasiswa m ON n.mahasiswa_id = m.id");
$pdf->SetFont('Arial','',10);

while ($row = mysqli_fetch_assoc($data)) {
    $pdf->Cell(40,10,$row['nama'],1);
    $pdf->Cell(30,10,$row['nim'],1);
    $pdf->Cell(20,10,$row['absen'],1);
    $pdf->Cell(20,10,$row['tugas'],1);
    $pdf->Cell(20,10,$row['uts'],1);
    $pdf->Cell(20,10,$row['uas'],1);
    $pdf->Cell(30,10,number_format($row['nilai_akhir'],2),1);
    $pdf->Cell(30,10,$row['nilai_huruf'],1);
    $pdf->Ln();
}

$pdf->Output();

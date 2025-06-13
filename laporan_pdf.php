<?php
// File: laporan_pdf.php
include 'koneksi.php';

$data = mysqli_query($koneksi, "SELECT m.nama, m.nim, n.absen, n.tugas, n.uts, n.uas, n.nilai_akhir, n.nilai_huruf FROM nilai n JOIN mahasiswa m ON n.mahasiswa_id = m.id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Nilai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-white p-8">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold">Laporan Nilai Mahasiswa</h1>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">NIM</th>
                    <th class="border px-4 py-2">Absen</th>
                    <th class="border px-4 py-2">Tugas</th>
                    <th class="border px-4 py-2">UTS</th>
                    <th class="border px-4 py-2">UAS</th>
                    <th class="border px-4 py-2">Nilai Akhir</th>
                    <th class="border px-4 py-2">Nilai Huruf</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($data)) : ?>
                <tr class="text-sm">
                    <td class="border px-4 py-2"><?= $row['nama'] ?></td>
                    <td class="border px-4 py-2"><?= $row['nim'] ?></td>
                    <td class="border px-4 py-2"><?= $row['absen'] ?></td>
                    <td class="border px-4 py-2"><?= $row['tugas'] ?></td>
                    <td class="border px-4 py-2"><?= $row['uts'] ?></td>
                    <td class="border px-4 py-2"><?= $row['uas'] ?></td>
                    <td class="border px-4 py-2"><?= number_format($row['nilai_akhir'],2) ?></td>
                    <td class="border px-4 py-2"><?= $row['nilai_huruf'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-6 text-center no-print">
        <button onclick="window.print()" class="bg-blue-500 text-white px-4 py-2 rounded">Cetak</button>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Penilaian Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Dashboard Penilaian</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="mahasiswa.php" class="bg-white shadow-md rounded-lg p-4 hover:bg-gray-200">Kelola Mahasiswa</a>
            <a href="dosen_pa.php" class="bg-white shadow-md rounded-lg p-4 hover:bg-gray-200">Kelola Dosen PA</a>
            <a href="nilai.php" class="bg-white shadow-md rounded-lg p-4 hover:bg-gray-200">Input Nilai</a>
        </div>
        <div class="mt-6">
            <a href="cetak_pdf.php" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cetak Laporan PDF</a>
        </div>
    </div>
</body>
</html>

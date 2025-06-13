<?php
// File: nilai.php
include 'koneksi.php';

// Tambah Nilai
if (isset($_POST['tambah'])) {
    $mahasiswa_id = $_POST['mahasiswa_id'];
    $dosen_pa_id = $_POST['dosen_pa_id'];
    $hadir = $_POST['hadir'];
    $tugas = $_POST['tugas'];
    $uts = $_POST['uts'];
    $uas = $_POST['uas'];

    $nilai_absen = ($hadir / 16) * 100 * 0.10;
    $nilai_tugas = $tugas * 0.20;
    $nilai_uts = $uts * 0.30;
    $nilai_uas = $uas * 0.40;

    $nilai_akhir = $nilai_absen + $nilai_tugas + $nilai_uts + $nilai_uas;

    if ($nilai_akhir >= 80) $nilai_huruf = 'A';
    elseif ($nilai_akhir >= 68) $nilai_huruf = 'B';
    elseif ($nilai_akhir >= 56) $nilai_huruf = 'C';
    elseif ($nilai_akhir >= 45) $nilai_huruf = 'D';
    else $nilai_huruf = 'E';

    mysqli_query($koneksi, "INSERT INTO nilai (mahasiswa_id, dosen_pa_id, absen, tugas, uts, uas, nilai_akhir, nilai_huruf) VALUES ('$mahasiswa_id','$dosen_pa_id','$hadir','$tugas','$uts','$uas','$nilai_akhir','$nilai_huruf')");
    header('Location: nilai.php');
}

// Hapus Nilai
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM nilai WHERE id=$id");
    header('Location: nilai.php');
}

$mahasiswa = mysqli_query($koneksi, "SELECT * FROM mahasiswa");
$dosen = mysqli_query($koneksi, "SELECT * FROM dosen_pa");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nilai Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-xl font-bold mb-4">Input Nilai Mahasiswa</h2>
        <form method="post" class="bg-white p-4 rounded shadow-md">
            <select name="mahasiswa_id" class="border p-2 w-full mb-2" required>
                <option value="">Pilih Mahasiswa</option>
                <?php while($m = mysqli_fetch_assoc($mahasiswa)): ?>
                    <option value="<?= $m['id'] ?>"><?= $m['nama'] ?> (<?= $m['nim'] ?>)</option>
                <?php endwhile; ?>
            </select>
            <select name="dosen_pa_id" class="border p-2 w-full mb-2" required>
                <option value="">Pilih Dosen PA</option>
                <?php while($d = mysqli_fetch_assoc($dosen)): ?>
                    <option value="<?= $d['id'] ?>"><?= $d['nama'] ?></option>
                <?php endwhile; ?>
            </select>
            <input type="number" name="hadir" placeholder="Jumlah Hadir (0-16)" class="border p-2 w-full mb-2" required>
            <input type="number" name="tugas" placeholder="Rata-rata Tugas 1-5" class="border p-2 w-full mb-2" required>
            <input type="number" name="uts" placeholder="Nilai UTS" class="border p-2 w-full mb-2" required>
            <input type="number" name="uas" placeholder="Nilai UAS" class="border p-2 w-full mb-2" required>
            <button type="submit" name="tambah" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        </form>

        <h2 class="text-xl font-bold mt-6">Data Nilai</h2>
        <table class="table-auto w-full bg-white mt-2">
            <thead>
                <tr>
                    <th class="border px-2">Mahasiswa</th>
                    <th class="border px-2">Nilai Akhir</th>
                    <th class="border px-2">Nilai Huruf</th>
                    <th class="border px-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $data = mysqli_query($koneksi, "SELECT nilai.*, mahasiswa.nama as mhs FROM nilai JOIN mahasiswa ON nilai.mahasiswa_id = mahasiswa.id");
                while ($row = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td class="border px-2"><?= $row['mhs'] ?></td>
                        <td class="border px-2"><?= number_format($row['nilai_akhir'],2) ?></td>
                        <td class="border px-2"><?= $row['nilai_huruf'] ?></td>
                        <td class="border px-2">
                            <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin?')" class="text-red-500">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="index.php" class="text-blue-500 inline-block mt-4">Kembali ke Dashboard</a>
    </div>
</body>
</html>

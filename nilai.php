<?php
// File: nilai.php
include 'koneksi.php';

$edit_id = null;
$edit_data = null;

// Tambah Nilai
if (isset($_POST['tambah'])) {
    $mahasiswa_id = $_POST['mahasiswa_id'];
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

    mysqli_query($koneksi, "INSERT INTO nilai (mahasiswa_id, absen, tugas, uts, uas, nilai_akhir, nilai_huruf) VALUES ('$mahasiswa_id','$hadir','$tugas','$uts','$uas','$nilai_akhir','$nilai_huruf')");
    header('Location: nilai.php');
}

// Hapus Nilai
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM nilai WHERE id=$id");
    header('Location: nilai.php');
}

// Ambil data untuk Edit
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id = $edit_id");
    $edit_data = mysqli_fetch_assoc($result);
}

// Simpan Edit
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $mahasiswa_id = $_POST['mahasiswa_id'];
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

    mysqli_query($koneksi, "UPDATE nilai SET mahasiswa_id='$mahasiswa_id', absen='$hadir', tugas='$tugas', uts='$uts', uas='$uas', nilai_akhir='$nilai_akhir', nilai_huruf='$nilai_huruf' WHERE id=$id");
    header('Location: nilai.php');
}

$mahasiswa = mysqli_query($koneksi, "SELECT * FROM mahasiswa");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nilai Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- DataTables & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="p-6 bg-gray-100">
    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a class="px-2 py-1 rounded bg-blue-500 text-white" href="index.php">Kembali</a>
        </div>

        <h2 class="text-xl font-bold mb-4"><?= $edit_data ? 'Edit Nilai Mahasiswa' : 'Input Nilai Mahasiswa' ?></h2>
        <form method="post" class="bg-white p-4 rounded shadow-md">
            <?php if ($edit_data): ?>
                <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
            <?php endif; ?>
            <select name="mahasiswa_id" class="border p-2 w-full mb-2" required>
                <option value="">Pilih Mahasiswa</option>
                <?php mysqli_data_seek($mahasiswa, 0);
                while ($m = mysqli_fetch_assoc($mahasiswa)): ?>
                    <option value="<?= $m['id'] ?>" <?= ($edit_data && $edit_data['mahasiswa_id'] == $m['id']) ? 'selected' : '' ?>>
                        <?= $m['nama'] ?> (<?= $m['nim'] ?>)
                    </option>
                <?php endwhile; ?>
            </select>
            <input type="number" name="hadir" placeholder="Jumlah Hadir (0-16)" class="border p-2 w-full mb-2" required value="<?= $edit_data ? $edit_data['absen'] : '' ?>">
            <input type="number" name="tugas" placeholder="Rata-rata Tugas 1-5 (0-100)" class="border p-2 w-full mb-2" required value="<?= $edit_data ? $edit_data['tugas'] : '' ?>">
            <input type="number" name="uts" placeholder="Nilai UTS (0-100)" class="border p-2 w-full mb-2" required value="<?= $edit_data ? $edit_data['uts'] : '' ?>">
            <input type="number" name="uas" placeholder="Nilai UAS (0-100)" class="border p-2 w-full mb-2" required value="<?= $edit_data ? $edit_data['uas'] : '' ?>">
            <button type="submit" name="<?= $edit_data ? 'update' : 'tambah' ?>" class="bg-blue-500 text-white px-4 py-2 rounded">
                <?= $edit_data ? 'Update Nilai' : 'Simpan' ?>
            </button>
        </form>

        <div class="mt-6" id="print-area">
            <h2 class="text-xl text-center font-bold">Penilaian Mata Kuliah Jaringan Syaraf Tiruan</h2>
            <h2 class="text-xl text-center font-bold">Tahun Ajaran 2024/2025</h2>
            <table id="tabel-nilai" class="table-auto w-full bg-white mt-4">
                <thead>
                    <tr>
                        <th class="border px-2">No</th>
                        <th class="border px-2">NIM</th>
                        <th class="border px-2">Mahasiswa</th>
                        <th class="border px-2">Dosen PA</th>
                        <th class="border px-2">Absen</th>
                        <th class="border px-2">Tugas</th>
                        <th class="border px-2">UTS</th>
                        <th class="border px-2">UAS</th>
                        <th class="border px-2">Nilai Akhir</th>
                        <th class="border px-2">Nilai Huruf</th>
                        <th class="border px-2 no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = mysqli_query($koneksi, "SELECT nilai.*, mahasiswa.nama as mhs, mahasiswa.nim as nim, dosen_pa.nama as dosen_pa_nama 
                            FROM nilai 
                            JOIN mahasiswa ON nilai.mahasiswa_id = mahasiswa.id 
                            LEFT JOIN dosen_pa ON mahasiswa.dosen_pa_id = dosen_pa.id");
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($data)): ?>
                        <tr>
                            <td class="border px-2 text-center"><?= $no++ ?></td>
                            <td class="border px-2"><?= $row['nim'] ?></td>
                            <td class="border px-2"><?= $row['mhs'] ?></td>
                            <td class="border px-2"><?= $row['dosen_pa_nama'] ?? '-' ?></td>
                            <td class="border px-2 text-center"><?= $row['absen'] ?></td>
                            <td class="border px-2 text-center"><?= $row['tugas'] ?></td>
                            <td class="border px-2 text-center"><?= $row['uts'] ?></td>
                            <td class="border px-2 text-center"><?= $row['uas'] ?></td>
                            <td class="border px-2 text-center"><?= number_format($row['nilai_akhir'], 2) ?></td>
                            <td class="border px-2 text-center"><?= $row['nilai_huruf'] ?></td>
                            <td class="border px-2 no-print">
                                <a href="?edit=<?= $row['id'] ?>" class="text-green-500 mr-2">Edit</a>
                                <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus nilai <?= $row['mhs'] ?>?')" class="text-red-500">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="flex flex-col items-end mt-4 hidden" id="ttd">
                <div class="w-fit">
                    <h3>Mengetahui,</h3>
                    <p class="mt-16">Novhirtamely Kahar ST .M.Kom</p>
                    <p>NIDN: 1015118101</p>
                </div>
            </div>
        </div>

        <div class="no-print mt-4">
            <button onclick="PrintLaporan()" class="bg-green-500 text-white px-4 py-2 rounded">Cetak Tabel Nilai</button>
        </div>
    </div>

    <script>
        let table;

        $(document).ready(function() {
            table = $('#tabel-nilai').DataTable({
                paging: false,
                info: false
            });
        });

        function PrintLaporan() {
            const ttd = document.getElementById("ttd");

            if ($.fn.dataTable.isDataTable('#tabel-nilai')) {
                table.destroy();
            }

            ttd.classList.remove("hidden");

            window.print();

            ttd.classList.add("hidden");

            setTimeout(() => {
                table = $('#tabel-nilai').DataTable({
                    paging: false,
                    info: false
                });
            }, 1000);
        }
    </script>
</body>

</html>
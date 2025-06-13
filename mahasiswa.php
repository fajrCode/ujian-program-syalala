<?php
include 'koneksi.php';

$edit = false;
$data_edit = [];

$list_dosen = mysqli_query($koneksi, "SELECT * FROM dosen_pa");

if (isset($_GET['edit'])) {
    $edit = true;
    $id_edit = $_GET['edit'];
    $data_edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id = $id_edit"));
}

if (isset($_POST['simpan'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $no_wa = $_POST['no_wa'];
    $jk = $_POST['jk'];
    $dosen_pa_id = $_POST['dosen_pa_id'];

    mysqli_query($koneksi, "INSERT INTO mahasiswa (nim, nama, no_wa, jk, dosen_pa_id) VALUES ('$nim', '$nama', '$no_wa', '$jk', '$dosen_pa_id')");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $no_wa = $_POST['no_wa'];
    $jk = $_POST['jk'];
    $dosen_pa_id = $_POST['dosen_pa_id'];

    mysqli_query($koneksi, "UPDATE mahasiswa SET nim='$nim', nama='$nama', no_wa='$no_wa', jk='$jk', dosen_pa_id='$dosen_pa_id' WHERE id='$id'");
    header("Location: mahasiswa.php");
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE id = $id");
    header("Location: mahasiswa.php");
}

$mahasiswa = mysqli_query($koneksi, "SELECT m.*, d.nama as nama_dosen FROM mahasiswa m JOIN dosen_pa d ON m.dosen_pa_id = d.id");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery dan DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto">
        <div class="mb-4">
            <a class="px-2 py-1 rounded bg-blue-500 text-white" href="index.php">Kembali</a>
        </div>
        <h1 class="text-2xl font-bold mb-4">Data Mahasiswa</h1>

        <form method="post" class="bg-white p-4 rounded shadow-md mb-6">
            <input type="hidden" name="id" value="<?= $edit ? $data_edit['id'] : '' ?>">
            <input type="number" name="nim" placeholder="NIM" class="border p-2 w-full mb-2" value="<?= $edit ? $data_edit['nim'] : '' ?>" required>
            <input type="text" name="nama" placeholder="Nama" class="border p-2 w-full mb-2" value="<?= $edit ? $data_edit['nama'] : '' ?>" required>
            <input type="text" name="no_wa" placeholder="No WhatsApp" class="border p-2 w-full mb-2" value="<?= $edit ? $data_edit['no_wa'] : '' ?>" required>
            <select name="jk" class="border p-2 w-full mb-2" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki" <?= $edit && $data_edit['jk'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= $edit && $data_edit['jk'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
            </select>
            <select name="dosen_pa_id" class="border p-2 w-full mb-2" required>
                <option value="">Pilih Dosen PA</option>
                <?php mysqli_data_seek($list_dosen, 0);
                while ($dosen = mysqli_fetch_assoc($list_dosen)) : ?>
                    <option value="<?= $dosen['id'] ?>" <?= $edit && $data_edit['dosen_pa_id'] == $dosen['id'] ? 'selected' : '' ?>><?= $dosen['nama'] ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" name="<?= $edit ? 'update' : 'simpan' ?>" class="bg-<?= $edit ? 'yellow' : 'blue' ?>-500 text-white px-4 py-2 rounded">
                <?= $edit ? 'Update' : 'Simpan' ?>
            </button>
        </form>

        <table id="tabelMahasiswa" class="display w-full bg-white rounded shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 text-left">NIM</th>
                    <th class="p-2 text-left">Nama</th>
                    <th class="p-2 text-left">No WA</th>
                    <th class="p-2 text-left">JK</th>
                    <th class="p-2 text-left">Dosen PA</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($m = mysqli_fetch_assoc($mahasiswa)) : ?>
                    <tr class="border-t">
                        <td class="p-2"><?= $m['nim'] ?></td>
                        <td class="p-2"><?= $m['nama'] ?></td>
                        <td class="p-2"><?= $m['no_wa'] ?></td>
                        <td class="p-2"><?= $m['jk'] ?></td>
                        <td class="p-2"><?= $m['nama_dosen'] ?></td>
                        <td class="p-2">
                            <a href="?edit=<?= $m['id'] ?>" class="text-yellow-500 mr-2">Edit</a>
                            <a href="?hapus=<?= $m['id'] ?>" class="text-red-500" onclick="return confirm('Yakin?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            $('#tabelMahasiswa').DataTable({
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    },
                    zeroRecords: "Tidak ditemukan data yang cocok"
                }
            });
        });
    </script>
</body>

</html>

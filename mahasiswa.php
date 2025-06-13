<?php
// File: mahasiswa.php
include 'koneksi.php';

// Tambah Mahasiswa
if (isset($_POST['tambah'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $no_wa = $_POST['no_wa'];
    $jk = $_POST['jk'];
    $dosen_pa_id = $_POST['dosen_pa_id'];
    
    mysqli_query($koneksi, "INSERT INTO mahasiswa (nim, nama, no_wa, jk, dosen_pa_id) VALUES ('$nim','$nama','$no_wa','$jk','$dosen_pa_id')");
    header('Location: mahasiswa.php');
}

// Hapus Mahasiswa
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE id=$id");
    header('Location: mahasiswa.php');
}

// Ambil data dosen
$dosen = mysqli_query($koneksi, "SELECT * FROM dosen_pa");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-xl font-bold mb-4">Form Mahasiswa</h2>
        <form method="post" class="bg-white p-4 rounded shadow-md">
            <input type="number" name="nim" placeholder="NIM" class="border p-2 w-full mb-2" required>
            <input type="text" name="nama" placeholder="Nama" class="border p-2 w-full mb-2" required>
            <input type="text" name="no_wa" placeholder="No. WA" class="border p-2 w-full mb-2" required>
            <select name="jk" class="border p-2 w-full mb-2">
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            <select name="dosen_pa_id" class="border p-2 w-full mb-2" required>
                <option value="">Pilih Dosen PA</option>
                <?php while($row = mysqli_fetch_assoc($dosen)): ?>
                <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" name="tambah" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        </form>

        <h2 class="text-xl font-bold mt-6">Data Mahasiswa</h2>
        <table class="table-auto w-full bg-white mt-2">
            <thead>
                <tr>
                    <th class="border px-2">NIM</th>
                    <th class="border px-2">Nama</th>
                    <th class="border px-2">WA</th>
                    <th class="border px-2">JK</th>
                    <th class="border px-2">Dosen PA</th>
                    <th class="border px-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $data = mysqli_query($koneksi, "SELECT mahasiswa.*, dosen_pa.nama AS dosen_nama FROM mahasiswa JOIN dosen_pa ON mahasiswa.dosen_pa_id = dosen_pa.id");
                while ($row = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td class="border px-2"><?= $row['nim'] ?></td>
                        <td class="border px-2"><?= $row['nama'] ?></td>
                        <td class="border px-2"><?= $row['no_wa'] ?></td>
                        <td class="border px-2"><?= $row['jk'] ?></td>
                        <td class="border px-2"><?= $row['dosen_nama'] ?></td>
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

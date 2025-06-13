<?php
// File: dosen_pa.php
include 'koneksi.php';

// Tambah Dosen
if (isset($_POST['tambah'])) {
    $nidn = $_POST['nidn'];
    $nama = $_POST['nama'];

    mysqli_query($koneksi, "INSERT INTO dosen_pa (nidn, nama) VALUES ('$nidn', '$nama')");
    header('Location: dosen_pa.php');
}

// Hapus Dosen
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM dosen_pa WHERE id=$id");
    header('Location: dosen_pa.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dosen PA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-3xl mx-auto">
        <h2 class="text-xl font-bold mb-4">Form Dosen PA</h2>
        <form method="post" class="bg-white p-4 rounded shadow-md">
            <input type="number" name="nidn" placeholder="NIDN" class="border p-2 w-full mb-2" required>
            <input type="text" name="nama" placeholder="Nama" class="border p-2 w-full mb-2" required>
            <button type="submit" name="tambah" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        </form>

        <h2 class="text-xl font-bold mt-6">Data Dosen PA</h2>
        <table class="table-auto w-full bg-white mt-2">
            <thead>
                <tr>
                    <th class="border px-2">NIDN</th>
                    <th class="border px-2">Nama</th>
                    <th class="border px-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $data = mysqli_query($koneksi, "SELECT * FROM dosen_pa");
                while ($row = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td class="border px-2"><?= $row['nidn'] ?></td>
                        <td class="border px-2"><?= $row['nama'] ?></td>
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

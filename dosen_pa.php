<?php
include 'koneksi.php';

$edit = false;
$data_edit = [];

if (isset($_GET['edit'])) {
    $edit = true;
    $id_edit = $_GET['edit'];
    $data_edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM dosen_pa WHERE id = $id_edit"));
}

if (isset($_POST['simpan'])) {
    $nidn = $_POST['nidn'];
    $nama = $_POST['nama'];
    mysqli_query($koneksi, "INSERT INTO dosen_pa (nidn, nama) VALUES ('$nidn', '$nama')");
    header("Location: dosen_pa.php");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nidn = $_POST['nidn'];
    $nama = $_POST['nama'];
    mysqli_query($koneksi, "UPDATE dosen_pa SET nidn='$nidn', nama='$nama' WHERE id='$id'");
    header("Location: dosen_pa.php");
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM dosen_pa WHERE id = $id");
    header("Location: dosen_pa.php");
}

$dosen = mysqli_query($koneksi, "SELECT * FROM dosen_pa");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dosen PA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto">
        <div class="mb-4">
            <a class="px-2 py-1 rounded bg-blue-500 text-white" href="index.php">Kembali</a>
        </div>
        <h1 class="text-2xl font-bold mb-4">Data Dosen PA</h1>

        <form method="post" class="bg-white p-4 rounded shadow-md mb-6">
            <input type="hidden" name="id" value="<?= $edit ? $data_edit['id'] : '' ?>">
            <input type="number" name="nidn" placeholder="NIDN" class="border p-2 w-full mb-2" value="<?= $edit ? $data_edit['nidn'] : '' ?>" required>
            <input type="text" name="nama" placeholder="Nama Dosen" class="border p-2 w-full mb-2" value="<?= $edit ? $data_edit['nama'] : '' ?>" required>
            <button type="submit" name="<?= $edit ? 'update' : 'simpan' ?>" class="bg-<?= $edit ? 'yellow' : 'blue' ?>-500 text-white px-4 py-2 rounded">
                <?= $edit ? 'Update' : 'Simpan' ?>
            </button>
        </form>

        <table class="w-full bg-white rounded shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 text-left">NIDN</th>
                    <th class="p-2 text-left">Nama</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($d = mysqli_fetch_assoc($dosen)): ?>
                    <tr class="border-t">
                        <td class="p-2"><?= $d['nidn'] ?></td>
                        <td class="p-2"><?= $d['nama'] ?></td>
                        <td class="p-2">
                            <a href="?edit=<?= $d['id'] ?>" class="text-yellow-500 mr-2">Edit</a>
                            <a href="?hapus=<?= $d['id'] ?>" class="text-red-500" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
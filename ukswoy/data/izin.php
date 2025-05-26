<?php
include '../config.php';

$editMode = false;
$editData = [
    'id' => '',
    'nama_siswa' => '',
    'tanggal_izin' => '',
    'alasan_sakit' => ''
];

// Tambah Data
if (isset($_POST['submit'])) {
    $nama = $_POST['nama_siswa'];
    $tanggal = $_POST['tanggal_izin'];
    $alasan = $_POST['alasan_sakit'];

    $sql = "INSERT INTO izin_sakit (nama_siswa, tanggal_izin, alasan_sakit) 
            VALUES ('$nama', '$tanggal', '$alasan')";
    mysqli_query($conn, $sql);
    header("Location: izin.php?success=1");
}

// Update Data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama_siswa'];
    $tanggal = $_POST['tanggal_izin'];
    $alasan = $_POST['alasan_sakit'];

    $sql = "UPDATE izin_sakit SET 
            nama_siswa='$nama', 
            tanggal_izin='$tanggal', 
            alasan_sakit='$alasan' 
            WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: izin.php?update=1");
}

// Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM izin_sakit WHERE id=$id");
    header("Location: izin.php");
}

// Ambil data untuk diedit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editMode = true;
    $resultEdit = mysqli_query($conn, "SELECT * FROM izin_sakit WHERE id=$id");
    $editData = mysqli_fetch_assoc($resultEdit);
}

$result = mysqli_query($conn, "SELECT * FROM izin_sakit");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Tindak Lanjut Pasien</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f3a683, #eb4d4b);
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 700px;
            margin: auto;
            animation: fadeIn 1s ease-in-out;
        }

        h2 {
            margin-bottom: 15px;
            color: #d32f2f;
        }

        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            color: white;
            display: none;
        }

        .success {
            background: #2e7d32;
        }

        .error {
            background: #d32f2f;
        }

        button, .btn {
            background: #d32f2f;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
            transition: 0.3s;
        }

        button:hover, .btn:hover {
            background: #b71c1c;
            transform: scale(1.05);
        }

        input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background: #d32f2f;
            color: white;
        }

        .actions a {
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 5px;
        }

        .delete {
            background: #d32f2f;
        }

        .edit {
            background: #1976d2;
        }

        .edit:hover {
            background: #0d47a1;
        }

        .delete:hover {
            background: #b71c1c;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body.loaded table tr {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Tindak Lanjut Pasien</h2>

        <div class="alert success" id="successMessage">✅ Data berhasil ditambahkan!</div>

        <!-- Tombol -->
        <a href="../" class="btn">🏠 Kembali ke Dashboard</a>
        <a href="../assets/surat/izin.pdf" target="_blank" class="btn">🖨️ Cetak Surat Izin</a>

        <!-- Form Tambah/Edit -->
        <form method="post">
            <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <input type="text" name="nama_siswa" placeholder="Nama Siswa" required value="<?= $editData['nama_siswa'] ?>">
            <input type="date" name="tanggal_izin" required value="<?= $editData['tanggal_izin'] ?>">
            <input type="text" name="alasan_sakit" placeholder="Alasan Sakit" required value="<?= $editData['alasan_sakit'] ?>">
            <?php if ($editMode): ?>
                <button type="submit" name="update">💾 Update</button>
                <a href="izin.php" class="btn">↩️ Batal</a>
            <?php else: ?>
                <button type="submit" name="submit">➕ Tambah</button>
            <?php endif; ?>
        </form>

        <!-- Tabel Data -->
        <table>
            <tr>
                <th>Nama Siswa</th>
                <th>Tanggal Izin</th>
                <th>Alasan Sakit</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['nama_siswa'] ?></td>
                <td><?= $row['tanggal_izin'] ?></td>
                <td><?= $row['alasan_sakit'] ?></td>
                <td class="actions">
                    <a href="?edit=<?= $row['id'] ?>" class="edit">✏️ Edit</a>
                    <a href="?hapus=<?= $row['id'] ?>" class="delete" onclick="return confirm('Yakin ingin menghapus?')">🗑️ Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.body.classList.add("loaded");

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                document.getElementById("successMessage").textContent = "✅ Data berhasil ditambahkan!";
                document.getElementById("successMessage").style.display = "block";
            }
            if (urlParams.has('update')) {
                document.getElementById("successMessage").textContent = "✅ Data berhasil diperbarui!";
                document.getElementById("successMessage").style.display = "block";
            }

            setTimeout(() => {
                document.getElementById("successMessage").style.display = "none";
            }, 3000);
        });
    </script>

</body>
</html>

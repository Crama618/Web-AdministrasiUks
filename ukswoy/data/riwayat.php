<?php
include '../config.php';

// Ambil data untuk edit
$edit_nama = $edit_riwayat = $edit_keluhan = $edit_tanggal = $edit_deskripsi = "";
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = mysqli_query($conn, "SELECT * FROM riwayat_kesehatan WHERE id=$id");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $edit_nama = $data['nama_siswa'];
        $edit_riwayat = $data['riwayat'];
        $edit_keluhan = $data['keluhan'];
        $edit_tanggal = $data['tanggal'];
        $edit_deskripsi = $data['deskripsi'];
    }
}

// Tambah Data
if (isset($_POST['submit'])) {
    $nama = $_POST['nama_siswa'];
    $riwayat = $_POST['riwayat'];
    $keluhan = $_POST['keluhan'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];

    $sql = "INSERT INTO riwayat_kesehatan (nama_siswa, riwayat, keluhan, tanggal, deskripsi) 
            VALUES ('$nama', '$riwayat', '$keluhan', '$tanggal', '$deskripsi')";
    mysqli_query($conn, $sql);
    header("Location: riwayat.php");
}

// Update Data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama_siswa'];
    $riwayat = $_POST['riwayat'];
    $keluhan = $_POST['keluhan'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];

    $sql = "UPDATE riwayat_kesehatan SET 
            nama_siswa='$nama', riwayat='$riwayat', keluhan='$keluhan', tanggal='$tanggal', deskripsi='$deskripsi' 
            WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: riwayat.php");
}

// Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM riwayat_kesehatan WHERE id=$id");
    header("Location: riwayat.php");
}

$result = mysqli_query($conn, "SELECT * FROM riwayat_kesehatan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Pasien</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #a8e063, #56ab2f);
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
            color: #2e7d32;
        }

        button, .btn {
            background: #2e7d32;
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
            background: #1b5e20;
            transform: scale(1.05);
        }

        input, textarea {
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
            background: #2e7d32;
            color: white;
        }

        .actions a {
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .edit {
            background: #fbc02d;
        }

        .delete {
            background: #d32f2f;
        }

        /* Animasi fade-in */
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

        /* Animasi tabel muncul satu per satu */
        table tr {
            opacity: 0;
            transform: translateX(-20px);
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
        }

        /* Efek muncul setelah halaman dimuat */
        body.loaded table tr {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Data Pasien</h2>

        <!-- Tombol Kembali ke Dashboard -->
        <a href="../" class="btn">🏠 Kembali ke Dashboard</a>

        <form method="post">
            <input type="hidden" name="id" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '' ?>">
            <input type="text" name="nama_siswa" placeholder="Nama Siswa" value="<?= $edit_nama ?>" required>
            <input type="text" name="riwayat" placeholder="Riwayat Penyakit" value="<?= $edit_riwayat ?>">
            <input type="text" name="keluhan" placeholder="Keluhan" value="<?= $edit_keluhan ?>" required>
            <input type="date" name="tanggal" value="<?= $edit_tanggal ?>" required>
            <textarea name="deskripsi" placeholder="Deskripsi (Opsional)"><?= $edit_deskripsi ?></textarea>
            
            <?php if (isset($_GET['edit'])) { ?>
                <button type="submit" name="update">✏️ Update</button>
                <a href="riwayat.php" class="btn">❌ Batal</a>
            <?php } else { ?>
                <button type="submit" name="submit">➕ Tambah</button>
            <?php } ?>
        </form>

        <a href="cetak_riwayat.php" target="_blank" class="btn">🖨️ Cetak Data</a>

        <table>
            <tr>
                <th>Nama Siswa</th>
                <th>Riwayat Penyakit</th>
                <th>Keluhan</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['nama_siswa'] ?></td>
                <td><?= $row['riwayat'] ?></td>
                <td><?= $row['keluhan'] ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['deskripsi'] ?></td>
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
        });
    </script>

</body>
</html>

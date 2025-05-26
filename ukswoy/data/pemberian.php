<?php
include '../config.php';

if (isset($_POST['submit'])) {
    $nama_siswa = $_POST['nama_siswa'];
    $nama_obat = $_POST['nama_obat'];
    $dosis = $_POST['dosis'];
    $tanggal = $_POST['tanggal_pemberian'];
    $waktu = $_POST['waktu_pemberian'];

    $sql = "INSERT INTO pemberian_obat (nama_siswa, nama_obat, dosis, tanggal_pemberian, waktu_pemberian) 
            VALUES ('$nama_siswa', '$nama_obat', '$dosis', '$tanggal', '$waktu')";
    mysqli_query($conn, $sql);
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM pemberian_obat WHERE id=$id");
    header("Location: pemberian.php");
}

$result = mysqli_query($conn, "SELECT * FROM pemberian_obat");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pemberian Obat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #89f7fe, #66a6ff);
            margin: 0;
            padding: 20px;
            color: #333;
            animation: fadeIn 1s ease-in-out;
        }

        h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 30px;
            animation: slideDown 1s ease;
        }

        form {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 12px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            animation: fadeInUp 1s ease;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            font-size: 16px;
        }

        input {
            background-color: #f0f0f0;
            transition: 0.3s;
        }

        input:focus {
            background-color: #fff;
            outline: 2px solid #66a6ff;
        }

        button {
            background: #66a6ff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background: #4a90e2;
            transform: scale(1.03);
        }

        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
            animation: fadeInUp 1.2s ease;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        th {
            background: #66a6ff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #eef6ff;
            transition: 0.3s ease;
        }

        a {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideDown {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeInUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .top-bar {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
        }       

        .dashboard-btn {
            background-color: #ffffff;
            color: #4a90e2;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .dashboard-btn:hover {
            background-color: #66a6ff;
            color: #fff;
            transform: scale(1.05);
        }

    </style>
</head>
<body>
<div class="top-bar">
    <a href="../dashboard.php" class="dashboard-btn">🏠 Dashboard</a>
</div>


<h2>💊 Data Pemberian Obat UKS</h2>

<form method="post">
    <input type="text" name="nama_siswa" placeholder="Nama Siswa" required>
    <input type="text" name="nama_obat" placeholder="Nama Obat" required>
    <input type="text" name="dosis" placeholder="Dosis" required>
    <input type="date" name="tanggal_pemberian" required>
    <input type="time" name="waktu_pemberian" required>
    <button type="submit" name="submit">✅ Tambah Data</button>
</form>

<table>
    <tr>
        <th>Nama Siswa</th>
        <th>Nama Obat</th>
        <th>Dosis</th>
        <th>Tanggal</th>
        <th>Waktu</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
        <td><?= htmlspecialchars($row['nama_obat']) ?></td>
        <td><?= htmlspecialchars($row['dosis']) ?></td>
        <td><?= date("d-m-Y", strtotime($row['tanggal_pemberian'])) ?></td>
        <td><?= date("H:i", strtotime($row['waktu_pemberian'])) ?></td>
        <td><a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">🗑</a></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>

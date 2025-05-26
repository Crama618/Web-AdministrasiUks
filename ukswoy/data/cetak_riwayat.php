<?php
include '../config.php';

// Ambil data dari database
$result = mysqli_query($conn, "SELECT * FROM riwayat_kesehatan");

// Format tanggal hari ini
$tanggal_cetak = date("d-m-Y");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Cetak Riwayat Kesehatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        h2 {
            margin-bottom: 10px;
        }
        .tanggal-cetak {
            font-size: 14px;
            font-style: italic;
            margin-bottom: 20px;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        .print-button {
            margin: 20px;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
        }
        @media print {
            @page {
                margin: 10mm; /* Mengurangi margin agar lebih rapi */
            }
            body {
                margin: 0;
                padding: 0;
            }
            h2 {
                margin-top: 0;
            }
            .print-button {
                display: none; /* Sembunyikan tombol cetak saat print */
            }
        }
    </style>
</head>
<body>
    <h2>Cetak Riwayat Kesehatan</h2>
    <p class="tanggal-cetak">Tanggal Cetak: <?= $tanggal_cetak ?></p>

    <?php if (mysqli_num_rows($result) > 0) { ?>
        <table>
            <tr>
                <th>Nama Siswa</th>
                <th>Riwayat Penyakit</th>
                <th>Keluhan</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
                <td><?= htmlspecialchars($row['riwayat']) ?></td>
                <td><?= htmlspecialchars($row['keluhan']) ?></td>
                <td><?= htmlspecialchars($row['tanggal']) ?></td>
                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
            </tr>
            <?php } ?>
        </table>
        <button class="print-button" onclick="window.print()">Cetak</button>
    <?php } else { ?>
        <p style="color: red;">Tidak ada data riwayat kesehatan.</p>
    <?php } ?>

</body>
</html>

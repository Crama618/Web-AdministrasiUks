<?php
include '../config.php';

$jadwal = [
    "Senin" => [
        ["nama" => "Andi Prasetyo", "telepon" => "081234567890"],
        ["nama" => "Siti Rahmawati", "telepon" => "082345678901"]
    ],
    "Selasa" => [
        ["nama" => "Budi Santoso", "telepon" => "083456789012"],
        ["nama" => "Dewi Lestari", "telepon" => "084567890123"]
    ],
    "Rabu" => [
        ["nama" => "Citra Melati", "telepon" => "085678901234"],
        ["nama" => "Fajar Nugroho", "telepon" => "086789012345"]
    ],
    "Kamis" => [
        ["nama" => "Gina Kurnia", "telepon" => "087890123456"],
        ["nama" => "Hendra Wijaya", "telepon" => "088901234567"]
    ],
    "Jumat" => [
        ["nama" => "Intan Permata", "telepon" => "089012345678"],
        ["nama" => "Joko Widodo", "telepon" => "080123456789"]
    ],
    "Sabtu" => "Tutup",
    "Minggu" => "Tutup"
];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jadwal Petugas UKS</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            padding: 30px;
            border-radius: 15px;
        }
        h2 {
            text-align: center;
            color: #0077b6;
            margin-bottom: 30px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px 12px;
            text-align: left;
        }
        th {
            background-color: #0077b6;
            color: white;
        }
        .tutup {
            color: red;
            font-weight: bold;
            text-align: center;
        }
        tr.petugas:nth-child(odd) td {
            background-color: #fff8dc; /* kuning muda */
        }
        tr.petugas:nth-child(even) td {
            background-color: #e0f7fa; /* biru muda */
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            margin: 10px;
            padding: 12px 24px;
            font-size: 16px;
            color: white;
            background: #0077b6;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            text-decoration: none;
        }
        .btn:hover {
            background: #00b4d8;
            transform: scale(1.05);
        }
        @media print {
            .button-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Jadwal Petugas UKS</h2>
        <table>
            <tr>
                <th>Hari</th>
                <th>Nama Petugas</th>
                <th>Nomor Telepon</th>
            </tr>
            <?php foreach ($jadwal as $hari => $petugas): ?>
                <?php if ($petugas === "Tutup"): ?>
                    <tr>
                        <td><?php echo $hari; ?></td>
                        <td class="tutup" colspan="2">Tutup</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($petugas as $index => $data): ?>
                        <tr class="petugas">
                            <?php if ($index === 0): ?>
                                <td rowspan="<?php echo count($petugas); ?>"><?php echo $hari; ?></td>
                            <?php endif; ?>
                            <td><?php echo $data['nama']; ?></td>
                            <td><?php echo $data['telepon']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>

        <div class="button-container">
            <button class="btn" onclick="window.print()">Cetak ke PDF</button>
            <a href="../dashboard.php" class="btn">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>

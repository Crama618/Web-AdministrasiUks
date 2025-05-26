<?php
// Menghubungkan ke database
include '../config.php';

// ✅ 1. Menambahkan data obat ke database
if (isset($_POST['submit'])) {
    $nama = $_POST['nama_obat']; // Mengambil input nama obat
    $jumlah = $_POST['jumlah_stok']; // Mengambil input jumlah stok
    $kadaluarsa = $_POST['tanggal_kadaluarsa']; // Mengambil input tanggal kedaluwarsa

    // Query untuk memasukkan data ke tabel 'obat'
    $sql = "INSERT INTO obat (nama_obat, jumlah_stok, tanggal_kadaluarsa) VALUES ('$nama', '$jumlah', '$kadaluarsa')";
    
    // Eksekusi query
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Obat berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Gagal menambahkan obat!');</script>";
    }

    // Redirect ke halaman obat.php setelah submit
    header("Location: obat.php");
    exit();
}

// ✅ 2. Menghapus data obat berdasarkan ID
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus']; // Mengambil ID obat yang akan dihapus

    // Query untuk menghapus obat berdasarkan ID
    $sql = "DELETE FROM obat WHERE id=$id";

    // Eksekusi query
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Obat berhasil dihapus!');</script>";
    } else {
        echo "<script>alert('Gagal menghapus obat!');</script>";
    }

    // Redirect ke halaman obat.php setelah penghapusan
    header("Location: obat.php");
    exit();
}

// ✅ 3. Mengambil semua data obat dari database
$result = mysqli_query($conn, "SELECT * FROM obat");

// ✅ 4. Analisis Data Obat
$total_stok = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah_stok) as total FROM obat"))['total'];
$hampir_kadaluarsa = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as jumlah FROM obat 
    WHERE tanggal_kadaluarsa BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
"))['jumlah'];
$kadaluarsa = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as jumlah FROM obat 
    WHERE tanggal_kadaluarsa < CURDATE()
"))['jumlah'];
?>


<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Obat - UKS</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Gaya Global */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            text-align: center;
            color: #fff;
            animation: fadeIn 1s ease-in-out;
        }

        /* Animasi */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            font-size: 30px;
            margin-bottom: 20px;
            animation: fadeIn 1s ease-in-out;
        }

        /* Tombol Dashboard */
        .dashboard-btn {
            text-decoration: none;
            color: white;
            background: #ff416c;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .dashboard-btn:hover {
            background: #ff4b2b;
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(255, 65, 108, 0.5);
        }

        /* Form Input */
        .form-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
            animation: fadeIn 1s ease-in-out;
        }

        .form-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            outline: none;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transition: 0.3s;
        }

        .form-container input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-container input:focus {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .form-container button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(255, 65, 108, 0.5);
        }

        .analisis-container {
    background: rgba(0, 0, 0, 0.2);
    padding: 15px;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
    margin-bottom: 20px;
    width: 100%;
    max-width: 500px;
    animation: fadeIn 1s ease-in-out;
}

.analisis-container h3 {
    margin-bottom: 10px;
    color: #ffcc00;
}

.analisis-container p {
    font-size: 16px;
}


        /* Tabel Data */
        table {
            width: 100%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.1);
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            animation: fadeIn 1s ease-in-out;
        }

        th, td {
            padding: 15px;
            text-align: center;
            color: white;
        }

        th {
            background: rgba(255, 255, 255, 0.2);
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.3);
            transition: 0.3s;
        }

        .edit-btn {
        padding: 8px 15px;
        background: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: 0.3s;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 4px 6px rgba(0, 123, 255, 0.3);
    }

    .edit-btn:hover {
        background: #0056b3;
        transform: scale(1.1);
        box-shadow: 0 6px 10px rgba(0, 123, 255, 0.5);
    }

    .edit-btn:active {
        transform: scale(0.9);
    }

        /* Tombol Hapus */
        .hapus-btn {
            padding: 8px 15px;
            background: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .hapus-btn:hover {
            background: darkred;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <a href="../dashboard.php" class="dashboard-btn">🏠 Dashboard</a>
    <h2>📋 Data Obat - UKS</h2>

    <!-- Container Analisis Data -->
    <div class="analisis-container">
        <h3>📊 Grafik</h3>
        <canvas id="analisisChart" width="200" height="200"></canvas>
    </div>
   
    <div class="form-container">
    <h3>📝 Tambah Obat</h3>
    <form method="post">
        <input type="text" name="nama_obat" placeholder="Nama Obat" required>
        <input type="number" name="jumlah_stok" placeholder="Jumlah Stok" required>
        <input type="date" name="tanggal_kadaluarsa" required>
        <button type="submit" name="submit">Tambah</button>
    </form>
</div>

    <table border="1">
    <tr>
        <th>No</th>
        <th>Nama Obat</th>
        <th>Jumlah Stok</th>
        <th>Tanggal Kedaluwarsa</th>
        <th>Aksi</th>
    </tr>
    <?php 
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama_obat']; ?></td>
            <td><?= $row['jumlah_stok']; ?></td>
            <td><?= $row['tanggal_kadaluarsa']; ?></td>
            <td>
                <a href="edit_obat.php?id=<?= $row['id']; ?>" class="edit-btn">Edit</a>
                <a href="#" onclick="confirmDelete('obat.php?hapus=<?= $row['id']; ?>')" class="hapus-btn">Hapus</a>
            </td>
        </tr>
    <?php } ?>
</table>

<script>
function confirmDelete(url) {
    Swal.fire({
        title: "Yakin ingin menghapus?",
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>

<script>
    // Ambil data dari PHP
    var total_stok = <?= $total_stok; ?>;
    var hampir_kadaluarsa = <?= $hampir_kadaluarsa; ?>;
    var kadaluarsa = <?= $kadaluarsa; ?>;

    var ctx = document.getElementById('analisisChart').getContext('2d');
    var analisisChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Total Stok', 'Hampir Kedaluwarsa', 'Kadaluarsa'],
            datasets: [{
                data: [total_stok, hampir_kadaluarsa, kadaluarsa],
                backgroundColor: ['#4CAF50', '#FFC107', '#F44336'], // Hijau, Kuning, Merah
                hoverOffset: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

    
</body>
</html>

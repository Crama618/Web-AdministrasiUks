<?php
session_start();
include 'config.php'; 
$sqlUser = "SELECT COUNT(*) as total FROM users";
$resultUser = mysqli_query($conn, $sqlUser);
$rowUser = mysqli_fetch_assoc($resultUser);
$jumlahUser = $rowUser['total'];
$sqlLoginTerakhir = "SELECT COUNT(*) as total FROM users WHERE DATE(last_login) = CURDATE()";
$resultLogin = mysqli_query($conn, $sqlLoginTerakhir);
$rowLogin = mysqli_fetch_assoc($resultLogin);
$jumlahLoginTerakhir = $rowLogin['total'];


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard UKS</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/script.js" defer></script>

    <style>
        /* ---- BODY ---- */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* ---- BACKGROUND BLUR ---- */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('assets/uks.gif') no-repeat center center fixed;
            background-size: cover;
            z-index: -1;
            filter: blur(8px);
        }

        /* ---- HEADER ---- */
        .header {
            background: linear-gradient(45deg, #ff0000, #ff7300, #ffeb3b, #4caf50, #2196f3, #9c27b0);
            background-size: 400% 400%;
            animation: gradientBG 6s ease infinite;
            color: white;
            width: 100%;
            padding: 20px;
            text-align: center;
            font-size: 35px;
            font-weight: bold;
            border-radius: 10px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* ---- ANNOUNCEMENT ---- */
        .announcement {
            width: 100%;
            background-color: black;
            padding: 15px;
            font-weight: bold;
            font-size: 18px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            color: #ff0000;
            text-shadow: 0 0 10px red, 0 0 20px red, 0 0 30px red;
        }

        /* ---- WELCOME TEXT ---- */
        .welcome {
            font-size: 24px;
            font-weight: bold;
            color:rgb(0, 255, 13);
            text-shadow: 0 0 10px #00e1ff, 0 0 20pxrgb(0, 0, 0), 0 0 30pxrgb(19, 188, 211);
            text-align: center;
        }

        /* ---- INFO CARDS ---- */
        .info-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            max-width: 800px;
            margin: 20px auto;
        }

        .info-card {
            background-color: #800080;
            color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }

        .info-card:hover {
            transform: scale(1.05);
        }

        /* ---- SIDEBAR ---- */
        .sidebar {
            width: 250px;
            background-color: rgb(69, 103, 139);
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            height: 100vh;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .sidebar h2 {
            text-align: center;
            font-size: 22px;
        }

        .menu-group {
            margin-top: 20px;
            font-weight: bold;
        }

        .menu a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            margin: 5px 0;
            background-color: #0056b3;
            transition: background-color 0.3s;
        }

        .menu a:hover {
            background-color: #003d80;
        }

        /* ---- MAIN CONTENT ---- */
        .main {
            flex-grow: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: auto;
            margin-left: 250px;
            transition: margin-left 0.3s ease-in-out;
        }

        .main.fullscreen {
            margin-left: 0;
        }

        /* ---- TOGGLE SIDEBAR BUTTON ---- */
        .toggle-sidebar-btn {
            position: fixed;
            top: 20px;
            left: 260px;
            font-size: 30px;
            cursor: pointer;
            color: black;
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid black;
            transition: left 0.3s ease-in-out;
        }

        .sidebar.hidden + .toggle-sidebar-btn {
            left: 10px;
        }
        .description {
    max-width: 800px;
    margin: 30px auto;
    background-color: rgba(255, 255, 255, 0.95);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
    color: #333;
    font-size: 16px;
    line-height: 1.6;
    text-align: justify;
}

.description h3 {
    text-align: center;
    color: #007bff;
    margin-bottom: 15px;
}

    </style>
</head>

<body>

    <div class="sidebar" id="sidebar">
        <h2>UKS</h2>
        <div id="menu-container">
            <div class="menu-group">Admin</div>
            <div class="menu">
                <a href="#">Dashboard</a>
                <a href="data/riwayat.php">Data Pasien</a>
                <a href="data/kunjungan.php">Jadwal Petugas</a>
                <a href="data/izin.php">Tindak Lanjut Pasien</a>
                <a href="data/obat.php">Stok Obat</a>
                <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
            </div>
        </div>
    </div>

    <div class="toggle-sidebar-btn" id="toggle-sidebar-btn" onclick="toggleSidebar()">☰</div>

    <div class="main" id="main-content">
        <div class="header">🔥✨ Dashboard UKS ✨🔥</div>

        <div class="announcement">
            <marquee behavior="scroll" direction="left">
                📢 UKS SMK Negeri 5 Surakarta resmi dibuka! Layanan kesehatan siap membantu siswa dengan pemeriksaan kesehatan, kunjungan, izin sakit, dan pengelolaan obat! 🚑💊
            </marquee>
        </div>
          
        
        <h2 class="welcome">Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>! 🎉</h2>

        <div class="info-container">
        <div class="info-card"><h3>Jumlah User</h3><p><?php echo $jumlahUser; ?> Orang</p></div>
            <div class="info-card"><h3>Jumlah Obat</h3><p>5 Jenis</p></div>
            <div class="info-card"><h3>Login Terakhir</h3><p><?php echo $jumlahLoginTerakhir; ?> Orang</p></div>
        </div>
        <div class="description">
    <h3>✨ Tentang Website UKS SMK Negeri 5 Surakarta ✨</h3>

    <p style="font-size: 17px; text-align: center;">
        <strong>UKS (Unit Kesehatan Sekolah)</strong> adalah pusat layanan kesehatan yang ada di lingkungan sekolah untuk memberikan pelayanan kesehatan dasar kepada siswa, guru, dan staf.
    </p>

    <hr style="margin: 20px 0;">

    <h4 style="color:#007bff;">🎯 Tujuan Pembuatan Website UKS</h4>
    <ul style="list-style-type: '✅ '; padding-left: 20px;">
        <li>Meningkatkan efisiensi dan kecepatan pelayanan kesehatan di sekolah</li>
        <li>Mendigitalisasi proses pencatatan data kesehatan siswa</li>
        <li>Memudahkan monitoring dan evaluasi kesehatan siswa secara berkala</li>
    </ul>

    <h4 style="color:#007bff; margin-top: 20px;">👥 Sasaran Pengguna Website</h4>
    <ul style="list-style-type: '👤 '; padding-left: 20px;">
        <li><strong>Petugas UKS:</strong> Mengelola data kesehatan siswa dan obat-obatan</li>
    </ul>

    <h4 style="color:#007bff; margin-top: 20px;">🧰 Fitur Utama Website</h4>
    <ul style="list-style-type: '🚀 '; padding-left: 20px;">
        <li><strong>Dashboard:</strong> Menampilkan ringkasan jumlah pengguna, obat, dan siswa</li>
        <li><strong>Pemeriksaan & Keluhan:</strong> Input keluhan dan hasil pemeriksaan siswa</li>
        <li><strong>Kunjungan UKS:</strong> Data siswa yang berobat ke UKS</li>
        <li><strong>Surat Izin Sakit:</strong> Pengajuan dan pengelolaan izin sakit</li>
        <li><strong>Analisis Obat:</strong> Monitoring stok dan penggunaan obat</li>
        <li><strong>Data Pemberian:</strong> Riwayat pemberian obat dan tindakan</li>
    </ul>

    <p style="margin-top: 20px; font-size: 16px; text-align: center;">
        Dengan sistem ini, <strong>pelayanan UKS menjadi lebih cepat, transparan, dan terorganisir</strong>, mendukung kesehatan siswa secara optimal di lingkungan sekolah.
    </p>
</div>



    </div>
    

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("hidden");
        }
    </script>

</body>
</html>

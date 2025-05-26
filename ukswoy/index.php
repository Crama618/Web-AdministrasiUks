<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKS - Beranda</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Styling dasar */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .container {
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: slideIn 1s ease-in-out;
            transition: transform 0.6s ease-in-out, opacity 0.6s ease-in-out;
        }

        h2 {
            margin-bottom: 20px;
            font-weight: 600;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            margin: 10px;
            font-size: 16px;
            text-decoration: none;
            color: white;
            background: #ff7eb3;
            border-radius: 8px;
            transition: transform 0.3s ease-in-out, background 0.3s ease-in-out;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
        }

        .button:hover {
            background: #ff5177;
            transform: scale(1.05);
        }

        /* Animasi */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Animasi keluar */
        .fade-out {
            transform: translateY(30px);
            opacity: 0;
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <h2>🎉 Selamat Datang di Sistem Administrasi UKS 🎉</h2>
        <a href="login.php" class="button" onclick="animateExit(event, 'login.php')">🔑 Login</a>
        <a href="register.php" class="button" onclick="animateExit(event, 'register.php')">📝 Register</a>
    </div>

    <script>
        function animateExit(event, url) {
            event.preventDefault();
            let container = document.getElementById('container');
            container.classList.add('fade-out');
            setTimeout(() => {
                window.location.href = url;
            }, 500);
        }
    </script>
</body>
</html>

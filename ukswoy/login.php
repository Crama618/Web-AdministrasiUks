<?php
session_start();
include "config.php";

$username = isset($_SESSION['register_username']) ? $_SESSION['register_username'] : '';
unset($_SESSION['register_username']); // hanya ditampilkan sekali

$error = ""; // untuk menampilkan pesan error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_user = mysqli_real_escape_string($conn, $_POST['username']);
    $input_pass = $_POST['password'];

    // Ambil data user
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$input_user'");

    if ($query && mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);

        if (password_verify($input_pass, $user['password'])) {
            // Update last_login
            mysqli_query($conn, "UPDATE users SET last_login = NOW() WHERE username='$input_user'");

            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login UKS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
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
            font-weight: 600;
            margin-bottom: 20px;
            color: white;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease-in-out;
        }

        input:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        button {
            background: #ff7eb3;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            font-size: 16px;
            width: 100%;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
        }

        button:hover {
            background: #ff5177;
            transform: scale(1.05);
        }

        p {
            margin-top: 10px;
            color: white;
        }

        a {
            color: #ff7eb3;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease-in-out;
        }

        a:hover {
            color: #ff5177;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .fade-out {
            transform: translateY(30px);
            opacity: 0;
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <h2>🔐 Login Akun UKS</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" onsubmit="return animateSubmit()">
            <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($username) ?>" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Registrasi</a></p>
    </div>

    <script>
        function animateSubmit() {
            let container = document.getElementById('container');
            container.classList.add('fade-out');
            setTimeout(() => {
                document.forms[0].submit();
            }, 500);
            return false;
        }
    </script>
</body>
</html>

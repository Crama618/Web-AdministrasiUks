<?php
include '../config.php';
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM obat WHERE id = $id");
$data = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $nama = $_POST['nama_obat'];
    $jumlah = $_POST['jumlah_stok'];
    $kadaluarsa = $_POST['tanggal_kadaluarsa'];
    
    $sql = "UPDATE obat SET nama_obat='$nama', jumlah_stok='$jumlah', tanggal_kadaluarsa='$kadaluarsa' WHERE id=$id";
    mysqli_query($conn, $sql);
    
    header("Location: obat.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Obat</title>
    <link rel="stylesheet" href="../assets/style.css">
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
            height: 100vh;
            text-align: center;
            color: white;
        }

        /* Container Form */
        .form-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 1s ease-in-out;
        }

        /* Animasi */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            font-size: 26px;
            margin-bottom: 20px;
        }

        /* Input Style */
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

        /* Tombol Submit */
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

        /* Tombol Kembali */
        .back-btn {
            display: inline-block;
            text-decoration: none;
            color: white;
            background: #3498db;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 15px;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .back-btn:hover {
            background: #2980b9;
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(52, 152, 219, 0.5);
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>📝 Edit Data Obat</h2>
        <form method="post">
            <input type="text" name="nama_obat" value="<?= $data['nama_obat'] ?>" required>
            <input type="number" name="jumlah_stok" value="<?= $data['jumlah_stok'] ?>" required>
            <input type="date" name="tanggal_kadaluarsa" value="<?= $data['tanggal_kadaluarsa'] ?>" required>
            <button type="submit" name="update">✅ Update</button>
        </form>
        <a href="obat.php" class="back-btn">🔙 Kembali</a>
    </div>

</body>
</html>

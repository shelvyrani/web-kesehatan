<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Penyakit Kucing</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Sistem Pakar Diagnosa Penyakit Kucing</h1>
    <form action="hasil.php" method="post">
        <h2>Pilih Gejala:</h2>
        <?php
        include 'config.php';
        $result = mysqli_query($conn, "SELECT * FROM tb_gejala");
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<label><input type="checkbox" name="gejala[]" value="' . $row['id_gejala'] . '"> ' . $row['nama_gejala'] . '</label><br>';
        }
        ?>
        <button type="submit">Diagnosa</button>
    </form>
</body>
</html>

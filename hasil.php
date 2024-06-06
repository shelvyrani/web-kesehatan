<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Hasil Diagnosa</h1>
    <?php
    include 'config.php';

    if (isset($_POST['gejala'])) {
        $gejala = $_POST['gejala'];
        $gejala_list = implode(",", $gejala);

      
        $query = "SELECT * FROM penyakit";
        $result = mysqli_query($conn, $query);
        $penyakit_teridentifikasi = [];
        $penyakit_gejala_count = [];

        while ($penyakit = mysqli_fetch_assoc($result)) {
            $penyakit_id = $penyakit['id_penyakit'];
            
            
            $gejala_query = "SELECT id_gejala FROM aturan_diagnosis WHERE id_penyakit = $penyakit_id";
            $gejala_result = mysqli_query($conn, $gejala_query);

            $gejala_penyakit = [];
            while ($row = mysqli_fetch_assoc($gejala_result)) {
                $gejala_penyakit[] = $row['id_gejala'];
            }

           
            $matched_gejala_count = count(array_intersect($gejala, $gejala_penyakit));

            if ($matched_gejala_count > 0) {
                $penyakit_teridentifikasi[] = $penyakit;
                $penyakit_gejala_count[$penyakit_id] = $matched_gejala_count;
            }
        }

        if (count($penyakit_teridentifikasi) > 0) {
         
            $penyakit_teratas = array_keys($penyakit_gejala_count, max($penyakit_gejala_count))[0];

            echo "<div class='results'>";
            foreach ($penyakit_teridentifikasi as $penyakit) {
                echo "<h2>" . $penyakit['nama_penyakit'] . "</h2>";
                echo "<p><strong>Deskripsi:</strong> " . $penyakit['deskripsi'] . "</p>";
                echo "<p><strong>Rekomendasi:</strong> " . $penyakit['rekomendasi'] . "</p>";
                if ($penyakit['id_penyakit'] == $penyakit_teratas) {
                    echo "<p style='color: green;'><strong>Penyakit yang paling mungkin berdasarkan gejala yang dipilih.</strong></p>";
                }
                echo "<hr>";
            }
            echo "</div>";
        } else {
            echo "<p>Tidak ada penyakit yang sesuai dengan gejala yang dipilih.</p>";
        }
    } else {
        echo "<p>Anda belum memilih gejala apapun.</p>";
    }
    ?>
    <a href="index.php">Kembali</a>
</body>
</html>

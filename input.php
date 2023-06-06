<!DOCTYPE html>
<html>
<head>
    <title>Halaman Input, Lihat, dan Hapus Database</title>
</head>
<body>
    <h1>Halaman Input, Lihat, dan Hapus Database</h1>

    <form method="post" action="">
        <label for="column_a">Kolom A:</label><br>
        <textarea name="column_a" id="column_a" rows="10" cols="50"></textarea><br><br>

        <label for="column_b">Kolom B:</label><br>
        <textarea name="column_b" id="column_b" rows="10" cols="50"></textarea><br><br>

        <input type="submit" name="submit" value="Tambahkan Data">
    </form>

    <?php
    // Fungsi untuk koneksi ke database
    function connectDatabase() {
        $host = 'fdb1029.awardspace.net';
        $database = '4325265_form';
        $username = '4325265_form';
        $password = '@1)iLO,U9P:fTfzB';

        $connection = new mysqli($host, $username, $password, $database);

        if ($connection->connect_error) {
            die('Koneksi database gagal: ' . $connection->connect_error);
        }

        return $connection;
    }

    // Fungsi untuk membuat tabel
    function createTable($connection) {
        $tableName = 'angka';

        $sql = "CREATE TABLE IF NOT EXISTS $tableName (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            column_a VARCHAR(255),
            column_b VARCHAR(255)
        )";

        if ($connection->query($sql) === TRUE) {
            echo "Tabel $tableName berhasil dibuat atau sudah ada.";
        } else {
            echo "Error: " . $connection->error;
        }
    }

    // Fungsi untuk menghapus tabel
    function dropTable($connection) {
        $tableName = 'angka';

        $sql = "DROP TABLE IF EXISTS $tableName";

        if ($connection->query($sql) === TRUE) {
            echo "Tabel $tableName berhasil dihapus.";

            // Membuat tabel kosong kembali setelah dihapus
            createTable($connection);
        } else {
            echo "Error: " . $connection->error;
        }
    }

    // Fungsi untuk menampilkan data dari tabel
    function showData($connection) {
        $tableName = 'angka';

        // Query untuk mendapatkan data dari tabel
        $query = "SELECT * FROM $tableName";

        // Eksekusi query
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            // Menampilkan tabel jika ada data
            echo '<h2>Data di Tabel:</h2>';
            echo '<table>';
            echo '<tr><th>ID</th><th>Kolom A</th><th>Kolom B</th><th>Edit</th><th>Hapus</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['column_a'] . '</td>';
                echo '<td>' . $row['column_b'] . '</td>';
                echo '<td><a href="edit.php?id=' . $row['id'] . '">Edit</a></td>';
                echo '<td><a href="hapus.php?id=' . $row['id'] . '">Hapus</a></td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'Tidak ada data.';
        }
    }

    // Memeriksa apakah tombol submit ditekan
    if (isset($_POST['submit'])) {
        $connection = connectDatabase();
        createTable($connection);

        // Memeriksa apakah ada data yang dikirimkan
        if (!empty($_POST['column_a']) && !empty($_POST['column_b'])) {
            $columnAData = explode("\n", $_POST['column_a']);
            $columnBData = explode("\n", $_POST['column_b']);

            // Membersihkan data dari karakter yang tidak diinginkan
            $columnAData = array_map('trim', $columnAData);
            $columnBData = array_map('trim', $columnBData);

            // Menggabungkan data menjadi pasangan kolom A dan B
            $data = array();
            $count = count($columnAData);
            for ($i = 0; $i < $count; $i++) {
                $columnA = $columnAData[$i];
                $columnB = $columnBData[$i];
                $data[] = "('$columnA', '$columnB')";
            }

            // Query untuk memasukkan data ke tabel
            $tableName = 'angka';
            $sql = "INSERT INTO $tableName (column_a, column_b) VALUES " . implode(', ', $data);

            if ($connection->query($sql) === TRUE) {
                echo "Data berhasil ditambahkan ke tabel $tableName.";
            } else {
                echo "Error: " . $connection->error;
            }
        } else {
            echo "Mohon isi kedua kolom dengan data yang valid.";
        }

        // Menutup koneksi database
        $connection->close();
    }

    // Memeriksa apakah tombol hapus ditekan
    if (isset($_POST['hapus'])) {
        $connection = connectDatabase();
        dropTable($connection);
        $connection->close();
    }

    // Menampilkan data dari tabel
    $connection = connectDatabase();
    showData($connection);
    $connection->close();
    ?>

    <br>
    <form method="post" action="">
        <input type="submit" name="hapus" value="Hapus Tabel">
    </form>
</body>
</html>

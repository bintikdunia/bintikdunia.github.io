<!DOCTYPE html>
<html>
<head>
  <title>AUTOMATA</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    h1 {
      text-align: center;
    }

    form {
      text-align: center;
    }

    label {
      display: block;
      margin-bottom: 10px;
    }

    input[type="text"] {
      padding: 5px;
      width: 150px;
    }

    button {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #45a049;
    }

    #hasil {
      text-align: center;
      margin-top: 20px;
      font-size: 18px;
    }
  </style>
</head>
<body>
  <h1>AUTOMATA</h1>
  <form method="post">
    <label for="angkaPertama">Result 1</label>
    <input type="text" id="angkaPertama" name="angkaPertama" maxlength="4">
    <br><br>
    <label for="angkaKedua">Result 2</label>
    <input type="text" id="angkaKedua" name="angkaKedua" maxlength="4">
    <br><br>
    <button type="submit" name="submit">Proses</button>
  </form>

  <div id="hasil">
    <?php
    if (isset($_POST['submit'])) {
      $angkaPertama = $_POST['angkaPertama'];
      $angkaKedua = $_POST['angkaKedua'];

      // Mengambil digit-ditit dan melakukan operasi sesuai langkah-langkah yang telah ditentukan
      $digit1 = intval($angkaPertama[0]);
      $digit2 = intval($angkaPertama[1]);
      $digit3 = intval($angkaPertama[2]);
      $digit4 = intval($angkaPertama[3]);

      $varA = $digit1 + $digit2;
      $varB = $digit3 * $digit4;

      $varA = array_sum(str_split($varA));
      $varB = array_sum(str_split($varB));

      $varAA = $digit1 + $varA;
      $varAB = $digit2 + $varA;
      $varAC = $digit3 + $varA;
      $varAD = $digit4 + $varA;

      $varAA = array_sum(str_split($varAA));
      $varAB = array_sum(str_split($varAB));
      $varAC = array_sum(str_split($varAC));
      $varAD = array_sum(str_split($varAD));

      $hasilA = '[' . $varAA . $varAB . $varAC . $varAD . ']';

      // Mengambil digit-ditit angka kedua dan melakukan operasi sesuai langkah-langkah yang telah ditentukan
      $digit5 = intval($angkaKedua[0]);
      $digit6 = intval($angkaKedua[1]);
      $digit7 = intval($angkaKedua[2]);
      $digit8 = intval($angkaKedua[3]);

      $varC = $digit5 + $digit6;
      $varD = $digit7 * $digit8;

      $varC = array_sum(str_split($varC));
      $varD = array_sum(str_split($varD));

      $kunciA = intval(preg_replace('/[^0-9]/', '', $hasilA)) - $varC;
      if ($kunciA < 0) {
        $kunciA = abs($kunciA);
      }

      $hasilAkhir = '[' . $hasilA . $varD . $kunciA . ']';

      // Menghilangkan angka yang sama
      $hasilAkhir = implode('', array_unique(str_split($hasilAkhir, 1)));
      
      // Menambah angka acak untuk mencapai 7 digit yang berbeda
      while (strlen($hasilAkhir) < 7) {
        $angkaAcak = strval(rand(0, 9));
        if (!str_contains($hasilAkhir, $angkaAcak)) {
          $hasilAkhir .= $angkaAcak;
        }
      }

      echo "Hasil: " . $hasilAkhir;
    }
    ?>
  </div>
</body>
</html>

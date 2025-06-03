<?php
session_start();
require("../savienojums/connect_db.php");

if (!isset($_SESSION['Lietotajs_ID'])) {
    header('Location: login.php');
    exit;
}

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];

$sql = "SELECT Viktorina_Pareizas_Atbildes, Viktorina_Kopskaits FROM lietotaji WHERE Lietotajs_ID='$ID_Lietotajs'";
$result = mysqli_query($savienojums, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $pareizas_atbildes = $row['Viktorina_Pareizas_Atbildes'];
    $kopskaits = $row['Viktorina_Kopskaits'];
} else {
    echo "Error: " . mysqli_error($savienojums);
    exit;
}

$nauda_par_atbildi = 15;
$kop_nauda = $pareizas_atbildes * $nauda_par_atbildi;

?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viktorīnas Rezultāti</title>
    <link rel="stylesheet" type="text/css" href="../public/spelesstyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="https://poetry4kids.com/wp-content/uploads/2021/09/I-Think-Id-Like-to-Get-a-Pet-icon-300x300.png">
    <script src="../public/muzika.js"></script>
</head>
<body>
    <div class="speles-container">
    <h2 style="text-align: center;">Viktorīnas Rezultāti</h2>
            <p>Jūs atbildējāt pareizi uz <?php echo htmlspecialchars($pareizas_atbildes); ?> no <?php echo htmlspecialchars($kopskaits); ?> jautājumiem.</p>
            <p style="text-align: center;">Jūs saņēmāt <?php echo htmlspecialchars($kop_nauda); ?> monētas.</p>
    </div>
    <a href="../home.php" class="btn">Atpakaļ</a>
</body>
</html>
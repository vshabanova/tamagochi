<?php 
session_start();
require("../savienojums/connect_db.php");

if (!isset($_SESSION['viktorina_pabeigta']) || !$_SESSION['viktorina_pabeigta']) {
    header('Location: viktorina.php');
    exit;
}

$pareizas_atbildes = $_SESSION['pareizas_atbildes'];
$kopskaits = $_SESSION['kopskaits'];
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
</head>
<body>
    <div class="speles-container">
    <h2 style="text-align: center;">Viktorīnas Rezultāti</h2>
            <p>Jūs atbildējāt pareizi uz <?php echo htmlspecialchars($pareizas_atbildes); ?> no <?php echo htmlspecialchars($kopskaits); ?> jautājumiem.</p>
            <p style="text-align: center;">Jūs saņēmāt <?php echo htmlspecialchars($pareizas_atbildes * 20); ?> monētas.</p>
    </div>
    <a href="../home.php" class="btn">Atpakaļ</a>
</body>
</html>
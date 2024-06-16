<?php 
session_start();

if (isset($_SESSION['viktorina_pabeigta']) && $_SESSION['viktorina_pabeigta']) {
    header('Location: viktorina_rezultati.php');
    exit;
}

require("../savienojums/connect_db.php");

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];
$Lietotajvards = $_SESSION['autorizejies'];

$jautajumi_sql = "SELECT * FROM jautajumu_banka";
$jautajumi_result = mysqli_query($savienojums, $jautajumi_sql);
$jautajumi = [];
if ($jautajumi_result && mysqli_num_rows($jautajumi_result) > 0) {
    while ($row = mysqli_fetch_assoc($jautajumi_result)) {
        $jautajumi[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viktorīna</title>
    <link rel="stylesheet" type="text/css" href="../public/spelesstyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="https://poetry4kids.com/wp-content/uploads/2021/09/I-Think-Id-Like-to-Get-a-Pet-icon-300x300.png">
</head>
<body>
    <div class="speles-container">
        <h2 style="text-align: center;">Viktorīna</h2>
        <p>Atbildēs izmantot garumzīmes, ja vajadzīgs!</p>
        <form id="quizForm" action="viktorina_apstrade.php" method="post">
            <?php foreach ($jautajumi as $jautajums): ?>
            <div class="jautajums">
                <p><?php echo htmlspecialchars($jautajums['Jautajums']); ?></p>
                <div class="viktorina-centrs">
                    <input class="viktorina-atbilde" type="text" name="atbilde[<?php echo $jautajums['Jautajums_ID']; ?>]" required>
                </div>
            </div>
            <?php endforeach; ?>
            <button class="dropbtn" type="submit">Iesniegt</button>
        </form>
    </div>
</body>
</html>
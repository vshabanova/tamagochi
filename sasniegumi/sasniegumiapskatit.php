<?php
session_start();
require("../savienojums/connect_db.php");

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];

$sql = "SELECT sb.Nosaukums, sb.Apraksts, sb.Vertiba, s.Datums_laiks 
        FROM sasniegumi s 
        JOIN sasniegumu_banka sb ON s.Sasniegums_ID = sb.Sasniegums_ID 
        WHERE s.Lietotajs_ID='$ID_Lietotajs'";
$result = mysqli_query($savienojums, $sql);

$sasniegumi = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sasniegumi[] = $row;
    }
} else {
    echo "Error: " . mysqli_error($savienojums);
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sasniegumi</title>
    <link rel="stylesheet" type="text/css" href="../public/spelesstyles.css">
    <link rel="icon" type="image/x-icon" href="https://poetry4kids.com/wp-content/uploads/2021/09/I-Think-Id-Like-to-Get-a-Pet-icon-300x300.png">
    <script src="../public/muzika.js"></script>
</head>
<body>
    <div class="speles-container">
    <div class="transakcijash2">
    <?php if (!empty($sasniegumi)): ?>
        <h2>Sasniegtie sasniegumi</h2>
    </div>
        <div class="transakcijas-container">
            <table class="transakcijas-table">
                <tr>
                    <th>Sasniegums</th>
                    <th>Apraksts</th>
                    <th>Vertiba</th>
                    <th>Datums un Laiks</th>
                </tr>
                <?php foreach ($sasniegumi as $sasniegums): ?>
                <tr>
                    <td><?php echo htmlspecialchars($sasniegums['Nosaukums']); ?></td>
                    <td><?php echo htmlspecialchars($sasniegums['Apraksts']); ?></td>
                    <td><?php echo htmlspecialchars($sasniegums['Vertiba']); ?></td>
                    <td><?php echo htmlspecialchars($sasniegums['Datums_laiks']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Nav sasniegumu.</p>
        <?php endif; ?>
    </div>
    </div>
    <a href="../home.php" class="btn">Atpakaļ</a>
</body>
</html>
<?php
session_start();
require("savienojums/connect_db.php");

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];

$transakcijas_sql = "SELECT t.*, e.Nosaukums FROM transakcijas t JOIN ediens e ON t.Ediens_ID = e.Ediens_ID WHERE t.Lietotajs_ID='$ID_Lietotajs' ORDER BY t.Datums_laiks DESC";
$transakcijas_result = mysqli_query($savienojums, $transakcijas_sql);
$transakcijas = [];
while ($row = mysqli_fetch_assoc($transakcijas_result)) {
    $transakcijas[] = $row;
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darījumu Vēsture</title>
    <link rel="stylesheet" type="text/css" href="public/spelesstyles.css">
    <link rel="icon" type="image/x-icon" href="https://poetry4kids.com/wp-content/uploads/2021/09/I-Think-Id-Like-to-Get-a-Pet-icon-300x300.png">
</head>
<body>
    <div class="speles-container">
    <div class="transakcijash2">
        <h2>Darījumu Vēsture</h2>
    </div>
        <div class="transakcijas-container">
            <table class="transakcijas-table">
                <tr>
                    <th>Datums un Laiks</th>
                    <th>Ēdiens</th>
                    <th>Daudzums</th>
                    <th>Cena</th>
                </tr>
                <?php foreach ($transakcijas as $transakcija): ?>
                <tr>
                    <td><?php echo htmlspecialchars($transakcija['Datums_laiks']); ?></td>
                    <td><?php echo htmlspecialchars($transakcija['Nosaukums']); ?></td>
                    <td><?php echo htmlspecialchars($transakcija['Daudzums']); ?></td>
                    <td><?php echo htmlspecialchars($transakcija['Nauda']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <a href="veikals.php" class="btn">Atpakaļ</a>
</body>
</html>
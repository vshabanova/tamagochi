<?php
session_start();
require("../savienojums/connect_db.php");

mysqli_set_charset($savienojums, "utf8");
$ID_Lietotajs = $_SESSION['Lietotajs_ID'];

$horoskopu_sql = "SELECT h.*, l.Lietotajs_ID FROM horoskopi h JOIN lietotaji l ON h.Lietotajs_ID = l.Lietotajs_ID WHERE l.Lietotajs_ID='$ID_Lietotajs' ORDER BY h.Datums DESC";
$horoskopu_result = mysqli_query($savienojums, $horoskopu_sql);
$horoskopi = [];
while ($rinda = mysqli_fetch_assoc($horoskopu_result)) {
    $horoskopi[] = $rinda;
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horoskopu Vēsture</title>
    <link rel="stylesheet" type="text/css" href="../public/spelesstyles.css">
    <link rel="icon" type="image/x-icon" href="https://poetry4kids.com/wp-content/uploads/2021/09/I-Think-Id-Like-to-Get-a-Pet-icon-300x300.png">
    <script src="../public/muzika.js"></script>
</head>
<body>
    <a href="horoskops.php" class="btn">Atpakaļ</a>
    <div class="speles-container">
    <div class="transakcijash2">
        <h2>Horoskopu Vēsture</h2>
    </div>
        <div class="transakcijas-container">
            <table class="transakcijas-table">
                <tr>
                    <th>Datums</th>
                    <th>Teksts</th>
                    <th>Noskaņa</th>
                </tr>
                <?php foreach ($horoskopi as $horoskops): ?>
                <tr>
                    <td><?php echo htmlspecialchars($horoskops['Datums']); ?></td>
                    <td><?php echo htmlspecialchars($horoskops['Teksts']); ?></td>
                    <td><?php echo htmlspecialchars($horoskops['Reakcija']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>
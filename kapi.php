<?php
require("savienojums/connect_db.php");

$sql = "SELECT k.Datums_laiks, l.Lietotajvards, d.Vards, d.Dzivnieks
        FROM kapi k
        JOIN lietotaji l ON k.Lietotajs_ID = l.Lietotajs_ID
        JOIN dzivnieki d ON k.Dzivnieks_ID = d.Dzivnieks_ID
        ORDER BY k.Datums_laiks DESC";
$result = mysqli_query($savienojums, $sql);

$mirusi_dzivnieki = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $mirusi_dzivnieki[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kapsēta</title>
    <link rel="stylesheet" type="text/css" href="public/kapistyles.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
    <link rel='icon' type='image/x-icon' href='https://poetry4kids.com/wp-content/uploads/2021/09/I-Think-Id-Like-to-Get-a-Pet-icon-300x300.png'>
    <script src="/tamagochi/public/atmosfera.js"></script>
</head>
<body>
    <div class="speles-container">
        <h2 class="transakcijash2">Kapsēta</h2>
        <?php if (!empty($mirusi_dzivnieki)): ?>
            <div class="transakcijas-container">
            <table class="transakcijas-table">
                <tr>
                    <th>Dzīvnieka vārds</th>
                    <th>Dzīvnieks</th>
                    <th>Dzīvnieka attēls</th>
                    <th>Īpašnieka vārds</th>
                    <th>Datums un laiks</th>
                </tr>
                <?php foreach ($mirusi_dzivnieki as $dzivnieks): ?>
                <tr>
                    <td><?php echo htmlspecialchars($dzivnieks['Vards']); ?></td>
                    <td><?php echo htmlspecialchars($dzivnieks['Dzivnieks']); ?></td>
                    <td>
                        <?php
                        $dzivnieksBilde = '';
                        switch ($dzivnieks['Dzivnieks']) {
                            case 'Suns':
                                $dzivnieksBilde = 'public/suns.png';
                                break;
                            case 'Kakis':
                                $dzivnieksBilde = 'public/kakis.png';
                                break;
                            case 'Zakis':
                                $dzivnieksBilde = 'public/zakis.png';
                                break;
                        }
                        ?>
                        <img src="<?php echo htmlspecialchars($dzivnieksBilde); ?>" alt="Dzīvnieka attēls" class="dzivnieka-attels" height="120px" width="80px">
                    </td>
                    <td><?php echo htmlspecialchars($dzivnieks['Lietotajvards']); ?></td>
                    <td><?php echo htmlspecialchars($dzivnieks['Datums_laiks']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Nav mirušo dzīvnieku.</p>
        <?php endif; ?>
        </div>
        </div>
    </div>
    <a href='index.php' class='btn'>Atpakaļ</a>
</body>
</html>
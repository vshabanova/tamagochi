<?php 
session_start();
require("savienojums/connect_db.php");

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];
$Lietotajvards = $_SESSION['autorizejies'];

// sanem lietotaja naudu
$nauda_sql = "SELECT Nauda FROM lietotaji WHERE Lietotajs_ID='$ID_Lietotajs'";
$nauda_result = mysqli_query($savienojums, $nauda_sql);
$nauda_row = mysqli_fetch_assoc($nauda_result);
$nauda = $nauda_row['Nauda'];

// sanem pieejamos edienus
$nauda_sql = "SELECT Ediens_ID, Nosaukums, Vertiba FROM ediens";
$ediens_result = mysqli_query($savienojums, $nauda_sql);
$edieni = [];
if ($ediens_result && mysqli_num_rows($ediens_result) > 0) {
    while ($row = mysqli_fetch_assoc($ediens_result)) {
        $edieni[] = $row;
    }
} else {
    echo "Error: " . mysqli_error($savienojums);
}
$naudasBilde = 'public/kapeika.png';
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veikals</title>
    <link rel="stylesheet" type="text/css" href="public/spelesstyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="https://poetry4kids.com/wp-content/uploads/2021/09/I-Think-Id-Like-to-Get-a-Pet-icon-300x300.png">
    <script>
        function atjaunotKopejoCenu() {
            const daudzumi = document.querySelectorAll('input[type="number"]');
            let kopejaCena = 0;

            daudzumi.forEach(input => {
                const cena = parseFloat(input.dataset.cena);
                const daudzums = parseInt(input.value);
                kopejaCena += cena * daudzums;
            });

            document.getElementById('kopeja-cena').innerText = kopejaCena.toFixed(2);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const daudzumi = document.querySelectorAll('input[type="number"]');
            daudzumi.forEach(input => {
                input.addEventListener('input', atjaunotKopejoCenu);
            });

            atjaunotKopejoCenu();
        });
    </script>
</head>
<body>
    <div class="speles-container">
<div class="veikals-nauda">
    <h2>Veikals</h2>
</div>
<div class="naudas">
        <div class="naudasAttrib"><img id="naudasBilde" src="<?php echo $naudasBilde; ?>" alt="Nauda" class="naudasBilde"> <span id="nauda"><?php echo $nauda; ?></span></div>
    </div>
        <div class="veikals-container">
            <form id="buyForm" action="pirkums.php" method="post">
                <table class="veikals-table">
                    <tr>
                        <th>Ēdiena Nosaukums</th>
                        <th>Vērtība (Cena)</th>
                        <th>Daudzums</th>
                    </tr>
                    <?php foreach ($edieni as $ediens): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ediens['Nosaukums']); ?></td>
                        <td><?php echo htmlspecialchars($ediens['Vertiba']); ?></td>
                        <td>
                            <input type="number" name="daudzums[<?php echo $ediens['Ediens_ID']; ?>]" min="0" value="0" data-cena="<?php echo $ediens['Vertiba']; ?>">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <div style="margin-top: 20px; text-align: center;">
                <strong>Kopējās izmaksas: </strong><span id="kopeja-cena">0.00</span>
            </div>
                <div class="veikals-back">
                    <button type="submit" class="dropbtnpirkt">Pirkt</button>
                </div>
            </form>
        </div>
    </div>
    <a href="home.php" class="btn">Atpakaļ</a>
</body>
</html>
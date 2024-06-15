<?php
session_start();
require("savienojums/connect_db.php");

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];
$Lietotajvards = $_SESSION['autorizejies'];

// sanem lietotaja tagadejo naudu
$nauda_sql = "SELECT Nauda FROM lietotaji WHERE Lietotajs_ID='$ID_Lietotajs'";
$nauda_result = mysqli_query($savienojums, $nauda_sql);
$nauda_row = mysqli_fetch_assoc($nauda_result);
$tagadeja_nauda = $nauda_row['Nauda'];

// edienus ko velas pirkt
$ediens_sql = "SELECT Ediens_ID, Vertiba FROM ediens";
$ediens_result = mysqli_query($savienojums, $ediens_sql);
$ediena_cena = [];
while ($row = mysqli_fetch_assoc($ediens_result)) {
    $ediena_cena[$row['Ediens_ID']] = $row['Vertiba'];
}

$kopeja_cena = 0;
$pirkti_edieni = [];

// aprekina kopejo summu pirkumam
foreach ($_POST['daudzums'] as $edien_id => $daudzums) {
    if ($daudzums > 0) {
        $cena = $ediena_cena[$edien_id] * $daudzums;
        $kopeja_cena += $cena;
        $pirkti_edieni[$edien_id] = $daudzums;
    }
}
    // atnemt vinam naudu
    $cita_nauda = $tagadeja_nauda - $kopeja_cena;
    $atjaunot_naudu_sql = "UPDATE lietotaji SET Nauda='$cita_nauda' WHERE Lietotajs_ID='$ID_Lietotajs'";
    if (mysqli_query($savienojums, $atjaunot_naudu_sql)) {
        // pievieno edienus ledusskapim
        foreach ($pirkti_edieni as $edien_id => $daudzums) {
            $pastavosh_ediens_sql = "SELECT Daudzums FROM ledusskapis WHERE Lietotajs_ID='$ID_Lietotajs' AND Ediens_ID='$edien_id'";
            $pastavosh_ediens_result = mysqli_query($savienojums, $pastavosh_ediens_sql);
            if (mysqli_num_rows($pastavosh_ediens_result) > 0) {
                // atjaunina daudzumu
                $pastavosh_ediens_row = mysqli_fetch_assoc($pastavosh_ediens_result);
                $jauns_daudzums = $pastavosh_ediens_row['Daudzums'] + $daudzums;
                $atjaunot_edienu_sql = "UPDATE ledusskapis SET Daudzums='$jauns_daudzums' WHERE Lietotajs_ID='$ID_Lietotajs' AND Ediens_ID='$edien_id'";
                mysqli_query($savienojums, $atjaunot_edienu_sql);
            } else {
                // pievieno edienu
                $pievienot_edienu_sql = "INSERT INTO ledusskapis (Lietotajs_ID, Ediens_ID, Daudzums) VALUES ('$ID_Lietotajs', '$edien_id', '$daudzums')";
                mysqli_query($savienojums, $pievienot_edienu_sql);
            }
            // ieraksta transakciju
            $tagadejais_laiks = date('Y-m-d H:i:s');
            $transakcija_sql = "INSERT INTO transakcijas (Lietotajs_ID, Ediens_ID, Daudzums, Nauda, Datums_laiks) VALUES ('$ID_Lietotajs', '$edien_id', '$daudzums', '{$ediena_cena[$edien_id]}', '$tagadejais_laiks')";
            mysqli_query($savienojums, $transakcija_sql);
        }
    } else {
        echo "Kļūda atjauninot naudu: " . mysqli_error($savienojums);
    }
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pirkuma apstiprinājums</title>
    <link rel="stylesheet" type="text/css" href="public/spelesstyles.css">
</head>
<body>
    <div class="speles-container">
        <h2 style="text-align: center;">Pirkuma apstiprinājums</h2>
        <!-- skatas vai lietotajam vsp ir nauda lai pirktu -->
        <p><?php echo ($kopeja_cena > $tagadeja_nauda) ? "Nepietiek naudas." : "Pirkums veiksmīgs!"; ?></p>
        <meta http-equiv="refresh" content="2;url=veikals.php">
    </div>
</body>
</html>
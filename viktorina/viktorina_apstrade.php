<?php
session_start();
require("../savienojums/connect_db.php");
require("../sasniegumi/sasniegumi.php");

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jautajumi_sql = "SELECT * FROM jautajumu_banka";
    $jautajumi_result = mysqli_query($savienojums, $jautajumi_sql);

    $pareizas_atbildes = 0;
    $kopskaits = 0;

    while ($jautajums = mysqli_fetch_assoc($jautajumi_result)) {
        $jautajums_id = $jautajums['Jautajums_ID'];
        $pareiza_atbilde_sql = "SELECT Atbilde FROM atbildes WHERE Jautajums_ID = '$jautajums_id'";
        $pareiza_atbilde_result = mysqli_query($savienojums, $pareiza_atbilde_sql);
        $pareiza_atbilde = mysqli_fetch_assoc($pareiza_atbilde_result)['Atbilde'];

        if (isset($_POST['atbilde'][$jautajums_id]) && $_POST['atbilde'][$jautajums_id] === $pareiza_atbilde) {
            $pareizas_atbildes++;
        }
        $kopskaits++;
    }

    $_SESSION['pareizas_atbildes'] = $pareizas_atbildes;
    $_SESSION['kopskaits'] = $kopskaits;

    if ($pareizas_atbildes === $kopskaits) {
        apbalvotLietotaju($savienojums, $ID_Lietotajs, 'viktorina_izpildita');
    }

    $_SESSION['viktorina_pabeigta'] = true;

    $sql = "UPDATE lietotaji SET Viktorina_Pareizas_Atbildes = $pareizas_atbildes, Viktorina_Kopskaits = $kopskaits, Viktorina_Pabeigta = 1 WHERE Lietotajs_ID = '$ID_Lietotajs'";
    mysqli_query($savienojums, $sql);

    if ($pareizas_atbildes === $kopskaits) {
        apbalvotLietotaju($savienojums, $ID_Lietotajs, 'viktorina_izpildita');
    }

    $nauda_par_atbildi = 15;
    $kop_nauda = $pareizas_atbildes * $nauda_par_atbildi;

    $sql = "UPDATE lietotaji SET Nauda = Nauda + $kop_nauda WHERE Lietotajs_ID = '$ID_Lietotajs'";
    mysqli_query($savienojums, $sql);

    $_SESSION['pareizas_atbildes'] = $pareizas_atbildes;
    $_SESSION['kopskaits'] = $kopskaits;

    header('Location: viktorina_rezultati.php');
    exit;
}
?>
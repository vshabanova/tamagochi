<?php
session_start();
require("savienojums/connect_db.php");
require("sasniegumi/sasniegumi.php");

$response = "";

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];

$laiks = time();

if (isset($_SESSION['pedeja_reize_guleta'])) {
    $pedeja_reize_guleta = $_SESSION['pedeja_reize_guleta'];
    $laiks_pagajis = $laiks - $last_sleep_time;

    if ($laiks_pagajis < 12 * 60) {
        $laiks_palicis = 12 * 60 - $laiks_pagajis;
        echo "cooldown,$laiks_palicis";
        exit;
    }
}

$_SESSION['pedeja_reize_guleta'] = $laiks;

$sql = "SELECT Bada_limenis, Labsajutas_limenis, Reizes_gulets FROM dzivnieki WHERE ID_Lietotajs='$ID_Lietotajs'";
$result = mysqli_query($savienojums, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $bada_limenis = $row['Bada_limenis'];
    $labsajutas_limenis = $row['Labsajutas_limenis'];
    $reizes_gulets = $row['Reizes_gulets'];
} else {
    echo "nav_dziv";
    exit;
}

$bada_limenis = max(0, $bada_limenis - 30);
$labsajutas_limenis = min(100, $labsajutas_limenis + 30);
$reizes_gulets++;

$sql = "UPDATE dzivnieki SET Bada_limenis='$bada_limenis', Labsajutas_limenis='$labsajutas_limenis', Reizes_gulets='$reizes_gulets' WHERE ID_Lietotajs='$ID_Lietotajs'";
if (mysqli_query($savienojums, $sql)) {
    $response = "success,$bada_limenis,$labsajutas_limenis,$reizes_gulets";
} else {
    $response = "error," . mysqli_error($savienojums);
}

echo $response;
?>
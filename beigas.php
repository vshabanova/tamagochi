<?php
session_start();
require("savienojums/connect_db.php");

if (!isset($_SESSION['Lietotajs_ID'])) {
    header("Location: login.php");
    exit;
}

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];

$sql = "SELECT Dzivnieks_ID, Bada_limenis, Labsajutas_limenis FROM dzivnieki WHERE ID_Lietotajs='$ID_Lietotajs'";
$result = mysqli_query($savienojums, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $ID_Dzivnieks = $row['Dzivnieks_ID'];
    $bada_limenis = $row['Bada_limenis'];
    $labsajutas_limenis = $row['Labsajutas_limenis'];

    if ($bada_limenis == 0 || $labsajutas_limenis == 0) {
        $laiks = date('Y-m-d H:i:s');
        $insert_kapi_sql = "INSERT INTO kapi (Lietotajs_ID, Dzivnieks_ID, Datums_laiks) VALUES ('$ID_Lietotajs', '$ID_Dzivnieks', '$laiks')";
        mysqli_query($savienojums, $insert_kapi_sql);

        $dzest_sasniegumus_sql = "DELETE FROM sasniegumi WHERE Lietotajs_ID='$ID_Lietotajs'";
        mysqli_query($savienojums, $dzest_sasniegumus_sql);

        $dzest_edienu_sql = "DELETE FROM ledusskapis WHERE Lietotajs_ID='$ID_Lietotajs'";
        mysqli_query($savienojums, $dzest_edienu_sql);

        session_unset();
        session_destroy();

        header("Location: speles_beigas.php");
        exit;
    } else {
        echo "Jūsu mājdzīvnieks joprojām ir dzīvs.";
    }
} else {
    echo "Error: " . mysqli_error($savienojums);
}
?>
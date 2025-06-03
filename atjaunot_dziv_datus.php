<?php
session_start();
require("savienojums/connect_db.php");

if (!isset($_SESSION['Lietotajs_ID'])) {
    echo "not_logged_in";
    exit;
}

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['badaLimenis']) && isset($_POST['labsajutasLimenis']) && isset($_POST['nauda'])) {
        $bada_limenis = intval($_POST['badaLimenis']);
        $labsajutas_limenis = intval($_POST['labsajutasLimenis']);
        $nauda = intval($_POST['nauda']);

        $sql_dzivnieki = "UPDATE dzivnieki SET Bada_limenis='$bada_limenis', Labsajutas_limenis='$labsajutas_limenis' WHERE ID_Lietotajs='$ID_Lietotajs'";
        $result_dzivnieki = mysqli_query($savienojums, $sql_dzivnieki);

        $sql_nauda = "UPDATE lietotaji SET Nauda='$nauda' WHERE Lietotajs_ID='$ID_Lietotajs'";
        $result_nauda = mysqli_query($savienojums, $sql_nauda);

        if ($result_dzivnieki && $result_nauda) {
            echo "success";
        } else {
            echo "update_error: " . mysqli_error($savienojums);
        }
    } else {
        echo "invalid_data";
    }
} else {
    echo "invalid_request_method";
}
?>
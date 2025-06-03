<?php
session_start();
require("savienojums/connect_db.php");

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];

if (!isset($_SESSION['gulet_solis'])) {
    echo json_encode(["status" => "not_started"]);
    exit;
}

$solis = $_SESSION['gulet_solis'];

if ($solis >= 6) {
    unset($_SESSION['gulet_solis']);
    echo json_encode(["status" => "done"]);
    exit;
}

$sql = "SELECT Bada_limenis, Labsajutas_limenis, Reizes_gulets FROM dzivnieki WHERE ID_Lietotajs='$ID_Lietotajs'";
$result = mysqli_query($savienojums, $sql);
$row = mysqli_fetch_assoc($result);

$bada = max(0, $row['Bada_limenis'] - 5);  // Reduce hunger by 5 (minimum 0)
$labsajuta = min(100, $row['Labsajutas_limenis'] + 5);  // Increase happiness by 5 (maximum 100)

mysqli_query($savienojums, "UPDATE dzivnieki SET Bada_limenis='$bada', Labsajutas_limenis='$labsajuta' WHERE ID_Lietotajs='$ID_Lietotajs'");

$_SESSION['gulet_solis']++;

if ($_SESSION['gulet_solis'] == 6) {
    $reizes = $row['Reizes_gulets'] + 1;
    mysqli_query($savienojums, "UPDATE dzivnieki SET Reizes_gulets='$reizes' WHERE ID_Lietotajs='$ID_Lietotajs'");
}

echo json_encode([
    "status" => "progress",
    "solis" => $_SESSION['gulet_solis'],
    "bads" => $bada,
    "labsajuta" => $labsajuta
]);
?>
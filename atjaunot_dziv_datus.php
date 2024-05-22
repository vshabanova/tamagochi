<?php
session_start();
require("savienojums/connect_db.php");

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bada_limenis = $_POST['badaLimenis'];
    $labsajutas_limenis = $_POST['labsajutasLimenis'];

    $sql = "UPDATE dzivnieki SET Bada_limenis='$bada_limenis', Labsajutas_limenis='$labsajutas_limenis' WHERE ID_Lietotajs='$ID_Lietotajs'";
    
    if (mysqli_query($savienojums, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($savienojums);
    }
}
?>
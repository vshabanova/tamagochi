<?php
session_start();
require("savienojums/connect_db.php");

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];

// Atzīmē, ka dzīvnieks tagad guļ
$_SESSION['gulet_solis'] = 0;

echo json_encode([
    "status" => "ok", 
    "soli" => 6,
    "message" => "Gulēšana sākta"
]);
?>
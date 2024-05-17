<?php
$host = "localhost";
$username = "root";
$password = "";
$db = "2024_proj_dzivnieki";


$savienojums = mysqli_connect($host, $username, $password, $db);
mysqli_set_charset($savienojums, "utf8");


if (!$savienojums) {
    die("KĻŪDA: " . mysqli_connect_error());
}
?>
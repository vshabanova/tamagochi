<?php 
session_start();
require("savienojums/connect_db.php");

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];

$sql = "SELECT Bada_limenis, Labsajutas_limenis, Vards, Dzivnieks FROM dzivnieki WHERE ID_Lietotajs='$ID_Lietotajs'";
$rezultats = mysqli_query($savienojums, $sql);
$dzivDati = mysqli_fetch_assoc($rezultats);

$bada_limenis = $dzivDati['Bada_limenis'];
$labsajutas_limenis = $dzivDati['Labsajutas_limenis'];
$vards = $dzivDati['Vards'];
$dzivnieks = $dzivDati['Dzivnieks'];

$dzivBilde = '';
switch($dzivnieks) {
    case "Suns":
        $dzivBilde = "public/suns.png";
        break;
    case "Kakis":
        $dzivBilde = "public/kakis.png";
        break;
    case "Zakis":
        $dzivBilde = "public/zakis.png";
        break;
    default:
    break;
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pabaro savu mājdzīvnieku</title>
    <link rel="stylesheet" type="text/css" href="public/spelesstyles.css">
    <link rel="icon" type="image/x-icon" href="https://poetry4kids.com/wp-content/uploads/2021/09/I-Think-Id-Like-to-Get-a-Pet-icon-300x300.png">
    <style>
        .konteiners {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 20px;
        }
        .dzivBilde {
            max-width: 200px;
            height: auto;
        }
        .dzivInfo {
            margin-left: 20px;
        }
        .divAttrib {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="speles-container">
        <div class="konteiners">
            <img id="dzivBilde" src="<?php echo $dzivBilde; ?>" alt="Pet" class="dzivBilde">
            <div class="dzivInfo">
                <div class="divAttrib">Vārds: <span id="petName"><?php echo htmlspecialchars($vards); ?></span></div>
                <div class="divAttrib">Bada līmenis: <span id="bada_limenis"><?php echo $bada_limenis; ?></span></div>
                <div class="divAttrib">Labsajūtas līmenis: <span id="labsajutas_limenis"><?php echo $labsajutas_limenis; ?></span></div>
                <div class="dropbtniziet"><a href='logout.php'>Iziet</a></div>
            </div>
        </div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    let badaLimenis = parseInt(localStorage.getItem("badaLimenis"));
    if (isNaN(badaLimenis)) {
        badaLimenis = <?php echo $bada_limenis; ?>;
    }
    
    let labsLimenis = parseInt(localStorage.getItem("labsLimenis"));
    if (isNaN(labsLimenis)) {
        labsLimenis = <?php echo $labsajutas_limenis; ?>;
    }

    document.getElementById("bada_limenis").innerText = badaLimenis;
    document.getElementById("labsajutas_limenis").innerText = labsLimenis;

    atjaunotDzivDatus(badaLimenis, labsLimenis);

    setInterval(function() {
        badaLimenis = parseInt(document.getElementById("bada_limenis").innerText);
        labsLimenis = parseInt(document.getElementById("labsajutas_limenis").innerText);
        
        atjaunotDzivDatus(badaLimenis, labsLimenis);
    }, 30000);
});

function atjaunotDzivDatus(badaLimenis, labsLimenis) {
    badaLimenis = Math.max(0, badaLimenis - 1);
    labsLimenis = Math.max(0, labsLimenis - 1);
    
    document.getElementById("bada_limenis").innerText = badaLimenis;
    document.getElementById("labsajutas_limenis").innerText = labsLimenis;

    localStorage.setItem("badaLimenis", badaLimenis);
    localStorage.setItem("labsLimenis", labsLimenis);
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "atjaunot_dziv_datus.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("badaLimenis=" + badaLimenis + "&labsajutasLimenis=" + labsLimenis);
}</script>
</body>
</html>
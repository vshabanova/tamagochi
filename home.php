<?php 
session_start();
require("savienojums/connect_db.php");

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];
$Lietotajvards = $_SESSION['autorizejies'];

$sql = "SELECT Bada_limenis, Labsajutas_limenis, Vards, Dzivnieks FROM dzivnieki WHERE ID_Lietotajs='$ID_Lietotajs'";
$result = mysqli_query($savienojums, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $bada_limenis = $row['Bada_limenis'];
    $labsajutas_limenis = $row['Labsajutas_limenis'];
    $vards = $row['Vards'];
    $dzivnieks = $row['Dzivnieks'];
} else {
    echo "Error: " . mysqli_error($savienojums);
}
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
        $dzivBilde = "public/default.png";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="https://poetry4kids.com/wp-content/uploads/2021/09/I-Think-Id-Like-to-Get-a-Pet-icon-300x300.png">
</head>
<body>
    <div class="speles-container">
        <div class="konteiners">
            <img id="dzivBilde" src="<?php echo $dzivBilde; ?>" alt="Pet" class="dzivBilde">
            <div class="dzivInfo">
                <div class="divAttrib">Dzīvnieka vārds: <span id="Vards"><?php echo htmlspecialchars($vards); ?></span></div>
                <div class="divAttrib">Īpašnieka vārds: <span id="Lietotajvards"><?php echo htmlspecialchars($Lietotajvards); ?></span></div>
                <div class="divAttrib">Bada līmenis: <span id="bada_limenis"><?php echo $bada_limenis; ?></span></div>
                <div class="divAttrib">Labsajūtas līmenis: <span id="labsajutas_limenis"><?php echo $labsajutas_limenis; ?></span></div>
                <div class="dropbtniziet"><a href='logout.php'>Iziet</a></div>
            </div>
        </div>
        <div class="pogas">
            <div class="dropbtnizvelne"><a href='veikals.php'><i class='fa fa-store'></i>Veikals</a></div>
            <div class="dropbtnizvelne"><a href='ledusskapis.php'><i class="fa-solid fa-bowl-food"></i>Ledusskapis</a></div>
            <div class="dropbtnizvelne"><a href='sasniegumi.php'><i class="fa fa-star"></i>Sasniegumi</a></div>
        </div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    let badaLimenis = <?php echo $bada_limenis; ?>;
    let labsajutasLimenis = <?php echo $labsajutas_limenis; ?>;

    function atjaunotDzivDatus() {
        badaLimenis = Math.max(0, badaLimenis - 1);
        labsajutasLimenis = Math.max(0, labsajutasLimenis - 1);

        document.getElementById("bada_limenis").innerText = badaLimenis;
        document.getElementById("labsajutas_limenis").innerText = labsajutasLimenis;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "atjaunot_dziv_datus.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log("Dati atjaunoti");
                } else {
                    console.error("Kluda: " + xhr.statusText);
                }
            }
        };
        xhr.send("badaLimenis=" + badaLimenis + "&labsajutasLimenis=" + labsajutasLimenis);
    }

    atjaunotDzivDatus();

    setInterval(atjaunotDzivDatus, 30000);
});
</script>
</body>
</html>
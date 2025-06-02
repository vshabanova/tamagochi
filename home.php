<?php 
session_start();
require("savienojums/connect_db.php");
require("sasniegumi/sasniegumi.php");

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];
$Lietotajvards = $_SESSION['Lietotajvards'];

$sql_dzivnieks = "SELECT Bada_limenis, Labsajutas_limenis, Reizes_gulets, Vards, Dzivnieks FROM dzivnieki WHERE ID_Lietotajs='$ID_Lietotajs'";
$result_dzivnieks = mysqli_query($savienojums, $sql_dzivnieks);

if ($result_dzivnieks && mysqli_num_rows($result_dzivnieks) > 0) {
    $row_dzivnieks = mysqli_fetch_assoc($result_dzivnieks);
    $bada_limenis = $row_dzivnieks['Bada_limenis'];
    $labsajutas_limenis = $row_dzivnieks['Labsajutas_limenis'];
    $reizes_gulets = $row_dzivnieks['Reizes_gulets'];
    $vards = $row_dzivnieks['Vards'];
    $dzivnieks = $row_dzivnieks['Dzivnieks'];

    if ($bada_limenis == 0 || $labsajutas_limenis == 0) {
        header("Location: beigas.php");
        exit;
    }
} else {
    echo "Error: " . mysqli_error($savienojums);
}

$sql_nauda = "SELECT Nauda FROM lietotaji WHERE Lietotajs_ID='$ID_Lietotajs'";
$result_nauda = mysqli_query($savienojums, $sql_nauda);

if ($result_nauda && mysqli_num_rows($result_nauda) > 0) {
    $row_nauda = mysqli_fetch_assoc($result_nauda);
    $nauda = $row_nauda['Nauda'];
} else {
    echo "Error: " . mysqli_error($savienojums);
}

$dzivBilde = '';
$naudasBilde = 'public/kapeika.png';
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


apbalvotLietotaju($savienojums, $ID_Lietotajs, 'spele_sakta');

if ($labsajutas_limenis <= 70) {
    apbalvotLietotaju($savienojums, $ID_Lietotajs, 'labsajuta_krities', ['Labsajutas_limenis' => $labsajutas_limenis]);
}

if ($reizes_gulets == 1) {
    apbalvotLietotaju($savienojums, $ID_Lietotajs, 'dziv_gulejis', ['Reizes_gulets' => $reizes_gulets]);
}
if ($reizes_gulets == 5) {
    apbalvotLietotaju($savienojums, $ID_Lietotajs, 'dziv_gulejis', ['Reizes_gulets' => $reizes_gulets]);
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
    <script src="/tamagochi/public/muzika.js"></script>
</head>
<body>
    <div class="speles-container">
    <div class="nauda">
    <div class="naudasAttrib"><img id="naudasBilde" src="<?php echo $naudasBilde; ?>" alt="Nauda" class="naudasBilde"> <span id="nauda"><?php echo $nauda; ?></span></div>
    </div>
        <div class="konteiners">
            <img id="dzivBilde" src="<?php echo $dzivBilde; ?>" alt="Pet" class="dzivBilde">
            <div class="dzivInfo">
                <div class="divAttrib">Dzīvnieka vārds: <span id="Vards"><?php echo htmlspecialchars($vards); ?></span></div>
                <div class="divAttrib">Īpašnieka vārds: <span id="Lietotajvards"><?php echo htmlspecialchars($Lietotajvards); ?></span></div>
                <div class="divAttrib">Bada līmenis: <span id="bada_limenis"><?php echo $bada_limenis; ?></span></div>
                <div class="divAttrib">Labsajūtas līmenis: <span id="labsajutas_limenis"><?php echo $labsajutas_limenis; ?></span></div>
                <div class="dropbtngulet">
                    <button id="guletPoga" onclick="gulet()"><i class="fa fa-moon"></i> Gulēt</button>
                </div>
                <div class="dropbtniziet"><a href='logout.php'>Iziet</a></div>
            </div>
        </div>
        <div class="pogas">
            <div class="dropbtnizvelne"><a href='veikals/veikals.php'><i class='fa fa-store'></i>Veikals</a></div>
            <div class="dropbtnizvelne"><a href='ledusskapis/ledusskapis.php'><i class="fa-solid fa-bowl-food"></i>Ledusskapis</a></div>
            <div class="dropbtnizvelne"><a href='sasniegumi/sasniegumiapskatit.php'><i class="fa fa-star"></i>Sasniegumi</a></div>
            <div class="dropbtnizvelne"><a href='horoskops/horoskops.php'><i class="fa fa-moon"></i>Horoskops</a></div>
            <div class="dropbtnizvelne"><a href='viktorina/viktorina.php'><i class="fa fa-question"></i>Viktorīna</a></div>
        </div>
    </div>
<script>
        document.addEventListener("DOMContentLoaded", function() {
            let badaLimenis = <?php echo $bada_limenis; ?>;
            let labsajutasLimenis = <?php echo $labsajutas_limenis; ?>;
            let nauda = <?php echo $nauda; ?>;
            let pedejaReizeGuleta = <?php echo isset($_SESSION['pedeja_reize_guleta']) ? $_SESSION['pedeja_reize_guleta'] : 0; ?>;
            let guletInterval = null;
            const guletPoga = document.getElementById('guletPoga');

            function atjaunotDzivDatusFrontend() {
            document.getElementById("bada_limenis").innerText = badaLimenis;
            document.getElementById("labsajutas_limenis").innerText = labsajutasLimenis;
            document.getElementById("nauda").innerText = nauda;
        }

            function atjaunotDzivDatus() {
                badaLimenis = Math.max(0, badaLimenis - 1);
                labsajutasLimenis = Math.max(0, labsajutasLimenis - 1);
                nauda += 5;

                document.getElementById("bada_limenis").innerText = badaLimenis;
                document.getElementById("labsajutas_limenis").innerText = labsajutasLimenis;
                document.getElementById("nauda").innerText = nauda;

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
                xhr.send("badaLimenis=" + badaLimenis + "&labsajutasLimenis=" + labsajutasLimenis + "&nauda=" + nauda);
            }
            function guletSolis() {
            fetch("gulet_update.php")
                .then(res => res.json())
                .then(data => {
                    if (data.status === "progress") {
                        badaLimenis = data.bads;
                        labsajutasLimenis = data.labsajuta;
                        atjaunotDzivDatusFrontend();
                        guletPoga.innerHTML = `<i class="fa fa-moon"></i> Guļ (${data.solis}/6)`;
                    } else if (data.status === "done") {
                        if (guletInterval) {
                            clearInterval(guletInterval);
                            guletInterval = null;
                        }
                        guletPoga.disabled = false;
                        guletPoga.innerHTML = `<i class="fa fa-moon"></i> Gulēt`;
                        alert("Gulēšana pabeigta!");
                    }
                });
        }
            atjaunotDzivDatusFrontend();

            guletPoga.addEventListener("click", function() {
                guletPoga.disabled = true;
                guletPoga.innerHTML = `<i class="fa fa-moon"></i> Guļ (0/6)`;
                guletInterval = setInterval(guletSolis, 2000);
                
                fetch("sakt_gulet.php")
                    .then(res => res.json())
                    .then(data => {
                        if (data.status !== "ok") {
                            alert("Kļūda: Neizdevās sākt gulēt");
                            guletPoga.disabled = false;
                            guletPoga.innerHTML = `<i class="fa fa-moon"></i> Gulēt`;
                            if (guletInterval) {
                                clearInterval(guletInterval);
                                guletInterval = null;
                            }
                        }
                    });
            });

            atjaunotDzivDatus();
            setInterval(atjaunotDzivDatus, 30000);
        });
    </script>
</body>
</html>
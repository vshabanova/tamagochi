<?php
session_start();
require("savienojums/connect_db.php");
require("sasniegumi.php");

if (!isset($_SESSION['Lietotajs_ID'])) {
    echo "Please log in";
    exit;
}

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ediena_id'])) {
        $ediena_id = intval($_POST['ediena_id']);

        $sql = "SELECT Bada_limenis, Labsajutas_limenis FROM dzivnieki WHERE ID_Lietotajs='$ID_Lietotajs'";
        $result = mysqli_query($savienojums, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $bada_limenis = $row['Bada_limenis'];
            $labsajutas_limenis = $row['Labsajutas_limenis'];

            $sql = "SELECT Daudzums, Vertiba, e.Nosaukums FROM ledusskapis l JOIN ediens e ON l.Ediens_ID = e.Ediens_ID WHERE l.Lietotajs_ID='$ID_Lietotajs' AND l.Ediens_ID='$ediena_id'";
            $result = mysqli_query($savienojums, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $daudzums = $row['Daudzums'];
                $vertiba = $row['Vertiba'];
                $ediens = $row['Nosaukums'];

                if ($daudzums > 0) {
                    $bada_limenis = min(100, $bada_limenis + $vertiba);
                    $labsajutas_limenis = min(100, $labsajutas_limenis + $vertiba);

                    $sql = "UPDATE dzivnieki SET Bada_limenis='$bada_limenis', Labsajutas_limenis='$labsajutas_limenis' WHERE ID_Lietotajs='$ID_Lietotajs'";
                    if (mysqli_query($savienojums, $sql)) {
                        $sql = "UPDATE ledusskapis SET Daudzums = Daudzums - 1 WHERE Lietotajs_ID='$ID_Lietotajs' AND Ediens_ID='$ediena_id'";
                        if (mysqli_query($savienojums, $sql)) {
                            $newDaudzums = $daudzums - 1;
                            apbalvotLietotaju($savienojums, $ID_Lietotajs, 'dziv_pabarots', ['Ediens' => $ediens]);
                            echo "<div class='success-message'>Dzīvnieks ir pabarots! Jaunais daudzums: $newDaudzums</div>";
                            exit;
                        } else {
                            echo "<div class='error-message'>Kļūda atjauninot ēdiena daudzumu.</div>";
                            exit;
                        }
                    } else {
                        echo "<div class='error-message'>Kļūda atjauninot dzīvnieka statusu.</div>";
                        exit;
                    }
                } else {
                    echo "<div class='error-message'>Nav pietiekami daudz ēdiena atlikumā.</div>";
                    exit;
                }
            } else {
                echo "<div class='error-message'>Ēdiens netika atrasts.</div>";
                exit;
            }
        } else {
            echo "<div class='error-message'>Dzīvnieks netika atrasts.</div>";
            exit;
        }
    } else {
        echo "<div class='error-message'>Nepareizi dati saņemti.</div>";
        exit;
    }
} else {
    echo "<div class='error-message'>Nepareizs pieprasījuma veids.</div>";
    exit;
}
?>
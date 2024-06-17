<?php
function sanemtSasniegumus($savienojums) {
    $sql = "SELECT * FROM sasniegumu_banka";
    $result = mysqli_query($savienojums, $sql);
    $sasniegumi = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $sasniegumi[] = $row;
    }

    return $sasniegumi;
}

function sanemtLietotajaSasniegumus($savienojums, $ID_Lietotajs) {
    $sql = "SELECT Sasniegums_ID FROM sasniegumi WHERE Lietotajs_ID = '$ID_Lietotajs'";
    $result = mysqli_query($savienojums, $sql);
    $lietotajaSasniegumi = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $lietotajaSasniegumi[] = $row['Sasniegums_ID'];
    }

    return $lietotajaSasniegumi;
}

function apbalvotLietotaju($savienojums, $ID_Lietotajs, $notikums, $notikumaDati = []) {
    $sasniegumi = sanemtSasniegumus($savienojums);
    $lietotajaSasniegumi = sanemtLietotajaSasniegumus($savienojums, $ID_Lietotajs);

    foreach ($sasniegumi as $sasniegums) {
        if (!in_array($sasniegums['Sasniegums_ID'], $lietotajaSasniegumi)) {
            $sasniegums_ID = $sasniegums['Sasniegums_ID'];
            $balva = false;

            switch ($sasniegums_ID) {
                case 1:
                    if ($notikums === 'spele_sakta') {
                        $balva = true;
                    }
                    break;
                case 2:
                    if ($notikums === 'dziv_gulejis' && isset($notikumaDati['Reizes_gulets']) && $notikumaDati['Reizes_gulets'] == 1) {
                        $balva = true;
                    }
                    break;
                case 3:
                    if ($notikums === 'dziv_pabarots' && $notikumaDati['Ediens'] === 'Burkans') {
                        $balva = true;
                    }
                    break;
                case 4:
                    if ($notikums === 'dziv_gulejis' && isset($notikumaDati['Reizes_gulets']) && $notikumaDati['Reizes_gulets'] == 5) {
                        $balva = true;
                    }
                    break;
                case 5:
                    if ($notikums === 'dziv_pabarots' && $notikumaDati['Ediens'] === 'Burger') {
                        $balva = true;
                    }
                    break;
                case 6:
                    if ($notikums === 'dziv_pabarots' && $notikumaDati['Ediens'] === 'Piens') {
                        $balva = true;
                    }
                    break;
                case 7:
                    if ($notikums === 'labsajuta_krities' && isset($notikumaDati['Labsajutas_limenis']) && $notikumaDati['Labsajutas_limenis'] < 70) {
                        $balva = true;
                    }
                    break;
                case 8:
                    if ($notikums === 'viktorina_izpildita') {
                        $balva = true;
                    }
                    break;
            }

            if ($balva) {
                $vertiba = $sasniegums['Vertiba'];
                $sql = "UPDATE lietotaji SET Nauda = Nauda + $vertiba WHERE Lietotajs_ID = '$ID_Lietotajs'";
                if (mysqli_query($savienojums, $sql)) {
                    $sql = "INSERT INTO sasniegumi (Lietotajs_ID, Sasniegums_ID, Datums_laiks) 
                            VALUES ('$ID_Lietotajs', '$sasniegums_ID', NOW())";
                    $result = mysqli_query($savienojums, $sql);
                    if ($result) {
                        echo "<div class='speles-container'>
                                    <p>Izpildīts sasniegums: " . htmlspecialchars($sasniegums['Nosaukums']) . " - Balva: " . htmlspecialchars($vertiba) . " monētas!</p>
                              </div>";
                    } else {
                            echo "Kļūda pievienojot sasniegumu: " . mysqli_error($savienojums);
                    }
                } else {
                        echo "Kļūda atjauninot naudu: " . mysqli_error($savienojums);
                }
            }
        }
    }
}

function irPirmoReiziApejus($savienojums, $ID_Lietotajs, $ediens) {
    $sql = "SELECT COUNT(*) AS skaits 
            FROM ledusskapis 
            WHERE Lietotajs_ID = '$ID_Lietotajs' 
            AND Ediens_ID = (SELECT Ediens_ID FROM ediens WHERE Nosaukums = '$ediens')";
    
    $result = mysqli_query($savienojums, $sql);
    $row = mysqli_fetch_assoc($result);
    
    return $row['skaits'] == 1;
}
?>
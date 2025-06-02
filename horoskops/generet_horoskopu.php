<?php
header('Content-Type: application/json');

$atbilde = [
    'success' => false,
    'error' => null,
    'data' => [
        'teksts' => null,
        'datums' => date('Y-m-d'),
        'zvaigznajs' => null
    ]
];

try {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['Lietotajs_ID'])) {
        throw new Exception('Lietotājs nav pieslēdzies', 401);
    }

    require_once 'config.php';
    require_once 'horoskopa_generetajs.php';

    $db = new mysqli("localhost", "root", "", "2025_proj_dzivnieki");
    if ($db->connect_error) {
        throw new Exception('Datubāzes savienojuma kļūda', 500);
    }

    // Get user's birth date
    $stmt = $db->prepare("SELECT Dzim_dat FROM lietotaji WHERE Lietotajs_ID = ?");
    if (!$stmt) {
        throw new Exception('Datubāzes pieprasījuma kļūda', 500);
    }

    $stmt->bind_param("i", $_SESSION['Lietotajs_ID']);
    if (!$stmt->execute()) {
        throw new Exception('Neizdevās ielādēt lietotāja datus', 500);
    }

    $rezultats = $stmt->get_result();
    $lietotajs = $rezultats->fetch_assoc();

    if (!$lietotajs || empty($lietotajs['Dzim_dat'])) {
        throw new Exception('Nav pieejams dzimšanas datums', 400);
    }

    $dzimDatums = new DateTime($lietotajs['Dzim_dat']);
    $dzimMenesis = (int)$dzimDatums->format('m');
    $dzimDiena = (int)$dzimDatums->format('d');
    $dzimVertiba = $dzimMenesis * 100 + $dzimDiena;

    $zvaigznajusql = $db->query("
        SELECT 
            Zvaigznajs_ID,
            Nosaukums,
            MONTH(Datums_no) as sakum_menesis,
            DAY(Datums_no) as sakum_diena,
            MONTH(Datums_lidz) as beigu_menesis,
            DAY(Datums_lidz) as beigu_diena
        FROM zvaigznaji
        ORDER BY MONTH(Datums_no), DAY(Datums_no)
    ");

    if (!$zvaigznajusql) {
        throw new Exception("Database query failed: " . $db->error);
    }

    $atrastaZime = null;
    while ($rinda = $zvaigznajusql->fetch_assoc()) {
        $sakumMenesis = (int)$rinda['sakum_menesis'];
        $sakumDiena = (int)$rinda['sakum_diena'];
        $beiguMenesis = (int)$rinda['beigu_menesis'];
        $beiguDiena = (int)$rinda['beigu_diena'];

        $sakumVertiba = $sakumMenesis * 100 + $sakumDiena;
        $beiguVertiba = $beiguMenesis * 100 + $beiguDiena;

        if ($sakumVertiba > $beiguVertiba) {
            if ($dzimVertiba >= $sakumVertiba) {
                $atrastaZime = $rinda;
                break;
            }
            elseif ($dzimVertiba <= $beiguVertiba) {
                $atrastaZime = $rinda;
                break;
            }
        } 
        else {
            if ($dzimVertiba >= $sakumVertiba && $dzimVertiba <= $beiguVertiba) {
                $atrastaZime = $rinda;
                break;
            }
        }
    }

    if (!$atrastaZime) {
        throw new Exception('Zvaigznājs nav atrasts datubāzē', 404);
    }
    
    $generators = new HoroskopuGeneretajs();
    $horoskops = $generators->generetDienasHoroskopu($atrastaZime['Nosaukums'], date('Y-m-d'));
    $noskana = $generators->iegutPedejoNoskanu();
    
    if (empty($horoskops)) {
        throw new Exception('Neizdevās ģenerēt horoskopu', 500);
    }

    $stmt = $db->prepare("INSERT INTO horoskopi (Lietotajs_ID, Zvaigznajs, Datums, Teksts, Reakcija, Izveidots) VALUES (?, ?, ?, ?, ?, NOW())");
    if (!$stmt) {
        throw new Exception('Datubāzes pieprasījuma kļūda', 500);
    }

$stmt->bind_param("iisss", $_SESSION['Lietotajs_ID'], $atrastaZime['Zvaigznajs_ID'], $atbilde['data']['datums'], $horoskops, $noskana);
    if (!$stmt->execute()) {
        throw new Exception('Neizdevās saglabāt horoskopu', 500);
    }

    $bonuss = 0;
    if ($noskana === 'pozitīva') {
        $bonuss = 15;
    } elseif ($noskana === 'negatīva') {
        $bonuss = -15;
    }

    $vaicajums = $db->prepare("SELECT Labsajutas_limenis FROM dzivnieki WHERE ID_Lietotajs = ?");
    if (!$vaicajums) {
        throw new Exception('Datubāzes pieprasījuma kļūda', 500);
    }
    $vaicajums->bind_param("i", $_SESSION['Lietotajs_ID']);
    if (!$vaicajums->execute()) {
        throw new Exception('Neizdevās ielādēt labsajūtas līmeni', 500);
    }
    $rezultats = $vaicajums->get_result();
    $pashreizejaisLimenis = $rezultats->fetch_assoc()['Labsajutas_limenis'] ?? 50;

    $jaunaisLimenis = $pashreizejaisLimenis + $bonuss;
    if ($jaunaisLimenis > 100) {
        $bonuss = 100 - $pashreizejaisLimenis;
        $jaunaisLimenis = 100;
    } elseif ($jaunaisLimenis < 0) {
        $bonuss = -$pashreizejaisLimenis;
        $jaunaisLimenis = 0;
    }

    if ($bonuss != 0) {
        $vaicajums = $db->prepare("UPDATE dzivnieki SET Labsajutas_limenis = ? WHERE ID_Lietotajs = ?");
        if (!$vaicajums) {
            throw new Exception('Datubāzes pieprasījuma kļūda', 500);
        }
        $vaicajums->bind_param("ii", $jaunaisLimenis, $_SESSION['Lietotajs_ID']);
        if (!$vaicajums->execute()) {
            throw new Exception('Neizdevās atjaunināt labsajūtas līmeni', 500);
        }
    }

    $atbilde['data']['bonuss'] = $bonuss;
    $atbilde['success'] = true;
    $atbilde['data']['teksts'] = $horoskops;
    $atbilde['data']['zvaigznajs'] = $atrastaZime['Nosaukums'];
    $atbilde['data']['reakcija'] = $noskana; 

} catch (Exception $e) {
    $atbilde['error'] = [
        'message' => $e->getMessage(),
        'code' => $e->getCode()
    ];
} finally {
    if (isset($db)) {
        $db->close();
    }

    echo json_encode($atbilde);
    exit;
}
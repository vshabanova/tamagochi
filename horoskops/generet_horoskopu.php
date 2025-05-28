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

    $gads = date('Y');
    $d = new DateTime($lietotajs['Dzim_dat']);
    $salidzDatums = $gads . '-' . $d->format('m-d');

    if ($d->format('m-d') === '02-29') {
        $salidzDatums = $gads . '-02-28';
    }

    $stmt = $db->prepare("SELECT Zvaigznajs_ID, Nosaukums FROM zvaigznaji WHERE ? BETWEEN Datums_no AND Datums_lidz");
    if (!$stmt) {
        throw new Exception('Datubāzes pieprasījuma kļūda', 500);
    }

    $stmt->bind_param("s", $salidzDatums);
    if (!$stmt->execute()) {
        throw new Exception('Neizdevās atrast zvaigznāju', 500);
    }

    $zRinda = $stmt->get_result()->fetch_assoc();
    if (!$zRinda) {
        throw new Exception('Zvaigznājs nav atrasts datubāzē', 404);
    }

    $generators = new HoroskopuGeneretajs();
    $horoskops = $generators->generetDienasHoroskopu($zRinda['Nosaukums'], date('Y-m-d'));
    
    if (empty($horoskops)) {
        throw new Exception('Neizdevās ģenerēt horoskopu', 500);
    }

    $stmt = $db->prepare("INSERT INTO horoskopi (Lietotajs_ID, Zvaigznajs, Datums, Teksts, Izveidots) VALUES (?, ?, ?, ?, NOW())");
    if (!$stmt) {
        throw new Exception('Datubāzes pieprasījuma kļūda', 500);
    }

    $stmt->bind_param("iiss", $_SESSION['Lietotajs_ID'], $zRinda['Zvaigznajs_ID'], $atbilde['data']['datums'], $horoskops);
    if (!$stmt->execute()) {
        throw new Exception('Neizdevās saglabāt horoskopu', 500);
    }

    $atbilde['success'] = true;
    $atbilde['data']['teksts'] = $horoskops;
    $atbilde['data']['zvaigznajs'] = $zRinda['Nosaukums'];

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
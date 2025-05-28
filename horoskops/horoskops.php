<?php
require_once 'config.php';
require_once 'horoskopa_generetajs.php';


if (!isset($_SESSION['Lietotajs_ID'])) {
    header("Location: ../home.php");
    exit;
}

$db = new mysqli("localhost", "root", "", "2025_proj_dzivnieki");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$stmt = $db->prepare("SELECT * FROM lietotaji WHERE Lietotajs_ID = ?");
$stmt->bind_param("i", $_SESSION['Lietotajs_ID']);
$stmt->execute();
$result = $stmt->get_result();
$lietotajs = $result->fetch_assoc();

function iegutZvaigznaklu($dzimsanasDatums, $db) {
    if (empty($dzimsanasDatums)) {
        return 'Nezināms';
    }

    $d = new DateTime($dzimsanasDatums);
    $salidzDatums = '2025-' . $d->format('m-d');
    $stmt = $db->prepare("SELECT Nosaukums FROM zvaigznaji WHERE ? BETWEEN Datums_no AND Datums_lidz");
    $stmt->bind_param("s", $salidzDatums);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    return $result['Nosaukums'] ?? 'Nezināms';
}

$today = date('Y-m-d');
$zvaigznaks = iegutZvaigznaklu($lietotajs['Dzim_dat'], $db);

$stmt = $db->prepare("SELECT Teksts FROM horoskopi WHERE Lietotajs_ID = ? AND Datums = ?");
$stmt->bind_param("is", $_SESSION['Lietotajs_ID'], $today);
$stmt->execute();
$result = $stmt->get_result();
$existingHoroscope = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="lv">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pabaro savu mājdzīvnieku</title>
    <link rel="stylesheet" type="text/css" href="../public/spelesstyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="https://poetry4kids.com/wp-content/uploads/2021/09/I-Think-Id-Like-to-Get-a-Pet-icon-300x300.png">
    <script src="/tamagochi/public/muzika.js"></script>
</head>
<body>

    <div class="speles-container">
    <div class="transakcijash2"><h1>Mans horoskops</h1></div>
        <div class="horoskops" id="horoskopsBloks" style="display: none;">
            <div class="datums" id="datums"></div>
            <div class="zvaigznajs">Zodiaka zīme: <?= htmlspecialchars($zvaigznaks) ?></div>
            <div class="teksts"><p id="teksts"></p></div>
        </div>

        <div class="dropbtnizvelne-horoskops">
    <button id="generetBtn" class="dropbtn">Ģenerēt horoskopu</button>
    <div id="loadingIcon" style="display: none;">
        <i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i>
    </div>
    <div id="taimeris"></div>
</div>
</div>
        <a href='../home.php' class='btn'>Atpakaļ</a>


<script>
function saglabatHoroskopu(horoskops) {
    try {
        const horoskopaDati = {
            teksts: horoskops.teksts,
            datums: horoskops.datums,
            zvaigznajs: horoskops.zvaigznajs,
            saglabats: Date.now(),
            lietotajsId: <?= $_SESSION['Lietotajs_ID'] ?? 0 ?>
        };
        localStorage.setItem('horoskops_' + <?= $_SESSION['Lietotajs_ID'] ?? 0 ?>, JSON.stringify(horoskopaDati));
        console.log('Horoskops saglabāts:', horoskopaDati);
    } catch (e) {
        console.error('Kļūda saglabājot horoskopu:', e);
    }
}

function ieladetHoroskopu() {
    try {
        const saglabats = localStorage.getItem('horoskops_' + <?= $_SESSION['Lietotajs_ID'] ?? 0 ?>);
        if (saglabats) {
            const data = JSON.parse(saglabats);
            
            if (!data || !data.teksts || !data.datums) {
                console.error('Nepareizi horoskopa dati:', data);
                localStorage.removeItem('horoskops_' + <?= $_SESSION['Lietotajs_ID'] ?? 0 ?>);
                return;
            }
            
            const sodien = new Date().toISOString().split('T')[0];
            if (data.datums === sodien) {
                attelotHoroskopu(data);
                document.getElementById('horoskopsBloks').style.display = 'block';
                return;
            } else {
                localStorage.removeItem('horoskops_' + <?= $_SESSION['Lietotajs_ID'] ?? 0 ?>);
            }
        }
    } catch (e) {
        console.error('Kļūda ielādējot horoskopu:', e);
    }
    document.getElementById('horoskopsBloks').style.display = 'none';
}

function attelotHoroskopu(horoskops) {
    try {
        document.getElementById('datums').textContent = horoskops.datums;
        document.querySelector('.zvaigznajs').textContent = `Zodiaka zīme: ${horoskops.zvaigznajs}`;
        
        const tekstsElements = document.getElementById('teksts');
        tekstsElements.innerHTML = '';
        
        if (!horoskops.teksts) {
            console.error('Trūkst horoskopa teksta');
            return;
        }
        
        const vardi = horoskops.teksts.trim().split(/\s+/);
        vardi.forEach((vards, indekss) => {
            const span = document.createElement('span');
            span.textContent = vards + ' ';
            span.style.opacity = '0';
            span.style.transition = 'opacity 0.3s ease';
            tekstsElements.appendChild(span);
            
            setTimeout(() => span.style.opacity = '1', indekss * 100);
        });
    } catch (e) {
        console.error('Kļūda attēlojot horoskopu:', e);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    ieladetHoroskopu();
    
    const beiguLaiks = parseInt(localStorage.getItem('taimerisBeigas') || 0);
    if (beiguLaiks > Date.now()) {
        document.getElementById('generetBtn').disabled = true;
        atjaunotTaimeri();
    }
});

document.getElementById('generetBtn').addEventListener('click', function() {
    saktTaimeri();
    paradiIeladi(true);
    ieladetJaunuHoroskopu();
});

function ieladetJaunuHoroskopu() {
    paradiIeladi(true);
    
    fetch('generet_horoskopu.php')
        .then(atbilde => {
            if (!atbilde.ok) {
                throw new Error('Servera atbilde nav korekta');
            }
            return atbilde.json();
        })
        .then(data => {
            if (!data.success || !data.data?.teksts) {
                throw new Error(data.error?.message || 'Nepareiza horoskopa struktūra');
            }
            
            saglabatHoroskopu(data.data);
            attelotHoroskopu(data.data);
            document.getElementById('horoskopsBloks').style.display = 'block';
        })
        .catch(kļūda => {
            console.error('Horoskopa ielādes kļūda:', kļūda);
            alert(kļūda.message || 'Radās kļūda, mēģiniet vēlāk');
        })
        .finally(() => {
            paradiIeladi(false);
        });
}

function saktTaimeri() {
    const btn = document.getElementById('generetBtn');
    const taimeris = document.getElementById('taimeris');
    const beiguLaiks = Date.now() + 10000; // 10 sekundes

    localStorage.setItem('taimerisBeigas', beiguLaiks);
    btn.disabled = true;
    atjaunotTaimeri();
}

function atjaunotTaimeri() {
    const taimeris = document.getElementById('taimeris');
    const btn = document.getElementById('generetBtn');
    const beiguLaiks = parseInt(localStorage.getItem('taimerisBeigas') || 0);
    const atlikusais = Math.ceil((beiguLaiks - Date.now()) / 1000);

    if (atlikusais > 0) {
        taimeris.textContent = `Lūdzu, uzgaidi ${atlikusais} sek.`;
        setTimeout(atjaunotTaimeri, 1000);
    } else {
        taimeris.textContent = '';
        btn.disabled = false;
        btn.textContent = 'Ģenerēt horoskopu';
        localStorage.removeItem('taimerisBeigas');
    }
}

function paradiIeladi(paradit) {
    document.getElementById('loadingIcon').style.display = paradit ? 'block' : 'none';
}
</script>




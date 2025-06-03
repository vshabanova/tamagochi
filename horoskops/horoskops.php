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

$today = date('Y-m-d');
$stmt = $db->prepare("SELECT * FROM horoskopi WHERE Lietotajs_ID = ? AND DATE(Datums) = ?");
$stmt->bind_param("is", $_SESSION['Lietotajs_ID'], $today);
$stmt->execute();
$result = $stmt->get_result();
$alreadyGenerated = $result->num_rows > 0;

$stmt = $db->prepare("SELECT * FROM lietotaji WHERE Lietotajs_ID = ?");
$stmt->bind_param("i", $_SESSION['Lietotajs_ID']);
$stmt->execute();
$result = $stmt->get_result();
$lietotajs = $result->fetch_assoc();

function iegutZvaigznaklu($dzimsanasDatums, $db) {
    if (empty($dzimsanasDatums)) {
        return 'Nezināms';
    }

    try {
        $dzimDatums = new DateTime($dzimsanasDatums);
        $dzimMenesis = (int)$dzimDatums->format('m');
        $dzimDiena = (int)$dzimDatums->format('d');
        $dzimVertiba = $dzimMenesis * 100 + $dzimDiena;

        $result = $db->query("
            SELECT 
                Nosaukums,
                MONTH(Datums_no) as sakum_menesis,
                DAY(Datums_no) as sakum_diena,
                MONTH(Datums_lidz) as beigu_menesis,
                DAY(Datums_lidz) as beigu_diena
            FROM zvaigznaji
            ORDER BY MONTH(Datums_no), DAY(Datums_no)
        ");

        if (!$result) {
            throw new Exception("Database query failed: " . $db->error);
        }

        while ($rinda = $result->fetch_assoc()) {
        $sakumMenesis = (int)$rinda['sakum_menesis'];
        $sakumDiena = (int)$rinda['sakum_diena'];
        $beiguMenesis = (int)$rinda['beigu_menesis'];
        $beiguDiena = (int)$rinda['beigu_diena'];

            $sakumVertiba = $sakumMenesis * 100 + $sakumDiena;
            $beiguVertiba = $beiguMenesis * 100 + $beiguDiena;

            if ($sakumVertiba > $beiguVertiba) {
                if ($dzimVertiba >= $sakumVertiba) {
                    return $rinda['Nosaukums'];
                }
                elseif ($dzimVertiba <= $beiguVertiba) {
                    return $rinda['Nosaukums'];
                }
            } 
            else {
                if ($dzimVertiba >= $sakumVertiba && $dzimVertiba <= $beiguVertiba) {
                    return $rinda['Nosaukums'];
                }
            }
        }

        return 'Nezināms';

    } catch (Exception $e) {
        error_log("Error in iegutZvaigznaklu: " . $e->getMessage());
        return 'Nezināms';
    }
}

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

        <style>
    .emoji-rain {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1000;
        overflow: hidden;
    }
    
    .emoji {
        position: absolute;
        font-size: 24px;
        animation: fall linear forwards;
        user-select: none;
    }
    
    @keyframes fall {
        to {
            transform: translateY(100vh);
        }
    }
</style>


</head>
<body>
    <a href='../home.php' class='btn'>Atpakaļ</a>
    <div class="speles-container">
    <div class="transakcijash2"><h1>Mans horoskops</h1></div>
        <div class="horoskops" id="horoskopsBloks" style="display: none;">
            <div class="datums" id="datums"></div>
            <div class="zvaigznajs">Zodiaka zīme: <?= htmlspecialchars($zvaigznaks) ?></div>
            <div class="noskana" id="noskana"></div>
            <div class="bonuss" id="bonuss"></div>
            <div class="teksts"><p id="teksts"></p></div>
        </div>

        <div class="dropbtnizvelne-horoskops">
            <button id="generetBtn" class="dropbtn" <?= $alreadyGenerated ? 'disabled' : '' ?>>
                <?= $alreadyGenerated ? 'Limits ir pārsniegts' : 'Ģenerēt horoskopu' ?>
            </button>
            <div id="loadingIcon" style="display: none;">
                <i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i>
            </div>
            <div id="taimeris"></div>
            <?php if ($alreadyGenerated): ?>
                <div class="info-message">Nākamo horoskopu varēsiet saņemt rīt!</div>
            <?php endif; ?>
        </div>
    </div>
    <div class="transakcijas-button">
        <a href="horoskopu_vesture.php" class="btn">Mana Horoskopu Vēsture</a>
    </div>


<script>
function saglabatHoroskopu(horoskops) {
    try {
        const horoskopaDati = {
            teksts: horoskops.teksts,
            datums: horoskops.datums,
            zvaigznajs: horoskops.zvaigznajs,
            reakcija: horoskops.reakcija,
            bonuss: horoskops.bonuss,
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
            
            if (!data || !data.teksts || !data.datums || !data.reakcija) {
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
function createEmojiRain(emoji, count = 50, duration = 3000) {
    const container = document.createElement('div');
    container.className = 'emoji-rain';
    document.body.appendChild(container);

    for (let i = 0; i < count; i++) {
        setTimeout(() => {
            const emojiElement = document.createElement('div');
            emojiElement.className = 'emoji';
            emojiElement.textContent = emoji;
            
            
            emojiElement.style.left = Math.random() * 100 + 'vw';
            
            
            const animDuration = Math.random() * 3000 + 2000;
            emojiElement.style.animationDuration = animDuration + 'ms';
            
            
            const size = Math.random() * 20 + 16;
            emojiElement.style.fontSize = size + 'px';
            
            container.appendChild(emojiElement);
            
            
            setTimeout(() => {
                emojiElement.remove();
            }, animDuration);
        }, Math.random() * duration);
    }

    
    setTimeout(() => {
        container.remove();
    }, duration + 3000);
}
function attelotHoroskopu(horoskops) {
    try {
        document.getElementById('datums').textContent = horoskops.datums;
        document.querySelector('.zvaigznajs').textContent = `Zodiaka zīme: ${horoskops.zvaigznajs}`;
        
        const noskanaElement = document.getElementById('noskana');
        if (horoskops.reakcija) {
            noskanaElement.textContent = `Noskaņa šim rakstam ir ${horoskops.reakcija}`;
            noskanaElement.className = 'noskana ' + 
                (horoskops.reakcija === 'pozitīva' ? 'positive' : 
                 horoskops.reakcija === 'neitrāla' ? 'neutral' : 'negative');

            
            let emoji = '🙂';
            if (horoskops.reakcija === 'pozitīva') emoji = '🥰';
            else if (horoskops.reakcija === 'negatīva') emoji = '😡';
            createEmojiRain(emoji);
        } else {
            noskanaElement.textContent = '';
        }
        
        const bonussElement = document.getElementById('bonuss');
        if (horoskops.bonuss !== undefined) {
            const bonusText = horoskops.bonuss > 0 ? `Lietotājs saņem +${horoskops.bonuss} labsajūtas punktus` : 
                               horoskops.bonuss < 0 ? `Lietotājs saņem ${horoskops.bonuss} labsajūtas punkti` : 
                               'Labsajūtas līmenis nemainās';
            bonussElement.textContent = bonusText;
            bonussElement.className = 'bonuss ' + 
                (horoskops.bonuss > 0 ? 'positive' : 
                 horoskops.bonuss < 0 ? 'negative' : '');
        } else {
            bonussElement.textContent = '';
        }
        
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

document.getElementById('generetBtn')?.addEventListener('click', async function() {
    if (this.disabled) return;
    
    const loadingIcon = document.getElementById('loadingIcon');
    loadingIcon.style.display = 'block';
    this.disabled = true;
    
    try {
        const response = await fetch('generet_horoskopu.php');
        const data = await response.json();
        
        if (data.success) {
            saglabatHoroskopu(data.data);
            attelotHoroskopu(data.data);
            document.getElementById('horoskopsBloks').style.display = 'block';
        } else {
            alert('Kļūda: ' + (data.error?.message || 'Nezināma kļūda'));
        }
    } catch (error) {
        console.error('Kļūda:', error);
        alert('Radās kļūda, mēģiniet vēlāk');
    } finally {
        loadingIcon.style.display = 'none';
    }
});

function paradiIeladi(paradit) {
    document.getElementById('loadingIcon').style.display = paradit ? 'block' : 'none';
}
document.addEventListener('DOMContentLoaded', function() {
        ieladetHoroskopu();
        
        
        const alreadyGenerated = <?= $alreadyGenerated ? 'true' : 'false' ?>;
        if (alreadyGenerated) {
            document.getElementById('generetBtn').disabled = true;
        }
        
        const beiguLaiks = parseInt(localStorage.getItem('taimerisBeigas') || 0);
        if (beiguLaiks > Date.now()) {
            document.getElementById('generetBtn').disabled = true;
            atjaunotTaimeri();
        }
    });
    </script>
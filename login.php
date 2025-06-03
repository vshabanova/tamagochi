<?php
session_start();

if (isset($_POST['Lietotajvards'], $_POST['Parole'], $_POST['autorizeties'])) {
    $Lietotajvards = $_POST['Lietotajvards'];
    $parole = $_POST['Parole'];

    if (empty($Lietotajvards) || empty($parole)) {
        header('Location: login.php?status=empty');
        exit();
    }

    require("savienojums/connect_db.php");

    $stmt_kapi = $savienojums->prepare("SELECT COUNT(*) as skaits FROM kapi WHERE Lietotajs_ID = (SELECT Lietotajs_ID FROM lietotaji WHERE Lietotajvards = ?)");
    $stmt_kapi->bind_param("s", $Lietotajvards);
    $stmt_kapi->execute();
    $rezultats_kapi = $stmt_kapi->get_result();
    $kapi_skaits = $rezultats_kapi->fetch_assoc()['skaits'];

    if ($kapi_skaits > 0) {
        header("Location: speles_beigas.php");
        exit();
    }

    $stmt = $savienojums->prepare("SELECT Lietotajs_ID, Lietotajvards, Parole FROM lietotaji WHERE Lietotajvards = ?");
    $stmt->bind_param("s", $Lietotajvards);
    $stmt->execute();
    $rezultats = $stmt->get_result();
    $lietotajs = $rezultats->fetch_assoc();

    if ($lietotajs && password_verify($parole, $lietotajs['Parole'])) {
        $_SESSION['Lietotajs_ID'] = $lietotajs['Lietotajs_ID'];
        $_SESSION['Lietotajvards'] = $lietotajs['Lietotajvards'];
        $_SESSION['autorizejies'] = true;
        
        header('Location: home.php');
        exit();
    } else {
        header('Location: login.php?status=incorrect');
        exit();
    }
}

$statusMessage = '';
$statusClass = '';
if(isset($_GET['status'])) {
    switch($_GET['status']) {
        case 'incorrect':
            $statusMessage = "Nepareizs lietotājvārds vai parole";
            $statusClass = 'error';
            break;
        case 'empty':
            $statusMessage = "Lūdzu, ievadiet lietotājvārdu un paroli";
            $statusClass = 'error';
            break;
    }
}
echo '
<head>
    <link rel="stylesheet" type="text/css" href="public/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <div class="form-container-login">
    <div class="flex-container">
        <form id="login" action="login.php" method="post">
        <h2>Autorizējies</h2>
        <div class="status-message ' . $statusClass . '">' . htmlspecialchars($statusMessage) . '</div>
            <div class="form-group-login">
                <label for="Lietotajvards"><i class="fa-solid fa-user"></i>Lietotājvārds:</label>
                <input type="text" id="Lietotajvards" name="Lietotajvards">
            </div>
            <div class="form-group-login">
            <label for="Parole"><i class="fa-solid fa-key"></i>Parole:</label>
                <input type="password" id="Parole" name="Parole">
            </div>
			    <input type="submit" class="dropbtnreg" name="autorizeties" value="Autorizēties">
		</form>
        <a href="aizmirstaparole.php">Aizmirsat paroli?</a>
        <div class="line"></div>
        </div>
	</div>
    <a href="index.php" class="btn">Atpakaļ</a>
</body>';
?>
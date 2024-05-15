<?php
session_start(); // Ja izmanto $_SESSION, vienmēr jāuzsāk sessija
// Tā kā mēs izmantojam SQL datubāzi priekš datu glabāšanas, masīvus gluži nav jegas izmantot vairak, tāpēc $derigie_lietotaji nav

if(isset($_POST['Lietotajvards'], $_POST['Parole'], $_POST['autorizeties'])){ //pārbauda vai forma ir nosūtīta
    require("savienojums/connect_db.php"); // savieno ar DB

    $lietotajvards = $_POST['Lietotajvards']; // pasaka PHP ka mainīgais $lietotajvards ir vienāds ar datubāzes Lietotajvards mainīgo

    $stmt = $savienojums->prepare("SELECT Lietotajs_ID, Lietotajvards, Parole FROM lietotajs WHERE Lietotajvards = ?"); // sagatavo SQL vaicājumu priekš palaišanas (meklē lietotājvārdu)
    $stmt->bind_param("s", $lietotajvards); // Pasaka to PHP valodā
    $stmt->execute(); //Palaiž SQL vaicājumu
    $rezultats = $stmt->get_result(); // Saglabā rezultātus mainīgajā $rezultāts
    $lietotajs = $rezultats->fetch_assoc(); // Saglabātos rezultātus (Šajā gadījumā lietotāja vārdu) paķer $lietotajs mainīgajā priekš pārbaudes vēlāk

    if ($lietotajs && password_verify($_POST['Parole'], $lietotajs['Parole'])) { // Ja visi dati sakrīt ar datubāzi, tad...
        $_SESSION['autorizejies'] = $lietotajs['Lietotajvards']; //Pievieno lietotāju pie sessijas
        
    $stmt = $savienojums->prepare("SELECT Parole FROM lietotaji WHERE Lietotajs_ID = ?");
    $stmt->bind_param("i", $lietotajs['Lietotajs_ID']);
    $stmt->execute();
    $rezultats = $stmt->get_result();
    $stmt->close();

        $row = $rezultats->fetch_assoc();
        if ($row['Parole'] !== NULL && $row['Parole'] !== '' && $row['Parole'] !== false && $row['Parole'] !== 0) {
            header('Location: home.php');
            exit();
        } else {
            header('Location: register.php');
            exit();
        }
    } else {
        header('Location: login.php');
        exit();
    }
}
// ================================= neverifice datus, prost palaiz pie speles
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$statusMessage = ''; // Tīri priekš smuka message
$statusClass = '';
if(isset($_GET['status'])) {
    switch($_GET['status']) {
        case 'incorrect':
            $statusMessage = "Nepareizs lietotājvārds vai parole";
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
        <form id="login" action="home.php" method="post">
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
            <div class="buttons-login">
			<input type="submit" name="autorizeties" value="Autorizēties">
            </div>
            <div class="registrejies">
            <a href="register.php">Neesi reģistrējies?</a>
            </div>
		</form>
        <div class="line"></div>
        </div>
	</div>
    <a href="index.php">Atpakaļ</a>
</body>';
?>
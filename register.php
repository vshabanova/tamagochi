<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $lietotajvards = $_POST["Lietotajvards"];
    $parole = $_POST['Parole'];
    $epasts = $_POST["Epasts"];
    $vards = $_POST["Vards"];
    $dzim_dat = $_POST["Dzim_dat"];
    $dzivnieks = $_POST["Dzivnieks"];
    require("savienojums/connect_db.php");

    $sql = "SELECT * FROM lietotaji WHERE Lietotajvards='$lietotajvards'";
    $rezultats = mysqli_query($savienojums, $sql);
    $hashed_parole = password_hash($_POST['Parole'], PASSWORD_DEFAULT);

    if (mysqli_num_rows($rezultats) > 0) {
        header('Location: register.php?status=sameusername');
    }else{
        $sql = "INSERT INTO lietotaji (Lietotajvards, Parole, Epasts, Nauda, Dzim_dat) VALUES ('$lietotajvards', '$hashed_parole', '$epasts', 50, '$dzim_dat')";

        if (mysqli_query($savienojums, $sql)) {
            $ID_Lietotajs = mysqli_insert_id($savienojums);
            $_SESSION['Lietotajs_ID'] = $ID_Lietotajs;
            $_SESSION['autorizejies'] = true;

        if ($ID_Lietotajs) {
        $sql = "INSERT INTO dzivnieki (ID_Lietotajs, Vards, Dzivnieks, Bada_limenis, Labsajutas_limenis) VALUES ('$ID_Lietotajs', '$vards', '$dzivnieks', 100, 100)";
            if (mysqli_query($savienojums, $sql)) {
                header('Location: home.php');
                exit;
            } else {
                echo "Kļūda: " . $sql . "<br>" . mysqli_error($savienojums);
            }
    } 
    mysqli_close($savienojums);
}
}
}
$statusMessage = '';
$statusClass = '';
if(isset($_GET['status'])) {
    switch($_GET['status']) {
        case 'sameusername':
            $statusMessage = "Lietotajvārds ir aizņemts!";
            $statusClass = 'error';
            break;
    }
}  

echo'
<head>
    <link rel="stylesheet" type="text/css" href="public/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="https://poetry4kids.com/wp-content/uploads/2021/09/I-Think-Id-Like-to-Get-a-Pet-icon-300x300.png"></head>
    <title>Reģistrēties</title>
</head>
<body>
    <div class="form-container-login">
        <div class="flex-container">
            <form id="registration" action="register.php" method="post">
                <h2>Reģistrēties</h2>
                <div class="status-message ' . $statusClass . '">' . htmlspecialchars($statusMessage) . '</div>
                <div class="form-group-login">
                    <label for="Lietotajvards"><i class="fa-solid fa-user"></i>Lietotājvārds:</label>
                    <input type="text" id="Lietotajvards" name="Lietotajvards" required>
                </div>
                <div class="form-group-login">
                    <label for="Email"><i class="fa-solid fa-envelope"></i>Epasts:</label>
                    <input type="email" id="Epasts" name="Epasts" required>
                </div>
                <div class="form-group-login">
                    <label for="Parole"><i class="fa-solid fa-key"></i>Parole:</label>
                    <input type="password" id="Parole" name="Parole" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                </div>
                <div class="dropdown">
                    <select id="Dzivnieks" name="Dzivnieks" class="dropbtn" required onchange="dzivBilde()">
                        <option value="">Izvēlies mīluli</option>
                        <option value="Suns">Suns</option>
                        <option value="Kakis">Kaķis</option>
                        <option value="Zakis">Zaķis</option>
                    </select>
                    <div class="dzivBilde">
                        <img id="dzivniekuBilde" src=""  style="max-width: 200px; height: 150px; margin: 20px;">
                    </div>
                </div>
                <div class="form-group-login">
                    <label for="Vards">Mīluļa vārds:</label>
                    <input type="text" id="Vards" name="Vards" placeholder="Džeks" required>
                </div>
                <div class="form-group-login">
                    <label for="Dzim_dat">Dzimšanas datums:</label>
                    <input type="date" id="Dzim_dat" name="Dzim_dat" placeholder="DD-MM-GGGG" required>
                </div>

                    <input type="submit" class="dropbtnreg" name="registreties" value="Reģistrēties">
            </form>
            <div class="line"></div>
        </div>
    </div>
    <a href="index.php" class="btn">Atpakaļ</a>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function dzivBilde() {
                var dzivnieks = document.getElementById("Dzivnieks").value;
                var img = document.getElementById("dzivniekuBilde");
                if (dzivnieks) {
                    switch (dzivnieks) {
                        case "Suns":
                            img.src = "public/suns.png";
                            img.style.display = "block";
                            break;
                        case "Kakis":
                            img.src = "public/kakis.png";
                            img.style.display = "block";
                            break;
                        case "Zakis":
                            img.src = "public/zakis.png";
                            img.style.display = "block";
                            break;
                        default:
                            img.style.display = "none";
                            img.src = "";
                    }
                } else {
                    img.style.display = "none";
                    img.src = "";
                }
            }
            document.getElementById("Dzivnieks").addEventListener("change", dzivBilde);
        });
    </script>
</body>';
?>
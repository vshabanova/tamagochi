<?php
session_start();

if (isset($_GET['status']) && $_GET['status'] === 'success') {
    header("Refresh:2; url=login.php"); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $lietotajvards = $_POST["Lietotajvards"];
    $parole = $_POST['Parole'];
    $epasts = $_POST["Epasts"];
    $vards = $_POST["Vards"];
    require("savienojums/connect_db.php");

    $sql = "SELECT * FROM lietotaji WHERE Lietotajvards='$lietotajvards'";
    $rezultats = mysqli_query($savienojums, $sql);
    $hashed_parole = password_hash($_POST['Parole'], PASSWORD_DEFAULT);

    if (mysqli_num_rows($rezultats) > 0) {
        header('Location: register.php?status=sameusername');
    }else{
        //==================pagaidām var pievienot tikai lietotaju, bez sasaistita dzivienka
        $sql = "INSERT INTO lietotaji (Lietotajvards, Parole, Epasts, Nauda) VALUES ('$lietotajvards', '$hashed_parole', '$epasts', 50)";
        if (mysqli_query($savienojums, $sql)) {
            header('Location: register.php?status=success'); 
        } else {
            echo "Kļūda: " . $sql . "<br>" . mysqli_error($savienojums);
        }
    } 
    mysqli_close($savienojums);
}
$statusMessage = '';
$statusClass = '';
if(isset($_GET['status'])) {
    switch($_GET['status']) {
        case 'sameusername':
            $statusMessage = "Lietotajvārds ir aizņemts!";
            $statusClass = 'error';
            break;
        case 'success':
            $statusMessage = "Reģistrācija veiksmīga!";
            $statusClass = 'success';
            break;
    }
}  

echo'
<head>
    <link rel="stylesheet" type="text/css" href="public/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="https://poetry4kids.com/wp-content/uploads/2021/09/I-Think-Id-Like-to-Get-a-Pet-icon-300x300.png"></head>

<body>
    <div class="form-container-login">
        <div class="flex-container">
            <form id="registration" action="register.php" method="post">
                <h2>Reģistrēties</h2>
                <div class="status-message ' . $statusClass . '">' . htmlspecialchars($statusMessage) . '</div>
                <div class="form-group-login">
                    <label for="Lietotajvards"><i class="fa-solid fa-user"></i>Lietotājvārds:</label>
                    <input type="text" id="Lietotajvards" name="Lietotajvards">
                </div>
                <div class="form-group-login">
                    <label for="Email"><i class="fa-solid fa-envelope"></i>Epasts:</label>
                    <input type="email" id="Epasts" name="Epasts">
                </div>
                <div class="form-group-login">
                    <label for="Parole"><i class="fa-solid fa-key"></i>Parole:</label>
                    <input type="password" id="Parole" name="Parole">
                </div>
                <div class="dropdown">
                    <select class="dropbtn">
                        <option value="" disabled selected>Izvēlies mīluli</option>
                        <option value="Suns">Suns</option>
                        <option value="Kakis">Kaķis</option>
                        <option value="Zakis">Zaķis</option>
                    </select>
                </div>

                <label for="Vards">Mīluļa vārds:</label>
                <input type="text" id="Vards" name="Vards" placeholder="Džeks">


                <div class="buttons-login">
                    <input type="submit" name="registreties" value="Reģistrēties">
                </div>
                <div class="registrejies">
                    <a href="autorizeties.php">Jau esi reģistrējies?</a>
                </div>
            </form>
            <div class="line"></div>
        </div>
    </div>
    <a href="index.php">Atpakaļ</a>
</body>';
?>
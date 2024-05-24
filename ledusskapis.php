<?php 
session_start();
require("savienojums/connect_db.php");

$ID_Lietotajs = $_SESSION['Lietotajs_ID'];
$Lietotajvards = $_SESSION['autorizejies'];

$sql = "SELECT l.Ledusskapja_ID, l.Ediens_ID, l.Daudzums, Nosaukums, Vertiba
        FROM ledusskapis l
        JOIN ediens e ON l.Ediens_ID = e.Ediens_ID
        WHERE l.Lietotajs_ID='$ID_Lietotajs'";
$result = mysqli_query($savienojums, $sql);

$foodItems = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $foodItems[] = $row;
    }
} else {
    echo "Error: " . mysqli_error($savienojums);
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ledusskapis</title>
    <link rel="stylesheet" type="text/css" href="public/spelesstyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="https://poetry4kids.com/wp-content/uploads/2021/09/I-Think-Id-Like-to-Get-a-Pet-icon-300x300.png">
</head>
<body>
    <div class="speles-container">
        <div class="ledusskapis-container">
            <h2>Ledusskapis</h2>
            <table class="ledusskapis-table">
                <tr>
                    <th>Ēdiena Nosaukums</th>
                    <th>Daudzums</th>
                    <th>Vērtiba</th>
                    <th>Darbība</th>
                </tr>
                <?php foreach ($foodItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['Nosaukums']); ?></td>
                    <td><?php echo htmlspecialchars($item['Daudzums']); ?></td>
                    <td><?php echo htmlspecialchars($item['Vertiba']); ?></td>
                    <td><button class="dropbtn" data-ediena-id="<?php echo $item['Ediens_ID']; ?>">Barot</button></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <a href="home.php" class="btn">Atpakaļ</a>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const buttons = document.querySelectorAll('.dropbtn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const edienaId = this.getAttribute('data-ediena-id');
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'barotdziv.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                switch(xhr.responseText) {
                                    case "success":
                                        alert('Dzīvnieks ir pabarots!');
                                        location.reload();
                                        break;
                                    case "piesledzies":
                                        alert('Lūdzu, piesakieties sistēmā.');
                                        break;
                                    case "nav_dziv":
                                        alert('Dzīvnieks netika atrasts.');
                                        break;
                                    case "nav_ediens":
                                        alert('Ēdiens ir beidzies.');
                                        break;
                                    case "nav_ediens_atrasts":
                                        alert('Ēdiens netika atrasts.');
                                        break;
                                    case "daudzums_error":
                                        alert('Kļūda atjauninot ēdiena daudzumu.');
                                        break;
                                    case "dzivnieks_error":
                                        alert('Kļūda atjauninot dzīvnieka statusu.');
                                        break;
                                    case "kluda":
                                        alert('Nepareizi dati.');
                                        break;
                                    case "requests_neiet":
                                        alert('Nepareizs pieprasījuma veids.');
                                        break;
                                    default:
                                        alert('Kļūda barojot dzīvnieku.');
                                }
                            } else {
                                alert('Kļūda savienojoties ar serveri.');
                            }
                        }
                    };
                    xhr.send('ediena_id=' + edienaId);
                });
            });
        });
    </script>
</body>
</html>
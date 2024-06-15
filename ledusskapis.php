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

$Edieni = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $Edieni[] = $row;
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
                <?php foreach ($Edieni as $Ediens): ?>
                <tr>
                    <td><?php echo htmlspecialchars($Ediens['Nosaukums']); ?></td>
                    <td id="daudzums-<?php echo $Ediens['Ediens_ID']; ?>"><?php echo htmlspecialchars($Ediens['Daudzums']); ?></td>
                    <td><?php echo htmlspecialchars($Ediens['Vertiba']); ?></td>
                    <td><button class="dropbtn" data-ediena-id="<?php echo $Ediens['Ediens_ID']; ?>">Barot</button></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <a href="home.php" class="btn">Atpakaļ</a>
    
    <div id="pazinojums" style="display: none; position: fixed; top: 10px; right: 10px; background-color: #f0f0f0; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    </div>

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
                        const response = xhr.responseText;
                        document.getElementById('pazinojums').innerHTML = response;
                        
                        if (response.includes('success-message')) {
                            const newDaudzums = response.match(/Jaunais daudzums: (\d+)/);
                            if (newDaudzums && newDaudzums.length > 1) {
                                const atjaunotsDaudzums = newDaudzums[1];
                                document.getElementById(`daudzums-${edienaId}`).innerText = atjaunotsDaudzums;
                            }
                        }
                        
                        document.getElementById('pazinojums').style.display = 'block';
                        setTimeout(() => {
                            document.getElementById('pazinojums').style.display = 'none';
                        }, 3000);
                    } else {
                        raditPazinojumu('Kļūda savienojoties ar serveri.');
                    }
                }
            };
            xhr.send('ediena_id=' + edienaId);
        });
    });
});

function raditPazinojumu(message) {
    const pazinojums = document.getElementById('pazinojums');
    pazinojums.innerText = message;
    pazinojums.style.display = 'block';
    setTimeout(() => {
        pazinojums.style.display = 'none';
    }, 3000);
}
</script>
</body>
</html>
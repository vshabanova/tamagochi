<?php
require("savienojums/connect_db.php");
$successEmail = '';
$errorEmail = '';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require 'vendor/phpmailer/phpmailer/src/SMTP.php';
        require 'vendor/phpmailer/phpmailer/src/Exception.php';
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $epasts = $_POST['epasts'];
    if (!filter_var($epasts, FILTER_VALIDATE_EMAIL)) {
        die("Nepareizs e-pasta formāts");
    }
    function generateToken()
    {
        $length = 32;
        $bytes = random_bytes($length);
        return bin2hex($bytes);
    }

    $laiks = 86400 ;

    $deriguma_termins = date('Y-m-d H:i:s', time() + $laiks);
    $token = bin2hex(random_bytes(50));
    $sql = "INSERT INTO atjaunot_paroli (epasts, token, deriguma_termins_parole) VALUES ('$epasts', '$token', '$deriguma_termins')";

    if ($savienojums->query($sql) === TRUE) {
        $link = "localhost/tamagochi/attiestatitparoli.php?epasts=" . $epasts . "&token=" . $token;
        require 'vendor/autoload.php';
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'koksniesi@gmail.com';
            $mail->Password = 'sdhrwarhruwpvsao';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('koksniesi@gmail.com', 'Koksniesi');
            $mail->addAddress($epasts);

            $mail->isHTML(false);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Paroles atjaunošana';
            $mail->Body = "Sveiki,\n\nNoklikšķiniet šeit, lai atjaunotu paroli:\n\n$link";
            $mail->send();
            $successEmail = 'E-pasts tika nosūtīts uz jūsu adresi, apstipriniet lūdzu uzspiežot uz hipersaiti.';
        } catch (Exception $e) {
            $errorEmail = 'Neizdevās nosūtīt e-pastu.';
            echo "KĻŪME: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $savienojums->error;
    }
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aizmirsta parole</title>
    <link rel="stylesheet" type="text/css" href="public/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="form-container-login">
        <div class="flex-container">
            <form id="login" action="aizmirstaparole.php" method="post">
                <h2>Aizmirsta parole</h2>
                <div class="status-message <?php echo !empty($errorEmail) ? 'error' : ''; ?>">
                    <?php echo !empty($errorEmail) ? htmlspecialchars($errorEmail) : ''; ?>
                </div>
                <div class="status-message <?php echo !empty($successEmail) ? 'success' : ''; ?>">
                    <?php echo !empty($successEmail) ? htmlspecialchars($successEmail) : ''; ?>
                </div>
                <div class="form-group-login">
                    <label for="epasts"><i class="fa-solid fa-envelope"></i>E-pasts:</label>
                    <input type="email" id="epasts" name="epasts" required>
                </div>
                <input type="submit" class="dropbtnreg" value="Nosūtīt saiti">
            </form>
            <div class="line"></div>
        </div>
    </div>
    <a href="login.php" class="btn">Atpakaļ</a>
</body>
</html>
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
<html>
<head>
    <title>Aizmirsta parole</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../stili/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="shortcut icon" href="../../atteli/logo.jpg" type="image/x-icon">
</head>
<body>
    <form action="aizmirstaparole.php" method="post">
        <div class="centericon">
            <span class="fas fa-envelope"></span>
        </div>
        <input type="email" name="epasts" placeholder="Ievadiet E-pastu" required>
        <input type="submit" class="button-link" value="Nosūtīt saiti">
        <?php if ($successEmail): ?>
            <p><?php echo $successEmail; ?></p>
        <?php endif; ?>
        <?php if ($errorEmail): ?>
            <p><?php echo $errorEmail; ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
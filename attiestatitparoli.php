<?php
require("savienojums/connect_db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $epasts = $_POST['epasts'];
    $token = $_POST['token'];
    $parole = $_POST['Parole'];

    $token_valid = false;

    $stmt = $savienojums->prepare("SELECT token, deriguma_termins_parole FROM atjaunot_paroli WHERE epasts = ?");
    $stmt->bind_param('s', $epasts);

    if ($stmt->execute()) {
        $stmt->bind_result($db_token, $deriguma_termins_parole);

        if ($stmt->fetch()) {
            if ($db_token == $token && strtotime($deriguma_termins_parole) > time()) {
                $token_valid = true;
            }
        }
    }
    $stmt->close();

    if ($token_valid) {
        $stmt = $savienojums->prepare("UPDATE lietotaji SET Parole = ? WHERE Epasts = ?");
        $stmt->bind_param('ss', $hashed_parole, $epasts);

        $hashed_parole = password_hash($parole, PASSWORD_DEFAULT);

        if ($stmt->execute()) {
            $successMessage = 'Parole tika veiksmīgi atjaunota.';
            $stmt = $savienojums->prepare("DELETE FROM atjaunot_paroli WHERE epasts = ?");
            $stmt->bind_param('s', $epasts);
            $stmt->execute();
            $stmt->close();
            
            session_start();
            session_unset();
            session_destroy();
            
            header("Location: login.php");
            exit;
        }
        $savienojums->close();
    } else {
        $errorMessage = 'Nepareizs vai novecojis token.';
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
    <h2>Atiestatīt paroli</h2>
    <form method="post">
        <input type="hidden" name="epasts" value="<?php echo htmlspecialchars($_GET['epasts']); ?>">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
<div class="centericon">
        <span class="fas fa-lock"></span>
        </div>
        <input type="password" name="Parole" placeholder="Jauna parole" required>
        <input type="submit" class="button-link" value="Iestatit paroli">

        <?php if (isset($successMessage)): ?>
            <p><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <?php if (isset($errorMessage)): ?>
            <p><?php echo $errorMessage; ?></p>
        <?php endif; ?>
    </form>
</body>
</html>

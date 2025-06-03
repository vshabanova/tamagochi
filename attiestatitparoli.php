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
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atiestatīt paroli</title>
    <link rel="stylesheet" type="text/css" href="public/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="form-container-login">
        <div class="flex-container">
            <form id="login" method="post">
                <h2>Atiestatīt paroli</h2>
                <?php if (isset($errorMessage)): ?>
                    <div class="status-message error"><?php echo htmlspecialchars($errorMessage); ?></div>
                <?php endif; ?>
                <div class="form-group-login">
                    <label for="Parole"><i class="fa-solid fa-key"></i>Jaunā parole:</label>
                    <input type="password" id="Parole" name="Parole" required>
                </div>
                <input type="hidden" name="epasts" value="<?php echo htmlspecialchars($_GET['epasts'] ?? ''); ?>">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">
                <input type="submit" class="dropbtnreg" value="Iestatīt paroli">
            </form>
            <div class="line"></div>
        </div>
    </div>
    <a href="login.php" class="btn">Atpakaļ</a>
</body>
</html>

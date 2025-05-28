<?php
// Iestatām kļūdu ziņošanu
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Datubāzes konfigurācija
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', '2024_proj_dzivnieki');

// OpenAI konfigurācija
define('OPENAI_KEY', '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'); // Aizstājiet ar reālo atslēgu

// Sesijas sākšana
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoloader priekš OpenAI bibliotēkas
require_once 'vendor/autoload.php';
?>
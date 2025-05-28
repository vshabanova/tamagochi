<?php
// Iestatām kļūdu ziņošanu
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ielādējam .env failu
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Datubāzes konfigurācija
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', '2025_proj_dzivnieki');

// OpenAI konfigurācija
define('OPENAI_KEY', $_ENV['OPENAI_KEY']);

// Sesijas sākšana
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
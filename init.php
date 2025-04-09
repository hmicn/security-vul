<?php
ini_set('session.use_strict_mode', 0);
ini_set('session.use_only_cookies', 0);
ini_set('session.use_trans_sid', 0);

session_start();

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Charge les variables d’environnement
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = 'localhost';
$dbname = 'security_vul';
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$charset = 'utf8mb4';
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Création des tables si elles n'existent pas
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS comments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user VARCHAR(255) NOT NULL,
        comment TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}



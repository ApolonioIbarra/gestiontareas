<?php
$host = "192.168.0.100";
$username = "apoloiba_db";
$password = "aTZ6cnL62KCWEc7Lq5Mg";
$dbname = "apoloiba_db";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>

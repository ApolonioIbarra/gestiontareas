<?php
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['username'];
    $password = sha1($_POST['password']);

    // Validar las credenciales
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = :usuario AND password = :password");
    $stmt->execute(['usuario' => $usuario, 'password' => $password]);

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['usuario_id'] = $user['id'];  // Guardar el user_id en la sesión
        $_SESSION['username'] = $usuario;

        header("Location: ../pages/dashboard.html");
        exit();
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos.');</script>";
        echo "<script>window.location.href = '../index.html';</script>";
        exit();
    }
}
?>

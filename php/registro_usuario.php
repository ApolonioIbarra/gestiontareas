<?php
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Verificar si el usuario ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = :usuario");
    $stmt->execute(['usuario' => $usuario]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('El usuario ya está registrado.');</script>";
        echo "<script>window.location.href = '../pages/registro.html';</script>";
        exit();
    }

    // Insertar el nuevo usuario con contraseña cifrada
    $passwordHash = sha1($password);
    $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, password) VALUES (:usuario, :password)");
    $stmt->execute(['usuario' => $usuario, 'password' => $passwordHash]);

    echo "<script>alert('Usuario registrado con éxito.');</script>";
    echo "<script>window.location.href = '../index.html';</script>";
}
?>

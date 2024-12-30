<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["status" => "error", "message" => "Acceso no autorizado"]);
    exit();
}

try {
    $pdo = new PDO("mysql:host=192.168.0.100;dbname=apoloiba_db", "apoloiba_db", "aTZ6cnL62KCWEc7Lq5Mg");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $task_id = $_POST['id'];
    $user_id = $_SESSION['usuario_id'];

    // Asegurar que la tarea pertenece al usuario actual
    $stmt = $pdo->prepare("DELETE FROM tareas WHERE id = :id AND usuario_id = :user_id");
    $stmt->execute(['id' => $task_id, 'user_id' => $user_id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se encontró la tarea o no pertenece a este usuario"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

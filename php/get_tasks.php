<?php
session_start();
require 'conexion.php';

// Verificar si la sesión está activa y si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["status" => "error", "message" => "Acceso no autorizado"]);
    exit();
}

if (isset($_GET['id'])) {
    $taskId = intval($_GET['id']);
    $query = $pdo->prepare("SELECT * FROM tareas WHERE id = :task_id AND usuario_id = :user_id");
    $query->execute(['task_id' => $taskId, 'user_id' => $_SESSION['usuario_id']]);
    $task = $query->fetch(PDO::FETCH_ASSOC);

    if ($task) {
        echo json_encode(['status' => 'success', 'data' => $task]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Tarea no encontrada o no pertenece al usuario.']);
    }
    exit;
}

try {
    // Obtener las tareas del usuario autenticado
    $stmt = $pdo->prepare("SELECT * FROM tareas WHERE usuario_id = :user_id");
    $stmt->execute(['user_id' => $_SESSION['usuario_id']]);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["status" => "success", "data" => $tasks]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>

<?php
session_start();

// Validación de sesión
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["status" => "error", "message" => "Acceso no autorizado"]);
    exit();
}

try {
    // Configuración de conexión a la base de datos
    $pdo = new PDO("mysql:host=192.168.0.100;dbname=apoloiba_db", "apoloiba_db", "aTZ6cnL62KCWEc7Lq5Mg");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener datos del formulario
    $titulo = $_POST['titulo'] ?? '';
    $asignatura = $_POST['asignatura'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fecha_entrega = $_POST['fecha_entrega'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $usuario_id = $_SESSION['usuario_id'];
    $id = $_POST['id'] ?? null;

    if ($id) {
        // Actualizar tarea existente
        $stmt = $pdo->prepare("UPDATE tareas SET titulo = :titulo, asignatura = :asignatura, descripcion = :descripcion, fecha_entrega = :fecha_entrega, estado = :estado WHERE id = :id AND usuario_id = :usuario_id");
        $stmt->execute(['titulo' => $titulo, 'asignatura' => $asignatura, 'descripcion' => $descripcion, 'fecha_entrega' => $fecha_entrega, 'estado' => $estado, 'id' => $id, 'usuario_id' => $usuario_id]);
    } else {
        // Insertar nueva tarea
        $stmt = $pdo->prepare("INSERT INTO tareas (titulo, asignatura, descripcion, fecha_entrega, estado, usuario_id) VALUES (:titulo, :asignatura, :descripcion, :fecha_entrega, :estado, :usuario_id)");
        $stmt->execute(['titulo' => $titulo, 'asignatura' => $asignatura, 'descripcion' => $descripcion, 'fecha_entrega' => $fecha_entrega, 'estado' => $estado, 'usuario_id' => $usuario_id]);
    }

    // Respuesta JSON
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
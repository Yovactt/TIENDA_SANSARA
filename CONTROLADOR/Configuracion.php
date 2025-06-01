<?php
require_once 'Conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_nombre = $_POST['nombre'] ?? '';
    $nuevo_correo = $_POST['correo'] ?? '';
    $nombre_anterior = $_POST['nombre_anterior'] ?? '';

    // Validación básica
    if (empty($nuevo_nombre) || empty($nuevo_correo)) {
        header('Location: CONFIGURACION.php?error=Faltan campos obligatorios');
        exit;
    }

    try {
        $conn = conectar();

        // Verificar si el nuevo nombre ya está en uso por otro
        $check = $conn->prepare('SELECT COUNT(*) FROM usuarios WHERE nombre = :nombre AND nombre != :nombre_anterior');
        $check->bindParam(':nombre', $nuevo_nombre);
        $check->bindParam(':nombre_anterior', $nombre_anterior);
        $check->execute();

        if ($check->fetchColumn() > 0) {
            header('Location: CONFIGURACION.php?error=Ese nombre de usuario ya está en uso');
            exit;
        }

        $stmt = $conn->prepare('UPDATE usuarios SET nombre = :nuevo_nombre, correo = :nuevo_correo WHERE nombre = :nombre_actual');
        $stmt->bindParam(':nuevo_nombre', $nuevo_nombre);
        $stmt->bindParam(':nuevo_correo', $nuevo_correo);
        $stmt->bindParam(':nombre_actual', $nombre_anterior);
        $stmt->execute();

        // Actualiza la sesión
        $_SESSION['nombre'] = $nuevo_nombre;
        $_SESSION['correo'] = $nuevo_correo;

        header('Location: CONFIGURACION.php?success=1');
    } catch (PDOException $e) {
        header('Location: CONFIGURACION.php?error=' . urlencode('Error al actualizar: ' . $e->getMessage()));
    }
}
?>

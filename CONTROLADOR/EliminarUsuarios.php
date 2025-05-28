<?php
require_once '../MODELO/Conexion.php';

// Verificar que el id del usuario a eliminar esté disponible
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    
    // Obtener el id del usuario
    $id = $_POST['id'];

    // Conectar a la base de datos
    $conexion = conectar();

    // Eliminar el usuario de la base de datos
    $sql = "DELETE FROM usuarios WHERE id_usuario = :id";

    // Preparar la consulta
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir al usuario con un mensaje de éxito
        header("Location: ../VISTA/MODIFICAR_USUARIOS.php?status=deleted");
        exit;
    } else {
        // Redirigir al usuario con un mensaje de error
        header("Location: ../VISTA/MODIFICAR_USUARIOS.php?status=error");
        exit;
    }
} else {
    // Si no se envía el id del usuario, redirigir con error
    header("Location: ../VISTA/MODIFICAR_USUARIOS.php?status=error");
    exit;
}
?>
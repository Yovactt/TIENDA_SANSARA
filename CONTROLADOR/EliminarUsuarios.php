<?php
require_once '../MODELO/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $conexion = conectar();

    $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        // Redirige con mensaje específico para eliminación
        header("Location: ../VISTA/MODIFICAR_USUARIOS.php?mensaje_eliminar=exito");
        exit;
    } else {
        header("Location: ../VISTA/MODIFICAR_USUARIOS.php?mensaje_eliminar=error");
        exit;
    }
} else {
    header("Location: ../VISTA/MODIFICAR_USUARIOS.php?mensaje_eliminar=error");
    exit;
}
?>
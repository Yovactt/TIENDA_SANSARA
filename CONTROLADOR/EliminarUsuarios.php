<?php
require_once '../MODELO/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $conexion = conectar();

        $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: ../VISTA/MODIFICAR_USUARIOS.php?mensaje=eliminado");
            exit;
        } else {
            header("Location: ../VISTA/MODIFICAR_USUARIOS.php?mensaje=error");
            exit;
        }

    } catch (PDOException $e) {
        header("Location: ../VISTA/MODIFICAR_USUARIOS.php?mensaje=error");
        exit;
    }
} else {
    header("Location: ../VISTA/MODIFICAR_USUARIOS.php?mensaje=error");
    exit;
}
?>

<?php
require_once '../MODELO/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['nombre'], $_POST['correo'], $_POST['telefono'], $_POST['direccion'], $_POST['contrasena'], $_POST['rol'])) {
    
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    $conexion = conectar();

    $sql = "UPDATE usuarios SET nombre = :nombre, correo = :correo, telefono = :telefono, direccion = :direccion, contrasena = :contrasena, rol = :rol WHERE id_usuario = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->bindParam(':rol', $rol);

    if ($stmt->execute()) {
        // ✅ Mostrar modal con mensaje=guardar
        header("Location: ../VISTA/MODIFICAR_USUARIOS.php?mensaje=guardar");
        exit;
    } else {
        header("Location: ../VISTA/MODIFICAR_USUARIOS.php?mensaje=error");
        exit;
    }
} else {
    header("Location: ../VISTA/MODIFICAR_USUARIOS.php?mensaje=error");
    exit;
}
?>
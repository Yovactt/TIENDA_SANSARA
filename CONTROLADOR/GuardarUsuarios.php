<?php
require_once '../MODELO/Conexion.php';

// Verificar que los datos necesarios están disponibles
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['nombre'], $_POST['correo'], $_POST['telefono'], $_POST['direccion'], $_POST['contrasena'], $_POST['rol'])) {
    
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    // Conectar a la base de datos
    $conexion = conectar();

    // Actualizar los datos en la base de datos
    $sql = "UPDATE usuarios SET nombre = :nombre, correo = :correo, telefono = :telefono, direccion = :direccion, contrasena = :contrasena, rol = :rol WHERE id_usuario = :id";

    // Preparar la consulta
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->bindParam(':rol', $rol);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir al usuario con un mensaje de éxito
        header("Location: ../VISTA/MODIFICAR_USUARIOS.php?status=success");
        exit;
    } else {
        // Redirigir al usuario con un mensaje de error
        header("Location: ../VISTA/MODIFICAR_USUARIOS.php?status=error");
        exit;
    }
} else {
    // Si no se envían datos válidos, redirigir con error
    header("Location: ../VISTA/MODIFICAR_USUARIOS.php?status=error");
    exit;
}
?>
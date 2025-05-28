<?php
require_once '../MODELO/Conexion.php';

$conn = conectar();

// Recibir y sanitizar datos
$nombre = strtoupper(trim($_POST['nombre'] ?? ''));
$correo = trim($_POST['correo'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$direccion = strtoupper(trim($_POST['direccion'] ?? ''));
$contrasena = $_POST['contrasena'] ?? '';
$confirmar = $_POST['confirmar'] ?? '';
$rol = $_POST['rol'] ?? null;

// Validar que las contraseñas coincidan (opcional pero recomendable)
if ($contrasena !== $confirmar) {
    header("Location: ../VISTA/REGISTRO_DE_USUARIOS.php?error=contrasena_no_coincide");
    exit;
}

// Verificar si ya existe un usuario con ese correo
$sql_verificar = "SELECT * FROM usuarios WHERE correo = :correo";
$stmt = $conn->prepare($sql_verificar);
$stmt->bindParam(':correo', $correo);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // Si el correo ya existe, redirigir con error
    header("Location: ../VISTA/REGISTRO_DE_USUARIOS.php?error=correo_existe");
    exit;
}

// Encriptar contraseña
$password_hashed = password_hash($contrasena, PASSWORD_DEFAULT);

// Insertar nuevo usuario
$sql_insertar = "INSERT INTO usuarios (nombre, correo, telefono, direccion, contrasena, rol) 
                 VALUES (:nombre, :correo, :telefono, :direccion, :contrasena, :rol)";
$stmt = $conn->prepare($sql_insertar);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':correo', $correo);
$stmt->bindParam(':telefono', $telefono);
$stmt->bindParam(':direccion', $direccion);
$stmt->bindParam(':contrasena', $password_hashed);
$stmt->bindParam(':rol', $rol);

if ($stmt->execute()) {
    header("Location: ../VISTA/REGISTRO_DE_USUARIOS.php?registro=exito");
    exit;
} else {
    header("Location: ../VISTA/REGISTRO_DE_USUARIOS.php?error=registro_fallido");
    exit;
}
?>
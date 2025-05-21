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

// Validar nombre (solo letras y espacios)
if (!preg_match("/^[A-ZÁÉÍÓÚÑ ]+$/", $nombre)) {
    echo "<script>alert('El nombre solo debe contener letras y espacios.'); window.history.back();</script>";
    exit;
}

// Verificar que las contraseñas coincidan
if ($contrasena !== $confirmar) {
    echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
    exit;
}

// Verificar si ya existe un usuario con ese correo
$sql_verificar = "SELECT * FROM usuarios WHERE correo = :correo";
$stmt = $conn->prepare($sql_verificar);
$stmt->bindParam(':correo', $correo);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "<script>alert('El correo ya está registrado.'); window.history.back();</script>";
    exit;
}

// Encriptar contraseña
$password_hashed = password_hash($contrasena, PASSWORD_DEFAULT);

// Insertar usuario
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
    echo "<script>alert('Usuario registrado correctamente.'); window.location.href='../VISTA/REGISTRO_DE_USUARIOS.php';</script>";
} else {
    echo "<script>alert('Error al registrar el usuario.'); window.history.back();</script>";
}
?>

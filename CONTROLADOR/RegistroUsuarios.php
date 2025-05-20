<?php
require_once '../MODELO/Conexion.php';

$conn = conectar();

// Recibir y sanitizar datos
$nombre = strtoupper(trim($_POST['nombre']));
$correo = trim($_POST['correo']);
$telefono = trim($_POST['telefono']);
$direccion = strtoupper(trim($_POST['direccion']));
$contrasena = $_POST['contrasena'];
$confirmar = $_POST['confirmar'];
$rol = isset($_POST['rol']) ? $_POST['rol'] : null;

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
$sql_verificar = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql_verificar);
if (!$stmt) {
    echo "<script>alert('Error al preparar la consulta de verificación.'); window.history.back();</script>";
    exit;
}
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('El correo ya está registrado.'); window.history.back();</script>";
    $stmt->close();
    exit;
}
$stmt->close();

// Encriptar contraseña
$password_hashed = password_hash($contrasena, PASSWORD_DEFAULT);

// Insertar usuario
$sql = "INSERT INTO usuarios (nombre, correo, telefono, direccion, contrasena, rol) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "<script>alert('Error al preparar la consulta de inserción.'); window.history.back();</script>";
    exit;
}
$stmt->bind_param("ssssss", $nombre, $correo, $telefono, $direccion, $password_hashed, $rol);
$success = $stmt->execute();

if ($success) {
    echo "<script>alert('Usuario registrado correctamente.'); window.location.href='../VISTA/REGISTRO_DE_USUARIOS.php';</script>";
} else {
    echo "<script>alert('Error al registrar el usuario: " . $stmt->error . "'); window.history.back();</script>";
}
$stmt->close();
$conn->close();
?>
<?php
require_once '../MODELO/Conexion.php';

$conn = conectar();

$nombre = strtoupper(trim($_POST['nombre'] ?? ''));
$correo = trim($_POST['correo'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$direccion = strtoupper(trim($_POST['direccion'] ?? ''));
$contrasena = $_POST['contrasena'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';
$rol = $_POST['rol'] ?? 'usuario'; // Por ejemplo, asignamos un rol por defecto

// Validar campos obligatorios
if (empty($nombre) || empty($correo) || empty($telefono) || empty($direccion) || empty($contrasena) || empty($confirmPassword)) {
    header("Location: ../VISTA/REGISTRO_DE_USUARIOS.php?error=campos_vacios");
    exit;
}

// Validar formato correo (opcional pero recomendado)
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../VISTA/REGISTRO_DE_USUARIOS.php?error=correo_invalido");
    exit;
}

// Validar que contraseñas coincidan
if ($contrasena !== $confirmPassword) {
    header("Location: ../VISTA/REGISTRO_DE_USUARIOS.php?error=contrasena_no_coincide");
    exit;
}

// Validar rol permitido (opcional)
$roles_permitidos = ['gerente', 'cajero', 'vendedor']; // ejemplo
if (!in_array($rol, $roles_permitidos)) {
    $rol = 'usuario'; // asignar rol por defecto si no es válido
}

// Verificar si el correo ya existe
$sql_verificar = "SELECT 1 FROM usuarios WHERE correo = :correo";
$stmt = $conn->prepare($sql_verificar);
$stmt->bindParam(':correo', $correo);
$stmt->execute();

if ($stmt->fetchColumn()) {
    header("Location: ../VISTA/REGISTRO_DE_USUARIOS.php?error=correo_existe");
    exit;
}

// Hashear la contraseña antes de guardar
$contrasena_hashed = password_hash($contrasena, PASSWORD_DEFAULT);

// Insertar usuario
$sql_insertar = "INSERT INTO usuarios (nombre, correo, telefono, direccion, contrasena, rol) 
                 VALUES (:nombre, :correo, :telefono, :direccion, :contrasena, :rol)";
$stmt = $conn->prepare($sql_insertar);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':correo', $correo);
$stmt->bindParam(':telefono', $telefono);
$stmt->bindParam(':direccion', $direccion);
$stmt->bindParam(':contrasena', $contrasena_hashed);
$stmt->bindParam(':rol', $rol);

if ($stmt->execute()) {
    header("Location: ../VISTA/REGISTRO_DE_USUARIOS.php?registro=exito");
    exit;
} else {
    header("Location: ../VISTA/REGISTRO_DE_USUARIOS.php?error=registro_fallido");
    exit;
}
?>

<?php
require_once '../MODELO/Conexion.php';

$conn = conectar();

// Obtener datos del formulario
$nombre = trim($_POST['nombre']);
$correo = trim($_POST['correo']);
$telefono = trim($_POST['telefono']);
$direccion = trim($_POST['direccion']);
$password = trim($_POST['contrasena']);
$rol = "administrador";

// Validación de campos vacíos
if (empty($nombre) || empty($correo) || empty($telefono) || empty($direccion) || empty($password)) {
    echo "<script>
        alert('Por favor, completa todos los campos.');
        window.location.href = '../SANSARA/index.php';
    </script>";
    exit();
}

// Validación de formato de correo
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo "<script>
        alert('Correo no válido.');
        window.location.href = '../SANSARA/index.php';
    </script>";
    exit();
}

// Hashear la contraseña
$passwordHashed = password_hash($password, PASSWORD_DEFAULT);

// Verificar si ya existe un administrador
$sql_verificar = "SELECT * FROM usuarios WHERE rol = :rol";
$stmt = $conn->prepare($sql_verificar);
$stmt->execute([':rol' => $rol]);
$resultado = $stmt->fetchAll();

if (count($resultado) > 0) {
    // Ya existe un administrador
    echo "<script>
        alert('Ya existe un administrador registrado.');
        window.location.href = '../SANSARA/index.php';
    </script>";
    exit();
}

// Insertar nuevo administrador
$sql = "INSERT INTO usuarios (nombre, correo, telefono, direccion, contrasena, rol)
        VALUES (:nombre, :correo, :telefono, :direccion, :contrasena, :rol)";
$stmt = $conn->prepare($sql);

$params = [
    ':nombre' => $nombre,
    ':correo' => $correo,
    ':telefono' => $telefono,
    ':direccion' => $direccion,
    ':contrasena' => $passwordHashed,
    ':rol' => $rol
];

if ($stmt->execute($params)) {
    // Registro exitoso, redirige con parámetro para mostrar modal en index.php
   header("Location: ../index.php?registro=exito");
    exit();
} else {
    echo "<script>
        alert('Ocurrió un error al registrar. Intente más tarde.');
        window.location.href = '/SANSARA/index.php';
    </script>";
    exit();
}
?>
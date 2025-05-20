<?php
include '../MODELO/Conexion.php';

$token = $_POST['token'];
$nueva = $_POST['nueva_contrasena'];
$confirmar = $_POST['confirmar_contrasena'];

if ($nueva !== $confirmar) {
    echo "<script>alert('Las contraseñas no coinciden.');window.history.back();</script>";
    exit();
}

$query = $conexion->prepare("SELECT correo FROM recuperaciones WHERE token = :token AND expiracion > NOW()");
$query->execute(['token' => $token]);

if ($query->rowCount() == 0) {
    echo "<script>alert('Token inválido o expirado.');window.location.href='../INDEX.php';</script>";
    exit();
}

$correo = $query->fetch()['correo'];
$hashed = password_hash($nueva, PASSWORD_DEFAULT);

// Actualiza contraseña
$update = $conexion->prepare("UPDATE usuarios SET contrasena = :contrasena WHERE correo = :correo");
$update->execute(['contrasena' => $hashed, 'correo' => $correo]);

// Elimina token usado
$delete = $conexion->prepare("DELETE FROM recuperaciones WHERE correo = :correo");
$delete->execute(['correo' => $correo]);

echo "<script>alert('Contraseña actualizada correctamente.');window.location.href='../INDEX.php';</script>";
?>

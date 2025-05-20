<?php
require_once '../MODELO/Conexion.php';

$conn = conectar();

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$password = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
$rol = "administrador";

// Verificar si ya existe un administrador
$sql_verificar = "SELECT * FROM usuarios WHERE rol = ?";
$stmt = $conn->prepare($sql_verificar);
$stmt->bind_param("s", $rol);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo "<script>alert('Ya existe un administrador registrado.'); window.location.href='../INDEX.php';</script>";
} else {
    $sql = "INSERT INTO usuarios (nombre, correo, telefono, direccion, contrasena, rol)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nombre, $correo, $telefono, $direccion, $password, $rol);

    if ($stmt->execute()) {
        echo "<script>alert('Administrador registrado correctamente. Puedes iniciar sesión.'); window.location.href='../INDEX.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>
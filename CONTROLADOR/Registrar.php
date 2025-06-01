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
$sql_verificar = "SELECT * FROM usuarios WHERE rol = :rol";
$stmt = $conn->prepare($sql_verificar);
$stmt->execute([':rol' => $rol]);
$resultado = $stmt->fetchAll();

if (count($resultado) > 0) {
    echo "<script>alert('Ya existe un administrador registrado.'); window.location.href='../index.php';</script>";
} else {
    $sql = "INSERT INTO usuarios (nombre, correo, telefono, direccion, contrasena, rol)
            VALUES (:nombre, :correo, :telefono, :direccion, :contrasena, :rol)";
    $stmt = $conn->prepare($sql);

    $params = [
        ':nombre' => $nombre,
        ':correo' => $correo,
        ':telefono' => $telefono,
        ':direccion' => $direccion,
        ':contrasena' => $password,
        ':rol' => $rol
    ];

   if ($stmt->execute($params)) {
    header("Location: ../index.php?registro=exito");
    exit();
    } else {
        $error = $stmt->errorInfo();
        echo "Error: " . $error[2];
    }
}

// No es necesario cerrar con PDO, se cierra solo al terminar el script
?>
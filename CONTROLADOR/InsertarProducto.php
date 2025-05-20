<?php
require 'Conexion.php';

$conn = conectar();

// Obtener datos del formulario
$categoria = $_POST['categoria'];
$tipo = $_POST['tipo'];
$modelo = $_POST['modelo'];
$color = $_POST['color'];
$talla = $_POST['talla'];
$stock = $_POST['stock'];
$precio = $_POST['precio'];
$sucursal = $_POST['sucursal'];

// Preparar e insertar
$sql = "INSERT INTO producto (categoria, tipo, modelo, color, talla, stock, precio, sucursal)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssids", $categoria, $tipo, $modelo, $color, $talla, $stock, $precio, $sucursal);

if ($stmt->execute()) {
    echo "ok";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>

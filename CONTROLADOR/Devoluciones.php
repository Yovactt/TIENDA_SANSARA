<?php
require_once '../MODELO/Conexion.php';
$conn = conectar();

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['etiqueta'])) {
    $etiqueta = $_GET['etiqueta'];

    $stmt = $conn->prepare("SELECT modelo, talla, color, precio FROM productos WHERE etiqueta = ?");
    $stmt->execute([$etiqueta]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        echo json_encode(["success" => true, "producto" => $producto]);
    } else {
        echo json_encode(["success" => false, "mensaje" => "Producto no encontrado"]);
    }
} else {
    echo json_encode(["success" => false, "mensaje" => "Etiqueta no proporcionada"]);
}

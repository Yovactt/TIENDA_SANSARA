<?php
header('Content-Type: application/json');

if (!isset($_GET['codigo'])) {
    echo json_encode(['error' => 'Código no especificado']);
    exit;
}

require_once('../MODELO/Conexion.php');


$conn = conectar();

$codigo = $_GET['codigo'];

// OPCIONAL: Forzar a string para evitar problemas con ceros
$codigo = strval($codigo);

$sql = "SELECT modelo, precio FROM productos WHERE etiqueta = :codigo LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':codigo', $codigo);
$stmt->execute();

$producto = $stmt->fetch();

if ($producto) {
    echo json_encode($producto);
} else {
    echo json_encode([
        'error' => 'Producto no encontrado',
        'codigo_enviado' => $codigo,
        'sql' => $sql
    ]);
}

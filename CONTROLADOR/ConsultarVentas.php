<?php
require_once '../MODELO/Conexion.php';
$pdo = conectar();

// Forzar zona horaria correcta en PHP
date_default_timezone_set('America/Mexico_City');

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

$fecha = $input['fecha'] ?? '';
$sucursal = $input['sucursal'] ?? '';

if (!$fecha || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
    echo json_encode(['ventas' => []]);
    exit;
}

// Consulta con JOIN para unir ventas y detalles_venta
$sql = "
SELECT 
    DATE(v.fecha) AS fecha,
    d.producto,
    d.modelo,
    d.cantidad,
    d.total,
    v.sucursal
FROM ventas v
JOIN detalles_venta d ON v.id_venta = d.id_venta
WHERE DATE(v.fecha) = :fecha
";

$params = [':fecha' => $fecha];

if (!empty($sucursal)) {
    $sql .= " AND v.sucursal = :sucursal";
    $params[':sucursal'] = $sucursal;
}

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['ventas' => $ventas]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}

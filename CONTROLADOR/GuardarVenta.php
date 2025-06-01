<?php
require_once '../MODELO/Conexion.php';

header('Content-Type: application/json');

$conn = conectar();

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['productos']) || !isset($data['total'])) {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    exit;
}

$productos = $data['productos'];
$totalVenta = $data['total'];

try {
    // Iniciar transacción
    $conn->beginTransaction();

    // 1. Verificar disponibilidad de cada producto
    foreach ($productos as $prod) {
        $stmt = $conn->prepare("SELECT cantidad FROM productos WHERE etiqueta = :etiqueta");
        $stmt->execute([':etiqueta' => $prod['producto']]);
        $cantidadDisponible = $stmt->fetchColumn();

        if ($cantidadDisponible === false) {
            throw new Exception("Producto no encontrado: " . $prod['producto']);
        }

        if ($prod['cantidad'] > $cantidadDisponible) {
            throw new Exception("Stock insuficiente para el producto " . $prod['producto'] . ". Disponibles: $cantidadDisponible");
        }
    }

    // 2. Insertar venta y obtener ID
    $stmt = $conn->prepare("INSERT INTO ventas (total) VALUES (:total) RETURNING id_venta");
    $stmt->execute([':total' => $totalVenta]);
    $idVenta = $stmt->fetchColumn();

    // 3. Insertar detalles y actualizar inventario
    $stmtDetalle = $conn->prepare("INSERT INTO detalles_venta (id_venta, producto, modelo, cantidad, precio_unitario, total) VALUES (:id_venta, :producto, :modelo, :cantidad, :precio_unitario, :total)");
    $stmtUpdate = $conn->prepare("UPDATE productos SET cantidad = cantidad - :cantidad WHERE etiqueta = :etiqueta");

    foreach ($productos as $prod) {
        // Insertar detalle
        $stmtDetalle->execute([
            ':id_venta' => $idVenta,
            ':producto' => $prod['producto'],
            ':modelo' => $prod['modelo'],
            ':cantidad' => $prod['cantidad'],
            ':precio_unitario' => $prod['precio_unitario'],
            ':total' => $prod['total'],
        ]);

        // Descontar inventario
        $stmtUpdate->execute([
            ':cantidad' => $prod['cantidad'],
            ':etiqueta' => $prod['producto'],
        ]);
    }

    $conn->commit();
    echo json_encode(['success' => true, 'id_venta' => $idVenta]);

} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

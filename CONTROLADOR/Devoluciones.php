<?php
require_once '../MODELO/Conexion.php';
$conn = conectar();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['etiqueta'])) {
    $etiqueta = trim($_GET['etiqueta']);

    try {
        // Buscar cantidad vendida
        $stmtVenta = $conn->prepare("SELECT COALESCE(SUM(cantidad), 0) AS cantidad_vendida FROM detalles_venta WHERE producto = ?");
        $stmtVenta->execute([$etiqueta]);
        $venta = $stmtVenta->fetch(PDO::FETCH_ASSOC);

        if (!$venta || $venta['cantidad_vendida'] == 0) {
            echo json_encode([
                "success" => false,
                "mensaje" => "Etiqueta no encontrada en ventas"
            ]);
            exit;
        }

        // Obtener detalles del producto
        $stmtProducto = $conn->prepare("SELECT modelo, talla, color, precio FROM productos WHERE etiqueta = ?");
        $stmtProducto->execute([$etiqueta]);
        $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);

        if (!$producto) {
            echo json_encode([
                "success" => false,
                "mensaje" => "Producto no encontrado en productos"
            ]);
            exit;
        }

        echo json_encode([
            "success" => true,
            "producto" => $producto,
            "cantidad_vendida" => (int)$venta['cantidad_vendida']
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "mensaje" => "Error del servidor: " . $e->getMessage()
        ]);
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $etiqueta = trim($input['etiqueta'] ?? '');
    $motivo = trim($input['motivo'] ?? '');
    $cantidad = (int)($input['cantidad'] ?? 0);

    if (!$etiqueta || !$cantidad || !$motivo) {
        echo json_encode([
            "success" => false,
            "mensaje" => "Datos incompletos"
        ]);
        exit;
    }

    try {
        // Obtener detalles del producto para insertar la devolución
        $stmtProducto = $conn->prepare("SELECT modelo, talla, color, precio FROM productos WHERE etiqueta = ?");
        $stmtProducto->execute([$etiqueta]);
        $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);

        if (!$producto) {
            echo json_encode([
                "success" => false,
                "mensaje" => "Producto no encontrado"
            ]);
            exit;
        }

        // Obtener la cantidad actual disponible en detalles_venta (ya descontadas devoluciones anteriores)
        $stmtVenta = $conn->prepare("SELECT cantidad FROM detalles_venta WHERE producto = ?");
        $stmtVenta->execute([$etiqueta]);
        $venta = $stmtVenta->fetch(PDO::FETCH_ASSOC);

        $cantidad_disponible = $venta ? (int)$venta['cantidad'] : 0;

        if ($cantidad > $cantidad_disponible) {
            echo json_encode([
                "success" => false,
                "mensaje" => "Cantidad a devolver excede la cantidad disponible. Disponible: $cantidad_disponible"
            ]);
            exit;
        }

        // Insertar la devolución
        $stmtInsert = $conn->prepare("INSERT INTO devoluciones (etiqueta, producto, talla, color, precio, cantidad, motivo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmtInsert->execute([
            $etiqueta,
            $producto['modelo'],
            $producto['talla'],
            $producto['color'],
            $producto['precio'],
            $cantidad,
            $motivo
        ]);

        // Actualizar la cantidad en detalles_venta restando la cantidad devuelta
        $stmtUpdate = $conn->prepare("UPDATE detalles_venta SET cantidad = cantidad - ? WHERE producto = ?");
        $stmtUpdate->execute([$cantidad, $etiqueta]);

        echo json_encode([
            "success" => true,
            "mensaje" => "Devolución registrada correctamente"
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "mensaje" => "Error del servidor: " . $e->getMessage()
        ]);
    }
}

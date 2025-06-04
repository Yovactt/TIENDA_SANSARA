<?php
require_once '../MODELO/Conexion.php';
$conn = conectar();

date_default_timezone_set('America/Mexico_City');
header('Content-Type: application/json; charset=utf-8');

// Obtener devolución (GET por etiqueta)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['etiqueta'])) {
    $etiqueta = $_GET['etiqueta'];

    $sql = "SELECT dv.producto, SUM(dv.cantidad) AS cantidad_vendida, p.modelo, p.talla, p.color, p.precio
            FROM detalles_venta dv
            JOIN productos p ON dv.producto = p.etiqueta
            WHERE dv.producto = ?
            GROUP BY dv.producto, p.modelo, p.talla, p.color, p.precio";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$etiqueta]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo json_encode([
            "success" => true,
            "producto" => [
                "modelo" => $resultado['modelo'],
                "talla" => $resultado['talla'],
                "color" => $resultado['color'],
                "precio" => $resultado['precio']
            ],
            "cantidad_vendida" => (int)$resultado['cantidad_vendida']
        ]);
    } else {
        echo json_encode(["success" => false, "mensaje" => "Etiqueta no encontrada en ventas"]);
    }
    exit;
}

// Registrar devolución (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['etiqueta'], $input['motivo'], $input['cantidad'])) {
        echo json_encode(["success" => false, "mensaje" => "Faltan datos para registrar devolución."]);
        exit;
    }

    $etiqueta = $input['etiqueta'];
    $motivo = $input['motivo'];
    $cantidad = (int)$input['cantidad'];
    $fecha = date("Y-m-d H:i:s");

    // Verificar cuántas unidades se han vendido
    $sqlCantidad = "SELECT SUM(cantidad) AS cantidad_vendida FROM detalles_venta WHERE producto = ?";
    $stmtCantidad = $conn->prepare($sqlCantidad);
    $stmtCantidad->execute([$etiqueta]);
    $res = $stmtCantidad->fetch(PDO::FETCH_ASSOC);
    $vendidas = (int)$res['cantidad_vendida'];

    if ($cantidad > $vendidas) {
        echo json_encode([
            "success" => false,
            "mensaje" => "No se puede devolver más de la cantidad vendida"
        ]);
        exit;
    }

    // Insertar en la tabla devoluciones
    $sqlInsert = "INSERT INTO devoluciones (etiqueta, motivo, cantidad, fecha) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sqlInsert);
    $insertado = $stmt->execute([$etiqueta, $motivo, $cantidad, $fecha]);

    if ($insertado) {
        // Actualizar detalles_venta para reflejar la devolución
        $sqlUpdate = "UPDATE detalles_venta SET cantidad = cantidad - ?
                      WHERE producto = ? AND cantidad >= ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->execute([$cantidad, $etiqueta, $cantidad]);

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "mensaje" => "No se pudo registrar la devolución."]);
    }
    exit;
}

// Si no es GET ni POST válido
echo json_encode(["success" => false, "mensaje" => "Solicitud no válida."]);

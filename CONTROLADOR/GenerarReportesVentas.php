<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../MODELO/Conexion.php';

header('Content-Type: application/json');

if (!isset($_POST['sucursal_ventas'], $_POST['fecha_inicio_ventas'], $_POST['fecha_fin_ventas'])) {
    echo json_encode(['error' => 'Faltan datos para generar el reporte.']);
    exit;
}

$sucursal = $_POST['sucursal_ventas'];
$fechaInicio = $_POST['fecha_inicio_ventas'];
$fechaFin = $_POST['fecha_fin_ventas'];

try {
    $conexion = conectar();

    $sql = "
    SELECT
        v.sucursal,
        v.fecha::date AS fecha,
        d.producto,
        d.modelo AS categoria,
        d.cantidad,
        d.total
    FROM ventas v
    INNER JOIN detalles_venta d ON v.id_venta = d.id_venta
    WHERE v.sucursal = :sucursal
      AND v.fecha BETWEEN :fecha_inicio AND (:fecha_fin::date + INTERVAL '1 day' - INTERVAL '1 second')
    ORDER BY v.fecha DESC
";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':sucursal', $sucursal);
    $stmt->bindParam(':fecha_inicio', $fechaInicio);
    $stmt->bindParam(':fecha_fin', $fechaFin);
    $stmt->execute();

    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlDevoluciones = "
    SELECT
        etiqueta,
        producto,
        talla,
        color,
        precio,
        cantidad,
        (precio * cantidad) AS total
    FROM devoluciones
    WHERE fecha BETWEEN :fecha_inicio AND (:fecha_fin::date + INTERVAL '1 day' - INTERVAL '1 second')
      AND etiqueta IN (
          SELECT d.producto
          FROM ventas v
          INNER JOIN detalles_venta d ON v.id_venta = d.id_venta
          WHERE v.sucursal = :sucursal
      )
    ORDER BY fecha DESC
";


    $stmtDev = $conexion->prepare($sqlDevoluciones);
    $stmtDev->bindParam(':sucursal', $sucursal);
    $stmtDev->bindParam(':fecha_inicio', $fechaInicio);
    $stmtDev->bindParam(':fecha_fin', $fechaFin);
    $stmtDev->execute();

    $devoluciones = $stmtDev->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "ventas" => $ventas,
        "devoluciones" => $devoluciones
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    exit;
} catch (Exception $e) {
    echo json_encode(['error' => 'Error general: ' . $e->getMessage()]);
    exit;
}

<?php
require_once '../MODELO/Conexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sucursal = $_POST['sucursal_ventas'];
    $fecha_inicio = $_POST['fecha_inicio_ventas'];
    $fecha_fin = $_POST['fecha_fin_ventas'];

    try {
        $conn = conectar();
$sql = "SELECT 
            p.categoria_id AS producto,
            dv.cantidad,
            v.sucursal,
            v.fecha AS fecha
        FROM ventas v
        JOIN detalle_venta dv ON v.id_venta = dv.id_venta
        JOIN productos p ON dv.id_producto = p.id
        WHERE v.sucursal = :sucursal
          AND v.fecha_registro BETWEEN :fecha_inicio AND :fecha_fin
        ORDER BY v.fecha DESC";


        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':sucursal' => $sucursal,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_fin' => $fecha_fin
        ]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>

<?php
// Conexión a la base de datos
require_once '../MODELO/Conexion.php';

$sucursal = $_POST['sucursal_inventario'];
$umbral = 10; // Puedes ajustar este valor según tus necesidades

$sql = "SELECT
            c.nombre AS categoria,
            i.stock AS cantidad,
            i.sucursal,
            p.fecha_registro::date AS fecha
        FROM inventario i
        JOIN productos p ON i.id_producto = p.id
        JOIN categorias c ON p.categoria_id = c.id
        WHERE i.sucursal = :sucursal
          AND i.stock <= :umbral
        ORDER BY i.stock ASC";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':sucursal', $sucursal);
$stmt->bindParam(':umbral', $umbral);
$stmt->execute();

$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($resultados);
?>

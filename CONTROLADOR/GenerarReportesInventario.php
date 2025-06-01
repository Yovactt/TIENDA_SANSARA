<?php
require_once '../MODELO/Conexion.php';

header('Content-Type: application/json');

// Mostrar errores para depuración (puedes quitar esto en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    if (!isset($_POST['sucursal_inventario'])) {
        echo json_encode(['error' => 'Falta la sucursal']);
        exit;
    }

    $sucursal = $_POST['sucursal_inventario'];

    $conn = conectar();

    $sql = "SELECT 
                p.modelo AS producto,
                c.nombre AS categoria,
                p.cantidad AS stock_actual,
                p.sucursal
            FROM productos p
            JOIN categorias c ON p.categoria_id = c.id
            WHERE p.sucursal = :sucursal AND p.cantidad < 10";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sucursal', $sucursal);
    $stmt->execute();

    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($productos);

} catch (Exception $e) {
    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
}

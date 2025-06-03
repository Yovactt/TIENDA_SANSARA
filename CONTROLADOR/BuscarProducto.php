<?php
header('Content-Type: application/json');

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

require_once('../MODELO/Conexion.php');

try {
    $conn = conectar();

    if (!isset($_GET['codigo']) || trim($_GET['codigo']) === '') {
        echo json_encode(['error' => 'Código inválido']);
        exit;
    }

    $codigo = trim($_GET['codigo']);

    // Usamos 'cantidad' como el stock disponible
    $sql = "SELECT modelo, precio, cantidad FROM productos WHERE etiqueta = :codigo LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
    $stmt->execute();

    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        // Renombramos 'cantidad' a 'stock' para el frontend
        $producto['stock'] = (int)$producto['cantidad'];
        unset($producto['cantidad']); // opcional: limpiar para no enviar ambos nombres
        echo json_encode($producto);
    } else {
        echo json_encode(['error' => 'Producto no encontrado']);
    }

    $conn = null;

} catch (PDOException $e) {
    error_log($e->getMessage());
    echo json_encode(['error' => 'Error interno del servidor']);
}
?>

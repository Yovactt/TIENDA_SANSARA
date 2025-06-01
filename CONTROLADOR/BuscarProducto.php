<?php
header('Content-Type: application/json');

require_once('../MODELO/Conexion.php');

try {
    $conn = conectar();

    if (!isset($_GET['codigo']) || trim($_GET['codigo']) === '') {
        echo json_encode(['error' => 'Código vacío o no especificado']);
        exit;
    }

    $codigo = trim($_GET['codigo']);

    $sql = "SELECT modelo, precio FROM productos WHERE etiqueta = :codigo LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
    $stmt->execute();

    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        echo json_encode($producto);
    } else {
        echo json_encode(['error' => 'Producto no encontrado']);
    }

    $conn = null; // Opcional: cerrar conexión

} catch (PDOException $e) {
    error_log($e->getMessage()); // Guardar en log, no mostrar al usuario
    echo json_encode(['error' => 'Error de base de datos']);
}
?>
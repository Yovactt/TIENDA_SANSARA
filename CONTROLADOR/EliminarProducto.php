<?php
require '/SANSARA/MODELO/Conexion.php';

$conn = conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
        exit;
    }

    $sql = "DELETE FROM productos WHERE id = :id";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute(['id' => $id])) {
        echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar producto']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>

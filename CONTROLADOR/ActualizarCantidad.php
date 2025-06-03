<?php
// Evitar espacios antes de <?php y después del cierre PHP (mejor no cerrar PHP)

// Mostrar todos los errores (solo para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

require_once 'MODELO/Conexion.php'; // Ajusta la ruta si es necesario

// Guardar log para depurar (opcional)
file_put_contents('debug.log', "POST RECIBIDO: " . print_r($_POST, true), FILE_APPEND);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
    $cantidad = isset($_POST["cantidad"]) ? intval($_POST["cantidad"]) : -1;

    if ($id <= 0 || $cantidad < 0) {
        echo json_encode(["success" => false, "message" => "Datos inválidos"]);
        exit;
    }

    try {
        $pdo = conectar();

        $sql = "UPDATE productos SET cantidad = :cantidad WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "Cantidad actualizada correctamente"]);
        } else {
            echo json_encode(["success" => false, "message" => "No se actualizó ningún registro (ID no encontrado)"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error de base de datos: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
}

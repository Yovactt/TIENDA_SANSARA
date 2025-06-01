<?php
require_once '../MODELO/Conexion.php';
$conn = conectar();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['etiqueta'], $data['motivo'], $data['cantidad'])) {
        $etiqueta = $data['etiqueta'];
        $motivo = $data['motivo'];
        $cantidad = $data['cantidad'];

        try {
            // Buscar producto
            $stmt = $conn->prepare("SELECT modelo, talla, color, precio FROM productos WHERE etiqueta = ?");
            $stmt->execute([$etiqueta]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($producto) {
                // Insertar devolución
                $stmtInsert = $conn->prepare("
                    INSERT INTO devoluciones (etiqueta, producto, talla, color, precio, cantidad, motivo, fecha)
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
                ");
                $resultado = $stmtInsert->execute([
                    $etiqueta,
                    $producto['modelo'],
                    $producto['talla'],
                    $producto['color'],
                    $producto['precio'],
                    $cantidad,
                    $motivo
                ]);

                if ($resultado) {
                    echo json_encode([
                        "success" => true,
                        "mensaje" => "Devolución registrada exitosamente"
                    ]);
                } else {
                    echo json_encode([
                        "success" => false,
                        "mensaje" => "Error al registrar la devolución en la base de datos"
                    ]);
                }
            } else {
                echo json_encode([
                    "success" => false,
                    "mensaje" => "Producto no encontrado"
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "success" => false,
                "mensaje" => "Error del servidor: " . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "mensaje" => "Datos incompletos"
        ]);
    }
    exit;
}

// Consulta GET para buscar producto por etiqueta
if (isset($_GET['etiqueta'])) {
    $etiqueta = $_GET['etiqueta'];

    $stmt = $conn->prepare("SELECT modelo, talla, color, precio FROM productos WHERE etiqueta = ?");
    $stmt->execute([$etiqueta]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        echo json_encode(["success" => true, "producto" => $producto]);
    } else {
        echo json_encode(["success" => false, "mensaje" => "Producto no encontrado"]);
    }
} else {
    echo json_encode(["success" => false, "mensaje" => "Etiqueta no proporcionada"]);
}

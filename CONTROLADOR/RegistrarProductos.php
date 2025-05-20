<?php
require_once '../MODELO/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modelo = $_POST['modelo'] ?? '';
    $categoria_id = $_POST['categoria'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $color = $_POST['color'] ?? '';
    $talla = $_POST['talla'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $sucursal_id = $_POST['sucursal'] ?? '';



    $conn = conectar();

    // Verifica si el producto ya existe (por modelo, talla y color)
    $stmt = $conn->prepare("SELECT id FROM productos WHERE modelo = ? AND talla = ? AND color = ?");
    $stmt->bind_param("sss", $modelo, $talla, $color);
    $stmt->execute();
    $stmt->bind_result($producto_id);
    $stmt->fetch();
    $stmt->close();

    if (!$producto_id) {
        // Insertar producto
        $stmt = $conn->prepare("INSERT INTO productos (modelo, categoria_id, tipo, color, talla, precio) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssd", $modelo, $categoria_id, $tipo, $color, $talla, $precio);
        if ($stmt->execute()) {
            $producto_id = $stmt->insert_id;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar el producto.']);
            $stmt->close();
            $conn->close();
            exit;
        }
        $stmt->close();
    }

    // Insertar en inventario
    $stmt = $conn->prepare("INSERT INTO inventario (producto_id, sucursal_id, cantidad) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $producto_id, $sucursal_id, $stock);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Producto registrado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar el inventario.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
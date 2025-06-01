<?php
session_start();

date_default_timezone_set('America/Mexico_City');
require_once '../MODELO/Conexion.php';

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['administrador', 'gerente'])) {
    header("Location: ../VISTA/REGISTRAR_PRODUCTOS.php?mensaje=" . urlencode("❌ No tienes permisos para registrar productos.") . "&tipo=error");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modelo = trim($_POST["modelo"] ?? '');
    $precio = trim($_POST["precio"] ?? '');
    $color = trim($_POST["color"] ?? '');
    $talla = trim($_POST["talla"] ?? '');
    $marca = trim($_POST["marca"] ?? '');
    $etiqueta = trim($_POST["etiqueta"] ?? '');
    $categoria_id = isset($_POST["categoria_id"]) ? (int)$_POST["categoria_id"] : null;
    $sucursal = trim($_POST["sucursal"] ?? '');
    $cantidad = trim($_POST["cantidad"] ?? '');

    // Ya no hay restricción para sucursal para gerente

    if (empty($etiqueta)) {
        $nombreCategoria = [
            1 => 'Dama', 2 => 'Caballero', 3 => 'Niño', 4 => 'Niña', 5 => 'Sandalia', 6 => 'Chachara'
        ][$categoria_id] ?? 'General';

        $etiqueta = substr(time(), -5);
    }

    if (empty($modelo) || empty($categoria_id) || empty($talla) || empty($color) || empty($precio)) {
        header("Location: ../VISTA/REGISTRAR_PRODUCTOS.php?mensaje=" . urlencode("❗Completa todos los campos obligatorios.") . "&tipo=error");
        exit;
    }

    try {
        $conn = conectar();

        $verificar = $conn->prepare("SELECT COUNT(*) FROM productos WHERE modelo = :modelo AND talla = :talla AND sucursal = :sucursal");
        $verificar->bindParam(':modelo', $modelo);
        $verificar->bindParam(':talla', $talla);
        $verificar->bindParam(':sucursal', $sucursal);
        $verificar->execute();
        $existe = $verificar->fetchColumn();

        if ($existe > 0) {
            header("Location: ../VISTA/REGISTRAR_PRODUCTOS.php?mensaje=" . urlencode("⚠️ El producto ya existe con ese modelo, talla y sucursal.") . "&tipo=error");
            exit;
        } else {
            $stmt = $conn->prepare("INSERT INTO productos
                (modelo, categoria_id, talla, color, precio, marca, etiqueta, sucursal, cantidad)
                VALUES (:modelo, :categoria_id, :talla, :color, :precio, :marca, :etiqueta, :sucursal, :cantidad)");

            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':categoria_id', $categoria_id);
            $stmt->bindParam(':talla', $talla);
            $stmt->bindParam(':color', $color);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':etiqueta', $etiqueta);
            $stmt->bindParam(':sucursal', $sucursal);
            $stmt->bindParam(':cantidad', $cantidad);

            if ($stmt->execute()) {
                header("Location: ../VISTA/REGISTRAR_PRODUCTOS.php?registroP=exito");
                exit;
            } else {
                header("Location: ../VISTA/REGISTRAR_PRODUCTOS.php?mensaje=" . urlencode("❌ Error al registrar el producto.") . "&tipo=error");
                exit;
            }
        }
    } catch (PDOException $e) {
        header("Location: ../VISTA/REGISTRAR_PRODUCTOS.php?mensaje=" . urlencode("❌ Error de PDO: " . $e->getMessage()) . "&tipo=error");
        exit;
    }
}
?>
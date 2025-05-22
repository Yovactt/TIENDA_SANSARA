<?php
date_default_timezone_set('America/Mexico_City');
require_once '../MODELO/Conexion.php';

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

    if (empty($modelo) || empty($categoria_id) || empty($talla) || empty($color) || empty($precio)) {
        header("Location: ../VISTA/REGISTRAR_PRODUCTOS.php?mensaje=" . urlencode("❗Completa todos los campos obligatorios.") . "&tipo=error");
        exit;
    }

    try {
        $conn = conectar();

        $verificar = $conn->prepare("SELECT COUNT(*) FROM productos WHERE modelo = :modelo AND talla = :talla");
        $verificar->bindParam(':modelo', $modelo);
        $verificar->bindParam(':talla', $talla);
        $verificar->execute();
        $existe = $verificar->fetchColumn();

        if ($existe > 0) {
            header("Location: ../VISTA/REGISTRAR_PRODUCTOS.php?mensaje=" . urlencode("⚠️ El producto ya existe con ese modelo y talla.") . "&tipo=error");
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
                header("Location: ../VISTA/REGISTRAR_PRODUCTOS.php?mensaje=" . urlencode("✅ Producto registrado correctamente.") . "&tipo=success");
            } else {
                header("Location: ../VISTA/REGISTRAR_PRODUCTOS.php?mensaje=" . urlencode("❌ Error al registrar el producto.") . "&tipo=error");
            }
        }
    } catch (PDOException $e) {
        header("Location: ../VISTA/REGISTRAR_PRODUCTOS.php?mensaje=" . urlencode("❌ Error de PDO: " . $e->getMessage()) . "&tipo=error");
    }
}
?>

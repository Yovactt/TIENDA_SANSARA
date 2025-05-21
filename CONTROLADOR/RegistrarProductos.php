<?php
require_once '../modelo/conexion.php'; // Asegúrate que este archivo existe y conecta bien a PostgreSQL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = $_POST['categoria'];
    $modelo = strtoupper(trim($_POST['modelo']));
    $talla = strtoupper(trim($_POST['talla']));
    $color = strtoupper(trim($_POST['color']));
    $precio = $_POST['precio'];
    $marca = strtoupper(trim($_POST['marca']));
    $cantidad = $_POST['cantidad'];
    $sucursal = $_POST['sucursal'];
    $etiqueta = strtoupper(trim($_POST['etiqueta']));

    // Verificar que no esté vacío algún campo obligatorio
    if ($categoria && $modelo && $talla && $color && $precio && $cantidad && $sucursal && $etiqueta) {
        try {
            $consulta = $bd->prepare("INSERT INTO productos (categoria, modelo, talla, color, precio, marca, cantidad, sucursal, etiqueta)
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $consulta->execute([$categoria, $modelo, $talla, $color, $precio, $marca, $cantidad, $sucursal, $etiqueta]);
            header("Location: ../vista/REGISTRAR_PRODUCTOS.php?exito=1");
        } catch (Exception $e) {
            echo "Error al registrar: " . $e->getMessage();
        }
    } else {
        echo "Por favor, completa todos los campos obligatorios.";
    }
}
?>

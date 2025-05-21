<?php
require_once '../modelo/conexion.php';

$sucursal = $_GET['sucursal'] ?? 'todas';

if ($sucursal === 'todas') {
    $stmt = $bd->query("SELECT * FROM productos ORDER BY sucursal, modelo");
} else {
    $stmt = $bd->prepare("SELECT * FROM productos WHERE sucursal = ?");
    $stmt->execute([$sucursal]);
}

$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($productos) === 0) {
    echo "<p class='sin-datos'>No hay productos en esta sucursal.</p>";
    exit;
}

echo "<table>";
echo "<tr><th>Categoría</th><th>Modelo</th><th>Talla</th><th>Color</th><th>Precio</th><th>Marca</th><th>Cantidad</th><th>Sucursal</th><th>Etiqueta</th></tr>";

foreach ($productos as $producto) {
    echo "<tr>
        <td>{$producto['categoria']}</td>
        <td>{$producto['modelo']}</td>
        <td>{$producto['talla']}</td>
        <td>{$producto['color']}</td>
        <td>{$producto['precio']}</td>
        <td>{$producto['marca']}</td>
        <td>{$producto['cantidad']}</td>
        <td>{$producto['sucursal']}</td>
        <td>{$producto['etiqueta']}</td>
    </tr>";
}
echo "</table>";
?>

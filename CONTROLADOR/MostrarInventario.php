<?php
require '../MODELO/Conexion.php';

$conn = conectar();
$sucursal = $_GET['sucursal'] ?? '';

try {
    if ($sucursal) {
        $stmt = $conn->prepare("
            SELECT p.modelo, c.nombre AS categoria, p.talla, p.color, p.precio, p.marca, p.etiqueta, s.nombre AS sucursal, i.cantidad
            FROM inventario i
            JOIN productos p ON i.producto_id = p.id
            JOIN categorias c ON p.categoria_id = c.id
            JOIN sucursales s ON i.sucursal_id = s.id
            WHERE s.nombre = ?
        ");
        $stmt->bind_param("s", $sucursal);
        $stmt->execute();
        $resultado = $stmt->get_result();
    } else {
        $resultado = $conn->query("
            SELECT p.modelo, c.nombre AS categoria, p.talla, p.color, p.precio, p.marca, p.etiqueta, s.nombre AS sucursal, i.cantidad
            FROM inventario i
            JOIN productos p ON i.producto_id = p.id
            JOIN categorias c ON p.categoria_id = c.id
            JOIN sucursales s ON i.sucursal_id = s.id
        ");
    }

    if ($resultado && $resultado->num_rows > 0):
        echo '<table>';
        echo '<thead><tr><th>Modelo</th><th>Categoría</th><th>Talla</th><th>Color</th><th>Precio</th><th>Marca</th><th>Etiqueta</th><th>Sucursal</th><th>Cantidad</th></tr></thead>';
        echo '<tbody>';
        while ($item = $resultado->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($item['modelo']) . '</td>';
            echo '<td>' . htmlspecialchars($item['categoria']) . '</td>';
            echo '<td>' . htmlspecialchars($item['talla']) . '</td>';
            echo '<td>' . htmlspecialchars($item['color']) . '</td>';
            echo '<td>' . htmlspecialchars($item['precio']) . '</td>';
            echo '<td>' . htmlspecialchars($item['marca']) . '</td>';
            echo '<td>' . htmlspecialchars($item['etiqueta']) . '</td>';
            echo '<td>' . htmlspecialchars($item['sucursal']) . '</td>';
            echo '<td>' . htmlspecialchars($item['cantidad']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    else:
        echo '<p class="sin-datos">Sin datos registrados</p>';
    endif;

    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();

} catch (Exception $e) {
    echo '<p class="sin-datos">Error al obtener los datos: ' . $e->getMessage() . '</p>';
}

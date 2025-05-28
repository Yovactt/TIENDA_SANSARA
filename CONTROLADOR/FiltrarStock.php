<?php
require '../MODELO/Conexion.php';
$conn = conectar();

// Recoger filtros (usar null coalescing operator para evitar warnings)
file_put_contents('debug.log', print_r($_POST, true));

$categoria = $_POST['categoria_id'] ?? '';
$etiqueta  = $_POST['etiqueta'] ?? '';
$modelo    = $_POST['modelo'] ?? '';
$color     = $_POST['color'] ?? '';
$talla     = $_POST['talla'] ?? '';
$sucursal  = $_POST['sucursal'] ?? '';

// Base query
$sql = "SELECT * FROM productos WHERE 1=1";

// Añadir condiciones si se proporcionan filtros
if (!empty($etiqueta)) {
    $sql .= " AND etiqueta LIKE :etiqueta";
}
if (!empty($modelo)) {
    $sql .= " AND modelo LIKE :modelo";
}
if (!empty($color)) {
    $sql .= " AND color LIKE :color";
}
if (!empty($talla)) {
    $sql .= " AND talla = :talla";
}
if (!empty($sucursal)) {
    $sql .= " AND sucursal = :sucursal";
}

$stmt = $conn->prepare($sql);

// Asociar parámetros
if (!empty($categoria)) $stmt->bindParam(':categoria_id', $categoria);
if (!empty($etiqueta))  $stmt->bindValue(':etiqueta', "%$etiqueta%");
if (!empty($modelo))    $stmt->bindValue(':modelo', "%$modelo%");
if (!empty($color))     $stmt->bindValue(':color', "%$color%");
if (!empty($talla))     $stmt->bindParam(':talla', $talla);
if (!empty($sucursal))  $stmt->bindParam(':sucursal', $sucursal);

$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($productos);

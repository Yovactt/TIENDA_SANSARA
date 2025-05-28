<?php
$id_venta = $_GET['id_venta'] ?? null;

if (!$id_venta) {
  echo "No se proporcionó un ID de venta.";
  exit;
}

// Conecta a la base de datos
include '../MODELO/Conexion.php'; // Asegúrate de tener este archivo o tu conexión manual

// Consulta para obtener el total
$sql = "SELECT total FROM ventas WHERE id_venta = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_venta);
$stmt->execute();
$result = $stmt->get_result();
$venta = $result->fetch_assoc();

if (!$venta) {
  echo "No se encontró la venta.";
  exit;
}

$total = $venta['total'];
?>

<?php
$id_venta = $_GET['id_venta'] ?? null;

if (!$id_venta) {
  echo "No se proporcionó un ID de venta.";
  exit;
}

require_once '../MODELO/Conexion.php';
$conn = conectar(); // Usa tu función PDO

// Validar que la venta existe
$stmt = $conn->prepare("SELECT total FROM ventas WHERE id_venta = ?");
$stmt->execute([$id_venta]);
$venta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$venta) {
  echo "No se encontró la venta.";
  exit;
}

// Aquí podrías registrar el pago, actualizar estado, etc.

// Redirige a la vista con mensaje de éxito
header("Location: ../VISTA/PROCESAR_PAGO.php?id_venta=$id_venta&mensaje=finalizarPago");
exit;
?>

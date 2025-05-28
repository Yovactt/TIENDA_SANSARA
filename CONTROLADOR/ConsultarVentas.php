<?php
include 'Conexion.php'; // Incluye tu archivo de conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'];
    $sucursal = $_POST['sucursal'];

    $conn = conectar(); // Esta función debe devolver un objeto PDO

    // Prepara la consulta SQL
$query = "SELECT v.fecha, dv.producto, dv.modelo, dv.cantidad, dv.total, v.sucursal
          FROM ventas v
          INNER JOIN detalles_venta dv ON v.id_venta = dv.id_venta
          WHERE v.fecha::date = :fecha";

if (!empty($sucursal) && $sucursal != 'Todas') {
    $query .= " AND v.sucursal = :sucursal";
}


    $stmt = $conn->prepare($query);
    $stmt->bindValue(':fecha', $fecha); // bindValue es mejor para variables simples

    if (!empty($sucursal) && $sucursal != 'Todas') {
        $stmt->bindValue(':sucursal', $sucursal);
    }

    $stmt->execute();
    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC); // Asegura array asociativo

    echo json_encode($ventas);
    exit;
}
?>

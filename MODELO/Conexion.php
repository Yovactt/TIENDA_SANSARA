<?php
function conectar() {
    $host = 'localhost:3305';           // Host del servidor MariaDB
    $usuario = 'root';       // Usuario de la base de datos
    $contrasena = 'Yovana21'; // Contraseña del usuario
    $dbname = 'sansara';  // Nombre de la base de datos

    // Crear conexión
    $conn = new mysqli($host, $usuario, $contrasena, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Establecer conjunto de caracteres
    $conn->set_charset("utf8");

    return $conn;
}
?>


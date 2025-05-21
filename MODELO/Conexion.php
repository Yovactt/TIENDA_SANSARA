<?php
function conectar() {
    $host = 'dpg-d0ml4quuk2gs73fof920-a.oregon-postgres.render.com'; // host completo de Render
    $port = '5432';
    $dbname = 'sansara';      // Tu nombre de base de datos en Render
    $usuario = 'sansara_user';     // Tu usuario de PostgreSQL en Render
    $contrasena = 'RcGlNtRexF21DPNsZpV5j6FLaikuSmBj'; // Tu contraseña

    try {
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $usuario, $contrasena, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $conn;
    } catch (PDOException $e) {
        die("❌ Error de conexión: " . $e->getMessage());
    }
}
?>


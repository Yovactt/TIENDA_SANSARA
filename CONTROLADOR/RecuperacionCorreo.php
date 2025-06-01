<?php
include '../MODELO/Conexion.php';

$correo = $_POST['correo'];
$query = $conexion->prepare("SELECT * FROM usuarios WHERE correo = :correo");
$query->execute(['correo' => $correo]);

if ($query->rowCount() > 0) {
    $token = bin2hex(random_bytes(32));
    $expira = date("Y-m-d H:i:s", strtotime('+1 hour'));

    $insert = $conexion->prepare("INSERT INTO recuperaciones (correo, token, expiracion) VALUES (:correo, :token, :expira)");
    $insert->execute(['correo' => $correo, 'token' => $token, 'expira' => $expira]);

    $link = "http://localhost/SANSARA_DV/CONTROLADOR/Reestablecer.php?token=" . $token;

    $asunto = "Recuperación de contraseña - SANSARA";
    $mensaje = "Haz clic en el siguiente enlace para recuperar tu contraseña:\n$link\nEste enlace expirará en 1 hora.";
    $cabeceras = "From: sansara@tienda.com";

    if (mail($correo, $asunto, $mensaje, $cabeceras)) {
        echo "<script>alert('Correo enviado. Revisa tu bandeja de entrada.');window.location.href='../INDEX.php';</script>";
    } else {
        echo "<script>alert('Error al enviar el correo.');window.location.href='../INDEX.php';</script>";
    }
} else {
    echo "<script>alert('Correo no registrado.');window.location.href='../INDEX.php';</script>";
}
?>

<?php
// Incluye los archivos de PHPMailer
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Instancia PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';           // Cambia por el SMTP que usarás
    $mail->SMTPAuth = true;
    $mail->Username = 'tucorreo@gmail.com';   // Tu correo real
    $mail->Password = 'tupassword_o_contraseña_de_aplicación';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Remitente y destinatario
    $mail->setFrom('tucorreo@gmail.com', 'Tu Nombre');
    $mail->addAddress('destinatario@ejemplo.com', 'Usuario Destino');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Recuperación de contraseña';
    $mail->Body    = 'Haz clic aquí para restablecer tu contraseña: <a href="http://tuweb.com/Restablecer.php?token=xxx">Restablecer</a>';

    $mail->send();
    echo 'Correo enviado correctamente';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
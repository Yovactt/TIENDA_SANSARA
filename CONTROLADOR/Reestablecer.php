<?php
include '../MODELO/Conexion.php';

$token = $_GET['token'];
$query = $conexion->prepare("SELECT * FROM recuperaciones WHERE token = :token AND expiracion > NOW()");
$query->execute(['token' => $token]);

if ($query->rowCount() == 0) {
    echo "<script>alert('Token inválido o expirado.');window.location.href='../INDEX.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reestablecer Contraseña</title>
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      background-color: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    form {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px gray;
      width: 300px;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      width: 100%;
      padding: 10px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <form action="ActualizarContrasena.php" method="POST">
    <h3>Restablecer Contraseña</h3>
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <input type="password" name="nueva_contrasena" placeholder="Nueva contraseña" required>
    <input type="password" name="confirmar_contrasena" placeholder="Confirmar contraseña" required>
    <button type="submit">Actualizar</button>
  </form>
</body>
</html>

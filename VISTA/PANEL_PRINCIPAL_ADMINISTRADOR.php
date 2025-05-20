<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: ..INDEX.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PANEL PRINCIPAL ADMIN</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .sidebar {
      width: 60px;
      background: linear-gradient(to right, #151718, #03045E);
      transition: width 0.3s ease;
      overflow: hidden;
      position: fixed;
      height: 100%;
      padding-top: 20px;
    }

    .sidebar:hover {
      width: 260px;
    }

    .sidebar h2 {
      color: #fff;
      text-align: center;
      margin-bottom: 30px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .sidebar:hover h2 {
      opacity: 1;
    }

    .sidebar a {
      position: relative;
      display: flex;
      align-items: center;
      color: #fff;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.3s ease, color 0.3s ease;
    }

    .sidebar a::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 4px;
      background: #F79824;
      border-radius: 0 4px 4px 0;
      transform: scaleY(0);
      transform-origin: top;
      transition: transform 0.3s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: linear-gradient(90deg, rgba(253,202,64,0.2) 0%, #FDCA40  100%);
      color: #151718;
    }

    .sidebar a:hover::before,
    .sidebar a.active::before {
      transform: scaleY(1);
    }

    .sidebar i {
      min-width: 30px;
      text-align: center;
      font-size: 18px;
      transition: color 0.3s ease;
    }

    .sidebar a:hover i,
    .sidebar a.active i {
      color: #151718;
    }

    .sidebar span {
      margin-left: 15px;
      white-space: nowrap;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .sidebar:hover span {
      opacity: 1;
    }

    .content {
      margin-left: 80px;
      padding: 60px;
      transition: margin-left 0.3s ease;
      flex: 1;
      position: relative;
      overflow: hidden;
    }

    .sidebar:hover ~ .content {
      margin-left: 260px;
    }

    .welcome {
      animation: fadeInSlide 1s ease forwards;
      opacity: 0;
    }

    @keyframes fadeInSlide {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .wave {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      z-index: -1;
    }

    h2 {
      margin-bottom: 20px;
      color: #31393C;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>SANSARA</h2> <br>
    <a href="REGISTRO_DE_USUARIOS.php"><i class="fas fa-user-shield"></i><span>Registrar Usuarios</span></a>
    <a href="MODIFICAR_USUARIOS.php"><i class="fas fa-users"></i><span>Modificar Usuarios</span></a>
    <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a>
    <a href="REPORTESADM.html"><i class="fas fa-chart-line"></i><span>Reportes</span></a>
    <a href="CONFIGURACION.php"><i class="fas fa-cog"></i><span>Configuración</span></a>
    <a href="CERRARSESION.html"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a>
  </div>

  <div class="content">
    <div class="welcome">
      <h2><i class="fas fa-user-shield"></i> BIENVENIDO ADMINISTRADOR</h2>
      <p>Seleccione una opción del menú para gestionar el sistema.</p>
     <p style="margin-top: 10px; color: #666;">Sesión iniciada como: <strong><?php echo $_SESSION['nombre']; ?></strong></p>

    </div>

    <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
      <path fill="#2176FF" fill-opacity="0.2" d="M0,192L60,181.3C120,171,240,149,360,154.7C480,160,600,192,720,192C840,192,960,160,1080,154.7C1200,149,1320,171,1380,181.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
    </svg>
  </div>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'gerente') {
    header("Location: ../VISTA/INICIO_SESION.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PANEL PRINCIPAL GERENTE </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" /> 

<style>
  /*Elimina márgenes/paddings por defecto.
  Usa flexbox para disposición.
  Fuente general: Arial*/
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color:  #fff              ;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /*Es un menú lateral colapsado de 60px, que se expande con hover.
    Fondo con degradado azul/negro.
    Fijo al lado izquierdo */
    .sidebar {
      width: 60px;
      background: linear-gradient(to right, #151718,  #03045E);
      transition: width 0.3s ease;
      overflow: hidden;
      position: fixed;
      height: 100%;
      padding-top: 20px;
    }

    /*Cuando pasas el mouse por encima, el menú se expande animadamente.*/
    .sidebar:hover {
      width: 260px;
    }

    /* titulo y animacion
    El título se oculta cuando el menú está colapsado.
    Se aparece con opacidad cuando haces hover*/
    .sidebar h2 {
      color: #fff;
      text-align: center;
      margin-bottom: 30px;
      /*animacion */
      opacity: 0; 
      transition: opacity 0.3s ease;
    }

    .sidebar:hover h2 {
      opacity: 1;
    }

    /*Muestra los íconos con texto alineado
    Tiene transición suave de color y fondo*/
    .sidebar a {
      display: flex;
      align-items: center;
      color: #fff;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.3s;
    }

  /* Base de los links para posicionar el indicador */
  .sidebar a {
    position: relative;
    display: flex;
    align-items: center;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    transition: background 0.3s ease, color 0.3s ease;
    }

    /* Aparece una barra dorada al lado izquierdo al pasar el mouse.
    Se anima desde arriba hacia abajo (efecto "despliegue"). */
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

    /* Barra de seleccion */
    .sidebar a:hover,
    .sidebar a.active {
    background: linear-gradient(90deg, rgba(253,202,64,0.2) 0%, #FDCA40  100%);
    color: #151718;
    }

    /* Al activar hover/activo, desplegar la barra lateral */
    .sidebar a:hover::before,
    .sidebar a.active::before {
    transform: scaleY(1);
    }

    /* Iconos: cambian de color al hover/activo */
    .sidebar i {
    min-width: 30px;
    text-align: center;
    font-size: 18px;
    transition: color 0.3s ease;
    }

    /*color de los iconos al ser selccionado */
    .sidebar a:hover i,
    .sidebar a.active i {
    color: #151718;
    }


    /*El texto del menú solo aparece al hacer hover (cuando se expande).*/
    .sidebar span {
      margin-left: 15px;
      white-space: nowrap;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .sidebar:hover span {
      opacity: 1;
    }

    /*Al hacer hover en el menú, el contenido se mueve suavemente hacia la derecha 
    para dejar espacio al menú expandido.*/
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


     /*LETRAS*/
     h2 {
       margin-bottom: 20px; 
       color:  #31393C  ;
       }

    /*Cuando se carga la página, el mensaje "BIENVENIDO GERENTE" aparece deslizándose 
    hacia arriba y se desvanece desde 0% a 100% de opacidad*/
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

    /* Es una onda SVG al fondo, con opacidad baja (fill-opacity="0.2").
    Solo decorativa, da un toque moderno. */
    .wave {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      z-index: -1;
    }

   

  </style>
</head>
<body>
  <div class="sidebar">
    <h2>SANSARA</h2>
    <a href="SUPERVISARVENTASG.html"><i class="	fas fa-cash-register"></i><span>Supervisión de Ventas</span></a>
    <a href="CONTROLINVENTARIOGEREN.html"><i class="fas fa-boxes-stacked"></i><span>Control de Inventario</span></a>
    <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a> 
    <a href="REPORTESGERENTE.html"><i class="fas fa-chart-bar"></i><span>Reportes</span></a>
    <a href="CERRAR_SESION.php"><i class="	fas fa-right-from-bracket"></i><span>Cerrar Sesión</span></a>
  </div>

  <div class="content">
    <div class="welcome">
      <h2><i class="	fas fa-user-shield"></i> BIENVENIDO GERENTE</h2>
      <p>Seleccione una opción del menú para supervisar las operaciones de Sansara.</p>
    </div>
    <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
      <path fill="#28a745" fill-opacity="0.2" d="M0,192L60,181.3C120,171,240,149,360,154.7C480,160,600,192,720,192C840,192,960,160,1080,154.7C1200,149,1320,171,1380,181.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
    </svg>
  </div>
</body>
</html>
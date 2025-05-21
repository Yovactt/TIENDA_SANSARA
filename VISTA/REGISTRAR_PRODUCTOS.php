<?php
session_start();
$rol = $_SESSION['rol'] ?? 'Administrador'; // 'Administrador' o 'Gerente'
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registrar Productos</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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


    .formulario, .tabla-container {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
      margin-bottom: 30px;
    }
          
    .formulario h3 { 
      margin-bottom: 15px; 
    }

    .formulario .fila {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 10px;
    }
    .formulario input,
    .formulario select {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      min-width: 150px;
      flex: 1;
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

    

    table {
      width: 100%; /*ocupa todo el ancho del contenedor.*/
      border-collapse: collapse; /* elimina espacios entre bordes.*/
      background-color: #fff;
      box-shadow: 0 0 5px #151718;/*  sombra suave alrededor de la tabla.*/
    }

   /*Celdas centradas, con borde y espaciado interno*/
   th, td {
      padding: 12px;
      text-align: center;
      border: 1px solid #ddd;
    }

    /*Fondo con degradado azul oscuro a azul intenso.
      Texto blanco.*/
      th {
        background: linear-gradient(to bottom, #31393C,#2176FF);
        color: white;
    }

    tr:hover { 
      background-color: #fff;
    }

    .sin-datos {
      text-align: center;
      color: #808181;
      font-style: italic;
    }


    /*para que no se muestren las tablas */
    .tabla-sucursal {
      display: none;
    }

    /*se vean al selecionar */
    .tabla-sucursal.visible {
      display: block;
    }


    /*Botón con gradiente dorado/naranja, sombra y efecto hover animado.*/
    .formulario button {
        padding: 12px 24px;
        background: linear-gradient(to right, #F79824, #FDCA40  );
        color: #fff;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 4px 10px #151718 ;
        transition: all 0.3s ease;
     }

    .formulario button:hover {
        background: linear-gradient(to right, #FDCA40 , #F79824);
        transform: translateY(-2px);
        box-shadow: 0 6px 14px #151718 ;
    }

  /* Fondo decorativo onda */
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
    <?php if ($rol === 'administrador'): ?>
      <h2>ADMINISTRADOR</h2>
    <a href="REGISTRO_DE_USUARIOS.php"><i class="fas fa-user-shield"></i><span>Registrar Usuarios</span></a>
    <a href="MODIFICAR_USUARIOS.php"><i class="fas fa-users"></i><span>Modificar Usuarios</span></a>
    <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a>
    <a href="REPORTESADM.html"><i class="fas fa-chart-line"></i><span>Reportes</span></a>
    <a href="CONFIGURACION.php"><i class="fas fa-cog"></i><span>Configuración</span></a>
    <a href="CERRAR_SESION.php"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a>
    <?php else: ?>
      <h2>SANSARA</h2>
      <a href="SUPERVISARVENTASG.html"><i class="fas fa-cash-register"></i><span>Supervisión de Ventas</span></a>
      <a href="CONTROLINVENTARIOGEREN.html"><i class="fas fa-boxes-stacked"></i><span>Control de Inventario</span></a>
      <a href="REGISTRARPRODUCTOGERENYADM.html"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a>
      <a href="REPORTESGERENTE.html"><i class="fas fa-chart-bar"></i><span>Reportes</span></a>
      <a href="CERRAR_SESION.php"><i class="fas fa-right-from-bracket"></i><span>Cerrar Sesión</span></a>
    <?php endif; ?>
  </div>

  <div class="content">
    <div class="welcome">
      <h2>Bienvenido <?php echo $rol; ?></h2>
    </div>

    <div class="formulario">
      <h3>Formulario de Registro de Producto</h3>
      <form action="../CONTROLADOR/RegistrarProductos.php" method="POST">
        <div class="fila">
          <label for="categoria">Categoría:</label>
          <select id="categoria" name="categoria">
            <option value="">Seleccionar</option>
            <option value="ropa">Ropa</option>
            <option value="chanclas">Chanclas</option>
            <option value="chacharas">Chacharas</option>
          </select>
        </div>

        <div class="fila">
          <label for="modelo">Modelo:</label>
          <input type="text" id="modelo" name="modelo" placeholder="Modelo del producto">
          <label for="talla">Talla:</label>
          <input type="text" id="talla" name="talla" placeholder="Talla">
        </div>

        <div class="fila">
          <label for="color">Color:</label>
          <input type="text" id="color" name="color" placeholder="Color">
          <label for="precio">Precio:</label>
          <input type="number" id="precio" name="precio" placeholder="Precio">
        </div>

        <div class="fila">
          <label for="marca">Marca:</label>
          <input type="text" id="marca" name="marca" placeholder="Marca (opcional)">
          <label for="cantidad">Cantidad:</label>
          <input type="number" id="cantidad" name="cantidad" placeholder="Cantidad en stock">
        </div>

        <div class="fila">
          <label for="sucursal">Sucursal:</label>
          <select id="sucursal" name="sucursal">
            <option value="">Seleccionar sucursal</option>
            <option value="Sucursal1">Sucursal 1</option>
            <option value="Sucursal2">Sucursal 2</option>
            <option value="Sucursal3">Sucursal 3</option>
            <option value="Sucursal4">Sucursal 4</option>
          </select>
        </div>

        <div class="fila">
          <label for="etiqueta">Etiqueta:</label>
          <input type="text" id="etiqueta" name="etiqueta" placeholder="Etiqueta para búsqueda">
        </div>

        <div class="fila">
          <button type="submit">Registrar Producto</button>
        </div>
      </form>
    </div>

    <div class="tabla-container">
      <h3>Inventario por Sucursal</h3>
      <label for="selectorSucursal">Seleccionar Sucursal:</label>
      <select id="selectorSucursal">
        <option value="">Todas</option>
        <option value="Sucursal1">Sucursal 1</option>
        <option value="Sucursal2">Sucursal 2</option>
        <option value="Sucursal3">Sucursal 3</option>
        <option value="Sucursal4">Sucursal 4</option>
      </select>

      <div id="tablaInventario">
        <?php include '../CONTROLADOR/MostrarInventario.php'; ?>
      </div>
    </div>
  </div>

 <script>
  window.addEventListener('DOMContentLoaded', function() {
    const tipoReporteRadios = document.getElementsByName('tipoReporte');
    const filtrosVentas = document.getElementById('filtrosVentas');
    const filtrosInventario = document.getElementById('filtrosInventario');
    const theadVentas = document.getElementById('theadVentas');
    const theadInventario = document.getElementById('theadInventario');

    function toggleInputs(container, enabled) {
      const inputs = container.querySelectorAll('input, select, button');
      inputs.forEach(input => {
        input.disabled = !enabled;
      });
    }

    function actualizarVistaReporte() {
      const tipoSeleccionado = document.querySelector('input[name="tipoReporte"]:checked').value;

      if (tipoSeleccionado === 'ventas') {
        filtrosVentas.style.display = 'block';
        filtrosInventario.style.display = 'none';
        theadVentas.style.display = 'table-header-group';
        theadInventario.style.display = 'none';

        toggleInputs(filtrosVentas, true);
        toggleInputs(filtrosInventario, false);
      } else {
        filtrosVentas.style.display = 'none';
        filtrosInventario.style.display = 'block';
        theadVentas.style.display = 'none';
        theadInventario.style.display = 'table-header-group';

        toggleInputs(filtrosVentas, false);
        toggleInputs(filtrosInventario, true);
      }
    }

    tipoReporteRadios.forEach(radio => {
      radio.addEventListener('change', actualizarVistaReporte);
    });

    // Inicializa correctamente al cargar
    actualizarVistaReporte();
  });
</script>
</body>
</html>
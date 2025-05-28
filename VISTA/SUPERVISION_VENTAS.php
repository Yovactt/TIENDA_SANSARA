<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SUPERVISION DE VENTAS</title>
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


    /* ESPACION ENTRE TABLA Y CUADRO DE TEXTOS */
    .filters {
      display: flex; /*organiza los filtros en una fila horizontal*/
      gap: 40px; /*separa cada filtro con un espacio de 20px.*/
      margin-bottom: 50px; /*espacio inferior con la tabla.*/
      flex-wrap: wrap; /*si no caben en una línea, se bajan a otra fila.*/
       /*Caja con sombra y bordes redondeados para seleccionar criterios de búsqueda.*/
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
      margin-bottom: 30px;
    }

    /*Texto en negrita para los nombres de los filtros.*/
    .filters label {
      font-weight: bold;
    }

    /*padding: espacio interno.
      border-radius: bordes redondeados.
      border: borde gris claro*/
    .filters select,
    .filters input {
      padding: 6px 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }


    /* Crea una tarjeta blanca con sombra, muy útil para resaltar la tabla.
    box-shadow le da un pequeño efecto de profundidad.*/
    .tabla-container {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #151718;
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


    tbody tr:hover {
      background-color: #fff;
    }

    /*Muestra un resumen debajo de la tabla (como el total vendido).
    Negrita y en color gris oscuro.*/
    .summary {
      margin-top: 20px;
      font-weight: bold;
      color: #31393C;
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
  
  <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#28a745" fill-opacity="0.2" d="M0,192L60,181.3C120,171,240,149,360,154.7C480,160,600,192,720,192C840,192,960,160,1080,154.7C1200,149,1320,171,1380,181.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
  </svg>

  <div class="sidebar">
    <h2>SANSARA</h2>
    <a href="SUPERVISION_VENTAS.php"><i class="	fas fa-cash-register"></i><span>Supervisión de Ventas</span></a>
    <a href="CONTROL_INVENTARIO_GERENTE.php"><i class="fas fa-boxes-stacked"></i><span>Control de Inventario</span></a>
    <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a> 
    <a href="REPORTES_GEREN.php"><i class="fas fa-chart-bar"></i><span>Reportes</span></a>
    <a href="CERRAR_SESION.php"><i class="	fas fa-right-from-bracket"></i><span>Cerrar Sesión</span></a>
  </div>


  <div class="content fade-in">
    <div class="welcome">
    <h2><i class="fas fa-cash-register"></i> SUPERVISIÓN DE VENTAS</h2>

    <div class="filters">
      <div>
        <label for="fecha">Fecha:</label><br>
        <input type="date" id="fecha" name="fecha">
      </div>

      <div>
        <label for="sucursal">Sucursal:</label><br>
        <select id="sucursal" name="sucursal">
          <option value="">Todas</option>
          <option value="Sucursal 1">Sucursal 1</option>
          <option value="Sucursal 2">Sucursal 2</option>
          <option value="Sucursal 3">Sucursal 3</option>
          <option value="Sucursal 4">Sucursal 4</option>
        </select>
        <button onclick="consultarVentas()">Consultar Ventas</button>

      </div>
    </div>

    <div class="tabla-container">
    <table>
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Etiqueta</th>
          <th>Modelo</th>
          <th>Cantidad</th>
          <th>Total</th>
          <th>Sucursal</th>
        </tr>
      </thead>
      <tbody id="tabla-ventas">
        <tr>
          <td colspan="6" style="text-align:center; color: #888;">
            No hay ventas registradas aún.
          </td>
        </tr>
      </tbody>
    </table>

    <div class="summary" id="resumen-total">
      Total vendido hoy: <strong>$0.00</strong>
    </div>
  </div>

  
  <script>
    /*Carga la fecha actual automáticamente.
  Si cambias fecha/sucursal, actualiza la tabla (aún no tiene ventas reales).*/
    const selectSucursal = document.getElementById('sucursal');
    const fechaInput = document.getElementById('fecha');
    const tablaVentas = document.getElementById('tabla-ventas');
    const resumenTotal = document.getElementById('resumen-total');

    function actualizarTabla() {
      tablaVentas.innerHTML = `
        <tr>
          <td colspan="6" style="text-align:center; color: #888;">
            No hay ventas registradas aún.
          </td>
        </tr>`;
      resumenTotal.innerHTML = `Total vendido hoy: <strong>$0.00</strong>`;
    }

    selectSucursal.addEventListener('change', actualizarTabla);
    fechaInput.addEventListener('change', actualizarTabla);

    window.addEventListener('DOMContentLoaded', () => {
      fechaInput.value = new Date().toISOString().split('T')[0];
      actualizarTabla();
    });
  </script>
  
  <script>
  const selectSucursal = document.getElementById('sucursal');
  const fechaInput = document.getElementById('fecha');
  const tablaVentas = document.getElementById('tabla-ventas');
  const resumenTotal = document.getElementById('resumen-total');

  function actualizarTabla() {
    const fecha = fechaInput.value;
    const sucursal = selectSucursal.value;

    fetch('ConsultarVentas.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `fecha=${fecha}&sucursal=${sucursal}`,
    })
      .then(response => response.json())
      .then(data => {
        if (data.length > 0) {
          tablaVentas.innerHTML = ''; // Limpiar tabla antes de actualizar

          let totalVendido = 0;
          data.forEach(venta => {
            totalVendido += parseFloat(venta.total);

            const row = `
              <tr>
                <td>${venta.fecha}</td>
                <td>${venta.producto}</td>
                <td>${venta.modelo}</td>
                <td>${venta.cantidad}</td>
                <td>${venta.total}</td>
                <td>${venta.sucursal}</td>
              </tr>
            `;
            tablaVentas.innerHTML += row;
          });

          resumenTotal.innerHTML = `Total vendido hoy: <strong>$${totalVendido.toFixed(2)}</strong>`;
        } else {
          tablaVentas.innerHTML = `
            <tr>
              <td colspan="6" style="text-align:center; color: #888;">
                No hay ventas registradas para esta fecha y sucursal.
              </td>
            </tr>`;
          resumenTotal.innerHTML = `Total vendido hoy: <strong>$0.00</strong>`;
        }
      })
      .catch(error => {
        console.error('Error al obtener datos de ventas:', error);
      });
  }

  selectSucursal.addEventListener('change', actualizarTabla);
  fechaInput.addEventListener('change', actualizarTabla);

  window.addEventListener('DOMContentLoaded', () => {
    fechaInput.value = new Date().toISOString().split('T')[0];
    actualizarTabla();
  });
</script>
<script>
function consultarVentas() {
    const fecha = document.getElementById("fecha").value;
    const sucursal = document.getElementById("sucursal").value;

    if (!fecha) {
        alert("Por favor selecciona una fecha.");
        return;
    }

    fetch("ConsultarVentas.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
            fecha: fecha,
            sucursal: sucursal
        })
    })
    .then(response => response.json())
    .then(data => {
        const tabla = document.getElementById("tablaVentas");
        tabla.innerHTML = ""; // Limpiar la tabla

        if (data.length === 0) {
            tabla.innerHTML = "<tr><td colspan='6'>No se encontraron ventas para esta fecha y sucursal.</td></tr>";
            return;
        }

        data.forEach(venta => {
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td>${venta.fecha}</td>
                <td>${venta.producto}</td>
                <td>${venta.modelo}</td>
                <td>${venta.cantidad}</td>
                <td>$${parseFloat(venta.total).toFixed(2)}</td>
                <td>${venta.sucursal}</td>
            `;
            tabla.appendChild(fila);
        });
    })
    .catch(error => {
        console.error("Error al consultar ventas:", error);
        alert("Hubo un error al consultar las ventas.");
    });
}
</script>
</body>
</html>
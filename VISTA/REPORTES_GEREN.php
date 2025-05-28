<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Generar Reportes</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <style>
     * {
      margin: 0; padding: 0; box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      display: flex;
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
      z-index: 1000;
    }

    .sidebar:hover { width: 260px; }

    .sidebar h2 {
      color: #fff;
      text-align: center;
      margin-bottom: 30px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .sidebar:hover h2 { opacity: 1; }

    .sidebar a {
      display: flex;
      align-items: center;
      color: #fff;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.3s ease, color 0.3s ease;
      position: relative;
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
      background: linear-gradient(90deg, rgba(253,202,64,0.2) 0%, #FDCA40 100%);
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

    .sidebar:hover span { opacity: 1; }

    .main {
      margin-left: 60px;
      padding: 40px;
      flex: 1;
      transition: margin-left 0.3s ease;
    }

    .sidebar:hover + .main {
      margin-left: 260px;
    }

    h2 {
      margin-bottom: 20px;
      color: #31393C;
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

.form-container {
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  max-width: 600px;
  margin-bottom: 40px;
}


    .form-container label {
      display: block;
      font-weight: bold;
      margin-top: 15px;
      color: #151718;
    }

    .form-container select,
    .form-container input[type="date"] {
      width: 100%;
      padding: 10px 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-top: 5px;
    }

    .form-container button {
      width: 100%;
      margin-top: 20px;
      padding: 12px;
      background: linear-gradient(to right, #F79824, #FDCA40);
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      box-shadow: 0 4px 10px #151718;
      transition: all 0.3s ease;
    }

    .form-container button:hover {
      background: linear-gradient(to right, #FDCA40, #F79824);
      transform: translateY(-2px);
      box-shadow: 0 6px 14px #151718;
    }

    .formulario-reporte {
      margin-top: 20px;
    }

    .tabla-resultados {
      max-width: 1000px;
      margin: 40px auto;
      overflow-x: auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid #ccc;
    }

    th, td {
      padding: 8px;
      text-align: center;
      vertical-align: middle;
    }

    th {
      background: linear-gradient(to bottom, #31393C, #2176FF);
      color: white;
    }

    @media (max-width: 768px) {
      .form-container, .tabla-resultados {
        padding: 20px;
      }

      .form-container button {
        font-size: 14px;
      }
    }

    body.dark-theme {
  background-color: #1c1c1c;
  color: #ffffff;
}
body.font-small { font-size: 10px; }
body.font-medium { font-size: 16px; }
body.font-large { font-size: 22px; }

/* MODO OSCURO */
body.dark-theme {
  background-color: #1c1c1c;
  color: #ffffff;
}

body.dark-theme .form-container,
body.dark-theme .tabla-resultados {
  background-color: #2c2c2c;
  color: #ffffff;
  box-shadow: 0 4px 10px rgba(255, 255, 255, 0.1);
}

body.dark-theme label,
body.dark-theme h2,
body.dark-theme .sidebar a,
body.dark-theme .sidebar h2 {
  color: #ffffff;
}

body.dark-theme select,
body.dark-theme input[type="date"] {
  background-color: #3a3a3a;
  color: #ffffff;
  border: 1px solid #666;
}

body.dark-theme table {
  background-color: #2c2c2c;
  color: #ffffff;
}

body.dark-theme th {
  background: linear-gradient(to bottom, #444, #2176FF);
  color: white;
}

body.dark-theme td {
  border-color: #555;
}

body.dark-theme .sidebar a:hover,
body.dark-theme .sidebar a.active {
  color: #000;
}
.tabla-resultados.tabla-inventario {
  max-width: 600px;  /* Igual que .form-container */
  margin: 40px 0 0 0; /* Separación arriba y sin margen lateral */
  overflow-x: auto;  /* Para scroll horizontal si se necesita */
  background-color: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 2px 6px #808181;


}

  /* Fondo decorativo onda */
  .wave {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      z-index: -1;
    }

  </style>
</head>
<body>
   <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
      <path fill="#2176FF" fill-opacity="0.2"
        d="M0,192L60,181.3C120,171,240,149,360,154.7C480,160,600,192,720,192C840,192,960,160,1080,154.7C1200,149,1320,171,1380,181.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
    </svg>

  <div class="sidebar">
    <h2>SANSARA</h2>
    <a href="SUPERVISION_VENTAS.php"><i class="	fas fa-cash-register"></i><span>Supervisión de Ventas</span></a>
    <a href="CONTROL_INVENTARIO_GERENTE.php"><i class="fas fa-boxes-stacked"></i><span>Control de Inventario</span></a>
    <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a> 
    <a href="REPORTES_GEREN.php"><i class="fas fa-chart-bar"></i><span>Reportes</span></a>
    <a href="CERRAR_SESION.php"><i class="	fas fa-right-from-bracket"></i><span>Cerrar Sesión</span></a>
  </div>

  <div class="main">
    <div class="welcome">
      <h2><i class="fas fa-chart-bar"></i> GENERAR REPORTES</h2>

      <div class="form-container">
        <label for="tipoReporte">Seleccione el tipo de reporte:</label>
        <select id="tipoReporte" name="tipo_reporte" onchange="mostrarFormulario()">
          <option value="ventas">Ventas por Sucursal</option>
          <option value="inventario">Inventario con Stock Bajo</option>
        </select>

        <div id="formulario_ventas" class="formulario-reporte">
         <form id="formReporteVentas" action="../CONTROLADOR/GenerarReportesVentas.php" method="POST">
            <label for="sucursal_ventas">Seleccione la sucursal:</label>
            <select name="sucursal_ventas" id="sucursal_ventas" required>
              <option value="" disabled selected>Seleccione una sucursal</option>
              <option value="Sucursal1">Sucursal 1</option>
              <option value="Sucursal2">Sucursal 2</option>
              <option value="Sucursal3">Sucursal 3</option>
              <option value="Sucursal4">Sucursal 4</option>
            </select>

            <label for="fecha_inicio_ventas">Fecha de inicio:</label>
            <input type="date" name="fecha_inicio_ventas" id="fecha_inicio_ventas" required>

            <label for="fecha_fin_ventas">Fecha de fin:</label>
            <input type="date" name="fecha_fin_ventas" id="fecha_fin_ventas" required>

            <button type="submit">Generar Reporte de Ventas</button>

            
          </form>
        </div>

        <div id="formulario_inventario" class="formulario-reporte" style="display:none;">
  <form id="formReporteInventario" action="../CONTROLADOR/GenerarReportesInventario.php" method="POST">
    <label for="sucursal_inventario">Seleccione la sucursal:</label>
    <select name="sucursal_inventario" id="sucursal_inventario" required>
      <option value="" disabled selected>Seleccione una sucursal</option>
      <option value="Sucursal1">Sucursal 1</option>
      <option value="Sucursal2">Sucursal 2</option>
      <option value="Sucursal3">Sucursal 3</option>
      <option value="Sucursal4">Sucursal 4</option>
    </select>
    <button type="submit">Generar Reporte de Inventario</button>
  </form>
</div>


      <!-- TABLA DE RESULTADOS -->
      <div class="tabla-resultados" >
        <table>
          <thead>
            <tr>
              <th>Sucursal</th>
              <th>Fecha</th>
              <th>Producto</th>
              <th>Categoría</th>
              <th>Cantidad Vendida</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <!-- Resultados dinámicos -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
        <!-- TABLA INVENTARIO RESULTADOS -->
<div class="tabla-resultados tabla-inventario" id="tablaInventario" style="display:none;">

  <table>
    <thead>
      <tr>
        <th>Sucursal</th>
        <th>Producto</th>
        <th>Categoría</th>
        <th>Stock Actual</th>
      </tr>
    </thead>
    <tbody>
      <!-- Resultados dinámicos del inventario -->
    </tbody>
  </table>
</div>

  <script>
function mostrarFormulario() {
  const tipo = document.getElementById("tipoReporte").value;

  document.getElementById("formulario_ventas").style.display = (tipo === "ventas") ? "block" : "none";
  document.getElementById("formulario_inventario").style.display = (tipo === "inventario") ? "block" : "none";

  // Mostrar/Ocultar tablas correspondientes
  document.querySelector(".tabla-resultados").style.display = (tipo === "ventas") ? "block" : "none";
  document.getElementById("tablaInventario").style.display = (tipo === "inventario") ? "block" : "none";
}

  </script>
 
<script>
document.getElementById('formReporteVentas').addEventListener('submit', function(e) {
  e.preventDefault(); // Evita que se recargue la página

  const sucursal = document.getElementById('sucursal_ventas').value;
  const fecha_inicio = document.getElementById('fecha_inicio_ventas').value;
  const fecha_fin = document.getElementById('fecha_fin_ventas').value;

  if (!sucursal || !fecha_inicio || !fecha_fin) {
    alert('Por favor, complete todos los campos.');
    return;
  }

  const formData = new FormData();
  formData.append('sucursal_ventas', sucursal);
  formData.append('fecha_inicio_ventas', fecha_inicio);
  formData.append('fecha_fin_ventas', fecha_fin);

  fetch('../CONTROLADOR/GenerarReportesVentas.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    const tbody = document.querySelector('.tabla-resultados tbody');
    tbody.innerHTML = ''; // Limpiar tabla

    if (data.error) {
      alert('Error: ' + data.error);
      return;
    }

    if (data.length === 0) {
      tbody.innerHTML = '<tr><td colspan="6">No se encontraron resultados.</td></tr>';
      return;
    }

    data.forEach(item => {
      const tr = document.createElement('tr');

      // El orden debe coincidir con la tabla: Sucursal, Fecha, Producto, Categoría, Cantidad, Total
      const tdSucursal = document.createElement('td');
      tdSucursal.textContent = item.sucursal;
      tr.appendChild(tdSucursal);

      const tdFecha = document.createElement('td');
      tdFecha.textContent = item.fecha.split(' ')[0]; // solo fecha sin hora
      tr.appendChild(tdFecha);

      const tdProducto = document.createElement('td');
      tdProducto.textContent = item.producto;
      tr.appendChild(tdProducto);

      const tdCategoria = document.createElement('td');
      tdCategoria.textContent = item.categoria;
      tr.appendChild(tdCategoria);

      const tdCantidad = document.createElement('td');
      tdCantidad.textContent = item.cantidad;
      tr.appendChild(tdCantidad);

      const tdTotal = document.createElement('td');
     tdTotal.textContent = parseFloat(item.total).toFixed(2);

      tr.appendChild(tdTotal);

      tbody.appendChild(tr);
    });
  })
  .catch(error => {
    alert('Error en la solicitud: ' + error);
  });
});

</script>

<script>
document.getElementById('formReporteInventario').addEventListener('submit', function(e) {
  e.preventDefault();

  const sucursal = document.getElementById('sucursal_inventario').value;

  if (!sucursal) {
    alert('Por favor, seleccione una sucursal.');
    return;
  }

  const formData = new FormData();
  formData.append('sucursal_inventario', sucursal);

  fetch('../CONTROLADOR/GenerarReportesInventario.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    const tbody = document.querySelector('#tablaInventario tbody');
    tbody.innerHTML = '';

    if (data.error) {
      alert('Error: ' + data.error);
      return;
    }

    if (data.length === 0) {
      tbody.innerHTML = '<tr><td colspan="5">No se encontraron productos con stock bajo.</td></tr>';
      return;
    }

    data.forEach(item => {
      const tr = document.createElement('tr');

      const tdSucursal = document.createElement('td');
      tdSucursal.textContent = item.sucursal;
      tr.appendChild(tdSucursal);

      const tdProducto = document.createElement('td');
      tdProducto.textContent = item.producto;
      tr.appendChild(tdProducto);

      const tdCategoria = document.createElement('td');
      tdCategoria.textContent = item.categoria;
      tr.appendChild(tdCategoria);

      const tdActual = document.createElement('td');
      tdActual.textContent = item.stock_actual;
      tr.appendChild(tdActual);

      tbody.appendChild(tr);
    });
  })
  .catch(error => {
    alert('Error en la solicitud: ' + error);
  });
});
</script>

<script>
  //TEMA OSCURO
  function aplicarPreferencias() {
    const tema = localStorage.getItem('tema') || 'light';
    const fuente = localStorage.getItem('fuente') || 'medium';

    document.body.classList.remove('dark-theme', 'font-small', 'font-medium', 'font-large');

    if (tema === 'dark') {
      document.body.classList.add('dark-theme');
    }

    document.body.classList.add(`font-${fuente}`);
  }

  window.addEventListener('DOMContentLoaded', aplicarPreferencias);
</script>
</body>
</html>
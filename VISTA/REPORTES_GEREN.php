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
    /* RESPONSIVE */
/* Pantallas pequeñas hasta 600px */
@media (max-width: 600px) {
  body {
    flex-direction: column;
    height: auto;
    overflow: auto;
  }

  .glass-card {
    padding: 30px 20px;
    max-width: 95%;
    width: 95%;
  }

  h1 {
    font-size: 24px;
  }

  input {
    font-size: 14px;
    padding: 12px 14px;
  }

  button {
    font-size: 16px;
    padding: 12px;
  }

  a {
    font-size: 13px;
  }
}

/* Pantallas medianas: móviles grandes, phablets, tablets 601px - 1200px */
@media (min-width: 601px) and (max-width: 1200px) {
  .glass-card {
    max-width: 400px; /* más pequeño para pantallas medianas */
    padding: 40px 30px;
  }

  h1 {
    font-size: 26px;
  }

  input {
    font-size: 15px;
    padding: 13px 15px;
  }

  button {
    font-size: 17px;
    padding: 13px;
  }

  a {
    font-size: 14px;
  }
}

/* Pantallas grandes, PCs, laptops */
@media (min-width: 1201px) {
  .glass-card {
    max-width: 450px;
    padding: 50px 40px;
  }

  h1 {
    font-size: 28px;
  }

  input {
    font-size: 16px;
    padding: 14px 16px;
  }

  button {
    font-size: 18px;
    padding: 14px;
  }

  a {
    font-size: 14px;
  }
}
.sidebar p.rol-text {
  color: #fff;
  text-align: center;
  font-size: 12px;
  margin-top: -30px;
  margin-bottom: 30px;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.sidebar:hover p.rol-text {
  opacity: 1;
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
     <p class="rol-text">Gerente</p>
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
            <br>

            
          </form>
          <!-- NUEVOS CONTENEDORES PARA MOSTRAR TABLAS -->
<div id="tablaVentas"></div>
<div id="tablaDevoluciones"></div>
<h3 id="totalFinal"></h3>

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
  e.preventDefault(); // Evita recarga

  const sucursal = document.getElementById('sucursal_ventas').value;
  const fechaInicio = document.getElementById('fecha_inicio_ventas').value;
  const fechaFin = document.getElementById('fecha_fin_ventas').value;

  fetch('../CONTROLADOR/GenerarReportesVentas.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({
          sucursal_ventas: sucursal,
          fecha_inicio_ventas: fechaInicio,
          fecha_fin_ventas: fechaFin
      })
  })
  .then(response => response.json())
  .then(data => {
      if (data.error) {
          alert(data.error);
          return;
      }

      // === Ventas ===
      const ventas = data.ventas || [];
      let tablaHTML = `<table border="1">
          <thead><tr><th>Fecha</th><th>Producto</th><th>Modelo</th><th>Cantidad</th><th>Total</th></tr></thead><tbody>`;
      let totalVentas = 0;

      ventas.forEach(v => {
          tablaHTML += `<tr>
              <td>${v.fecha}</td>
              <td>${v.producto}</td>
              <td>${v.categoria}</td>
              <td>${v.cantidad}</td>
              <td>$${parseFloat(v.total).toFixed(2)}</td>
          </tr>`;
          totalVentas += parseFloat(v.total);
      });
      tablaHTML += `</tbody></table>`;
      document.getElementById("tablaVentas").innerHTML = "<br><h3>Ventas</h3>" + tablaHTML;

      // === Devoluciones (sin columna fecha) ===
      const devoluciones = data.devoluciones || [];
      let tablaDevHTML = `<table border="1">
          <thead><tr><th>Etiqueta</th><th>Producto</th><th>Talla</th><th>Color</th><th>Cantidad</th><th>Precio</th><th>Total</th></tr></thead><tbody>`;
      let totalDevoluciones = 0;

      devoluciones.forEach(d => {
          let totalDev = parseFloat(d.total);
          tablaDevHTML += `<tr>
              <td>${d.etiqueta}</td>
              <td>${d.producto}</td>
              <td>${d.talla}</td>
              <td>${d.color}</td>
              <td>${d.cantidad}</td>
              <td>$${parseFloat(d.precio).toFixed(2)}</td>
              <td>$${totalDev.toFixed(2)}</td>
          </tr>`;
          totalDevoluciones += totalDev;
      });
      tablaDevHTML += `</tbody></table>`;
      document.getElementById("tablaDevoluciones").innerHTML = "<br><h3>Devoluciones</h3>" + tablaDevHTML;

      // === Total Final ===
      const totalFinal = totalVentas - totalDevoluciones;
      document.getElementById("totalFinal").innerHTML = `<br><h3>Total vendido neto: $${totalFinal.toFixed(2)}</h3>`;
  })
  .catch(error => {
      console.error('Error:', error);
      alert("Error al generar el reporte");
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
</body>
</html>
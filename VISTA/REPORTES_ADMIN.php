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
      margin: 0 auto 40px auto;
      max-width: 600px;
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
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
    }

    th {
      background: linear-gradient(to right, #151718, #03045E);
      color: white;
      padding: 14px;
      text-align: left;
      font-weight: bold;
    }

    td {
      padding: 12px 14px;
      border-bottom: 1px solid #ddd;
      color: #333;
    }

    tr:hover {
      background-color: #f9f9f9;
    }

    @media (max-width: 768px) {
      .form-container, .tabla-resultados {
        padding: 20px;
      }

      .form-container button {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <h2>SANSARA</h2>
      <a href="REGISTRO_DE_USUARIOS.php"><i class="fas fa-user-shield"></i><span>Registrar Usuarios</span></a>
      <a href="MODIFICAR_USUARIOS.php"><i class="fas fa-users"></i><span>Modificar Usuarios</span></a>
      <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a>
      <a href="REPORTES_ADMIN.php"><i class="fas fa-chart-line"></i><span>Reportes</span></a>
      <a href="CONFIGURACION.php"><i class="fas fa-cog"></i><span>Configuración</span></a>
      <a href="CERRAR_SESION.php"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a>
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
          <form action="../CONTROLADOR/GenerarReportesVentas.php" method="POST">
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
          <form action="../CONTROLADOR/GenerarReporteInventario.php" method="POST">
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
      </div>

      <!-- TABLA DE RESULTADOS -->
      <div class="tabla-resultados">
        <table>
          <thead>
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Sucursal</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Ejemplo Producto</td>
              <td>10</td>
              <td>Sucursal A</td>
              <td>2025-05-19</td>
            </tr>
            <!-- Resultados dinámicos -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    function mostrarFormulario() {
      var tipo = document.getElementById("tipoReporte").value;
      document.getElementById("formulario_ventas").style.display = (tipo === "ventas") ? "block" : "none";
      document.getElementById("formulario_inventario").style.display = (tipo === "inventario") ? "block" : "none";
    }
  </script>
  <script>
  document.getElementById('formReporteVentas').addEventListener('submit', function(e) {
    e.preventDefault(); // evitar recarga

    // Obtener valores
    const sucursal = document.getElementById('sucursal_ventas').value;
    const fecha_inicio = document.getElementById('fecha_inicio_ventas').value;
    const fecha_fin = document.getElementById('fecha_fin_ventas').value;

    // Validar (opcional)
    if (!sucursal || !fecha_inicio || !fecha_fin) {
      alert('Por favor, complete todos los campos.');
      return;
    }

    // Crear objeto FormData para enviar POST
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
      tbody.innerHTML = ''; // limpiar tabla

      if (data.error) {
        alert('Error: ' + data.error);
        return;
      }

      if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4">No se encontraron resultados.</td></tr>';
        return;
      }

      // Recorrer resultados y crear filas
      data.forEach(item => {
        const tr = document.createElement('tr');

        // Producto (aquí la columna que quieres mostrar: category_id, cantidad, sucursal, fecha_registro)
        // Según tu petición: Producto = category_id (del producto)
        // Pero en tu PHP actual no traes category_id, solo modelo.
        // Así que o ajustamos PHP para traer category_id o usamos lo que ya tienes.
        // Vamos a suponer que en PHP corriges para traer category_id como producto

        const tdProducto = document.createElement('td');
        tdProducto.textContent = item.producto; // si tienes category_id en producto
        tr.appendChild(tdProducto);

        const tdCantidad = document.createElement('td');
        tdCantidad.textContent = item.cantidad;
        tr.appendChild(tdCantidad);

        const tdSucursal = document.createElement('td');
        tdSucursal.textContent = item.sucursal;
        tr.appendChild(tdSucursal);

        const tdFecha = document.createElement('td');
        tdFecha.textContent = item.fecha;
        tr.appendChild(tdFecha);

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
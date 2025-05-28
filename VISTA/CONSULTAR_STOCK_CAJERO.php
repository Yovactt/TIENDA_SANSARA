<?php
require '../MODELO/Conexion.php'; // Incluir el archivo de conexión

// Establecer conexión a la base de datos
$conn = conectar();

// Preparar consulta SQL para seleccionar todos los productos
$sql = "SELECT * FROM productos";

// Preparar la declaración SQL y ejecutarla
$stmt = $conn->query($sql);

// Verificar si se encontraron resultados
if ($stmt->rowCount() > 0) {
    $productos = $stmt->fetchAll(); // Obtener todos los productos
} else {
    $productos = []; // Inicializar como array vacío si no hay productos
}

// Cerrar conexión a la base de datos
$conn = null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CONSULTAR STOCK</title> 
  <!-- Enlace a la biblioteca de iconos Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

  <style>
    /* Reset general */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Estilo general del cuerpo */
    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /*  (Menú lateral) */
    .sidebar {
      width: 60px; /* Tamaño minimizado */
      background: linear-gradient(to right, #151718,  #03045E); /* Fondo degradado */
      transition: width 0.3s ease;
      overflow: hidden;
      position: fixed;
      height: 100%;
      padding-top: 20px;
    }

    /* Al pasar el mouse, se expande */
    .sidebar:hover {
      width: 260px;
    }

    /* Título SANSARA oculto inicialmente */
    .sidebar h2 {
      color: #fff;
      text-align: center;
      margin-bottom: 30px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    /* Mostrar título al hacer hover */
    .sidebar:hover h2 {
      opacity: 1;
    }

    /* Enlaces dentro del menú */
    .sidebar a {
      position: relative;
      display: flex;
      align-items: center;
      color: #fff;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.3s ease, color 0.3s ease;
    }

    /* Barra decorativa a la izquierda al estar activo */
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

    /* Efecto al estar activo  */
    .sidebar a:hover,
    .sidebar a.active {
      background: linear-gradient(90deg, rgba(253,202,64,0.2) 0%, #FDCA40 100%);
      color: #151718;
    }

    .sidebar a:hover::before,
    .sidebar a.active::before {
      transform: scaleY(1);
    }

    /* Iconos */
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

    /* Texto al lado del ícono (oculto al inicio) */
    .sidebar span {
      margin-left: 15px;
      white-space: nowrap;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    /* Mostrar texto al expandir la barra */
    .sidebar:hover span {
      opacity: 1;
    }

    /* CONTENIDO PRINCIPAL */
    .content {
      margin-left: 80px;
      padding: 60px;
      transition: margin-left 0.3s ease;
      animation: fadeInSlide 1s ease forwards; /* Animación entrada */
      opacity: 0;
    }

    .sidebar:hover ~ .content {
      margin-left: 260px;
    }

    /* Animación de aparición del contenido */
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

    h2 {
      margin-bottom: 20px;
      color: #31393C;
    }

    /* FILTROS DE BÚSQUEDA */
    .filtros {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
      margin-bottom: 30px;
    }

    .filtros h3 {
      margin-bottom: 15px;
    }

    .fila-filtros {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 10px;
    }

    .filtros input,
    .filtros select {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      min-width: 150px;
      flex: 1;
    }

    /* TABLA DE RESULTADOS */
    .tabla-container {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #151718;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      border: 1px solid #ccc;
    }

    th, td {
      text-align: center;
      padding: 10px;
      border: 1px solid #ccc;
    }

    th {
      background: linear-gradient(to bottom, #31393C,#2176FF);
      color: white;
    }

    tr:hover {
      background-color: #fff;
    }

    /* Botón de solicitud  */
    .btn-solicitar {
      padding: 8px 12px;
      background: linear-gradient(to right, #F79824, #FDCA40);
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      box-shadow: 0 4px 10px #151718;
      transition: all 0.3s ease;
    }

    .btn-solicitar:hover {
      background: linear-gradient(to right, #FDCA40 , #F79824);
      transform: translateY(-2px);
      box-shadow: 0 6px 14px #151718;
    }
  </style>
</head>

<body>
 
    <div class="sidebar">
        <h2>SANSARA</h2><br>
    <a href="REGISTRAR_VENTAS.php"><i class="fas fa-cash-register"></i><span>Registrar Venta</span></a>
    <a href="PROCESAR_PAGO.php"><i class="fas fa-credit-card"></i><span>Procesar Pago</span></a>
    <a href="DEVOLUCIONES.php"><i class="fas fa-undo-alt"></i><span>Devoluciones</span></a>
    <a href="CONSULTAR_STOCK.php"><i class="fas fa-boxes"></i><span>Consultar Stock</span></a>
    <a href="CERRAR_SESION.php"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a>
      </div>

  <!-- CONTENIDO PRINCIPAL -->
  <div class="content">
    <h2><i class="fas fa-boxes-stacked"></i> CONSULTAR STOCK</h2>

    <!-- Sección de filtros -->
<div class="filtros">
  <input type="text" id="filtro-etiqueta" placeholder="Etiqueta">
  <input type="text" id="filtro-modelo" placeholder="Modelo">
  <input type="text" id="filtro-color" placeholder="Color">
  <input type="text" id="filtro-talla" placeholder="Talla">

  <select id="filtro-sucursal">
    <option value="">Sucursal</option>
    <option value="Sucursal 1">Sucursal 1</option>
    <option value="Sucursal 2">Sucursal 2</option>
    <option value="Sucursal 3">Sucursal 3</option>
    <option value="Sucursal 4">Sucursal 4</option>
  </select>
</div>


    <!-- Tabla de resultados -->
    <div class="tabla-container">
      <table>
        <thead>
          <tr>
            <th>Modelo</th>
            <th>Talla</th>
            <th>Color</th>
            <th>Precio</th>
            <th>Marca</th>
            <th>Etiqueta</th>
            <th>Sucursal</th>
            <th>Cantidad</th>
          </tr>
        </thead>
        <tbody>
          <!-- Mostrar productos dinámicamente -->
          <?php foreach ($productos as $producto): ?>
            <tr>
              <td><?php echo htmlspecialchars($producto['modelo']); ?></td>
              <td><?php echo htmlspecialchars($producto['talla']); ?></td>
              <td><?php echo htmlspecialchars($producto['color']); ?></td>
              <td><?php echo htmlspecialchars($producto['precio']); ?></td>
              <td><?php echo htmlspecialchars($producto['marca']); ?></td>
              <td><?php echo htmlspecialchars($producto['etiqueta']); ?></td>
              <td><?php echo htmlspecialchars($producto['sucursal']); ?></td>
              <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
            </tr>
          <?php endforeach; ?>
          <!-- Si no hay productos, mostrar mensaje -->
          <?php if (empty($productos)): ?>
            <tr>
              <td colspan="9" style="text-align:center; color: #999;">Sin productos disponibles</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <script>
  const inputs = [
    'filtro-etiqueta',
    'filtro-modelo',
    'filtro-color',
    'filtro-talla',
    'filtro-sucursal'
  ];

inputs.forEach(id => {
  const el = document.getElementById(id);
  if (el.tagName === 'SELECT') {
    el.addEventListener('change', filtrarProductos);
  } else {
    el.addEventListener('input', filtrarProductos);
  }
});

  function filtrarProductos() {
    const data = {
      etiqueta:  document.getElementById('filtro-etiqueta').value,
      modelo:    document.getElementById('filtro-modelo').value,
      color:     document.getElementById('filtro-color').value,
      talla:     document.getElementById('filtro-talla').value,
      sucursal:  document.getElementById('filtro-sucursal').value,
    };

    fetch('FiltrarStock.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams(data)
    })
    .then(res => res.json())
    .then(productos => {
      const tbody = document.querySelector('table tbody');
      tbody.innerHTML = '';

      if (productos.length === 0) {
        tbody.innerHTML = `<tr><td colspan="9" style="text-align:center; color: #999;">Sin resultados</td></tr>`;
        return;
      }

      productos.forEach(prod => {
        tbody.innerHTML += `
          <tr>
            <td>${prod.modelo}</td>
            <td>${prod.categoria_id}</td>
            <td>${prod.talla}</td>
            <td>${prod.color}</td>
            <td>${prod.precio}</td>
            <td>${prod.marca}</td>
            <td>${prod.etiqueta}</td>
            <td>${prod.sucursal}</td>
            <td>${prod.cantidad}</td>
          </tr>`;
      });
    });
  }
</script>
<script>
  // Esperar a que el DOM esté cargado
  document.addEventListener("DOMContentLoaded", () => {
    const filtroEtiqueta = document.getElementById("filtro-etiqueta");
    const filtroModelo = document.getElementById("filtro-modelo");
    const filtroColor = document.getElementById("filtro-color");
    const filtroTalla = document.getElementById("filtro-talla");
    const filtroSucursal = document.getElementById("filtro-sucursal");
    const filas = document.querySelectorAll("tbody tr");

    const aplicarFiltros = () => {
      const etiqueta = filtroEtiqueta.value.trim().toLowerCase();
      const modelo = filtroModelo.value.trim().toLowerCase();
      const color = filtroColor.value.trim().toLowerCase();
      const talla = filtroTalla.value.trim().toLowerCase();
      const sucursal = filtroSucursal.value;

      filas.forEach(fila => {
        const celdaModelo = fila.cells[0].textContent.toLowerCase();
        const celdaTalla = fila.cells[1].textContent.toLowerCase();
        const celdaColor = fila.cells[2].textContent.toLowerCase();
        const celdaEtiqueta = fila.cells[5].textContent.toLowerCase();
        const celdaSucursal = fila.cells[6].textContent;

        const coincide =
          (etiqueta === "" || celdaEtiqueta.includes(etiqueta)) &&
          (modelo === "" || celdaModelo.includes(modelo)) &&
          (color === "" || celdaColor.includes(color)) &&
          (talla === "" || celdaTalla.includes(talla)) &&
          (sucursal === "" || celdaSucursal === sucursal);

        fila.style.display = coincide ? "" : "none";
      });
    };

    // Agregar eventos a todos los filtros
    filtroEtiqueta.addEventListener("input", aplicarFiltros);
    filtroModelo.addEventListener("input", aplicarFiltros);
    filtroColor.addEventListener("input", aplicarFiltros);
    filtroTalla.addEventListener("input", aplicarFiltros);
    filtroSucursal.addEventListener("change", aplicarFiltros);
  });
</script>

</body>
</html>

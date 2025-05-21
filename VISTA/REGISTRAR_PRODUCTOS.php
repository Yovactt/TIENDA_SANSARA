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
    /* ... Todo tu CSS exactamente como lo compartiste ... */
  </style>

  <script>
    // Simulación para que puedas integrar con backend más tarde
    function filtrarSucursal() {
      const seleccion = document.getElementById("filtroSucursal").value;
      const contenedor = document.getElementById("contenedorTabla");
      
      // Simulación de resultados dinámicos (en desarrollo real deberías cargar por AJAX o PHP)
      let tabla = `
        <table>
          <thead>
            <tr><th>Modelo</th><th>Marca</th><th>Precio</th><th>Sucursal</th></tr>
          </thead>
          <tbody>
            <tr><td>Modelo A</td><td>Marca X</td><td>$120</td><td>${seleccion}</td></tr>
            <tr><td>Modelo B</td><td>Marca Y</td><td>$90</td><td>${seleccion}</td></tr>
          </tbody>
        </table>
      `;

      if (seleccion === "todas") {
        tabla = `<p class="sin-datos">Mostrando productos de todas las sucursales (simulado)</p>` + tabla;
      }

      contenedor.innerHTML = tabla;
    }
  </script>
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

    <!-- Formulario de Registro de Producto -->
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
          <input type="number" id="cantidad" name="cantidad" placeholder="Cantidad">
        </div>

        <div class="fila">
          <label for="sucursal">Sucursal:</label>
          <select id="sucursal" name="sucursal">
            <option value="Sucursal1">Sucursal 1</option>
            <option value="Sucursal2">Sucursal 2</option>
            <option value="Sucursal3">Sucursal 3</option>
            <option value="Sucursal4">Sucursal 4</option>
          </select>
        </div>

        <div class="fila">
          <button type="submit">Registrar Producto</button>
        </div>
      </form>
    </div>

    <!-- Filtro de Productos por Sucursal -->
    <div class="formulario">
      <h3>Ver Productos por Sucursal</h3>
      <div class="fila">
        <label for="filtroSucursal">Sucursal:</label>
        <select id="filtroSucursal" onchange="filtrarSucursal()">
          <option value="todas">Todas</option>
          <option value="Sucursal1">Sucursal 1</option>
          <option value="Sucursal2">Sucursal 2</option>
          <option value="Sucursal3">Sucursal 3</option>
          <option value="Sucursal4">Sucursal 4</option>
        </select>
      </div>
    </div>

    <!-- Contenedor dinámico para la tabla -->
    <div class="tabla-container" id="contenedorTabla">
      <!-- Aquí se mostrará la tabla con los productos filtrados -->
    </div>
  </div>
</body>
</html>

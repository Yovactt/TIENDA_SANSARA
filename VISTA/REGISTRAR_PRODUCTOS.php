<?php
session_start();
$rol = $_SESSION['rol'] ?? 'Administrador'; // 'Administrador' o 'Gerente'
require_once '../MODELO/Conexion.php';

$filtroSucursal = $_GET['filtroSucursal'] ?? 'todas';

try {
    $conn = conectar();

    if ($filtroSucursal == 'todas') {
        $stmt = $conn->prepare("SELECT p.*, c.nombre AS categoria_nombre FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id ORDER BY p.id DESC");
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("SELECT p.*, c.nombre AS categoria_nombre FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE p.sucursal = :sucursal ORDER BY p.id DESC");
        $stmt->bindParam(':sucursal', $filtroSucursal);
        $stmt->execute();
    }

    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $productos = [];
    // Opcional: manejar error de conexión o consulta
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registrar Productos</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  /* (Aquí va todo tu CSS, igual que antes) */
  * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color:  #fff;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .sidebar {
      width: 60px;
      background: linear-gradient(to right, #151718,  #03045E);
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
      width: 100%;
      border-collapse: collapse;
      background-color: #fff;
      box-shadow: 0 0 5px #151718;
    }

    th, td {
      padding: 12px;
      text-align: center;
      border: 1px solid #ddd;
    }

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
</style>
</head>
<body>
  <div class="sidebar">
    <?php if (strtolower($rol) === 'administrador'): ?>
      <h2>ADMINISTRADOR</h2>
      <a href="REGISTRO_DE_USUARIOS.php"><i class="fas fa-user-shield"></i><span>Registrar Usuarios</span></a>
      <a href="MODIFICAR_USUARIOS.php"><i class="fas fa-users"></i><span>Modificar Usuarios</span></a>
      <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a>
      <a href="REPORTES_ADMIN.php"><i class="fas fa-chart-line"></i><span>Reportes</span></a>
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
     <h2><i class="fas fa-box-open"></i>  REGISTRAR PRODUCTOS</h2>
    </div>

    <!-- Formulario de Registro de Producto -->
    <div class="formulario">
      <h3>Formulario de Registro de Producto</h3>
      <form action="../CONTROLADOR/RegistrarProductos.php" method="POST">
        <div class="fila">
          <label for="categoria_id">Categoría:</label>
          <select id="categoria_id" name="categoria_id">
            <option value="">Seleccionar</option>
            <option value="1">Ropa de Dama</option>
            <option value="2">Ropa de Caballero</option>
            <option value="3">Ropa de Niño</option>
            <option value="4">Ropa de Niña</option>
            <option value="5">Sandalias</option>
            <option value="6">Chacharas</option>
          </select>
        </div>

        <div class="fila">
          <label for="modelo">Modelo:</label>
          <input type="text" id="modelo" name="modelo" placeholder="Modelo del producto" required>
          <label for="talla">Talla:</label>
          <input type="text" id="talla" name="talla" placeholder="Talla" required>
        </div>

        <div class="fila">
          <label for="color">Color:</label>
          <input type="text" id="color" name="color" placeholder="Color" required>
          <label for="precio">Precio:</label>
          <input type="number" id="precio" name="precio" placeholder="Precio" required step="0.01" min="0">
        </div>

        <div class="fila">
          <label for="marca">Marca:</label>
          <input type="text" id="marca" name="marca" placeholder="Marca (opcional)">
          <label for="cantidad">Cantidad:</label>
          <input type="number" id="cantidad" name="cantidad" placeholder="Cantidad" required min="0">
        </div>

        <div class="fila">
          <label for="etiqueta">Etiqueta:</label>
          <input type="text" id="etiqueta" name="etiqueta" >
        </div>

        <div class="fila">
          <label for="sucursal">Sucursal:</label>
          <select id="sucursal" name="sucursal" required>
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
      <form method="GET" action="REGISTRAR_PRODUCTOS.php">
        <div class="fila">
          <label for="filtroSucursal">Sucursal:</label>
          <select id="filtroSucursal" name="filtroSucursal" onchange="this.form.submit()">
            <option value="todas" <?php if(($filtroSucursal ?? '') == 'todas') echo 'selected'; ?>>Todas</option>
            <option value="Sucursal1" <?php if(($filtroSucursal ?? '') == 'Sucursal1') echo 'selected'; ?>>Sucursal 1</option>
            <option value="Sucursal2" <?php if(($filtroSucursal ?? '') == 'Sucursal2') echo 'selected'; ?>>Sucursal 2</option>
            <option value="Sucursal3" <?php if(($filtroSucursal ?? '') == 'Sucursal3') echo 'selected'; ?>>Sucursal 3</option>
            <option value="Sucursal4" <?php if(($filtroSucursal ?? '') == 'Sucursal4') echo 'selected'; ?>>Sucursal 4</option>
          </select>
        </div>
      </form>
    </div>

    <!-- Contenedor dinámico para la tabla de productos filtrados -->
    <div class="tabla-container" id="contenedorTabla">
      <?php if (empty($productos)): ?>
        <p class="sin-datos">No hay productos registrados para esta sucursal.</p>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>Modelo</th>
              <th>Categoría</th>
              <th>Talla</th>
              <th>Color</th>
              <th>Precio</th>
              <th>Marca</th>
              <th>Cantidad</th>
              <th>Etiqueta</th>
              <th>Sucursal</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($productos as $producto): ?>
              <tr>
                <td><?php echo htmlspecialchars($producto['modelo']); ?></td>
                <td><?php echo htmlspecialchars($producto['categoria_nombre'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($producto['talla']); ?></td>
                <td><?php echo htmlspecialchars($producto['color']); ?></td>
                <td><?php echo number_format($producto['precio'], 2); ?></td>
                <td><?php echo htmlspecialchars($producto['marca']); ?></td>
                <td><?php echo (int)$producto['cantidad']; ?></td>
                <td><?php echo htmlspecialchars($producto['etiqueta']); ?></td>
                <td><?php echo htmlspecialchars($producto['sucursal']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>

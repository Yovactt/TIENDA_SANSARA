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
    z-index: 1000;
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
    padding: 60px 20px;
    flex: 1;
    transition: margin-left 0.3s ease;
  }

  .sidebar:hover ~ .content {
    margin-left: 260px;
  }

  h2 {
    margin-bottom: 20px;
    color: #31393C;
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
  display: grid;
  grid-template-columns: 150px 1fr;
  align-items: center;
  gap: 10px 20px;
  margin-bottom: 15px;
}

.formulario label {
  font-weight: bold;
  color: #31393C;
  margin-right: 10px;
}

.formulario input,
.formulario select {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  width: 100%;
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
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  z-index: -1;
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
    background: linear-gradient(to bottom, #31393C, #2176FF);
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
    background: linear-gradient(to right, #F79824, #FDCA40);
    color: #fff;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 4px 10px #151718;
    transition: all 0.3s ease;
    justify-content: center;
  }

  .formulario button:hover {
    background: linear-gradient(to right, #FDCA40, #F79824);
    transform: translateY(-2px);
    box-shadow: 0 6px 14px #151718;
  }

  body.dark-theme {
    background-color: #1c1c1c;
    color: #ffffff;
  }

  body.dark-theme .formulario,
  body.dark-theme .tabla-container,
  body.dark-theme .content {
    background-color: #2c2c2c;
    color: #ffffff;
    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.1);
  }

  body.dark-theme .sidebar {
    background: linear-gradient(to right, #0f0f0f, #03045E);
  }

  body.dark-theme .sidebar h2,
  body.dark-theme .sidebar a,
  body.dark-theme h2 {
    color: #ffffff;
  }

  body.dark-theme select,
  body.dark-theme input,
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
  }

  body.dark-theme td {
    border-color: #555;
  }

  body.dark-theme .sidebar a:hover,
  body.dark-theme .sidebar a.active {
    background: linear-gradient(90deg, rgba(253,202,64,0.2) 0%, #FDCA40  100%);
    color: #000;
  }

  body.dark-theme .formulario button {
    background: linear-gradient(to right, #FDCA40 , #F79824);
    color: #000;
  }

  body.dark-theme .formulario button:hover {
    background: linear-gradient(to right, #F79824, #FDCA40);
  }

  /* MEDIA QUERIES RESPONSIVE */
  @media (max-width: 768px) {
    .sidebar {
      width: 60px;
      position: fixed;
      height: auto;
      bottom: 0;
      top: auto;
      display: flex;
      flex-direction: row;
      justify-content: space-around;
      padding: 10px 0;
    }

    .sidebar:hover {
      width: 100%;
      height: auto;
    }

    .sidebar h2,
    .sidebar span {
      display: none;
    }

    .content {
      margin-left: 0;
      padding: 80px 10px 20px;
    }

    .formulario .fila {
      flex-direction: column;
    }

    .formulario input,
    .formulario select {
      width: 100%;
    }
  }

  @media (max-width: 480px) {
    h2, .formulario h3 {
      font-size: 1.2rem;
    }

    th, td {
      font-size: 0.85rem;
      padding: 8px;
    }

    .formulario button {
      width: 100%;
      padding: 12px;
      justify-content: center;
      
    }
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
    <a href="SUPERVISION_VENTAS.php"><i class="	fas fa-cash-register"></i><span>Supervisión de Ventas</span></a>
    <a href="CONTROL_INVENTARIO_GERENTE.php"><i class="fas fa-boxes-stacked"></i><span>Control de Inventario</span></a>
    <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a> 
    <a href="REPORTES_GEREN.php"><i class="fas fa-chart-bar"></i><span>Reportes</span></a>
    <a href="CERRAR_SESION.php"><i class="	fas fa-right-from-bracket"></i><span>Cerrar Sesión</span></a>
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

        <div class="fila" >
          <button type="submit" class="formulario">Registrar Producto</button>
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

  <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
      <path fill="#2176FF" fill-opacity="0.2" d="M0,192L60,181.3C120,171,240,149,360,154.7C480,160,600,192,720,192C840,192,960,160,1080,154.7C1200,149,1320,171,1380,181.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
  </svg>

  <script>
  const modelosPorCategoria = {
    "1": ["Vestido de noche", "Vestido casual", "Blusa", "Pantalón", "Falda", "Conjunto", "Top", "Short"],
    "2": ["Camisa", "Pantalón", "Playera", "Chamarra", "Short", "Traje", "Sudadera"],
    "3": ["Pantalón", "Camisa", "Conjunto", "Short", "Playera", "Sudadera"],
    "4": ["Vestido", "Conjunto", "Falda", "Blusa", "Playera", "Sudadera"],
    "5": ["Sandalia plana", "Sandalia con tacón", "Sandalia deportiva"],
    "6": ["Accesorio", "Bisutería", "Pulsera", "Collar", "Anillo", "Aretes"]
  };

  const colores = [
    "Rojo", "Azul", "Verde", "Negro", "Blanco", "Gris", "Beige", "Rosado",
    "Amarillo", "Café", "Vino", "Mostaza", "Turquesa", "Fucsia", "Morado", "Coral"
  ];

  // Elementos
  const categoriaSelect = document.getElementById("categoria_id");
  const modeloInput = document.getElementById("modelo");
  const colorInput = document.getElementById("color");
  const etiquetaInput = document.getElementById("etiqueta");

  const nuevoSelectColor = document.createElement("select");
  nuevoSelectColor.name = "color";
  nuevoSelectColor.id = "color";
  colores.forEach(color => {
    const opt = document.createElement("option");
    opt.value = color;
    opt.textContent = color;
    nuevoSelectColor.appendChild(opt);
  });
  colorInput.replaceWith(nuevoSelectColor);

  // Autocompletar modelos
  categoriaSelect.addEventListener("change", function () {
    const categoria = this.value;
    const modelos = modelosPorCategoria[categoria] || [];
    modeloInput.value = "";
    modeloInput.setAttribute("list", "modelos-list");
    let dataList = document.getElementById("modelos-list");
    if (!dataList) {
      dataList = document.createElement("datalist");
      dataList.id = "modelos-list";
      modeloInput.after(dataList);
    }
    dataList.innerHTML = modelos.map(modelo => `<option value="${modelo}">`).join("");
  });

  // Generar etiqueta automáticamente
const actualizarEtiqueta = () => {
  const fecha = new Date();
  const marcaTiempo = fecha.getTime().toString().slice(-5); // últimos 5 dígitos del timestamp
  etiquetaInput.value = marcaTiempo;
};


  modeloInput.addEventListener("input", actualizarEtiqueta);
  nuevoSelectColor.addEventListener("change", actualizarEtiqueta);
  nuevoSelectTalla.addEventListener("change", actualizarEtiqueta);
  categoriaSelect.addEventListener("change", actualizarEtiqueta);
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
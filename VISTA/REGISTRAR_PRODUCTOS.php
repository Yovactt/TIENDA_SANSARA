<?php
session_start();
if (!isset($_SESSION['rol'])) {
    die("Error: No se ha iniciado sesión correctamente.");
}
$rol = $_SESSION['rol'];
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

.logo-box {
  text-align: center;
  margin-bottom: 0px;
}

.logo-box h2 {
  margin: 0; /* Elimina espacio debajo del título SANSARA */
}

.rol {
  display: block;
  color: rgb(255, 255, 255);
  font-size: 12px;
  margin-top: 0px; /* Cero espacio para que quede pegado */
  opacity: 0;
  transition: opacity 0.3s ease;
}

.sidebar:hover .rol {
  opacity: 1;
}


/* Modal de fondo */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

/* Tarjeta con estilo de cristal */
.glass-card {
  max-width: 400px;
  background: rgba(15, 34, 204, 0.1);
  backdrop-filter: blur(10px);
  border-radius: 15px;
  padding: 30px 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
  position: relative;
  color: #fff;
}

/* Botón cerrar (X) */
.modal-close {
  position: absolute;
  top: 10px;
  right: 20px;
  font-size: 18px;
  cursor: pointer;
  color: #fff;
}

.modal-button {
  display: block;
  margin: 20px auto 0;
  padding: 8px 20px;
  background: linear-gradient(to right, #F79824, #FDCA40);
  color: #fff;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  transition: background 0.3s ease;
}

.modal-button:hover {
  background-color: #FDCA40;
  color: #000;
}
</style>
</head>
<body>
  <div class="sidebar">
    <div class="logo-box">
      <h2>SANSARA</h2>
      <span class="rol"><?php echo ucfirst($_SESSION['rol']); ?></span>
    </div>
    <br>

    <?php if (strtolower($rol) === 'administrador'): ?>
      <a href="REGISTRO_DE_USUARIOS.php"><i class="fas fa-user-shield"></i><span>Registrar Usuarios</span></a>
      <a href="MODIFICAR_USUARIOS.php"><i class="fas fa-users"></i><span>Modificar Usuarios</span></a>
      <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a>
      <a href="REPORTES_ADMIN.php"><i class="fas fa-chart-line"></i><span>Reportes</span></a>
      <a href="CERRAR_SESION.php"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a>
    <?php else: ?>
      <a href="SUPERVISION_VENTAS.php"><i class="fas fa-cash-register"></i><span>Supervisión de Ventas</span></a>
      <a href="CONTROL_INVENTARIO_GERENTE.php"><i class="fas fa-boxes-stacked"></i><span>Control de Inventario</span></a>
      <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a> 
      <a href="REPORTES_GEREN.php"><i class="fas fa-chart-bar"></i><span>Reportes</span></a>
      <a href="CERRAR_SESION.php"><i class="fas fa-right-from-bracket"></i><span>Cerrar Sesión</span></a>
    <?php endif; ?>
  </div>

  <div class="content">
    <div class="welcome">
      <h2><i class="fas fa-box-open"></i> REGISTRAR PRODUCTOS</h2>
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
          <select id="talla" name="talla" required>
            <option value="">Seleccionar</option>
            <option value="XS">XS</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
          </select>
        </div>

        <div class="fila">
          <label for="color">Color:</label>
          <select id="color" name="color" required></select>
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
  <input type="text" id="etiqueta" name="etiqueta" readonly style="background-color:rgb(255, 255, 255);">
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

    <!-- Tabla de productos -->
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

  <script>
    const modelosPorCategoria = {
      "1": ["Vestido de noche", "Vestido casual", "Blusa", "Pantalón", "Falda", "Conjunto", "Top", "Short"],
      "2": ["Camisa", "Pantalón", "Playera", "Chamarra", "Short", "Traje", "Sudadera"],
      "3": ["Pantalón", "Camisa", "Conjunto", "Short", "Playera", "Sudadera"],
      "4": ["Vestido", "Conjunto", "Falda", "Blusa", "Playera", "Sudadera"],
      "5": ["Sandalia plana", "Sandalia con tacón", "Sandalia deportiva"],
      "6": ["Accesorio", "Bisutería", "Pulsera", "Collar", "Anillo", "Aretes"]
    };

    const colores = ["Rojo", "Azul", "Verde", "Negro", "Blanco", "Gris", "Beige", "Rosado", "Amarillo", "Café", "Vino", "Mostaza", "Turquesa", "Fucsia", "Morado", "Coral"];

    const categoriaSelect = document.getElementById("categoria_id");
    const modeloInput = document.getElementById("modelo");
    const tallaSelect = document.getElementById("talla");
    const colorSelect = document.getElementById("color");
    const etiquetaSpan = document.getElementById("etiquetaGenerada");
    const etiquetaHidden = document.getElementById("etiqueta");

    // Cargar colores en el select
    colores.forEach(color => {
      const opt = document.createElement("option");
      opt.value = color;
      opt.textContent = color;
      colorSelect.appendChild(opt);
    });

    // Cargar modelos según categoría
    categoriaSelect.addEventListener("change", function () {
      const modelos = modelosPorCategoria[this.value] || [];
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

function actualizarEtiqueta() {
  const timestamp = new Date().getTime().toString().slice(-5);
  document.getElementById("etiqueta").value = timestamp;
}

modeloInput.addEventListener("input", actualizarEtiqueta);
colorSelect.addEventListener("change", actualizarEtiqueta);
tallaSelect.addEventListener("change", actualizarEtiqueta);
categoriaSelect.addEventListener("change", actualizarEtiqueta);

  </script>

  <?php if (isset($_GET['registroP']) && $_GET['registroP'] === 'exito'): ?>
    <div id="modalRegistroP" class="modal-overlay">
      <div class="glass-card">
        <span class="modal-close" onclick="cerrarModalRegistroP()">&times;</span>
        <h2 style="text-align:center; color:#FDCA40;">¡Producto Registrado!</h2>
        <p style="text-align:center;">Producto registrado correctamente.</p>
        <button class="modal-button" onclick="cerrarModalRegistroP()">Cerrar</button>
      </div>
    </div>
    <script>
      function cerrarModalRegistroP() {
        document.getElementById('modalRegistroP').style.display = 'none';
        window.history.replaceState({}, document.title, window.location.pathname);
      }
    </script>
  <?php endif; ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const soloLetrasMayus = function(input) {
      input.value = input.value.toUpperCase().replace(/[^A-ZÁÉÍÓÚÑ\s]/g, '');
    };

    const marcaInput = document.getElementById('marca');
    const modeloInput = document.getElementById('modelo');

    marcaInput.addEventListener('input', function() {
      soloLetrasMayus(this);
    });

    modeloInput.addEventListener('input', function() {
      soloLetrasMayus(this);
    });
  });
</script>
</body>

</html>

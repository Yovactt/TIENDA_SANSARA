<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PROCESAR PAGO</title>
  <!-- Fuente de íconos de Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

  <style>
    /* Estilos generales */
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

    /* (menú lateral) */
    .sidebar {
      width: 60px;
      background: linear-gradient(to right, #151718, #03045E);
      transition: width 0.3s ease;
      overflow: hidden;
      position: fixed;
      height: 100%;
      padding-top: 20px;
    }

    /* Al pasar el mouse se expande el menú */
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

    /* Línea naranja decorativa al pasar el mouse */
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

    /* Efectos hover y activo */
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

    .sidebar:hover span {
      opacity: 1;
    }

    /* Contenedor principal */
    .content {
      margin-left: 80px;
      padding: 60px;
      transition: margin-left 0.3s ease;
      animation: fadeInSlide 1s ease forwards;
      opacity: 0;
    }

    /* Transición al expandir menú */
    .sidebar:hover ~ .content {
      margin-left: 260px;
    }

    /* Animación de entrada */
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

    /* Estilo del formulario */
    .formulario {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
      max-width: 600px;
      margin-left: 0;
    }

    .input-group {
      margin-bottom: 15px;
    }

    .input-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .input-group input,
    .input-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    /* Botón de pago */
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
      display: block;
      margin: 0 auto;
    }

    .formulario button:hover {
      background: linear-gradient(to right, #FDCA40, #F79824);
      transform: translateY(-2px);
      box-shadow: 0 6px 14px #151718;
    }

    
    .total {
      font-size: 18px;
      font-weight: bold;
      margin-top: 20px;
      text-align: center;
      color: #31393C;
    }

    /* Ola decorativa inferior */
    .wave {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      z-index: -1;
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

/* Botón aceptar */
.modal-button {
  display: block;
  margin: 20px auto 0;
  padding: 8px 20px;
  background: linear-gradient(to right, #F79824, #FDCA40);
  color: #000;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.modal-button:hover {
  background-color: #e0b134;
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
    .sidebar .subtitulo {
  color: #fff;
  text-align: center;
  font-size: 12px;
  margin-top: -30px;  
  font-weight: normal;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.sidebar:hover .subtitulo {
  opacity: 1;
}

  </style>
</head>
<body>
<?php
$id_venta = $_GET['id_venta'] ?? null;
$totalVenta = 0;

if ($id_venta) {
    require_once '../MODELO/Conexion.php';
    $conn = conectar(); // conexión PDO

    // Preparar y ejecutar consulta
    $stmt = $conn->prepare("SELECT total FROM ventas WHERE id_venta = ?");
    $stmt->execute([$id_venta]);

    // Obtener resultado
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($fila) {
        $totalVenta = $fila['total'];
    }
}
?>

<!-- PASO DE ID DE VENTA A JS -->
<script>
  const idVenta = <?= json_encode($id_venta) ?>;
</script>

<div class="sidebar">
  <h2>SANSARA</h2>
  <p class="subtitulo">Cajero</p>
  <br>
  <a href="REGISTRAR_VENTAS.php"><i class="fas fa-cash-register"></i><span>Registrar Venta</span></a>
  <a href="PROCESAR_PAGO.php"><i class="fas fa-credit-card"></i><span>Procesar Pago</span></a>
  <a href="DEVOLUCIONES.php"><i class="fas fa-undo-alt"></i><span>Devoluciones</span></a>
  <a href="CONSULTAR_STOCK_CAJERO.php"><i class="fas fa-boxes"></i><span>Consultar Stock</span></a>
  <a href="CERRAR_SESION.php"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a>
</div>

<!-- Contenido principal -->
<div class="content">
  <h2><i class="fas fa-credit-card"></i> PROCESAR PAGO</h2>

  <div class="formulario">
    <!-- Total a pagar -->
    <div class="input-group">
      <label>Total a Pagar:</label>
      <input type="number" id="totalPagar" value="<?= htmlspecialchars($totalVenta) ?>" readonly>
    </div>

    <!-- Campo para ingresar dinero solo si es efectivo -->
    <div class="input-group" id="grupoEfectivo">
      <label>Dinero Recibido:</label>
      <input type="number" id="dineroRecibido" min="0" oninput="calcularCambio()">
    </div>

    <!-- Muestra el cambio -->
    <div class="total">
      Cambio: $<span id="cambio">0.00</span>
    </div>

    <!-- Botón para procesar el pago -->
    <button onclick="finalizarPago()">Finalizar Pago</button>
  </div>
</div>

<!-- Script para lógica del formulario -->
<script>
  let totalVenta = <?= json_encode($totalVenta) ?>;
  document.getElementById("totalPagar").value = totalVenta.toFixed(2);

  function calcularCambio() {
    const totalPagar = parseFloat(document.getElementById("totalPagar").value) || 0;
    const dineroRecibido = parseFloat(document.getElementById("dineroRecibido").value) || 0;
    const cambio = dineroRecibido - totalPagar;
    document.getElementById("cambio").textContent = cambio >= 0 ? cambio.toFixed(2) : "0.00";
  }

  function finalizarPago() {
    // Redireccionar al controlador con ID
    if (idVenta) {
      window.location.href = "../CONTROLADOR/ProcesarPago.php?id_venta=" + idVenta;
    } else {
      alert("ID de venta no válido.");
    }
  }

  document.getElementById("grupoEfectivo").style.display = "block";
</script>

<!-- Modal de Confirmación -->
<?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'finalizarPago'): ?>
  <div class="modal-overlay" id="mensajeModal">
    <div class="glass-card">
      <span class="modal-close" onclick="cerrarModal()">×</span>
      <h2 style="text-align:center; color:#FDCA40;">Pago Exitoso</h2>
      <button class="modal-button" onclick="cerrarModal()">Aceptar</button>
    </div>
  </div>

  <script>
    function cerrarModal() {
      document.getElementById("mensajeModal").style.display = "none";
    }
  </script>
<?php endif; ?>

<!-- Ola decorativa -->
<svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
  <path fill="#2176FF" fill-opacity="0.2"
    d="M0,192L60,181.3C120,171,240,149,360,154.7C480,160,600,192,720,192C840,192,960,160,1080,154.7C1200,149,1320,171,1380,181.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z">
  </path>
</svg>
</body>


</html>

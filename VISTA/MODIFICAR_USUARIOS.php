<?php
require_once '../MODELO/Conexion.php';
$conexion = conectar();
$sql = "SELECT * FROM usuarios WHERE rol != 'administrador'";
$usuarios = $conexion->query($sql);
?>

<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MODIFICAR USUARIOS</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    .sidebar {
      width: 60px;
      background: linear-gradient(to right, #151718, #03045E);
      transition: width 0.3s ease;
      overflow: hidden;
      position: fixed;
      height: 100%;
      padding-top: 20px;
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
  transition: color 0.3s ease;
  font-size: 20px; /* Tamaño fijo de los íconos */
}

    .sidebar span {
      margin-left: 15px;
      white-space: nowrap;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .sidebar:hover span { opacity: 1; }

    .content {
      margin-left: 80px;
      padding: 60px;
      transition: margin-left 0.3s ease;
      flex: 1;
      overflow: auto;
      animation: fadeInSlide 1s ease forwards;
      opacity: 0;
    }

    .sidebar:hover ~ .content {
      margin-left: 260px;
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

    h2 {
      color: #31393C;
      margin-bottom: 20px;
    }

    .tabla-container {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
      overflow-x: auto;
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

    input, select {
      padding: 4px;
      width: 130px;
      border: 1px solid #ccc;
      border-radius: 6px;
      text-align: center;
    }

    .btn-accion {
      padding: 4px 4px;
      background: linear-gradient(to right, #F79824, #FDCA40);
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin: 2px auto;
      display: block;
      width: 85px;
    }

    .btn-accion:hover {
      background: linear-gradient(to right, #FDCA40, #F79824);
    }

    .acciones {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

  /* Fondo decorativo onda */
  .wave {
      position: absolute;
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

  </style>

  <script>
    function habilitarEdicion(id) {
      const fila = document.getElementById('fila-' + id);
      const inputs = fila.querySelectorAll('input, select');
      inputs.forEach(input => input.removeAttribute('disabled'));
    }
  </script>
</head>
<body>
  <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#28a745" fill-opacity="0.2" d="M0,192L60,181.3C120,171,240,149,360,154.7C480,160,600,192,720,192C840,192,960,160,1080,154.7C1200,149,1320,171,1380,181.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
  </svg>

  <div class="sidebar">
  <div class="logo-box">
      <h2>SANSARA</h2>
      <span class="rol"><?php echo ucfirst($_SESSION['rol']); ?></span>
    </div>
    <br>
    <a href="REGISTRO_DE_USUARIOS.php"><i class="fas fa-user-shield"></i><span>Registrar Usuarios</span></a>
    <a href="MODIFICAR_USUARIOS.php"><i class="fas fa-users"></i><span>Modificar Usuarios</span></a>
    <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a>
    <a href="REPORTES_ADMIN.php"><i class="fas fa-chart-line"></i><span>Reportes</span></a>
    <a href="CERRAR_SESION.php"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a>
  </div>
<!-- Contenido principal -->
<div class="content">
  <h2><i class="fas fa-user-edit"></i> MODIFICAR USUARIOS</h2>

  <div class="tabla-container">
    <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th>Dirección</th>
          <th>Contraseña</th>
          <th>Rol</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $usuario): ?>
  <tr id="fila-<?= $usuario['id_usuario'] ?>">
    <!-- Formulario para Editar -->
    <form method="POST" action="../CONTROLADOR/GuardarUsuarios.php">
      <input type="hidden" name="id" value="<?= $usuario['id_usuario'] ?>">
      <td><input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" disabled></td>
      <td><input type="email" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" disabled></td>
      <td><input type="text" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>" disabled></td>
      <td><input type="text" name="direccion" value="<?= htmlspecialchars($usuario['direccion']) ?>" disabled></td>
      <td><input type="password" name="contrasena" value="<?= htmlspecialchars($usuario['contrasena']) ?>" disabled></td>
      <td>
        <select name="rol" disabled>
          <option value="gerente" <?= $usuario['rol'] == 'gerente' ? 'selected' : '' ?>>Gerente</option>
          <option value="cajero" <?=  $usuario['rol'] == 'cajero' ? 'selected' : '' ?>>Cajero</option>
          <option value="vendedor" <?= $usuario['rol'] == 'vendedor' ? 'selected' : '' ?>>Vendedor</option>
        </select>
      </td>
      <td class="acciones">
        <button type="button" class="btn-accion" onclick="habilitarEdicion(<?= $usuario['id_usuario'] ?>)">Editar</button>
        <button type="submit" class="btn-accion">Guardar</button>
    </form>

   <!-- Formulario para Eliminar -->
      <form method="POST" action="../CONTROLADOR/EliminarUsuarios.php" class="form-eliminar">
        <input type="hidden" name="id" value="<?= $usuario['id_usuario'] ?>">
        <button type="button" class="btn-accion" onclick="confirmarEliminacion(this) ">Eliminar</button>
      </form>

      </td>
  </tr>
  <?php endforeach; ?>
      </tbody>
    </table>
</div>


<!-- Modal de Confirmación de Eliminación -->
<div id="modalEliminar" class="modal-overlay" style="display: none;">
  <div class="glass-card">
    <span class="modal-close" onclick="cerrarModalEliminar()">&times;</span>
    <h2 style="text-align:center; color:#FDCA40;">¿Eliminar Usuario?</h2>
    <p style="text-align:center;">¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.</p>
    <div style="text-align:center; margin-top: 20px;">
      <button class="modal-button" onclick="enviarFormularioEliminar()">Sí, eliminar</button>
      <button class="modal-button" onclick="cerrarModalEliminar()">Cancelar</button>
    </div>
  </div>
</div>

<script>
  let formularioAEliminar = null;

  function confirmarEliminacion(boton) {
    formularioAEliminar = boton.closest('form');
    const modal = document.getElementById('modalEliminar');
    modal.style.display = 'flex';
  }

  function cerrarModalEliminar() {
    document.getElementById('modalEliminar').style.display = 'none';
    formularioAEliminar = null;
  }

  function enviarFormularioEliminar() {
    if (formularioAEliminar) {
      formularioAEliminar.submit();
    }
  }
</script>

<!-- Modal de Confirmación de Eliminación Exitosa -->
<?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'eliminado'): ?>
  <div class="modal-overlay" id="mensajeModal">
    <div class="glass-card">
      <span class="modal-close" onclick="cerrarModal()">×</span>
      <h2 style="text-align:center; color:#FDCA40;">Eliminacion Completada</h2>
       <p style="text-align:center;">Usuario eliminado correctamente</p>
      <button class="modal-button" onclick="cerrarModal()">Aceptar</button>
    </div>
  </div>

  <script>
    function cerrarModal() {
      document.getElementById("mensajeModal").style.display = "none";
    }
  </script>
<?php endif; ?>

<!-- Modal de Confirmación de Guardar -->
<?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'guardar'): ?>
  <div class="modal-overlay" id="mensajeModal">
    <div class="glass-card">
      <span class="modal-close" onclick="cerrarModal()">×</span>
      <h2 style="text-align:center; color:#FDCA40;">Modificacion Exitosa</h2>
       <p style="text-align:center;">Guardado correctamente</p>
      <button class="modal-button" onclick="cerrarModal()">Aceptar</button>
    </div>
  </div>

  <script>
    function cerrarModal() {
      document.getElementById("mensajeModal").style.display = "none";
    }
  </script>
<?php endif; ?>


</body>
</html>

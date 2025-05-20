<?php
require_once '../MODELO/Conexion.php';
$conexion = conectar();
$sql = "SELECT * FROM usuarios WHERE rol != 'administrador'";
$usuarios = $conexion->query($sql);
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
body.dark-theme {
  background-color: #1c1c1c;
  color: #ffffff;
}

body.dark-theme h2,
body.dark-theme th,
body.dark-theme td,
body.dark-theme label,
body.dark-theme .sidebar a,
body.dark-theme .sidebar h2 {
  color: #ffffff;
}

body.dark-theme .tabla-container {
  background-color: #2a2a2a;
  box-shadow: 0 2px 6px #444;
}

body.dark-theme table,
body.dark-theme th,
body.dark-theme td {
  border: 1px solid #444;
}

body.dark-theme th {
  background: linear-gradient(to bottom, #2d2d2d, #1e3a8a); /* reemplazo del azul oscuro */
}

body.dark-theme input,
body.dark-theme select {
  background-color: #333;
  color: #ffffff;
  border: 1px solid #666;
}

body.dark-theme .btn-accion {
  color: #000; /* para que resalte sobre el fondo anaranjado */
}


body.dark-theme .sidebar a::before {
  background: #f79824;
}
body.font-small { font-size: 10px; }
body.font-medium { font-size: 16px; }
body.font-large { font-size: 22px; }

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

<!-- Sidebar -->
<div class="sidebar">
  <h2>SANSARA</h2><br>
    <a href="REGISTRO_DE_USUARIOS.php"><i class="fas fa-user-shield"></i><span>Registrar Usuarios</span></a>
    <a href="MODIFICAR_USUARIOS.php"><i class="fas fa-users"></i><span>Modificar Usuarios</span></a>
  <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a>
  <a href="REPORTESADM.html"><i class="fas fa-chart-line"></i><span>Reportes</span></a>
  <a href="CONFIGURACION.php"><i class="fas fa-cog"></i><span>Configuración</span></a>
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
    <form method="POST" action="../CONTROLADOR/EliminarUsuarios.php" onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?');">
        <input type="hidden" name="id" value="<?= $usuario['id_usuario'] ?>">
        <button type="submit" class="btn-accion">Eliminar</button>
    </form>
      </td>
  </tr>
  <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<script>
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
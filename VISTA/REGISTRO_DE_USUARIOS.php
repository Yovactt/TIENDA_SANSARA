<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>REGISTRO DE USUARIOS</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      display: flex;
      height: 100vh;
      overflow: hidden;
      color: #000;
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

    .content {
      margin-left: 80px;
      padding: 60px;
      transition: margin-left 0.3s ease;
      flex: 1;
      overflow: auto;
      position: relative;
      animation: fadeInSlide 1s ease forwards;
      opacity: 0;
    }

    .sidebar:hover ~ .content {
      margin-left: 260px;
    }

    h2 {
      color: #31393C;
      margin-bottom: 20px;
    }

    .form-container {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
      margin-left: 30px;
      margin-bottom: 30px;
      max-width: 500px;
      animation: fadeInSlide 1s ease forwards;
      opacity: 0;
    }

    @keyframes fadeInSlide {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .button {
      padding: 12px 24px;
      background: linear-gradient(to right, #F79824, #FDCA40);
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      box-shadow: 0 4px 10px #151718;
      transition: all 0.3s ease;
    }

    .button:hover {
      background: linear-gradient(to right, #FDCA40, #F79824);
      transform: translateY(-2px);
      box-shadow: 0 6px 14px #151718;
    }

    .wave {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      z-index: -1;
    }

    .message {
      margin-top: 15px;
      font-weight: bold;
      color: green;
    }

    .error {
      color: red;
    }

    /* Tema oscuro */
    body.dark-theme {
      background-color: #1c1c1c;
      color: #ffffff;
    }

    body.dark-theme .form-container {
      background-color: #2a2a2a;
      color: #ffffff;
      box-shadow: 0 2px 6px #444;
    }

    body.dark-theme input,
    body.dark-theme select {
      background-color: #3a3a3a;
      color: #ffffff;
      border-color: #666;
    }

    body.dark-theme label,
    body.dark-theme h2,
    body.dark-theme .form-container h3 {
      color: #ffffff;
    }

    body.dark-theme .sidebar {
      background: linear-gradient(to right, #0a0a0a, #000033);
    }

    body.dark-theme .sidebar h2,
    body.dark-theme .sidebar a,
    body.dark-theme .sidebar i,
    body.dark-theme .sidebar span {
      color: #ffffff;
    }

    body.dark-theme .button {
      background: linear-gradient(to right, #FFAA00, #FFD700);
      color: #000;
    }

    body.dark-theme .button:hover {
      background: linear-gradient(to right, #FFD700, #FFAA00);
      color: #000;
    }

    body.dark-theme .message {
      color: lightgreen;
    }

    body.dark-theme .error {
      color: #ff6b6b;
    }

    body.font-small { font-size: 10px; }
    body.font-medium { font-size: 16px; }
    body.font-large { font-size: 22px; }

  </style>

  <script>
    function validarNombre(input) {
      input.value = input.value.replace(/[^a-zA-ZÁÉÍÓÚÑáéíóúñ\s]/g, '').toUpperCase();
    }

    function validarCorreo(input) {
      const mensaje = document.getElementById("mensajeCorreo");
      const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (input.value.trim() === "") {
        mensaje.textContent = "";
        return;
      }

      if (!regexCorreo.test(input.value)) {
        mensaje.textContent = "Correo inválido";
        mensaje.classList.add("error");
      } else {
        mensaje.textContent = "";
        mensaje.classList.remove("error");
      }
    }

    function formatearTelefono(input) {
      let mensaje = document.getElementById("mensajeTelefono");
      let valor = input.value.replace(/\D/g, '');

      if (valor.length > 10) {
        valor = valor.slice(0, 10);
      }

      let formateado = '';
      if (valor.length > 0) formateado += valor.substring(0, 3);
      if (valor.length > 3) formateado += ' ' + valor.substring(3, 6);
      if (valor.length > 6) formateado += ' ' + valor.substring(6, 10);

      input.value = formateado;

      if (valor.length < 10) {
        mensaje.textContent = "Teléfono incorrecto";
        mensaje.classList.add("error");
      } else {
        mensaje.textContent = "";
        mensaje.classList.remove("error");
      }
    }

    function formatearDireccion(input) {
      input.value = input.value.toUpperCase();
    }

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
</head>

<body>
  <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#2176FF" fill-opacity="0.2"
      d="M0,192L60,181.3C120,171,240,149,360,154.7C480,160,600,192,720,192C840,192,960,160,1080,154.7C1200,149,1320,171,1380,181.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
  </svg>

  <div class="sidebar">
    <h2>SANSARA</h2><br>
    <a href="REGISTRO_DE_USUARIOS.php"><i class="fas fa-user-shield"></i><span>Registrar Usuarios</span></a>
    <a href="MODIFICAR_USUARIOS.php"><i class="fas fa-users"></i><span>Modificar Usuarios</span></a>
    <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a>
    <a href="REPORTESADM.html"><i class="fas fa-chart-line"></i><span>Reportes</span></a>
    <a href="CONFIGURACION.php"><i class="fas fa-cog"></i><span>Configuración</span></a>
    <a href="CERRAR_SESION.php"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a>
  </div>

  <div class="content">
    <h2><i class="fas fa-users"></i> REGISTRO DE USUARIOS</h2>

    <div class="form-container">
      <h3>Registrar Nuevo Usuario</h3> <br>

      <?php if (isset($_GET['mensaje'])): ?>
        <div class="message <?= $_GET['tipo'] === 'error' ? 'error' : '' ?>">
          <?= htmlspecialchars($_GET['mensaje']) ?>
        </div>
      <?php endif; ?>

      <form class="register-form" action="../CONTROLADOR/RegistroUsuarios.php" method="POST">
        <div class="form-group">
          <label for="nombre">Nombre completo:</label>
          <input type="text" id="nombre" name="nombre" required oninput="validarNombre(this)" />
        </div>

        <div class="form-group">
          <label for="correo">Correo electrónico:</label>
          <input type="email" id="correo" name="correo" required oninput="validarCorreo(this)" />
          <span id="mensajeCorreo" style="font-size: 0.9em; display: block; margin-top: 5px;"></span>
        </div>

        <div class="form-group">
          <label for="telefono">Teléfono:</label>
          <input type="text" id="telefono" name="telefono" maxlength="14" oninput="formatearTelefono(this)" />
          <span id="mensajeTelefono" style="font-size: 0.9em; display: block; margin-top: 5px;"></span>
        </div>

        <div class="form-group">
          <label for="direccion">Dirección:</label>
          <input type="text" id="direccion" name="direccion" oninput="formatearDireccion(this)" />
        </div>

        <div class="form-group">
          <label for="contrasena">Contraseña:</label>
          <input type="password" id="contrasena" name="contrasena" required />
        </div>

        <div class="form-group">
          <label for="confirmar">Confirmar Contraseña:</label>
          <input type="password" id="confirmar" name="confirmar" required />
        </div>

        <div class="form-group">
          <label for="role">Rol:</label>
          <select name="rol" required>
            <option value="gerente">Gerente</option>
            <option value="cajero">Cajero</option>
            <option value="vendedor">Vendedor</option>
          </select>
        </div>

        <button type="submit" class="button">Registrar Usuario</button>
      </form>
    </div>
  </div>
</body>
</html>

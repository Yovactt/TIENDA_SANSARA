<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sansara - Ingreso y Registro</title>
  <link href="https://fonts.googleapis.com/css2?family=Telma&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
  <style>
    /* ESTILOS CSS */
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Open Sans', sans-serif;
      background: linear-gradient(to right, #151718, #03045E);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      position: relative;
      width: 850px;
      height: 550px;
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 30px #151718;
    }

    .form-container {
      position: absolute;
      top: 0;
      height: 100%;
      width: 50%;
      transition: 0.6s ease-in-out;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      padding: 0 30px;
      background-color: #fff;
      z-index: 1;
    }

    .register-form {
      right: 0;
      opacity: 0;
      pointer-events: none;
    }

    .login-form {
      right: 0;
    }

    .container.active .login-form {
      transform: translateX(-100%);
      opacity: 0;
      pointer-events: none;
    }

    .container.active .register-form {
      transform: translateX(-100%);
      opacity: 1;
      pointer-events: auto;
    }

    .toggle-panel {
      position: absolute;
      top: 0;
      left: 0;
      width: 50%;
      height: 100%;
      background: linear-gradient(to right, #2176FF , #00B4D8 , #90EDEF);
      color:  #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      border-radius: 0 150px 150px 0;
      z-index: 2;
      transition: 0.6s ease-in-out;
      text-align: center;
      padding: 0 20px;
    }

    .container.active .toggle-panel {
      transform: translateX(100%);
      border-radius: 150px 0 0 150px;
    }

    h2 {
      margin-bottom: 10px;
      font-family: 'Telma', cursive;
    }

    p {
      font-size: 14px;
      margin-bottom: 15px;
    }

    input {
      margin: 8px 0;
      padding: 12px;
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form-container small {
      font-size: 12px;
      color: #555;
    }

    button {
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

    button:hover {
      background: linear-gradient(to right, #FDCA40 , #F79824);
      transform: translateY(-2px);
      box-shadow: 0 6px 14px #151718;
    }

    .checkbox-group {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 10px;
      font-size: 13px;
    }

    .form-container a {
      font-size: 13px;
      color: #007bff;
      text-decoration: none;
      margin-top: 10px;
    }

    .form-container a:hover {
      text-decoration: underline;
    }

    #mensajeCorreo {
      text-align: left;
      width: 100%;
      color: red;
    }

    .telefono-wrapper {
      width: 100%;
      text-align: left;
    }

    #mensajeTelefono {
      color: red;
      font-size: 0.9em;
      margin-top: 5px;
      display: block;
      text-align: left;
    }

    /* MODAL CSS */
    .modal {
      display: none;
      position: fixed;
      z-index: 99;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.7);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 10% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 300px;
      border-radius: 8px;
      text-align: center;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 24px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover {
      color: #000;
    }
  </style>
</head>
<body>
  <script>
    //VALIDACIONES
    function validarNombre(input) {
      const valor = input.value;
      const soloLetras = /^[A-ZÁÉÍÓÚÑ\s]*$/;
      input.value = valor.toUpperCase();
      const mensaje = document.getElementById('errorNombre');
      mensaje.textContent = !soloLetras.test(input.value) ? 'Nombre incorrecto' : '';
    }

    function validarCorreo(input) {
      const mensaje = document.getElementById("mensajeCorreo");
      const regexCorreo = /^[^\s@]+@(gmail\.com|hotmail\.com|icloud\.com)$/;
      if (input.value.trim() === "") {
        mensaje.textContent = "";
        return;
      }
      mensaje.textContent = !regexCorreo.test(input.value) ? "Correo inválido" : "";
    }

    function formatearTelefono(input) {
      let mensaje = document.getElementById("mensajeTelefono");
      let valor = input.value.replace(/\D/g, '');
      if (valor.length > 10) valor = valor.slice(0, 10);
      let formateado = '';
      if (valor.length > 0) formateado += valor.substring(0, 3);
      if (valor.length > 3) formateado += ' ' + valor.substring(3, 6);
      if (valor.length > 6) formateado += ' ' + valor.substring(6, 10);
      input.value = formateado;
      mensaje.style.display = (valor.length < 10 && valor.length > 0) ? "block" : "none";
      mensaje.textContent = valor.length < 10 ? "Teléfono incorrecto" : "";
    }

    function formatearDireccion(input) {
      input.value = input.value.toUpperCase();
    }

    // MODAL SCRIPT
    function abrirModal() {
      document.getElementById('modalRecuperar').style.display = 'block';
    }

    function cerrarModal() {
      document.getElementById('modalRecuperar').style.display = 'none';
    }

    window.onclick = function(event) {
      const modal = document.getElementById('modalRecuperar');
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>

  <div class="container" id="container">
    <!-- Formulario de Inicio de Sesión -->
    <form class="form-container login-form" action="CONTROLADOR/Login.php" method="POST">
      <h2>BIENVENIDO DE NUEVO</h2>
      <p>INICIA SESIÓN</p>
      <input type="email" name="correo" placeholder="Correo" required />
      <input type="password" name="contrasena" placeholder="Contraseña" required />

      <a href="#" onclick="abrirModal()">¿Olvidaste tu contraseña?</a>
      <button type="submit">Ingresar</button>
    </form>

    <!-- Formulario de Registro -->
    <form class="form-container register-form" action="CONTROLADOR/Registrar.php" method="POST">
      <h2>Crea tu cuenta</h2>
      <p>Únete a la experiencia Sansara</p>
      <input type="text" name="nombre" placeholder="Nombre completo" required oninput="validarNombre(this)" />
      <span id="errorNombre" style="color: red; font-size: 0.8em;"></span>

      <input type="email" id="correo" name="correo" placeholder="Correo" required oninput="validarCorreo(this)" />
      <span id="mensajeCorreo" style="font-size: 0.9em; display: block; margin-top: 5px;"></span>

      <div class="telefono-wrapper">
        <input type="text" id="telefono" name="telefono" placeholder="Teléfono" maxlength="14" oninput="formatearTelefono(this)" />
        <span id="mensajeTelefono" style="display: none;">Teléfono incorrecto</span>
      </div>

      <input type="text" id="direccion" name="direccion" placeholder="Dirección" oninput="formatearDireccion(this)" />
      <span id="mensajeDireccion" style="font-size: 0.9em; display: block; margin-top: 5px;"></span>

      <input type="password" name="contrasena" placeholder="Contraseña" required />
      <input type="password" name="confirmar" placeholder="Confirmar contraseña" required />
      <input type="hidden" name="rol" value="administrador">
      <button type="submit">Registrarse</button>
    </form>

    <!-- Panel deslizante -->
    <div class="toggle-panel" id="togglePanel">
      <h2 id="toggleTitle">¡TIENDA SANSARA!</h2>
      <p id="toggleText">Descubre un nuevo mundo de moda y arte</p>
      <button id="toggleBtn">Registrarse</button>
    </div>
  </div>

  <!-- MODAL DE RECUPERACIÓN -->
  <div id="modalRecuperar" class="modal">
    <div class="modal-content">
      <span class="close" onclick="cerrarModal()">&times;</span>
      <h3>Recuperar contraseña</h3>
      <form action="CONTROLADOR/recuperar.php" method="POST">
        <input type="email" name="correo" placeholder="Ingresa tu correo" required />
        <button type="submit">Enviar enlace</button>
      </form>
    </div>
  </div>

  <script>
    const container = document.getElementById("container");
    const toggleBtn = document.getElementById("toggleBtn");

    toggleBtn.addEventListener("click", () => {
      container.classList.toggle("active");
      toggleBtn.textContent = container.classList.contains("active") ? "Iniciar Sesión" : "Registrarse";
    });
  </script>
</body>
</html>

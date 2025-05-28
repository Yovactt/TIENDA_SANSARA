<!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>REGISTRO DE USUARIOS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="estilos.css">
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

      /* estilos.css */
        .mensaje-error {
          font-size: 12px;
          color:rgb(230, 43, 43);
          margin-top: -10px;
          margin-bottom: 10px;
        }

        .mensaje-exito {
          font-size: 12px;
          color:rgba(12, 82, 51, 0.95);
          margin-top: -10px;
          margin-bottom: 10px;
        }

    /*reposive*/
    /* Celulares (pantallas pequeñas hasta 600px) */
@media (max-width: 600px) {
  body {
    flex-direction: column;
    height: auto;
    overflow: auto;
  }

  .sidebar {
    position: relative;
    width: 100%;
    height: auto;
    flex-direction: row;
    display: flex;
    overflow-x: auto;
    white-space: nowrap;
    padding: 10px 0;
  }

  .sidebar:hover {
    width: 100%;
  }

  .sidebar h2 {
    display: none;
  }

  .sidebar a {
    justify-content: center;
    flex-direction: column;
    padding: 10px;
  }

  .sidebar i {
    font-size: 18px;
  }

  .sidebar span {
    opacity: 1 !important;
    font-size: 12px;
    margin-left: 0;
    margin-top: 5px;
  }

  .content {
    margin-left: 0;
    padding: 20px;
  }

  .form-container {
    margin: 0 auto;
    width: 90%;
    padding: 15px;
  }

  h2 {
    font-size: 18px;
    text-align: center;
  }

  .button {
    width: 100%;
    font-size: 14px;
  }

  .wave {
    display: none;
  }
}

/* Tablets (600px - 1024px) */
@media (min-width: 601px) and (max-width: 1024px) {
  .sidebar {
    width: 80px;
  }

  .sidebar:hover {
    width: 200px;
  }

  .content {
    margin-left: 80px;
    padding: 40px;
  }

  .sidebar:hover ~ .content {
    margin-left: 200px;
  }

  .form-container {
    width: 80%;
    margin: 0 auto;
  }
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
        <a href="REPORTES_ADMIN.php"><i class="fas fa-chart-line"></i><span>Reportes</span></a>
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
            <input type="text" id="nombre" name="nombre" oninput="validarNombre(this)" onkeydown="bloquearNumeros(event)" required />
            <div id="error-nombre" class="mensaje-error" style="display: none;">Solo se permiten letras.</div>
          </div>


          <!-- Campo de correo -->
        <div class="form-group">
          <label for="correo">Correo:</label>
          <input type="email" id="correo" name="correo" required oninput="validarCorreo()">
          <small id="mensajeCorreo" class="mensaje-error"></small>
        </div>

          <!-- CAMPO TELEFONO -->
        <div class="form-group">
          <label for="telefono">Teléfono:</label>
          <input type="text" id="telefono" name="telefono" maxlength="10" required oninput="validarTelefono(this)" onblur="ocultarMensajeTelefono()" />
          <small id="mensaje-telefono" class="mensaje-error"></small>
       </div>


          <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" oninput="formatearDireccion(this)" />
          </div>

       <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="password" id="password" name="password" maxlength="8"  required oninput="validarPassword()"   onblur="ocultarMensajeContra()" />
           <small id="mensajePassword"  class="mensaje-error"></small>
       </div>

        <div class="form-group">
          <label for="confirmPassword">Confirmar Contraseña</label>
          <input type="password" id="confirmPassword" name="confirmPassword" maxlength="8" required oninput="validarConfirmacion()" onblur="ocultarMensajeConfirmacion()"/>
          <small id="mensajeConfirmacion" class="mensaje-error"></small>

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

        
  <script>
  function validarNombre(input) {
    const soloLetras = /^[A-ZÁÉÍÓÚÑ\s]*$/;
    input.value = input.value.toUpperCase().replace(/[^A-ZÁÉÍÓÚÑ\s]/gi, '');
    
    if (!soloLetras.test(input.value)) {
      document.getElementById('error-nombre').style.display = 'block';
    } else {
      document.getElementById('error-nombre').style.display = 'none';
    }
  }

  function bloquearNumeros(e) {
    // Permite solo letras, espacio, tab, retroceso, suprimir, flechas
    const codigo = e.keyCode || e.which;
    if (
      (codigo >= 48 && codigo <= 57) || // números
      (codigo >= 96 && codigo <= 105) || // teclado numérico
      (!e.ctrlKey && !e.metaKey && !e.altKey && codigo >= 33 && codigo <= 40) // navegación
    ) {
      e.preventDefault();
    }
  }
  </script>

  <script>
  function validarCorreo() {
    const correo = document.getElementById('correo').value;
    const mensajeCorreo = document.getElementById('mensajeCorreo');
    const regex = /^[^\s@]+@(gmail\.com|hotmail\.com|icloud\.com)$/;

    if (correo === "") {
      mensajeCorreo.textContent = "";
      mensajeCorreo.className = ""; // también limpiamos la clase
    } else if (!regex.test(correo)) {
      mensajeCorreo.textContent = "Correo inválido. Solo se aceptan gmail.com, hotmail.com e icloud.com";
      mensajeCorreo.className = "mensaje-error";
    } else {
      mensajeCorreo.textContent = "Correo válido";
      mensajeCorreo.className = "mensaje-exito";

      // Opcional: Ocultar mensaje después de unos segundos
      setTimeout(() => {
        mensajeCorreo.textContent = "";
        mensajeCorreo.className = ""; // limpiamos clase también
      }, 2000);
    }
  }
  </script>


<script>
  function validarTelefono(input) {
    let valor = input.value.replace(/\D/g, ''); // solo dígitos
    input.value = valor;

    const mensaje = document.getElementById('mensaje-telefono');

    if (valor.length < 10) {
      mensaje.textContent = "Teléfono inválido. Debe tener 10 dígitos.";
      mensaje.className = "mensaje-error";
    } else if (valor.length === 10) {
      mensaje.textContent = "Teléfono válido.";
      mensaje.className = "mensaje-exito";
    } else {
      mensaje.textContent = "No se permiten más de 10 dígitos.";
      mensaje.className = "mensaje-error";
      input.value = valor.slice(0, 10); // corta si excede
    }
  }

  function ocultarMensajeTelefono() {
    const mensaje = document.getElementById('mensaje-telefono');
    mensaje.textContent = ""; // oculta el mensaje al dejar de seleccionar el campo
  }
</script>

<script>
  function validarPassword() {
    const password = document.getElementById('password').value;
    const mensaje = document.getElementById('mensajePassword');
    const regex = /^[A-Z][A-Za-z0-9!@#$%^&*()\-_=+{}[\]:;"'<>,.?/~`]{0,7}$/;

    if (password.length === 0) {
      mensaje.textContent = '';
    } else if (!regex.test(password)) {
      mensaje.textContent = 'La contraseña debe iniciar con una mayúscula y contener solo 8 caracteres (letras, números o símbolos).';
      mensaje.className = "mensaje-error";
    } else {
      mensaje.textContent = 'Contraseña valida';
       mensaje.className = "mensaje-exito";
    }

    // Limitar a 8 caracteres manualmente por seguridad adicional
    if (password.length > 8) {
      document.getElementById('password').value = password.slice(0, 8);
    }
  }

  function validarConfirmacion() {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirmPassword').value;
    const mensaje = document.getElementById('mensajeConfirmacion');

    if (confirm.length > 8) {
      document.getElementById('confirmPassword').value = confirm.slice(0, 8);
    }

    if (confirm !== password && confirm.length > 0) {
      mensaje.textContent = 'Las contraseñas no coinciden.';
       mensaje.className = "mensaje-error";
    } else {
      mensaje.textContent = 'Las contraseñas coinciden';
       mensaje.className = "mensaje-exito";
    }
  }

  function ocultarMensajeConfirmacion() {
  const mensaje = document.getElementById('mensajeConfirmacion');
  mensaje.textContent = '';
  mensaje.className = "mensaje-error";
}


function ocultarMensajeContra() {
  const mensaje = document.getElementById('mensajePassword');
  mensaje.textContent = '';
  mensaje.className = "mensaje-error"; // Esto mantiene la clase sin afectar estilo
}
</script>

<?php if (isset($_GET['registro']) && $_GET['registro'] === 'exito'): ?>
  <div id="modalRegistro" class="modal-overlay">
    <div class="glass-card">
      <span class="modal-close" onclick="cerrarModalRegistro()">&times;</span>
      <h2 style="text-align:center; color:#FDCA40;">¡Registro Exitoso!</h2>
      <p style="text-align:center;">Usuario registrado correctamente..</p>
            <button class="modal-button" onclick="cerrarModalRegistro()">Cerrar</button>
    </div>
  </div>
  <script>
    function cerrarModalRegistro() {
      const modal = document.getElementById('modalRegistro');
      modal.style.display = 'none';
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  </script>
<?php endif; ?>


 <?php if (isset($_GET['error']) && $_GET['error'] === 'correo_existe'): ?>
  <div id="modalError" class="modal-overlay">
    <div class="glass-card">
      <span class="modal-close" onclick="cerrarModalError()">&times;</span>
      <h2 style="text-align:center; color:#FDCA40;;">¡Error!</h2>
      <p style="text-align:center;">El correo ya está registrado.</p>
      <button class="modal-button" onclick="cerrarModalError()">Cerrar</button>
    </div>
  </div>
  <script>
    function cerrarModalError() {
      const modal = document.getElementById('modalError');
      modal.style.display = 'none';
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  </script>
<?php endif; ?>

</body>
</html>
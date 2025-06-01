<?php
if (isset($_GET['updated']) && $_GET['updated'] == 1) {
    echo "<p style='color:green;'>Tu perfil y contraseña se actualizaron correctamente. Por favor, inicia sesión con tu nueva contraseña.</p>";
}
include_once 'MODELO/Conexion.php';
$conn = conectar();

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'administrador'");
$stmt->execute();
$resultado = $stmt->fetch();
$hayAdmin = $resultado['total'] > 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SANSARA - Login & Registro</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
   /* GLOBAL */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #03045E, #151718);
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  overflow-x: hidden; /* Evitar scroll horizontal */
}

.glass-card {
  backdrop-filter: blur(15px);
  background: rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  border: 1px solid rgba(255, 255, 255, 0.15);
  padding: 50px 40px;
  width: 95%;
  max-width: 450px; /* menor para mejor control */
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
  animation: fadeIn 1s ease;
  box-sizing: border-box;
}

h1 {
  text-align: center;
  margin-bottom: 24px;
  font-size: 28px; /* un poco más grande */
  color: #F79824;
}

input {
  width: 100%;
  padding: 14px 16px;
  margin-bottom: 16px;
  border: none;
  border-radius: 10px;
  background-color: rgba(255, 255, 255, 0.2);
  color: white;
  font-size: 16px;
  transition: background-color 0.3s, outline 0.3s;
}

input::placeholder {
  color: #ccc;
}

input:focus {
  outline: 2px solid #FDCA40;
  background-color: rgba(255, 255, 255, 0.3);
}

button {
  width: 100%;
  padding: 14px;
  border: none;
  border-radius: 12px;
  background: linear-gradient(to right, #F79824, #FDCA40);
  color: #fff;
  font-weight: bold;
  cursor: pointer;
  font-size: 18px;
  margin-top: 12px;
  transition: all 0.3s ease;
}

button:hover {
  transform: scale(1.03);
  box-shadow: 0 6px 18px rgba(0,0,0,0.25);
}

a {
  display: block;
  text-align: center;
  margin-top: 14px;
  font-size: 14px;
  color: #90EDEF;
  text-decoration: none;
  word-wrap: break-word;
}

a:hover {
  text-decoration: underline;
}

#mensajeCorreo, #mensajeTelefono {
  font-size: 13px;
  color: #ff6b6b;
  margin-top: -10px;
  margin-bottom: 12px;
}

/* MODAL */

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

.glass-card.modal {
  max-width: 400px;
  background: rgba(15, 34, 204, 0.1);
  backdrop-filter: blur(10px);
  border-radius: 15px;
  padding: 30px 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
  position: relative;
  color: #fff;
}

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
  padding: 10px 24px;
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

/* Mensajes */
.mensaje-error {
  font-size: 13px;
  color: #ff6b6b;
  margin-top: -10px;
  margin-bottom: 10px;
}

.mensaje-exito {
  font-size: 13px;
  color: rgba(52, 66, 60, 0.95);
  margin-top: -10px;
  margin-bottom: 10px;
}

/* Animación */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Oculto */
.oculto {
  display: none;
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

</style>
</head>
<body>

<div class="glass-card">
  <?php if (!$hayAdmin): ?>
    <div id="pantallaInicial">
      <h1>Bienvenido a SANSARA</h1>
      <p style="text-align:center; margin-bottom: 20px;">Presiona el botón para registrar al primer administrador.</p>
      <button onclick="mostrarFormulario()">Registrar Administrador</button>
    </div>

    <div id="formularioRegistro" class="oculto">
      <h1>Registrar Administrador</h1>
      <form action="CONTROLADOR/RegistrarAdmin.php" method="POST" >
        <input type="text" name="nombre" placeholder="Nombre" required oninput="validarNombre(this)">
        <input type="email" name="correo" placeholder="Correo" required oninput="validarCorreo(this)">
        <div id="mensajeCorreo"></div>
        <input type="text" name="telefono" placeholder="Teléfono" required oninput="formatearTelefono(this)">
        <div id="mensajeTelefono"></div>
        <input type="text" name="direccion" placeholder="Dirección" required oninput="formatearDireccion(this)">
        <input type="password" name="contrasena" placeholder="Contraseña" required  link rel="stylesheet" href="estilos.css">
        <input type="password" name="confirmar_contrasena" placeholder="Confirmar Contraseña" required  link rel="stylesheet" href="estilos.css">
        <input type="hidden" name="rol" value="administrador">
        <button type="submit">Registrarse</button>
      </form>
    </div>

  <?php else: ?>
    <h1>Iniciar Sesión</h1>
    <form action="CONTROLADOR/Login.php" method="POST">
      <input type="email" name="correo" placeholder="Correo" required>
      <input type="password" name="contrasena" placeholder="Contraseña" required>
      <a href="#" onclick="abrirModal()">¿Olvidaste tu contraseña?</a>
      <button type="submit">Entrar</button>
    </form>
  <?php endif; ?>
</div>


<!-- Modal Recuperación -->
<div id="modalRecuperar" class="modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); justify-content:center; align-items:center;">
  <div class="glass-card" style="max-width:360px;">
    <span class="close" style="position:absolute; top:10px; right:20px; font-size:18px; cursor:pointer; color:#fff;" onclick="cerrarModal()">&times;</span>
    <h2 style="text-align:center; color:#FDCA40;">Recuperar Contraseña</h2>
    <form action="CONTROLADOR/RecuperarContrasena.php" method="POST">
      <input type="email" name="correo" placeholder="Ingrese su correo registrado" required>
      <button type="submit" class="modal-button">Recuperar</button>
    </form>
  </div>
</div>


<script>
  function validarNombre(input) {
    const regex = /^[A-ZÁÉÍÓÚÑ\s]*$/;
    input.value = input.value.toUpperCase();
    document.getElementById('errorNombre')?.remove();
    if (!regex.test(input.value)) {
      const error = document.createElement('div');
      error.id = 'errorNombre';
      error.className = 'mensaje-error';
      error.innerText = 'Nombre incorrecto';
      input.parentNode.insertBefore(error, input.nextSibling);
    }
  }

  function validarCorreo(input) {
    const mensaje = document.getElementById("mensajeCorreo");
    const regex = /^[^\s@]+@(gmail\.com|hotmail\.com|icloud\.com)$/;
    mensaje.textContent = !regex.test(input.value) ? "Correo inválido" : "";
  }

  function formatearTelefono(input) {
    const mensaje = document.getElementById("mensajeTelefono");
    let valor = input.value.replace(/\D/g, '');
    valor = valor.slice(0, 10);
    let formateado = valor.match(/.{1,3}/g)?.join(' ') || '';
    input.value = formateado.trim();
    mensaje.style.display = (valor.length < 10 && valor.length > 0) ? "block" : "none";
    mensaje.textContent = valor.length < 10 ? "Teléfono incorrecto" : "";
  }

  function formatearDireccion(input) {
    input.value = input.value.toUpperCase();
  }

  function abrirModal() {
    document.getElementById('modalRecuperar').style.display = 'flex';
  }

  function cerrarModal() {
    document.getElementById('modalRecuperar').style.display = 'none';
  }

  function mostrarFormulario() {
    document.getElementById('pantallaInicial').classList.add('oculto');
    document.getElementById('formularioRegistro').classList.remove('oculto');
  }

  window.onclick = function(event) {
    const modal = document.getElementById('modalRecuperar');
    if (event.target == modal) modal.style.display = "none";
  }


  document.addEventListener("DOMContentLoaded", function () {
    const inputPassword = document.querySelector('input[name="contrasena"]');
    const inputConfirmar = document.querySelector('input[name="confirmar_contrasena"]');

    const mensajePassword = document.createElement("div");
    mensajePassword.classList.add("mensaje-error");
    inputPassword.parentNode.insertBefore(mensajePassword, inputPassword.nextSibling);

    const mensajeConfirmar = document.createElement("div");
    mensajeConfirmar.classList.add("mensaje-error");
    inputConfirmar.parentNode.insertBefore(mensajeConfirmar, inputConfirmar.nextSibling);

    inputPassword.addEventListener("focus", () => {
      validarPassword();
    });

    inputPassword.addEventListener("input", () => {
      // Limitar a 8 caracteres
      inputPassword.value = inputPassword.value.slice(0, 8);
      validarPassword();
    });

   inputConfirmar.addEventListener("input", () => {
    // Limitar a 8 caracteres en confirmar contraseña
    inputConfirmar.value = inputConfirmar.value.slice(0, 8);
    validarCoincidencia();
  });

    function validarPassword() {
      const valor = inputPassword.value;

      let mensajes = [];

      if (valor.length === 0) {
        mensajes.push("Debe iniciar con una letra mayúscula, contener letras, números y caracteres. Máximo 8 caracteres.");
      } else {
        if (!/^[A-Z]/.test(valor)) mensajes.push("Debe iniciar con una letra mayúscula.");
        if (!/^[A-Za-z0-9!@#$%^&*()_+={}[\]:;<>,.?~\\/-]{1,8}$/.test(valor)) mensajes.push("Sólo se permiten letras, números y caracteres especiales.");
        if (valor.length < 8) mensajes.push("Debe tener exactamente 8 caracteres.");
      }

      mensajePassword.textContent = mensajes.join(" ");
      mensajePassword.className = mensajes.length > 0 ? "mensaje-error" : "mensaje-exito";
      if (mensajes.length === 0) mensajePassword.textContent = "Contraseña válida";
    }

    function validarCoincidencia() {
      const pass = inputPassword.value;
      const confirm = inputConfirmar.value;

      if (confirm === "") {
        mensajeConfirmar.textContent = "";
        return;
      }

      if (pass === confirm) {
        mensajeConfirmar.textContent = "Las contraseñas coinciden.";
        mensajeConfirmar.className = "mensaje-exito";
      } else {
        mensajeConfirmar.textContent = "Las contraseñas no coinciden.";
        mensajeConfirmar.className = "mensaje-error";
      }
    }
  });

  
</script>

<?php if (isset($_GET['registro']) && $_GET['registro'] === 'exito'): ?>
  <div id="modalRegistro" class="modal-overlay">
    <div class="glass-card">
      <span class="modal-close" onclick="cerrarModalRegistro()">&times;</span>
      <h2 style="text-align:center; color:#FDCA40;">¡Registro Exitoso!</h2>
      <p style="text-align:center;">El administrador ha sido registrado correctamente. Ahora puedes iniciar sesión.</p>
      <button class="modal-button" onclick="cerrarModalRegistro()">Aceptar</button>
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

<?php if (isset($_GET['recuperacion'])): ?>
  <div class="modal-overlay">
    <div class="glass-card">
      <span class="modal-close" onclick="this.parentElement.parentElement.remove()">×</span>
      <?php if ($_GET['recuperacion'] === 'ok'): ?>
        <h2 style="text-align:center; color:#FDCA40;">¡Correo encontrado!</h2>
        <p style="text-align:center;">Hemos enviado un enlace para restablecer tu contraseña (simulado).</p>
      <?php else: ?>
        <h2 style="text-align:center; color:#ff6b6b;">Correo no encontrado</h2>
        <p style="text-align:center;">El correo que ingresaste no está registrado en el sistema.</p>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>


</body>
</html>
<?php
session_start();
$nombre = $_SESSION['nombre'] ?? '';
$correo = $_SESSION['correo'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Configuración - SANSARA</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <style>
* {margin: 0; padding: 0; box-sizing: border-box;}
html {
  font-size: 100%; /* Base = 16px */
}
body {
  font-family: Arial, sans-serif;
  background-color: #fff;
  color: #31393C;
  display: flex;
  height: 100vh;
  overflow: hidden;
  transition: background-color 0.3s ease, color 0.3s ease, font-size 0.3s ease;
}

/* Tema oscuro */
body.dark-theme {
  background-color: #1c1c1c;
  color: #ffffff;
}
body.dark-theme input,
body.dark-theme select {
  background-color: #2a2a2a;
  color: #ffffff;
  border-color: #444;
}
body.dark-theme label {
  color: #ffffff;
}
body.dark-theme .tab-btn {
  color: #ffffff;
}

/* Tamaño de fuente */
body.font-small { font-size: 12px; }
body.font-medium { font-size: 16px; }
body.font-large { font-size: 20px; }

.sidebar {
  width: 60px;
  background: linear-gradient(to right, #151718, #03045E);
  transition: width 0.3s ease;
  overflow: hidden;
  position: fixed;
  height: 100%;
  padding-top: 20px;
  z-index: 10;
}
.sidebar:hover {width: 260px;}
.sidebar h2 {
  color: white; 
  text-align: center; 
  margin-bottom: 30px;
  opacity: 0; 
  transition: opacity 0.3s ease;
  font-weight: 700;
  letter-spacing: 3px;
}
.sidebar:hover h2 {opacity: 1;}
.sidebar a {
  display: flex; 
  align-items: center;
  color: white; 
  padding: 12px 20px;
  text-decoration: none;
  transition: background 0.3s ease, color 0.3s ease;
  position: relative;
  white-space: nowrap;
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
  opacity: 0;
  transition: opacity 0.3s ease;
  font-size: 1em; /* Escala con el body */
}
.sidebar:hover span {
  opacity: 1;
}

.content {
  margin-left: 60px;
  padding: 40px 40px 80px;
  transition: margin-left 0.3s ease;
  flex: 1;
  overflow-y: auto;
  position: relative;
}
.sidebar:hover ~ .content {margin-left: 260px;}
h2 { margin-bottom: 10px; font-weight: 700;}

.tabs {
  display: flex;
  gap: 10px;
  margin-bottom: 30px;
  flex-wrap: wrap;
}
.tab-btn {
  padding: 10px 20px;
  background: linear-gradient(to right, #F79824, #FDCA40);
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 700;
  box-shadow: 0 2px 4px #15171888;
  transition: all 0.3s ease;
  user-select: none;
}
.tab-btn:hover {
  background: linear-gradient(to right, #FDCA40, #F79824);
  transform: translateY(-1px);
}
.tab-btn.active {
  background: linear-gradient(to right, #FDCA40, #F79824);
  box-shadow: 0 2px 6px #151718aa;
}

.config-section {
  display: none;
  animation: fadeInSlide 0.5s ease forwards;
}
.config-section.active {display: block;}

@keyframes fadeInSlide {
  from {opacity: 0; transform: translateY(20px);}
  to {opacity: 1; transform: translateY(0);}
}

label {
  display: block;
  margin: 10px 0 5px;
  font-weight: 700;
}
input, select {
  padding: 10px;
  width: 100%;
  max-width: 400px;
  border: 1px solid #ccc;
  border-radius: 8px;
  margin-bottom: 15px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  font-size: 1em;
  font-weight: 500;
}
input[type="checkbox"] {width: auto;}

.button-group {
  margin-top: 20px;
  text-align: left;
}
button.save-btn {
  padding: 12px 24px;
  background: linear-gradient(to right, #F79824, #FDCA40);
  color: #fff;
  font-weight: 700;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  box-shadow: 0 4px 10px #151718;
  transition: all 0.3s ease;
  user-select: none;
}
button.save-btn:hover {
  background: linear-gradient(to right, #FDCA40, #F79824);
  transform: translateY(-2px);
  box-shadow: 0 6px 14px #151718;
}

.wave {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 140px;
  z-index: -1;
}

  </style>
</head>
<body>
  <div class="sidebar">
    <h2>SANSARA</h2><br>
    <a href="REGISTRO_DE_USUARIOS.php"><i class="fas fa-user-shield"></i><span>Registrar Usuarios</span></a>
    <a href="MODIFICAR_USUARIOS.php"><i class="fas fa-users"></i><span>Modificar Usuarios</span></a>
    <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a>
    <a href="REPORTESADM.html"><i class="fas fa-chart-line"></i><span>Reportes</span></a>
    <a href="CONFIGURACION.php" class="active"><i class="fas fa-cog"></i><span>Configuración</span></a>
    <a href="CERRAR_SESION.php"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a>
  </div>

  <div class="content">
    <h2>Configuración del Sistema</h2>
    <div class="tabs">
      <button class="tab-btn active" onclick="showTab(event, 'perfil')">Perfil</button>
      <button class="tab-btn" onclick="showTab(event, 'apariencia')">Apariencia</button>
    </div>

    <div id="perfil" class="config-section active">
      <label>Nombre</label>
      <input type="text" placeholder="Nombre de usuario" value="<?php echo htmlspecialchars($nombre); ?>" />

      <label>Correo electrónico</label>
      <input type="email" placeholder="correo@ejemplo.com" value="<?php echo htmlspecialchars($correo); ?>" />
    </div>

    <div id="apariencia" class="config-section">
      <label>Tema</label>
      <select id="theme-selector">
        <option value="light">Claro</option>
        <option value="dark">Oscuro</option>
      </select>
      <label>Tamaño de fuente</label>
      <select id="font-size-selector">
        <option value="small">Pequeño</option>
        <option value="medium" selected>Mediano</option>
        <option value="large">Grande</option>
      </select>
    </div>

    <div class="button-group">
      <button class="save-btn">Guardar Cambios</button>
    </div>

    <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
      <path fill="#2176FF" fill-opacity="0.2"
        d="M0,192L60,181.3C120,171,240,149,360,154.7C480,160,600,192,720,192C840,192,960,160,1080,154.7C1200,149,1320,171,1380,181.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z">
      </path>
    </svg>
  </div>

  <script>
    function showTab(event, id) {
      document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.config-section').forEach(sec => sec.classList.remove('active'));
      document.getElementById(id).classList.add('active');
      event.currentTarget.classList.add('active');
    }

    function aplicarConfiguracion() {
    const tema = document.getElementById('theme-selector').value;
    const fuente = document.getElementById('font-size-selector').value;

    // Guardar preferencias en localStorage
    localStorage.setItem('tema', tema);
    localStorage.setItem('fuente', fuente);

    aplicarPreferencias();
  }

  function aplicarPreferencias() {
    const tema = localStorage.getItem('tema') || 'light';
    const fuente = localStorage.getItem('fuente') || 'medium';

    document.body.classList.remove('dark-theme', 'font-small', 'font-medium', 'font-large');

    if (tema === 'dark') {
      document.body.classList.add('dark-theme');
    }

    document.body.classList.add(`font-${fuente}`);

    // Actualiza los selectores
    document.getElementById('theme-selector').value = tema;
    document.getElementById('font-size-selector').value = fuente;
  }

  document.querySelector('.save-btn').addEventListener('click', aplicarConfiguracion);
  window.addEventListener('DOMContentLoaded', aplicarPreferencias);
  </script>
  
</body>
</html>

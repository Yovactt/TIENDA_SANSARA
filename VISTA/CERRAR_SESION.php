<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cerrar Sesión - SANSARA</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #03045E, #023E8A);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
    }
    .logout-container {
      background: white;
      color: #151718;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      text-align: center;
      max-width: 400px;
      width: 100%;
    }
    .logout-container h2 {
      margin-bottom: 20px;
      color: #03045E;
    }
    .logout-container p {
      margin-bottom: 30px;
      font-size: 16px;
    }
    .button-group {
      display: flex;
      justify-content: center;
      gap: 20px;
    }
    .btn {
      padding: 12px 24px;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .btn.confirm {
      background: linear-gradient(to right, #F79824, #FDCA40);
      color: white;
    }
    .btn.confirm:hover {
      background: linear-gradient(to right, #FDCA40, #F79824);
    }
    .btn.cancel {
      background: #ccc;
      color: #151718;
    }
    .btn.cancel:hover {
      background: #bbb;
    }
    .logout-icon {
      font-size: 60px;
      margin-bottom: 20px;
      color: #F79824;
    }
  </style>
</head>
<body>
  <div class="logout-container">
    <i class="fas fa-sign-out-alt logout-icon"></i>
    <h2>¿Cerrar sesión?</h2>
    <p>¿Estás seguro de que deseas cerrar sesión de tu cuenta?</p>
    <div class="button-group">
    <a class="btn confirm" href="../CONTROLADOR/CerrarSesion.php">Sí, cerrar</a>
      <a class="btn cancel">Cancelar</a>
    </div>
  </div>

  <script>
    function logout() {
      // Aquí puedes limpiar sesión o redirigir
      window.location.href = "../INDEX.php"; // Cambia esto si tu login está en otra URL
    }
  </script>
</body>
</html>
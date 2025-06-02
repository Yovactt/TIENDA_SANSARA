<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>REGISTRAR VENTAS</title>
  <!-- Enlazamos la librería Font Awesome para poder usar íconos en el menú -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

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
      position: relative;
      overflow-x: hidden;
      height: 100%;
      margin: 0;
      padding: 0;
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

    .content {
      margin-left: 80px;
      padding: 60px;
      transition: margin-left 0.3s ease;
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

    .sidebar:hover ~ .content {
      margin-left: 260px;
    }

    h2 {
      margin-bottom: 20px;
      color: #31393C;
    }

    .formulario {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
      margin-bottom: 30px;
    }

    .formulario label {
      display: block;
      margin-top: 10px;
    }

    .formulario input {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      width: 100%;
      margin-bottom: 10px;
    }

    .formulario button,
    .formulario-button {
      padding: 12px 24px;
      background: linear-gradient(to right, #F79824, #FDCA40);
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      box-shadow: 0 4px 10px #151718;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .formulario button:hover,
    .formulario-button:hover {
      background: linear-gradient(to right, #FDCA40, #F79824);
      transform: translateY(-2px);
      box-shadow: 0 6px 14px #151718;
    }

    .tabla-container {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
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
      padding: 10px;
      text-align: left;
    }

    th {
      background: linear-gradient(to bottom, #31393C, #2176FF);
      color: white;
    }

    .total {
      margin-top: 20px;
      font-size: 18px;
      font-weight: bold;
    }

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

    .rol {
      color: #fff;
      text-align: center;
      font-size: 12px;
      margin-bottom: 0px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .sidebar:hover .rol {
      opacity: 1;
    }

    .sidebar h3.subtitulo {
      color: #fff;
      font-weight: normal;
      text-align: center;
      font-size: 12px;
      margin-top: -30px;
      margin-bottom: 30px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .sidebar:hover h3.subtitulo {
      opacity: 1;
    }
</style>
</head>

<body>

  <!-- Onda decorativa al final de la página -->
  <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#2176FF" fill-opacity="0.2"
      d="M0,192L60,181.3C120,171,240,149,360,154.7C480,160,600,192,720,192C840,192,960,160,1080,154.7C1200,149,1320,171,1380,181.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z">
    </path>
  </svg>

  <!-- Menú lateral izquierdo -->
  <div class="sidebar">
    <h2>SANSARA</h2>
    <h3 class="subtitulo">Cajero</h3>
    <a href="REGISTRAR_VENTAS.php"><i class="fas fa-cash-register"></i><span>Registrar Venta</span></a>
    <a href="PROCESAR_PAGO.php"><i class="fas fa-credit-card"></i><span>Procesar Pago</span></a>
    <a href="DEVOLUCIONES.php"><i class="fas fa-undo-alt"></i><span>Devoluciones</span></a>
    <a href="CONSULTAR_STOCK_CAJERO.php"><i class="fas fa-boxes"></i><span>Consultar Stock</span></a>
    <a href="CERRAR_SESION.php"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a>
  </div>

  <!-- Contenido principal de la página -->
  <div class="content">
    <h2><i class="fas fa-cash-register"></i> REGISTRO DE VENTAS</h2>
    <!-- Formulario para ingresar productos -->
    <div class="formulario">
      <label for="producto">Código Producto:</label>
      <input type="text" id="producto" placeholder="Código del producto" onkeypress="if(event.key === 'Enter'){ buscarProducto(); return false; }">

      <label for="modelo">Modelo:</label>
      <input type="text" id="modelo" readonly>

      <label for="precio">Precio:</label>
      <input type="number" id="precio" min="0" step="0.01" value="0">

      <label for="cantidad">Cantidad:</label>
      <input type="number" id="cantidad" min="1" value="1" oninput="calcularPrecioTotal()">

      <button onclick="agregarProducto()">Agregar</button>
    </div>

    <!-- Tabla con los productos agregados -->
    <div class="tabla-container">
      <table>
        <thead>
          <tr>
            <th>Código</th>
            <th>Modelo</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody id="tablaVentas"></tbody>
      </table>
      <!-- Muestra el total final -->
      <div class="total">
        Total a Pagar: $<span id="total">0.00</span>
      </div>
      <button class="formulario-button" onclick="procesarVenta()">Finalizar Venta</button>
    </div>
  </div>

<script>
  let totalVenta = 0;

  function agregarProducto() {
    let codigo = document.getElementById("producto").value.trim();
    let modelo = document.getElementById("modelo").value.trim();
    let cantidad = parseInt(document.getElementById("cantidad").value);
    let precioUnitario = parseFloat(document.getElementById("precio").value);
    let total = cantidad * precioUnitario;
    totalVenta += total;

    let tabla = document.getElementById("tablaVentas");
    let fila = tabla.insertRow();
    fila.innerHTML = `
      <td>${codigo}</td>
      <td>${modelo}</td>
      <td>${cantidad}</td>
      <td>$${precioUnitario.toFixed(2)}</td>
      <td>$${total.toFixed(2)}</td>
    `;

    document.getElementById("total").textContent = totalVenta.toFixed(2);

    document.getElementById("producto").value = "";
    document.getElementById("modelo").value = "";
    document.getElementById("cantidad").value = "1";
    document.getElementById("precio").value = "0";
    document.getElementById("producto").focus();
  }

  function eliminarProducto(btn, total) {
    let fila = btn.parentNode.parentNode;
    fila.parentNode.removeChild(fila);
    totalVenta -= total;
    document.getElementById("total").textContent = totalVenta.toFixed(2);
  }

  async function buscarProducto() {
    const codigo = document.getElementById('producto').value.trim();
    if (!codigo) return;

    try {
      const response = await fetch(`../CONTROLADOR/BuscarProducto.php?codigo=${encodeURIComponent(codigo)}`);
      const data = await response.json();

      if (data.error) {
        document.getElementById('modelo').value = '';
        document.getElementById('precio').value = 0;
      } else {
        document.getElementById('modelo').value = data.modelo;
        document.getElementById('precio').value = parseFloat(data.precio);
      }
    } catch (error) {
      // Error silenciado
    }
  }

  function calcularPrecioTotal() {
    let cantidad = parseInt(document.getElementById('cantidad').value);
    let precioUnitario = parseFloat(document.getElementById('precio').value);
    if (isNaN(cantidad) || cantidad < 1) cantidad = 1;
    if (isNaN(precioUnitario)) precioUnitario = 0;
    document.getElementById('precio').value = precioUnitario.toFixed(2);
  }

  function procesarVenta() {
    const boton = document.querySelector(".formulario-button");
    boton.disabled = true;

    const filas = document.querySelectorAll("#tablaVentas tr");
    const productos = [];
    filas.forEach(fila => {
      const celdas = fila.querySelectorAll("td");
      const producto = {
        producto: celdas[0].textContent,
        modelo: celdas[1].textContent,
        cantidad: parseInt(celdas[2].textContent),
        precio_unitario: parseFloat(celdas[3].textContent.replace('$', '')),
        total: parseFloat(celdas[4].textContent.replace('$', ''))
      };
      productos.push(producto);
    });

    const ventaData = {
      productos: productos,
      total: totalVenta
    };

    fetch("../CONTROLADOR/GuardarVenta.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(ventaData)
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          window.location.href = "PROCESAR_PAGO.php?id_venta=" + data.id_venta;
        } else {
          // Error silenciado
          boton.disabled = false;
        }
      })
      .catch(() => {
        // Error silenciado
        boton.disabled = false;
      });
  }
</script>


</body>


</html>
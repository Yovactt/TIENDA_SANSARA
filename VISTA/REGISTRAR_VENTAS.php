<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>REGISTRAR VENTAS</title>
  <!-- Enlazamos la librería Font Awesome para poder usar íconos en el menú -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

  <style>
    /* Reset general para quitar márgenes y configurar el modelo de caja */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Estilo general del cuerpo de la página */
    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Estilo del menú lateral */
    .sidebar {
      width: 60px; /* Ancho reducido por defecto */
      background: linear-gradient(to right, #151718, #03045E); /* Fondo con degradado */
      transition: width 0.3s ease; /* Transición suave al expandirse */
      overflow: hidden;
      position: fixed;
      height: 100%; 
      padding-top: 20px;
    }

    /* Cuando el mouse pasa sobre el menu, se expande */
    .sidebar:hover {
      width: 260px;
    }

    /* Título dentro del menu */
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

    /* Enlaces dentro del sidebar */
    .sidebar a {
      position: relative;
      display: flex;
      align-items: center;
      color: #fff;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.3s ease, color 0.3s ease;
    }

    /* Línea decorativa a la izquierda del enlace, visible al hacer hover */
    .sidebar a::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 4px;
      background: #F79824;
      border-radius: 0 4px 4px 0;
      transform: scaleY(0); /* Oculto inicialmente */
      transform-origin: top;
      transition: transform 0.3s ease;
    }

    /* Estilo del enlace al pasar el mouse o cuando está activo */
    .sidebar a:hover,
    .sidebar a.active {
      background: linear-gradient(90deg, rgba(253,202,64,0.2) 0%, #FDCA40 100%);
      color: #151718;
    }

    .sidebar a:hover::before,
    .sidebar a.active::before {
      transform: scaleY(1); 
    }

    /* Estilo de los íconos en el menú */
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

    /* Texto al lado de los íconos: oculto por defecto */
    .sidebar span {
      margin-left: 15px;
      white-space: nowrap;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    /* Al pasar el mouse, se muestra el texto */
    .sidebar:hover span {
      opacity: 1;
    }

    /* Contenedor principal del contenido (fuera del menú) */
    .content {
      margin-left: 80px; 
      padding: 60px;
      transition: margin-left 0.3s ease;

      /* Animación al cargar */
      animation: fadeInSlide 1s ease forwards;
      opacity: 0;
    }

    /* Animación de entrada del contenido */
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

    /* Si el sidebar está expandido, el contenido se desplaza */
    .sidebar:hover ~ .content {
      margin-left: 260px;
    }

    /* Título de secciones */
    h2 {
      margin-bottom: 20px;
      color: #31393C;
    }

    /* Estilo del formulario de registro de ventas */
    .formulario {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
      margin-bottom: 30px;
    }

    /* Estilo de etiquetas del formulario */
    .formulario label {
      display: block;
      margin-top: 10px;
    }

    /* Campos de entrada */
    .formulario input {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      width: 100%;
      margin-bottom: 10px;
    }

    /* Botones del formulario */
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

    /* Efecto hover para los botones */
    .formulario button:hover,
    .formulario-button:hover {
      background: linear-gradient(to right, #FDCA40, #F79824);
      transform: translateY(-2px);
      box-shadow: 0 6px 14px #151718;
    }

    /* Contenedor de la tabla */
    .tabla-container {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
    }

    /* Tabla de productos */
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

    /* Ola decorativa inferior */
    .wave {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      z-index: -1;
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
    <h2>SANSARA</h2><br>
    <a href="REGISTRAR_VENTAS.php"><i class="fas fa-cash-register"></i><span>Registrar Venta</span></a>
    <a href="PROCESAR_PAGO.php"><i class="fas fa-credit-card"></i><span>Procesar Pago</span></a>
    <a href="DEVOLUCIONES.php"><i class="fas fa-undo-alt"></i><span>Devoluciones</span></a>
    <a href="CONSULTAR_STOCK.php"><i class="fas fa-boxes"></i><span>Consultar Stock</span></a>
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

  <!-- Script para controlar el formulario y tabla -->
  <script>
    let totalVenta = 0;

    // Agrega un producto a la tabla
function agregarProducto() {
  let codigo = document.getElementById("producto").value.trim();
  let modelo = document.getElementById("modelo").value.trim();
  let cantidad = parseInt(document.getElementById("cantidad").value);
  let precioUnitario = parseFloat(document.getElementById("precio").value);

  if (!codigo || !modelo || cantidad <= 0 || precioUnitario <= 0) {
    alert("Ingrese valores válidos y busque un producto primero");
    return;
  }

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

  // Limpia los campos para ingresar nuevo producto
  document.getElementById("producto").value = "";
  document.getElementById("modelo").value = "";
  document.getElementById("cantidad").value = "1";
  document.getElementById("precio").value = "0";

  document.getElementById("producto").focus();
}


    // Elimina una fila de la tabla y resta su total
    function eliminarProducto(btn, total) {
      let fila = btn.parentNode.parentNode;
      fila.parentNode.removeChild(fila);
      totalVenta -= total;
      document.getElementById("total").textContent = totalVenta.toFixed(2);
    }

    // Finaliza la venta, muestra total y reinicia todo
function procesarVenta() {
    const boton = document.querySelector(".formulario-button");
  boton.disabled = true; // ✅ Deshabilita el botón para prevenir clics dobles
  const filas = document.querySelectorAll("#tablaVentas tr");
  if (filas.length === 0) {
    alert("No hay productos en la venta.");
     boton.disabled = false; // Rehabilita si hay error
    return;
  }

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
      alert("Venta registrada exitosamente. ID Venta: " + data.id_venta);
   window.location.href = "PROCESAR_PAGO.php?id_venta=" + data.id_venta;
    } else {
      alert("Error al guardar venta: " + data.error);
    }
  })
  .catch(error => {
    alert("Error de conexión: " + error.message);
  });
}


    // Buscar producto cuando presionas Enter en el input 'producto'
function buscarProducto() {
  const codigo = document.getElementById('producto').value.trim();

  if (!codigo) {
    alert('Ingrese un código de producto');
    return;
  }

  fetch(`../CONTROLADOR/BuscarProducto.php?codigo=${encodeURIComponent(codigo)}`)
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        alert(data.error);
        document.getElementById('modelo').value = '';
        document.getElementById('precio').value = 0;
      } else {
        document.getElementById('modelo').value = data.modelo;
        document.getElementById('precio').value = parseFloat(data.precio);
      }
    })
    .catch(error => {
      alert('Error al buscar producto: ' + error);
    });
}


// Actualiza el precio total en base a cantidad y precio unitario
function calcularPrecioTotal() {
  let cantidad = parseInt(document.getElementById('cantidad').value);
  let precioUnitario = parseFloat(document.getElementById('precio').value);
  if (isNaN(cantidad) || cantidad < 1) cantidad = 1;
  if (isNaN(precioUnitario)) precioUnitario = 0;

  // Actualiza el precio total (pero en el input de precio solo queda unitario, 
  // el total se calcula cuando agregas el producto a la tabla)
  // Aquí actualizaremos el precio unitario por si quieres que el usuario no pueda modificarlo
  document.getElementById('precio').value = precioUnitario.toFixed(2);
}

  </script>


 
</body>
</html>

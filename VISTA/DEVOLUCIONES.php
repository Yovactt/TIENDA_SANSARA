<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> DEVOLUCIONES </title>
  <!-- Importación de los iconos de Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  
  <style>
    /* Reglas de estilo generales */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color:  #fff              ;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }


    /*Es un menú lateral colapsado de 60px, que se expande con hover.
    Fondo con degradado azul/negro.
    Fijo al lado izquierdo */
    .sidebar {
      width: 60px;
      background: linear-gradient(to right, #151718,  #03045E);
      transition: width 0.3s ease;
      overflow: hidden;
      position: fixed;
      height: 100%;
      padding-top: 20px;
    }


    /*Cuando pasas el mouse por encima, el menú se expande animadamente.*/
    .sidebar:hover {
      width: 260px;
    }

    /* titulo y animacion
    El título se oculta cuando el menú está colapsado.
    Se aparece con opacidad cuando haces hover*/
    .sidebar h2 {
      color: #fff;
      text-align: center;
      margin-bottom: 30px;
      /*animacion */
      opacity: 0; 
      transition: opacity 0.3s ease;
    }

    .sidebar:hover h2 {
      opacity: 1;
    }

    /*Muestra los íconos con texto alineado
    Tiene transición suave de color y fondo*/
    .sidebar a {
      display: flex;
      align-items: center;
      color: #fff;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.3s;
    }

 /* Base de los links para posicionar el indicador */
    .sidebar a {
    position: relative;
    display: flex;
    align-items: center;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    transition: background 0.3s ease, color 0.3s ease;
    }

    /* Aparece una barra dorada al lado izquierdo al pasar el mouse.
    Se anima desde arriba hacia abajo (efecto "despliegue"). */
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

    /* Barra de seleccion */
    .sidebar a:hover,
    .sidebar a.active {
    background: linear-gradient(90deg, rgba(253,202,64,0.2) 0%, #FDCA40  100%);
    color: #151718;
    }

 /* Al activar hover/activo, desplegar la barra lateral */
    .sidebar a:hover::before,
    .sidebar a.active::before {
    transform: scaleY(1);
    }

    /* Iconos: cambian de color al hover/activo */
    .sidebar i {
    min-width: 30px;
    text-align: center;
    font-size: 18px;
    transition: color 0.3s ease;
    }

  /*color de los iconos al ser selccionado */
    .sidebar a:hover i,
    .sidebar a.active i {
    color: #151718;
    }

   /*El texto del menú solo aparece al hacer hover (cuando se expande).*/
   .sidebar span {
      margin-left: 15px;
      white-space: nowrap;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .sidebar:hover span {
      opacity: 1;
    }

     /*Al hacer hover en el menú, el contenido se mueve suavemente hacia la derecha 
    para dejar espacio al menú expandido.*/
    .content {
      margin-left: 80px;
      padding: 60px;
      transition: margin-left 0.3s ease;
      flex: 1;
      position: relative;
      overflow: hidden;
    }

    .sidebar:hover ~ .content {
      margin-left: 260px;
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


    /* Estilo de los encabezados dentro del contenido */
    h2 {
      color: #31393C;
      margin-bottom: 10px;
      text-align: left;
    }

    /* Estilo para la sección de formularios */
    .main-section {
      display: flex;
      gap: 70px;
      flex-wrap: wrap;
      align-items: flex-start;
    }

    /* Estilo del formulario */
    .formulario {
      background: #fff;
      padding: 15px 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
      max-width: 400px;
      width: 100%;
    }

    .formulario label {
      display: block;
      margin-top: 6px;
      font-size: 14px;
    }

    .formulario input,
    .formulario select,
    .formulario textarea {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
      width: 100%;
      font-size: 14px;
      margin-bottom: 8px;
    }

    /* Estilo del botón */
    .formulario button {
      padding: 10px 20px;
      background: linear-gradient(to right, #F79824, #FDCA40);
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      box-shadow: 0 4px 10px #151718;
      transition: all 0.3s ease;
      font-size: 14px;
      margin-top: 6px;
    }

    /* Efecto del botón al pasar el mouse */
    .formulario button:hover {
      background: linear-gradient(to right, #FDCA40, #F79824);
      transform: translateY(-2px);
      box-shadow: 0 6px 14px #151718;
    }

    /* Estilo para la tabla que muestra las devoluciones */
    .tabla-container {
      background: #fff;
      padding: 15px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
      max-width: 600px;
      width: 100%;
    }

    .tabla-container h3 {
      text-align: left;
      font-size: 18px;
      margin-bottom: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }

    table, th, td {
      border: 1px solid #ccc;
    }

    th, td {
      padding: 8px;
      text-align: left;
    }

    th {
      background: linear-gradient(to bottom, #31393C, #2176FF);
      color: white;
    }

    /* SVG para la ola en la parte inferior */
    .wave {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      z-index: -1;
    }
  </style>
</head>
<body>
 
    <div class="sidebar">
        <h2>SANSARA</h2><br>
    <a href="REGISTRAR_VENTAS.php"><i class="fas fa-cash-register"></i><span>Registrar Venta</span></a>
    <a href="PROCESAR_PAGO.php"><i class="fas fa-credit-card"></i><span>Procesar Pago</span></a>
    <a href="DEVOLUCIONES.php"><i class="fas fa-undo-alt"></i><span>Devoluciones</span></a>
    <a href="CONSULTAR_STOCK.php"><i class="fas fa-boxes"></i><span>Consultar Stock</span></a>
    <a href="CERRAR_SESION.php"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a>
      </div>

  <!-- Contenido principal -->
  <div class="content">
    <h2><i class="fas fa-undo-alt"></i> GESTIÓN DE DEVOLUCIONES</h2>
    
    <div class="main-section">
      <!-- Formulario para registrar una devolución -->
      <div class="formulario">
        <label for="etiqueta">Etiqueta:</label>
        <input type="text" id="etiqueta" placeholder="Ingrese la etiqueta del producto">

        <label for="producto">Producto:</label>
        <input type="text" id="producto" placeholder="Nombre del producto">

        <label for="talla">Talla:</label>
        <input type="text" id="talla" readonly>

        <label for="color">Color:</label>
        <input type="text" id="color" readonly>

        <label for="precio">Precio:</label>
        <input type="text" id="precio" readonly>

        <label for="cantidad">Cantidad a devolver:</label>
        <input type="number" id="cantidad" min="1">

        <label for="motivo">Motivo de la Devolución:</label>
        <select id="motivo">
          <option value="defectuoso">Producto Defectuoso</option>
          <option value="equivocado">Producto Equivocado</option>
          <option value="otro">Otro</option>
        </select>


        <button onclick="registrarDevolucion()">Registrar Devolución</button>
      </div>

      <!-- Tabla de devoluciones -->
      <div class="tabla-container">
        <h3>Historial de Devoluciones</h3>
        <table>
         <thead>
  <tr>
    <th>Etiqueta</th>
    <th>Producto</th>
    <th>Talla</th>
    <th>Color</th>
    <th>Precio</th>
    <th>Cantidad</th>
    <th>Motivo</th>
  </tr>
</thead>

          <tbody id="tablaDevoluciones"></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- SVG para la ola -->
  <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#2176FF" fill-opacity="0.2"
      d="M0,192L60,181.3C120,171,240,149,360,154.7C480,160,600,192,720,192C840,192,960,160,1080,154.7C1200,149,1320,171,1380,181.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z">
    </path>
  </svg>

  <!-- Script para manejar el registro de devoluciones -->
  <script>
 function registrarDevolucion() {
      const etiqueta = document.getElementById('etiqueta').value.trim();
      const producto = document.getElementById('producto').value.trim();
      const talla = document.getElementById('talla').value.trim();
      const color = document.getElementById('color').value.trim();
      const precio = document.getElementById('precio').value.trim();
      const cantidad = document.getElementById('cantidad').value.trim();
      const motivo = document.getElementById('motivo').value;

      if (!etiqueta || !producto || !cantidad) {
        alert("Por favor completa los campos obligatorios.");
        return;
      }

      const tabla = document.getElementById('tablaDevoluciones');
      const fila = document.createElement('tr');

      fila.innerHTML = `
        <td>${etiqueta}</td>
        <td>${producto}</td>
        <td>${talla}</td>
        <td>${color}</td>
        <td>${precio}</td>
        <td>${cantidad}</td>
        <td>${motivo}</td>
      `;

      tabla.appendChild(fila);

      // Limpiar formulario
      document.getElementById('etiqueta').value = '';
      document.getElementById('producto').value = '';
      document.getElementById('talla').value = '';
      document.getElementById('color').value = '';
      document.getElementById('precio').value = '';
      document.getElementById('cantidad').value = '';
      document.getElementById('motivo').value = 'defectuoso';
    }
    
document.getElementById("etiqueta").addEventListener("keypress", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();  // Previene el envío del formulario

        const etiqueta = this.value.trim();
        console.log("Buscando etiqueta:", etiqueta);  // 🔍 DEBUG

        fetch(`../CONTROLADOR/Devoluciones.php?etiqueta=${encodeURIComponent(etiqueta)}`)

            .then(response => response.json())
            .then(data => {
                console.log("Respuesta del servidor:", data);  // 🔍 DEBUG

                if (data.success) {
                    document.getElementById("producto").value = data.producto.modelo;
                    document.getElementById("talla").value = data.producto.talla;
                    document.getElementById("color").value = data.producto.color;
                    document.getElementById("precio").value = data.producto.precio;
                } else {
                    alert(data.mensaje || "Producto no encontrado.");
                }
            })
            .catch(error => {
                console.error("Error en la petición:", error);
                alert("Error al conectar con el servidor.");
            });
    }
});

function guardarDevoluciones() {
    const filas = document.querySelectorAll('#tablaDevoluciones tr');
    const datos = [];

    filas.forEach(fila => {
        const celdas = fila.querySelectorAll('td');
        if (celdas.length === 7) {
            datos.push({
                etiqueta: celdas[0].textContent,
                producto: celdas[1].textContent,
                talla:    celdas[2].textContent,
                color:    celdas[3].textContent,
                precio:   parseFloat(celdas[4].textContent),
                cantidad: parseInt(celdas[5].textContent),
                motivo:   celdas[6].textContent
            });
        }
    });

    if (datos.length === 0) {
        alert("No hay devoluciones para guardar.");
        return;
    }

    fetch('../CONTROLADOR/GuardarDevolucion.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(respuesta => {
        if (respuesta.success) {
            alert("Devoluciones guardadas exitosamente.");
            document.getElementById('tablaDevoluciones').innerHTML = '';
        } else {
            alert("Error al guardar: " + (respuesta.error || "Desconocido"));
        }
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
        alert("Error al conectar con el servidor.");
    });
}


</script>


</body>
</html>

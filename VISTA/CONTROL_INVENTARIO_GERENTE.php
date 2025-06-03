<?php
require '../MODELO/Conexion.php'; // Incluir el archivo de conexión

// Establecer conexión a la base de datos
$conn = conectar();

// Preparar consulta SQL para seleccionar todos los productos
$sql = "SELECT * FROM productos";

// Preparar la declaración SQL y ejecutarla
$stmt = $conn->query($sql);

// Verificar si se encontraron resultados
if ($stmt->rowCount() > 0) {
    $productos = $stmt->fetchAll(); // Obtener todos los productos
} else {
    $productos = []; // Inicializar como array vacío si no hay productos
}

// Cerrar conexión a la base de datos
$conn = null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CONTROL DEL INVENTARIO</title> 
  <!-- Enlace a la biblioteca de iconos Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

  <style>
    /* Reset general */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Estilo general del cuerpo */
    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /*  (Menú lateral) */
    .sidebar {
      width: 60px; /* Tamaño minimizado */
      background: linear-gradient(to right, #151718,  #03045E); /* Fondo degradado */
      transition: width 0.3s ease;
      overflow: hidden;
      position: fixed;
      height: 100%;
      padding-top: 20px;
    }

    /* Al pasar el mouse, se expande */
    .sidebar:hover {
      width: 260px;
    }

    /* Título SANSARA oculto inicialmente */
    .sidebar h2 {
      color: #fff;
      text-align: center;
      margin-bottom: 30px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    /* Mostrar título al hacer hover */
    .sidebar:hover h2 {
      opacity: 1;
    }

    /* Enlaces dentro del menú */
    .sidebar a {
      position: relative;
      display: flex;
      align-items: center;
      color: #fff;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.3s ease, color 0.3s ease;
    }

    /* Barra decorativa a la izquierda al estar activo */
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

    /* Efecto al estar activo  */
    .sidebar a:hover,
    .sidebar a.active {
      background: linear-gradient(90deg, rgba(253,202,64,0.2) 0%, #FDCA40 100%);
      color: #151718;
    }

    .sidebar a:hover::before,
    .sidebar a.active::before {
      transform: scaleY(1);
    }

    /* Iconos */
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

    /* Texto al lado del ícono (oculto al inicio) */
    .sidebar span {
      margin-left: 15px;
      white-space: nowrap;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    /* Mostrar texto al expandir la barra */
    .sidebar:hover span {
      opacity: 1;
    }

    /* CONTENIDO PRINCIPAL */
    .content {
      margin-left: 80px;
      padding: 60px;
      transition: margin-left 0.3s ease;
      animation: fadeInSlide 1s ease forwards; /* Animación entrada */
      opacity: 0;
    }

    .sidebar:hover ~ .content {
      margin-left: 260px;
    }

    /* Animación de aparición del contenido */
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
      margin-bottom: 20px;
      color: #31393C;
    }

    /* FILTROS DE BÚSQUEDA */
    .filtros {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #808181;
      margin-bottom: 30px;
    }

    .filtros h3 {
      margin-bottom: 15px;
    }

    .fila-filtros {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 10px;
    }

    .filtros input,
    .filtros select {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      min-width: 150px;
      flex: 1;
    }

    /* TABLA DE RESULTADOS */
    .tabla-container {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px #151718;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      border: 1px solid #ccc;
    }

    th, td {
      text-align: center;
      padding: 10px;
      border: 1px solid #ccc;
    }

    th {
      background: linear-gradient(to bottom, #31393C,#2176FF);
      color: white;
    }

    tr:hover {
      background-color: #fff;
    }

    /* Botón de solicitud  */
    .btn-solicitar {
      padding: 8px 12px;
      background: linear-gradient(to right, #F79824, #FDCA40);
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      box-shadow: 0 4px 10px #151718;
      transition: all 0.3s ease;
    }

    .btn-solicitar:hover {
      background: linear-gradient(to right, #FDCA40 , #F79824);
      transform: translateY(-2px);
      box-shadow: 0 6px 14px #151718;
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
/* Estilo para el rol debajo de SANSARA */
.rol {
  color:rgb(255, 255, 255);
  text-align: center;
  font-size: 12px;
  opacity: 0;
  transition: opacity 0.3s ease;
  margin-top: -50px;
  margin-bottom: 0px;
}

/* Mostrar rol al hacer hover */
.sidebar:hover .rol {
  opacity: 1;
}

      .button {
        padding: 8px 16px;
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

  </style>
</head>
<body>
  <div class="sidebar">
    <h2>SANSARA</h2><br>
    <p class="rol">Gerente</p><br>
    <a href="SUPERVISION_VENTAS.php"><i class="fas fa-cash-register"></i><span>Supervisión de Ventas</span></a>
    <a href="CONTROL_INVENTARIO_GERENTE.php"><i class="fas fa-boxes-stacked"></i><span>Control de Inventario</span></a>
    <a href="REGISTRAR_PRODUCTOS.php"><i class="fas fa-box-open"></i><span>Registrar Productos</span></a>
    <a href="REPORTES_GEREN.php"><i class="fas fa-chart-bar"></i><span>Reportes</span></a>
    <a href="CERRAR_SESION.php"><i class="fas fa-right-from-bracket"></i><span>Cerrar Sesión</span></a>
  </div>

  <div class="content">
    <h2><i class="fas fa-boxes-stacked"></i> CONTROL DEL INVENTARIO</h2>

    <!-- Filtros -->
    <div class="filtros">
      <input type="text" id="filtro-etiqueta" placeholder="Etiqueta">
      <input type="text" id="filtro-modelo" placeholder="Modelo">
      <input type="text" id="filtro-color" placeholder="Color">
      <input type="text" id="filtro-talla" placeholder="Talla">
      <select id="filtro-sucursal">
        <option value="">Sucursal</option>
        <option value="Sucursal1">Sucursal 1</option>
        <option value="Sucursal2">Sucursal 2</option>
        <option value="Sucursal3">Sucursal 3</option>
        <option value="Sucursal4">Sucursal 4</option>
      </select>
    </div>

    <!-- Tabla -->
    <div class="tabla-container">
      <table>
        <thead>
          <tr>
            <th>Modelo</th>
            <th>Talla</th>
            <th>Color</th>
            <th>Precio</th>
            <th>Marca</th>
            <th>Etiqueta</th>
            <th>Sucursal</th>
            <th>Cantidad</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($productos as $producto): ?>
          <tr>
            <td><?= htmlspecialchars($producto['modelo']) ?></td>
            <td><?= htmlspecialchars($producto['talla']) ?></td>
            <td><?= htmlspecialchars($producto['color']) ?></td>
            <td><?= htmlspecialchars($producto['precio']) ?></td>
            <td><?= htmlspecialchars($producto['marca']) ?></td>
            <td><?= htmlspecialchars($producto['etiqueta']) ?></td>
            <td><?= htmlspecialchars($producto['sucursal']) ?></td>
            <td>
              <input type="number" value="<?= htmlspecialchars($producto['cantidad']) ?>"
                     data-id="<?= $producto['id'] ?>" class="cantidad-input" min="0" disabled>
            </td>
            <td>
<button class="editar-btn button" data-id="<?= $producto['id'] ?>">Editar</button>
<button class="guardar-btn button" data-id="<?= $producto['id'] ?>" style="display:none;">Guardar</button>
  <button class="eliminar-btn button" data-id="<?= $producto['id'] ?>">Eliminar</button>

            </td>
          </tr>
          <?php endforeach; ?>

          <?php if (empty($productos)): ?>
          <tr><td colspan="9" style="text-align:center; color:#999;">Sin productos disponibles</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Script: Filtro AJAX -->
  <script>
    const inputs = ['filtro-etiqueta', 'filtro-modelo', 'filtro-color', 'filtro-talla', 'filtro-sucursal'];
    inputs.forEach(id => {
      const el = document.getElementById(id);
      el.addEventListener(el.tagName === 'SELECT' ? 'change' : 'input', filtrarProductos);
    });

    function filtrarProductos() {
      const data = {
        etiqueta: document.getElementById('filtro-etiqueta').value,
        modelo: document.getElementById('filtro-modelo').value,
        color: document.getElementById('filtro-color').value,
        talla: document.getElementById('filtro-talla').value,
        sucursal: document.getElementById('filtro-sucursal').value
      };

      fetch('FiltrarStock.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(data)
      })
      .then(res => res.json())
      .then(productos => {
        const tbody = document.querySelector('table tbody');
        tbody.innerHTML = '';

        if (productos.length === 0) {
          tbody.innerHTML = `<tr><td colspan="9" style="text-align:center; color:#999;">Sin resultados</td></tr>`;
          return;
        }

        productos.forEach(prod => {
          tbody.innerHTML += `
            <tr>
              <td>${prod.modelo}</td>
              <td>${prod.talla}</td>
              <td>${prod.color}</td>
              <td>${prod.precio}</td>
              <td>${prod.marca}</td>
              <td>${prod.etiqueta}</td>
              <td>${prod.sucursal}</td>
              <td>
                <input type="number" value="${prod.cantidad}" data-id="${prod.id}" class="cantidad-input" min="0" disabled>
              </td>
              <td>
                <button class="editar-btn" data-id="${prod.id}">Editar</button>
                <button class="guardar-btn" data-id="${prod.id}" style="display:none;">Guardar</button>
              </td>
            </tr>`;
        });
      });
    }
  </script>

  <!-- Script: Filtro de texto puro -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const filtros = {
        etiqueta: document.getElementById("filtro-etiqueta"),
        modelo: document.getElementById("filtro-modelo"),
        color: document.getElementById("filtro-color"),
        talla: document.getElementById("filtro-talla"),
        sucursal: document.getElementById("filtro-sucursal")
      };

      const aplicarFiltros = () => {
        const valores = {
          etiqueta: filtros.etiqueta.value.toLowerCase(),
          modelo: filtros.modelo.value.toLowerCase(),
          color: filtros.color.value.toLowerCase(),
          talla: filtros.talla.value.toLowerCase(),
          sucursal: filtros.sucursal.value
        };

        document.querySelectorAll("tbody tr").forEach(fila => {
          const datos = {
            modelo: fila.cells[0].textContent.toLowerCase(),
            talla: fila.cells[1].textContent.toLowerCase(),
            color: fila.cells[2].textContent.toLowerCase(),
            etiqueta: fila.cells[5].textContent.toLowerCase(),
            sucursal: fila.cells[6].textContent
          };

          const visible =
            (!valores.etiqueta || datos.etiqueta.includes(valores.etiqueta)) &&
            (!valores.modelo || datos.modelo.includes(valores.modelo)) &&
            (!valores.color || datos.color.includes(valores.color)) &&
            (!valores.talla || datos.talla.includes(valores.talla)) &&
            (!valores.sucursal || datos.sucursal === valores.sucursal);

          fila.style.display = visible ? "" : "none";
        });
      };

      Object.values(filtros).forEach(f =>
        f.addEventListener(f.tagName === 'SELECT' ? 'change' : 'input', aplicarFiltros)
      );
    });
  </script>

  <!-- Script: Editar / Guardar cantidad -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  document.addEventListener('click', async e => {
    // Editar
    if (e.target.classList.contains('editar-btn')) {
      const id = e.target.dataset.id;
      const input = document.querySelector(`input[data-id="${id}"]`);
      const guardarBtn = document.querySelector(`.guardar-btn[data-id="${id}"]`);
      input.disabled = false;
      e.target.style.display = 'none';
      guardarBtn.style.display = 'inline-block';
      input.focus();
    }

    // Guardar
    if (e.target.classList.contains('guardar-btn')) {
      const id = e.target.dataset.id;
      const input = document.querySelector(`input[data-id="${id}"]`);
      const cantidad = input.value;

      fetch('ActualizarCantidad.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(id)}&cantidad=${encodeURIComponent(cantidad)}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          mostrarModal("¡Cantidad actualizada correctamente!");
          input.disabled = true;
          e.target.style.display = 'none';
          const editarBtn = document.querySelector(`.editar-btn[data-id="${id}"]`);
          editarBtn.style.display = 'inline-block';
        } else {
          alert(data.message);
        }
      })
      .catch(err => {
        console.error("Error en la solicitud:", err);
        alert("Error al guardar. Verifica la consola.");
      });
    }

    // Eliminar
    if (e.target.classList.contains('eliminar-btn')) {
      const id = e.target.dataset.id;

      // Mostrar modal de confirmación
      const confirmado = await mostrarModalConfirmacion("¿Estás seguro que quieres eliminar este producto?");
      if (!confirmado) return; // Si cancela, no hacer nada

      // Si confirma, enviar petición para eliminar
      fetch('EliminarProducto.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(id)}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          mostrarModal("Producto eliminado exitosamente");
          // Remover fila
          const fila = e.target.closest('tr');
          if (fila) fila.remove();
        } else {
          alert(data.message);
        }
      })
      .catch(err => {
        console.error("Error al eliminar:", err);
        alert("Error al eliminar. Verifica la consola.");
      });
    }
  });
});

// Modal genérico para mensajes de éxito o info
function mostrarModal(mensaje) {
  cerrarModal(); // Por si hay otro abierto
  const modal = document.createElement('div');
  modal.classList.add('modal-overlay');
  modal.id = 'mensajeModal';
  modal.innerHTML = `
    <div class="glass-card">
      <span class="modal-close" onclick="cerrarModal()">×</span>
      <h2 style="text-align:center; color:#FDCA40;">${mensaje}</h2>
      <button class="modal-button" onclick="cerrarModal()">Aceptar</button>
    </div>
  `;
  document.body.appendChild(modal);
}

// Modal de confirmación que devuelve una promesa para saber si el usuario aceptó o canceló
function mostrarModalConfirmacion(mensaje) {
  return new Promise(resolve => {
    cerrarModal(); // Cerrar modal anterior si existe

    const modal = document.createElement('div');
    modal.classList.add('modal-overlay');
    modal.id = 'mensajeModal';
    modal.innerHTML = `
      <div class="glass-card">
        <h2 style="text-align:center; color:#FDCA40;">${mensaje}</h2>
        <div style="text-align:center; margin-top: 20px;">
          <button class="modal-button" id="modalConfirmar">Sí</button>
          <button class="modal-button" id="modalCancelar">No</button>
        </div>
      </div>
    `;
    document.body.appendChild(modal);

    // Botones de confirmar y cancelar
    document.getElementById('modalConfirmar').onclick = () => {
      cerrarModal();
      resolve(true);
    };
    document.getElementById('modalCancelar').onclick = () => {
      cerrarModal();
      resolve(false);
    };
  });
}

function cerrarModal() {
  const modal = document.getElementById("mensajeModal");
  if (modal) modal.remove();
}
</script>



</body>



</html>

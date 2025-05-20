<?php
if (isset($_POST['guardar'])) {
    require 'EditarUsuarios.php';
    exit;
} elseif (isset($_POST['eliminar'])) {
    require 'EliminarUsuarios.php';
    exit;
} else {
    header('Location: ../VISTAS/MODIFICAR_USUARIOS.php');
}
?>
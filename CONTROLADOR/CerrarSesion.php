<?php
session_start();
session_unset(); // Limpia las variables de sesión
session_destroy(); // Destruye la sesión
header("Location: ../INDEX.php");
exit();

<?php
require_once '../MODELO/Conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $conn = conectar();

    $sql = "SELECT * FROM usuarios WHERE correo = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario_data = $resultado->fetch_assoc();

    if ($usuario_data && password_verify($contrasena, $usuario_data['contrasena'])) {
        $_SESSION['nombre'] = $usuario_data['nombre'];
        $_SESSION['rol'] = $usuario_data['rol'];
        $_SESSION['correo'] = $usuario_data['correo'];

        switch ($usuario_data['rol']) {
            case 'administrador':
                header("Location: ../VISTA/PANEL_PRINCIPAL_ADMINISTRADOR.php");
                break;
            case 'gerente':
                header("Location: ../VISTA/PANEL_PRINCIPAL_GERENTE.php");
                break;
            case 'cajero':
                header("Location: ../VISTA/PANEL_PRINCIPAL_CAJERO.php");
                break;
            case 'vendedor':
                header("Location: ../VISTA/PANEL_PRINCIPAL_VENDEDOR.php");
                break;
            default:
                echo "Rol no reconocido.";
        }
        exit;
    } else {
        echo "<script>alert('Correo o contraseña incorrectos'); window.location.href = '../SANSARA_DV/index.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../SANSARA_DV/INDEX.php");
    exit;
}
?>
<?php
session_start();
include_once '../MODELO/Conexion.php';

$conn = conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    try {
        $conn = conectar();

        $sql = "SELECT * FROM usuarios WHERE correo = :correo LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        $usuario_data = $stmt->fetch(PDO::FETCH_ASSOC);

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
            // Redirige con parámetro para mostrar modal en index.php
            header("Location: index.php?error=login");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    header("Location: index.php");
    exit;
}

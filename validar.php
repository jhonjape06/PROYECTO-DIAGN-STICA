<?php
session_start();
require("connect_db.php");

$username = $_POST['mail'];
$pass = $_POST['pass'];

// Consulta para obtener el usuario según el email
$sql = mysqli_query($mysqli, "SELECT * FROM login WHERE email='$username'");
if ($f = mysqli_fetch_assoc($sql)) {
    // Comprobación de la contraseña (puede que necesites cambiar 'password' según tu base de datos)
    if ($pass == $f['password']) {
        // Guardar la información del usuario en la sesión
        $_SESSION['id'] = $f['id'];
        $_SESSION['user'] = $f['user'];
        $_SESSION['rol'] = $f['rol'];

        // Redirigir según el rol del usuario
        switch ($f['rol']) {
            case 'administrador':
                echo '<script>alert("BIENVENIDO ADMINISTRADOR")</script>';
                echo "<script>location.href='usu_admin/admin.php'</script>";
                break;
            case 'logistica':
                header("Location: usu_logistica/index2.php");
                break;
            case 'sede':
                header("Location: usu_sede/index.php");
                break;
            // Añadir más casos según los roles que tengas en la base de datos
            default:
                echo '<script>alert("ROL NO RECONOCIDO")</script>';
                echo "<script>location.href='index.php'</script>";
                break;
        }
    } else {
        // Contraseña incorrecta
        echo '<script>alert("CONTRASEÑA INCORRECTA")</script>';
        echo "<script>location.href='index.php'</script>";
    }
} else {
    // Usuario no encontrado
    echo '<script>alert("ESTE USUARIO NO EXISTE, POR FAVOR COMUNÍQUESE CON EL ADMINISTRADOR DEL SISTEMA")</script>';
    echo "<script>location.href='index.php'</script>";
}
?>

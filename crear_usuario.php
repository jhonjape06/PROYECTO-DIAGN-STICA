<?php
    // Inicio de la sesión PHP
    session_start();
    // Redirección si no hay usuario autenticado
    if (!isset($_SESSION['user'])) {
        header("Location: index.php");
        exit(); // Finaliza el script para evitar ejecución adicional
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO DIAGNOSTICA</title>
    <link rel="stylesheet" href="css/estilos_crear_usuario.css">
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        <nav class="navbar">
            <img class="logo-adm" src="images/logo-adm.png" alt="logo">
            <ul class="nav pull-right">
                <li>
                    <form method="post" action="desconectar.php">
                        <button type="submit" class="cerrar_sesion">Cerrar sesión</button>
                    </form>
                </li>
                <li class="Usuario">Usuario: <strong><?php echo $_SESSION['user']; ?></strong></li>
            </ul>
        </nav>
        <!-- Fin Navbar -->

        <!-- Cuerpo del documento -->
        <div class="row-crear-usu">
            <form method="post" action="admin.php">
                <button type="submit" class="btn_crear_usu"><= ATRAS</button>
            </form> 
            <div class="row-fluid">
                <!-- Formulario de registro -->
                <form method="post" action="registro.php" onsubmit="return validarFormulario()">
                    <fieldset>
                        <legend style="font-size: 18pt"><b>REGISTRO</b></legend>
                        <div class="form-group">
                            <label><b>INGRESA EL NOMBRE</b></label>
                            <input type="text" name="realname" class="form-control" placeholder="Nombre completo" />
                        </div>
                        <div class="form-group">
                            <label><b>INGRESA EL CORREO</b></label>
                            <input type="text" name="nick" class="form-control" required placeholder="Correo electrónico"/>
                        </div>
                        <div class="form-group">
                            <label><b>INGRESA LA CONTRASEÑA</b></label>
                            <input type="password" name="pass" class="form-control" placeholder="Contraseña" />
                        </div>
                        <div class="form-group">
                            <label><b>REPITE LA CONTRASEÑA</b></label>
                            <input type="password" name="rpass" class="form-control" required placeholder="Repite contraseña" />
                        </div>
                        <div class="form-group">
                            <label><b>INGRESE EL ROL</b></label>
                            <input type="text" name="rol" class="form-control" required placeholder="Rol del usuario" />
                        </div>
                        <input  class="btn btn-danger" type="submit" name="submit" value="CREAR USUARIO"/>
                    </fieldset>
                </form>
                <!-- Fin del formulario de registro -->
            </div>
        </div>
        <!-- Fin Cuerpo del documento -->
    </div>
    <!-- JavaScript al final para mejorar la velocidad de carga -->
    <script src="bootstrap/js/jquery-1.8.3.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script>
        // Función para validar el formulario de registro
        function validarFormulario() {
            // Obtiene los valores de los campos del formulario
            var realname = document.getElementsByName("realname")[0].value.trim();
            var mail = document.getElementsByName("nick")[0].value.trim();
            var pass = document.getElementsByName("pass")[0].value.trim();
            var rpass = document.getElementsByName("rpass")[0].value.trim();
            var rol = document.getElementsByName("rol")[0].value.trim();

            // Validación de campos vacíos
            if (realname === "" || mail === "" || pass === "" || rpass === "" || rol === "") {
                alert("Por favor, complete todos los campos.");
                return false;
            }

            // Validación de contraseñas coincidentes
            if (pass !== rpass) {
                alert("Las contraseñas no coinciden.");
                return false;
            }

            // Validación de correo electrónico simple
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(mail)) {
                alert("Por favor, ingrese un correo electrónico válido.");
                return false;
            }

            // Si pasa todas las validaciones, devuelve verdadero y se envía el formulario
            return true;
        }
    </script>
</body>
</html>

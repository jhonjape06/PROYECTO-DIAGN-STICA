<?php
    // Inicio de la sesión PHP
    session_start();
    // Redirección si no hay usuario autenticado
    if (!isset($_SESSION['user'])) {
        header("Location: ../../index.php");
        exit(); // Finaliza el script para evitar ejecución adicional
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO DIAGNOSTICA</title>
    <link rel="stylesheet" href="../../css/estilos_crear_sede.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Convertir a mayúsculas al momento de entrada
            $('input[type="text"]').on('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        <nav class="navbar">
            <img class="logo-adm" src="../../images/logo-adm.png" alt="logo">
            <ul class="nav pull-right">
                <li>
                    <form method="post" action="../../desconectar.php">
                        <button type="submit" class="cerrar_sesion">CERRAR SESIÓN</button>
                    </form>
                </li>
                <nav>
                <li class="Usuario">USUARIO: <strong><?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
                <li class="Usuario">ROL: <strong><?php echo htmlspecialchars($_SESSION['rol'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
                </nav>
            </ul>
        </nav>
        <!-- Fin Navbar -->

        <!-- Cuerpo del documento -->
        <div class="row-crear-usu">
            <form method="post" action="sedes.php">
                <button type="submit" class="btn_atras"><= ATRAS</button>
            </form> 
            <div class="row-fluid">
                <!-- Formulario de registro -->
                <form method="post" action="registro_sedes.php" onsubmit="return validarFormulario()">
                    <fieldset>
                        <legend style="font-size: 18pt"><b>NUEVA SEDE</b></legend>
                        <div class="form-group">
                            <label><b>NOMBRE SEDE</b></label>
                            <input type="text" name="nombre_sede" class="form-control" placeholder="NOMBRE SEDE" />
                        </div>
                        <div class="form-group">
                            <label><b>DIRECCIÓN</b></label>
                            <input type="text" name="direccion" class="form-control" required placeholder="DIRECCIÓN"/>
                        </div>
                        <div class="form-group">
                            <label><b>BARRIO</b></label>
                            <input type="text" name="barrio" class="form-control" placeholder="BARRIO" />
                        </div>
                        <div class="form-group">
                            <label><b>CIUDAD</b></label>
                            <input type="text" name="ciudad" class="form-control" required placeholder="CIUDAD" />
                        </div>
                        <div class="form-group">
                            <label><b>COORDINADOR</b></label>
                            <input type="text" name="coordinador" class="form-control" required placeholder="COORDINADOR" />
                        </div>
                        <div class="form-group">
                            <label><b>TELEFONO</b></label>
                            <input type="text" name="telefono" class="form-control" required placeholder="TELEFONO" />
                        </div>
                        <input  class="btn btn-danger" type="submit" name="submit" value="CREAR SEDE"/>
                    </fieldset>
                </form>
                <!-- Fin del formulario de registro -->
            </div>
        </div>
        <!-- Fin Cuerpo del documento -->
    </div>
    <!-- JavaScript al final para mejorar la velocidad de carga -->
    <script src="../bootstrap/js/jquery-1.8.3.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script>
        // Función para validar el formulario de registro
        function validarFormulario() {
            // Obtiene los valores de los campos del formulario
            var nombre_sede = document.getElementsByName("nombre_sede")[0].value.trim();
            var direccion = document.getElementsByName("direccion")[0].value.trim();
            var barrio = document.getElementsByName("barrio")[0].value.trim();
            var ciudad = document.getElementsByName("ciudad")[0].value.trim();
            var coordinador = document.getElementsByName("coordinador")[0].value.trim();
            var telefono = document.getElementsByName("telefono")[0].value.trim();

            // Validación de campos vacíos
            if (nombre_sede === "" || direccion === "" || barrio === "" || ciudad === "" || coordinador === "" || telefono === "") {
                alert("Por favor, complete todos los campos.");
                return false;
            }

            // Si pasa todas las validaciones, devuelve verdadero y se envía el formulario
            return true;
        }
    </script>
</body>
</html>

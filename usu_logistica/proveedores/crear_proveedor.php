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
    <link rel="stylesheet" href="../../css/estilos_crear_proveedor.css">
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
                <li class="Usuario">USUARIO: <strong><?php echo $_SESSION['user']; ?></strong></li>
            </ul>
        </nav>
        <!-- Fin Navbar -->

        <!-- Cuerpo del documento -->
        <div class="row-crear-usu">
            <form method="post" action="proveedores.php">
                <button type="submit" class="btn_atras"><= ATRAS</button>
            </form> 
            <div class="row-fluid">
                <!-- Formulario de registro -->
                <form method="post" action="registro_proveedor.php" onsubmit="return validarFormulario()">
                    <fieldset>
                        <legend style="font-size: 18pt"><b>NUEVO PROVEEDOR</b></legend>
                        <div class="form-group">
                            <label><b>NIT</b></label>
                            <input type="text" name="nit" class="form-control" placeholder="nit" />
                        </div>
                        <div class="form-group">
                            <label><b>EMPRESA</b></label>
                            <input type="text" name="empresa" class="form-control" required placeholder="razón social"/>
                        </div>
                        <div class="form-group">
                            <label><b>NOMBRE DE CONTACTO</b></label>
                            <input type="text" name="contacto" class="form-control" placeholder="Contacto" />
                        </div>
                        <div class="form-group">
                            <label><b>TELEFONO</b></label>
                            <input type="text" name="telefono" class="form-control" required placeholder="telefono" />
                        </div>
                        <div class="form-group">
                            <label><b>DIRECCIÓN</b></label>
                            <input type="text" name="direccion" class="form-control" required placeholder="dirección" />
                        </div>
                        <div class="form-group">
                            <label><b>CIUDAD</b></label>
                            <input type="text" name="ciudad" class="form-control" required placeholder="ciudad" />
                        </div>
                        <div class="form-group">
                            <label><b>CORREO</b></label>
                            <input type="text" name="correo" class="form-control" required placeholder="correo" />
                        </div>
                        <input  class="btn btn-danger" type="submit" name="submit" value="CREAR PROVEEDOR"/>
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
            var nit = document.getElementsByName("nit")[0].value.trim();
            var empresa = document.getElementsByName("empresa")[0].value.trim();
            var contacto = document.getElementsByName("contacto")[0].value.trim();
            var telefono = document.getElementsByName("telefono")[0].value.trim();
            var direccion = document.getElementsByName("direccion")[0].value.trim();
            var ciudad = document.getElementsByName("ciudad")[0].value.trim();
            var correo = document.getElementsByName("correo")[0].value.trim();

            // Validación de campos vacíos
            if (nit === "" || empresa === "" || contacto === "" || telefono === "" || direccion === "" || ciudad === "" || correo === "") {
                alert("Por favor, complete todos los campos.");
                return false;
            }


            // Validación de correo electrónico simple
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(correo)) {
                alert("Por favor, ingrese un correo electrónico válido.");
                return false;
            }

            // Si pasa todas las validaciones, devuelve verdadero y se envía el formulario
            return true;
        }
    </script>
</body>
</html>

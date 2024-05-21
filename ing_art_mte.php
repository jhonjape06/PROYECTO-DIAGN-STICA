<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location:index.php");
    exit();
} elseif ($_SESSION['rol'] == 1) {
    header("Location:admin.php");
    exit();
}
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO DIAGNOSTICA</title>
    <link rel="stylesheet" href="css/estilos_ing_art_mte.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#codigo_art').on('change', function() {
                var codigo_art = $(this).val();
                if (codigo_art !== '') {
                    $.ajax({
                        url: 'buscar_producto.php',
                        type: 'POST',
                        data: {codigo_producto: codigo_art},
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.error) {
                                alert(data.error);
                                $('#nombre_art').val('');
                                $('#proveedor').val('');
                                $('#descrip').val('');
                                $('#valor_art').val('');
                                $('#cantidad').val('');
                            } else {
                                $('#nombre_art').val(data.nombre_art);
                                $('#proveedor').val(data.proveedor);
                                $('#descrip').val(data.descrip);
                                $('#valor_art').val(data.valor_art);
                                $('#cantidad').val('');
                            }
                        }
                    });
                }
            });
        });
    </script>
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
                <li class="Usuario">Usuario: <strong><?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
            </ul>
        </nav>
        <!-- Fin Navbar -->

        <!-- Cuerpo del documento -->
        <div class="row-ing-art">
            <form method="post" action="ingresar_articulos.php">
                <button type="submit" class="btn_atras"><= ATRÁS</button>
            </form> 
            <div class="row-fluid">
                <!-- Formulario de ingresar artículos manualmente -->
                <form method="post" action="registrar_art.php" onsubmit="return validarFormulario()">
                    <fieldset>
                        <legend style="font-size: 18pt"><b>CREAR ARTÍCULOS</b></legend>
                        <div class="form-group">
                            <label><b>CÓDIGO</b></label>
                            <input type="text" id="codigo_art" name="codigo_art" class="form-control" placeholder="Código" required />
                        </div>
                        <div class="form-group">
                            <label><b>NOMBRE</b></label>
                            <input type="text" id="nombre_art" name="nombre_art" class="form-control" required placeholder="Nombre" />
                        </div>
                        <div class="form-group">
                            <label><b>PROVEEDOR</b></label>
                            <input type="text" id="proveedor" name="proveedor" class="form-control" required placeholder="Proveedor" />
                        </div>
                        <div class="form-group">
                            <label><b>DESCRIPCIÓN</b></label>
                            <input type="text" id="descrip" name="descrip" class="form-control" required placeholder="Descripción" />
                        </div>
                        <div class="form-group">
                            <label><b>VALOR UNITARIO</b></label>
                            <input type="text" id="valor_art" name="valor_art" class="form-control" required placeholder="Valor unitario" />
                        </div>
                        <div class="form-group">
                            <label><b>CANTIDAD</b></label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" required placeholder="Cantidad" />
                        </div>
                        <input class="btn btn-crear" type="submit" name="submit" value="AGREGAR AL INVENTARIO" />
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
            var codigo_art = document.getElementById("codigo_art").value.trim();
            var nombre_art = document.getElementById("nombre_art").value.trim();
            var proveedor = document.getElementById("proveedor").value.trim();
            var descrip = document.getElementById("descrip").value.trim();
            var valor_art = document.getElementById("valor_art").value.trim();
            var cantidad = document.getElementById("cantidad").value.trim();

            // Validación de campos vacíos
            if (codigo_art === "" || nombre_art === "" || proveedor === "" || descrip === "" || valor_art === "" || cantidad === "") {
                alert("Por favor, complete todos los campos.");
                return false;
            }

            // Validar que la cantidad sea un número positivo
            if (isNaN(cantidad) || cantidad <= 0) {
                alert("Por favor, ingrese una cantidad válida.");
                return false;
            }

            // Si pasa todas las validaciones, devuelve verdadero y se envía el formulario
            return true;
        }
    </script>
</body>
</html>

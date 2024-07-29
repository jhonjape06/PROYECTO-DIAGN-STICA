<?php
// Inicio de la sesión PHP
session_start();

// Redirección si no hay usuario autenticado
if (!isset($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit(); // Finaliza el script para evitar ejecución adicional
}

// Requerir el archivo de conexión
require("../../connect_db.php");

// Obtener las sedes
$sql_sedes = "SELECT id, nombre_sede FROM sedes";
$result_sedes = $mysqli->query($sql_sedes);
$sedes = [];
if ($result_sedes->num_rows > 0) {
    // Almacenar las sedes en un array
    while($row_sede = $result_sedes->fetch_assoc()) {
        $sedes[] = $row_sede;
    }
} else {
    echo "No se encontraron sedes";
}

// Obtener los productos del inventario
$sql_productos = "SELECT id, nombre_art FROM inventario";
$result_productos = $mysqli->query($sql_productos);
$productos = [];
if ($result_productos->num_rows > 0) {
    // Almacenar los productos en un array
    while($row_producto = $result_productos->fetch_assoc()) {
        $productos[] = $row_producto;
    }
} else {
    echo "No se encontraron productos en el inventario";
}
$mysqli->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Productos</title>
    <link rel="stylesheet" href="../../css/estilos_asignar_productos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Convertir a mayúsculas al momento de entrada
            $('input[type="text"]').on('input', function() {
                this.value = this.value.toUpperCase();
            });

            // Variables para almacenar selecciones
            var sedeSeleccionada = '';
            var productoSeleccionado = '';

            // Agregar producto seleccionado a la tabla
            $('#agregarProducto').click(function() {
                var cantidad = $('input[name="cantidad"]').val();
                var sedeId = $('#nombre_sede').val();
                var productoNombre = $('#producto option:selected').text(); // Obtener nombre del producto

                // Validar campos antes de agregar a la tabla
                if (sedeId === "" || productoNombre === "" || cantidad === "") {
                    alert("Por favor, complete todos los campos.");
                    return;
                }

                // Obtener nombre de la sede
                sedeSeleccionada = $('#nombre_sede option:selected').text();

                // Agregar a la tabla de productos seleccionados
                var html = '<tr data-sede-id="' + sedeId + '" data-producto-nombre="' + productoNombre + '">';
                html += '<td>' + sedeSeleccionada + '</td>';
                html += '<td>' + productoNombre + '</td>';
                html += '<td>' + cantidad + '</td>';
                html += '<td><button type="button" class="eliminarProducto btn btn-danger">Eliminar</button></td>';
                html += '</tr>';
                $('#tablaProductos tbody').append(html);

                // Limpiar cantidad después de agregar a la tabla
                $('input[name="cantidad"]').val('');
            });

            // Eliminar fila de producto
            $('#tablaProductos').on('click', '.eliminarProducto', function() {
                $(this).closest('tr').remove();
            });

            // Validar formulario antes de enviar
            $('#enviarFormulario').click(function() {
                // Obtener número de filas en la tabla
                var rowCount = $('#tablaProductos tbody tr').length;

                // Si no hay filas, mostrar alerta y evitar envío del formulario
                if (rowCount === 0) {
                    alert("Debe seleccionar al menos un producto para asignar.");
                    return false;
                }

                // Crear un array para almacenar los datos de los productos
                var productos = [];

                // Iterar sobre las filas de la tabla y obtener los datos
                $('#tablaProductos tbody tr').each(function() {
                    var sedeId = $(this).data('sede-id');
                    var productoNombre = $(this).data('producto-nombre');
                    var cantidad = $(this).find('td:eq(2)').text();

                    productos.push({
                        sedeId: sedeId,
                        productoNombre: productoNombre,
                        cantidad: cantidad
                    });
                });

                // Crear un campo oculto en el formulario para enviar los datos de los productos
                $('<input>').attr({
                    type: 'hidden',
                    name: 'productos',
                    value: JSON.stringify(productos)
                }).appendTo('form');

                // Si pasa validación, enviar formulario
                $('form').submit();
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
            <form method="post" action="pedido_sedes.php">
                <button type="submit" class="btn_atras">&lt;= ATRAS</button>
            </form> 
            <div class="row-fluid">
                <!-- Formulario de asignación de productos -->
                <form method="post" action="guardar_asignacion.php">
                    <fieldset>
                        <legend style="font-size: 18pt"><b>ASIGNAR PRODUCTOS</b></legend>
                        <div class="form-group">
                            <label><b>NOMBRE SEDE</b></label>
                            <select id="nombre_sede" name="nombre_sede" class="form-control" required>
                                <option value="">Selecciona una sede</option>
                                <?php foreach ($sedes as $sede): ?>
                                    <option value="<?php echo $sede['id']; ?>"><?php echo $sede['nombre_sede']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><b>PRODUCTO</b></label>
                            <select id="producto" name="producto" class="form-control" required>
                                <option value="">Selecciona un producto</option>
                                <?php foreach ($productos as $producto): ?>
                                    <option value="<?php echo $producto['id']; ?>"><?php echo $producto['nombre_art']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><b>CANTIDAD</b></label>
                            <input type="number" name="cantidad" class="form-control" required placeholder="Cantidad"/>
                        </div>
                        <button type="button" id="agregarProducto" class="btn btn-primary">AGREGAR PRODUCTO</button>
                        <br><br>
                        <table id="tablaProductos">
                            <thead>
                                <tr>
                                    <th>NOMBRE SEDE</th>
                                    <th>PRODUCTO</th>
                                    <th>CANTIDAD</th>
                                    <th>ELIMINAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Filas de productos seleccionados se agregan dinámicamente aquí -->
                            </tbody>
                        </table>
                        <br>
                        <button type="submit" id="enviarFormulario" class="btn btn-danger">ASIGNAR PRODUCTOS</button>
                    </fieldset>
                </form>
                <!-- Fin del formulario de asignación -->
            </div>
        </div>
        <!-- Fin Cuerpo del documento -->

    </div>
    <!-- JavaScript al final para mejorar la velocidad de carga -->
    <script src="../bootstrap/js/jquery-1.8.3.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

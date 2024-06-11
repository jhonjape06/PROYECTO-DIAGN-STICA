<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}
?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO DIAGNOSTICA</title>
    <link rel="stylesheet" href="../css/estilos_actualizar.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
    <script>
        $(document).ready(function() {
            // Fetch providers when the page loads
            fetchProviders();

            // Function to fetch providers
            function fetchProviders() {
                $.ajax({
                    url: 'listar_proveedores.php',
                    type: 'GET',
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            // Populate the select field with providers
                            var options = '';
                            data.proveedores.forEach(function(proveedor) {
                                var selected = (proveedor.empresa === "<?php echo $proveedor; ?>") ? ' selected' : '';
                                options += '<option value="' + proveedor.id + '"' + selected + '>' + proveedor.empresa + '</option>';
                            });
                            $('#proveedor').html(options);
                        } else {
                            alert(data.error);
                            $('#proveedor').html('<option value="">Error al cargar proveedores</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Error al cargar proveedores.');
                        $('#proveedor').html('<option value="">Error al cargar proveedores</option>');
                    }
                });
            }
        });
        
    </script>

    <script>
        function toUpperCaseField(element) {
            element.value = element.value.toUpperCase();
        }
    </script>
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        <nav class="navbar">
            <img class="logo-adm" src="../images/logo-adm.png" alt="logo">
            <ul class="nav pull-right">
                <li>
                    <form method="post" action="../desconectar.php">
                        <button type="submit" class="cerrar_sesion">CERRAR SESIÓN</button>
                    </form>
                </li>
                <li class="Usuario">USUARIO: <strong><?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
            </ul>
        </nav>
        <div class="row">  
            <form method="post" action="index2.php">
                <button type="submit" class="btn_crear_usu"><= ATRÁS</button>
            </form> 
            <div class="row-fluid">
                <fieldset>
                    <legend style="font-size: 18pt"><b>EDICIÓN DE USUARIOS</b></legend>
                    <?php
                        extract($_GET);
                        require("../connect_db.php");
                        $sql = "SELECT * FROM inventario WHERE id = $id";
                        $ressql = mysqli_query($mysqli, $sql);
                        if ($row = mysqli_fetch_assoc($ressql)) {
                            $id = $row['id'];
                            $codigo_art = $row['codigo_art'];
                            $nombre_art = $row['nombre_art'];
                            $proveedor = $row['proveedor'];
                            $descrip = $row['descrip'];
                            $valor_art = $row['valor_art'];
                            $cantidad = $row['cantidad'];
                            $cantidad_stock_minimo = $row['cantidad_stock_minimo'];
                            $dias_pedido = $row['dias_pedido'];
                            $cantidad_nvo_ped = $row['cantidad_nvo_ped'];
                            $articulo_descontinuado = $row['articulo_descontinuado'];
                        }

                        // Cargar todos los proveedores para el campo select
                        $sql_proveedores = "SELECT * FROM proveedores";
                        $result_proveedores = mysqli_query($mysqli, $sql_proveedores);
                    ?>
                    <form action="ejecutar_actualizar_prod.php" method="post">
                        <label for="id">ID</label><br> 
                        <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"><br><br>

                        <label for="codigo_art">CÓDIGO ARTÍCULO</label><br> 
                        <input type="text" id="codigo_art" name="codigo_art" value="<?php echo htmlspecialchars($codigo_art, ENT_QUOTES, 'UTF-8'); ?>" oninput="toUpperCaseField(this)"><br><br>

                        <label for="nombre_art">NOMBRE</label><br> 
                        <input type="text" id="nombre_art" name="nombre_art" value="<?php echo htmlspecialchars($nombre_art, ENT_QUOTES, 'UTF-8'); ?>" oninput="toUpperCaseField(this)"><br><br>
                
                        <label for="proveedor">PROVEEDOR</label><br> 
                        <select id="proveedor" name="proveedor" class="form-control" required>
                            <?php
                            while ($row_proveedor = mysqli_fetch_assoc($result_proveedores)) {
                                $selected = ($row_proveedor['empresa'] === $proveedor) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($row_proveedor['empresa'], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($row_proveedor['empresa'], ENT_QUOTES, 'UTF-8') . '</option>';
                            }
                            ?>
                        </select><br><br>
                          
                        <label for="descrip">DESCRIPCIÓN</label><br> 
                        <input type="text" id="descrip" name="descrip" value="<?php echo htmlspecialchars($descrip, ENT_QUOTES, 'UTF-8'); ?>" oninput="toUpperCaseField(this)"><br><br>

                        <label for="valor_art">VALOR POR ARTÍCULO</label><br> 
                        <input type="text" id="valor_art" name="valor_art" value="<?php echo htmlspecialchars($valor_art, ENT_QUOTES, 'UTF-8'); ?>"><br><br>

                        <label for="cantidad">CANTIDAD EN STOCK</label><br> 
                        <input type="text" id="cantidad" name="cantidad" value="<?php echo htmlspecialchars($cantidad, ENT_QUOTES, 'UTF-8'); ?>"><br><br>

                        <label for="cantidad_stock_minimo">CANTIDAD STOCK MÍNIMO</label><br> 
                        <input type="text" id="cantidad_stock_minimo" name="cantidad_stock_minimo" value="<?php echo htmlspecialchars($cantidad_stock_minimo, ENT_QUOTES, 'UTF-8'); ?>"><br><br>

                        <label for="dias_pedido">DÍAS DE PEDIDO</label><br> 
                        <input type="date" id="dias_pedido" name="dias_pedido" value="<?php echo htmlspecialchars($dias_pedido, ENT_QUOTES, 'UTF-8'); ?>"><br><br>

                        <label for="cantidad_nvo_ped">CANTIDAD NUEVO PEDIDO</label><br> 
                        <input type="text" id="cantidad_nvo_ped" name="cantidad_nvo_ped" value="<?php echo htmlspecialchars($cantidad_nvo_ped, ENT_QUOTES, 'UTF-8'); ?>"><br><br>

                        <label for="articulo_descontinuado">ARTÍCULO DESCONTINUADO</label><br> 
                        <select id="articulo_descontinuado" name="articulo_descontinuado" class="articulo_descontinuado">
                            <option value="Sí" <?php if ($articulo_descontinuado == 'Sí') echo 'selected'; ?>>Sí</option>
                            <option value="No" <?php if ($articulo_descontinuado == 'No') echo 'selected'; ?>>No</option>
                        </select><br><br>

                        <input type="submit" value="GUARDAR" class="btn btn-success btn-primary">
                    </form>
                </fieldset>    
            </div>  
        </div>
    </div>
    <!-- JavaScript al final para mejorar la velocidad de carga -->
    <script src="../bootstrap/js/jquery-1.8.3.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

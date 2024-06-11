<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location:../index.php");
    exit();
} elseif ($_SESSION['rol'] == 1) {
    header("Location:../usu_admin/admin.php");
    exit();
}

// Configurar la zona horaria a Colombia
date_default_timezone_set('America/Bogota');

// Conectar a la base de datos
require("../connect_db.php");

// Obtener todos los días de pedido
$sql = "SELECT dias_pedido FROM inventario WHERE dias_pedido IS NOT NULL";
$query = mysqli_query($mysqli, $sql);

$dias_pedido = [];
while ($row = mysqli_fetch_assoc($query)) {
    $dias_pedido[] = $row['dias_pedido'];
}
?>

<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO DIAGNOSTICA</title>
    <link rel="stylesheet" href="../css/estilos_index2.css" />
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
        <!-- Fin Navbar -->

        <!-- Notificación de pedido -->
        <div class="row">
            <div class="container_btn">
                <form method="post" action="ingresar_articulos.php">
                    <button type="submit" class="btn_ing_art">INGRESAR ARTICULO</button>
                </form>
                <form method="post" action="#">
                    <button type="submit" class="btn_ped_sed">PEDIDO DE SEDES</button>
                </form>
                <form method="post" action="proveedores/proveedores.php">
                    <button type="submit" class="btn_proveedores">PROVEEDORES</button>
                </form>
                <form method="post" action="#">
                    <button type="submit" class="btn_gen_rep">GENERAR REPORTES</button>
                </form>
            </div>
            <div class="col-xs-12">
                <div class="caption">
                    <fieldset>
                        <legend style="font-size: 18pt"><b>ADMINISTRACIÓN DE INVENTARIO</b></legend>
                        <div class="well">
                            <div class="row">
                                <div class="col-xs-12">

                                    <?php
                                    $sql = "SELECT * FROM inventario";
                                    $query = mysqli_query($mysqli, $sql);

                                    echo "<table class='table table-hover'>";
                                    echo "<tr class='warning'>";
                                    echo "<td>Id</td>";
                                    echo "<td>ESTADO DE STOCK</td>";
                                    echo "<td>CODIGO ARTICULO</td>";
                                    echo "<td>NOMBRE</td>";
                                    echo "<td>PROVEEDOR</td>";
                                    echo "<td>DESCRIPCCION</td>";
                                    echo "<td>VALOR POR ARTICULO</td>";
                                    echo "<td>CANTIDAD EN STOCK</td>";
                                    echo "<td>VALOR TOTAL</td>";
                                    echo "<td>CANTIDAD STOCK MINIMO</td>";
                                    echo "<td>DIAS DE PEDIDO</td>";
                                    echo "<td>CANTIDAD NUEVO PEDIDO</td>";
                                    echo "<td>ARTICULO DESCONTINUADO</td>";
                                    echo "<td>Editar</td>";
                                    echo "<td>Borrar</td>";
                                    echo "</tr>";

                                    while ($arreglo = mysqli_fetch_array($query)) {
                                        $valor_por_articulo = number_format($arreglo['valor_art'], 2, ',', '.');
                                        $valor_total = number_format($arreglo['valor_total'], 2, ',', '.');
                                        $estado_stock = $arreglo['cantidad'] <= $arreglo['cantidad_stock_minimo'] ? 'Nivel Bajo' : 'Normal';
                                        $estado_class = $estado_stock === 'Nivel Bajo' ? 'nivel-bajo' : 'normal';

                                        echo "<tr class='success'>";
                                        echo "<td>$arreglo[0]</td>";
                                        echo "<td class='$estado_class'>$estado_stock</td>";
                                        echo "<td>$arreglo[2]</td>";
                                        echo "<td>$arreglo[3]</td>";
                                        echo "<td>$arreglo[4]</td>";
                                        echo "<td>$arreglo[5]</td>";
                                        echo "<td>$ $valor_por_articulo</td>";
                                        echo "<td>$arreglo[7]</td>";
                                        echo "<td>$ $valor_total</td>";
                                        echo "<td>$arreglo[9]</td>";
                                        echo "<td><input type='date' name='dias_pedido' value='$arreglo[10]'></td>";
                                        echo "<td>$arreglo[11]</td>";
                                        echo "<td>$arreglo[12]</td>";
                                        echo "<td><a href='actualizar_productos.php?id=$arreglo[0]'><img src='../images/actualizar.png' class='img-rounded'></a></td>";
                                        echo "<td><a href='index2.php?id=$arreglo[0]&idborrar=2'><img src='../images/eliminar.png' class='img-rounded'/></a></td>";
                                        echo "</tr>";

                                        // Verificar si el artículo debe eliminarse automáticamente
                                        if ($arreglo['cantidad'] <= 0 && strtolower($arreglo['articulo_descontinuado']) === "sí") {
                                            $id = $arreglo[0];
                                            $sqlborrar = "DELETE FROM inventario WHERE id=$id";
                                            $resborrar = mysqli_query($mysqli, $sqlborrar);

                                            if ($resborrar) {
                                                echo '<script>alert("Artículo eliminado automáticamente debido a la cantidad en stock igual a 0.");</script>';
                                                echo "<script>location.href='index2.php'</script>";
                                                exit();
                                            } else {
                                                $error_message = mysqli_error($mysqli);
                                                echo '<script>alert("Error al eliminar el artículo: ' . $error_message . '. Inténtelo de nuevo.");</script>';
                                                echo "<script>location.href='index2.php'</script>";
                                                exit();
                                            }
                                        }
                                    }
                                    echo "</table>";

                                    if (isset($_GET['idborrar']) && $_GET['idborrar'] == 2) {
                                        $id = $_GET['id'];
                                        $sqlborrar = "DELETE FROM inventario WHERE id=$id";
                                        $resborrar = mysqli_query($mysqli, $sqlborrar);

                                        if ($resborrar) {
                                            echo '<script>alert("REGISTRO ELIMINADO");</script>';
                                            echo '<script>location.href="index2.php";</script>';
                                            exit();
                                        } else {
                                            $error_message = mysqli_error($mysqli);
                                            echo '<script>alert("Error al eliminar el artículo: ' . $error_message . '. Inténtelo de nuevo.");</script>';
                                            echo '<script>location.href="index2.php";</script>';
                                            exit();
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <!-- Fin Cuerpo del documento -->
    </div>
    <!-- Footer -->
    <footer class="footer">
        <!-- Contenido del footer si es necesario -->
    </footer>

    <!-- JavaScript al final para mejorar la velocidad de carga -->
    <script src="../bootstrap/js/jquery-1.8.3.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <!-- JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Obtener la fecha actual en la zona horaria de Colombia
        var currentDate = new Date(new Date().toLocaleString("en-US", { timeZone: "America/Bogota" }));

        // Obtener todos los inputs de fecha de pedido
        var fechaPedidoInputs = document.getElementsByName("dias_pedido");

        fechaPedidoInputs.forEach(function(input) {
            // Obtener la fecha de pedido
            var pedidoDate = new Date(input.value + 'T00:00:00-05:00'); // Formato ISO con la zona horaria de Colombia

            // Calcular la diferencia en milisegundos
            var diff = pedidoDate - currentDate;

            // Convertir la diferencia a días
            var diffDays = Math.ceil(diff / (1000 * 60 * 60 * 24));

            // Si es el día del pedido, mostrar "Hoy es día de pedido"
            if (diffDays === 0) {
                alert("¡Hoy es el día del pedido!");
            }
            // Si la diferencia está entre 1 y 5 días, mostrar una alerta con los días restantes
            else if (diffDays > 0 && diffDays <= 5) {
                alert("¡Faltan " + diffDays + " días para el día del pedido!");
            }
        });
    });
    </script>
</body>
</html>

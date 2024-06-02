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
                <li class="Usuario">USUARIO: <strong><?php echo $_SESSION['user']; ?></strong></li>
            </ul>
        </nav>
        <!-- Fin Navbar -->

        <!-- Tabla de inventario existente -->
        <div class="row">
            <form method="post" action="index2.php">
                <button type="submit" class="btn_atras"><= ATRAS</button>
            </form>
            <div class="container_btn">
                <form method="post" action="#">
                    <button type="submit" class="btn_ing_art">CODIGO DE BARRAS</button>
                </form>
                <form method="post" action="ing_art_mte.php">
                    <button type="submit" class="btn_ped_sed">MANUALMENTE</button>
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
                                        require("../connect_db.php");
                                        $sql = "SELECT * FROM inventario";
                                        $query = mysqli_query($mysqli, $sql);

                                        echo "<table class='table table-hover'>";
                                        echo "<tr class='warning'>";
                                        echo "<td>Id</td>";
                                        echo "<td>ESTADO DE STOCK</td>";
                                        echo "<td>CODIGO ARTICULO</td>";
                                        echo "<td>NOMBRE</td>";
                                        echo "<td>PROVEEDOR</td>";
                                        echo "<td>DESCRIPCION</td>";
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
                                        }
                                        echo "</table>";

                                        extract($_GET);
                                        if (@$idborrar == 2) {
                                            $sqlborrar = "DELETE FROM inventario WHERE id=$id";
                                            $resborrar = mysqli_query($mysqli, $sqlborrar);
                                            echo '<script>alert("REGISTRO ELIMINADO")</script> ';
                                            echo "<script>location.href='index2.php'</script>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <!-- Fin Tabla de inventario existente -->
    </div>

    <!-- Footer -->
    <footer class="footer">
        <!-- Contenido del footer si es necesario -->
    </footer>

    <!-- JavaScript al final para mejorar la velocidad de carga -->
    <script src="../bootstrap/js/jquery-1.8.3.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
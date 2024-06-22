<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location:../../index.php");
    exit();
} elseif ($_SESSION['rol'] == 1) {
    header("Location:../../usu_admin/admin.php");
    exit();
}
?>

<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO DIAGNOSTICA</title>
    <link rel="stylesheet" href="../../css/estilos_sedes.css" />
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
                <li class="Usuario">USUARIO: <strong><?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
            </ul>
        </nav>
        <!-- Fin Navbar -->

        <!-- Notificación de pedido -->
        <div class="row">
            <div class="container_btn">
                <form method="post" action="pedido_sedes.php">
                    <button type="submit" class="btn_atras"><= ATRAS</button>
                </form>
                <form method="post" action="#">
                    <button type="submit" class="btn_crear_sede">CREAR SEDE</button>
                </form>
            </div>
            <div class="col-xs-12">
                <div class="caption">
                    <fieldset>
                        <legend style="font-size: 18pt"><b>ADMINISTRACIÓN DE SEDES</b></legend>
                        <div class="well">
                            <div class="row">
                                <div class="col-xs-12">

                                    <?php
                                    // Conectar a la base de datos
                                    require("../../connect_db.php");
                                    $sql = "SELECT * FROM sedes";
                                    $query = mysqli_query($mysqli, $sql);

                                    echo "<table class='table table-hover'>";
                                    echo "<tr class='warning'>";
                                    echo "<td>Id</td>";
                                    echo "<td>NOMBRE SEDE</td>";
                                    echo "<td>DIRECCIÓN</td>";
                                    echo "<td>BARRIO</td>";
                                    echo "<td>CIUDAD</td>";
                                    echo "<td>COORDINADOR</td>";
                                    echo "<td>TELEFONO</td>";
                                    echo "<td>Editar</td>";
                                    echo "<td>Borrar</td>";
                                    echo "</tr>";

                                    while ($arreglo = mysqli_fetch_array($query)) {

                                        echo "<tr class='success'>";
                                        echo "<td>$arreglo[0]</td>";
                                        echo "<td>$arreglo[1]</td>";
                                        echo "<td>$arreglo[2]</td>";
                                        echo "<td>$arreglo[3]</td>";
                                        echo "<td>$arreglo[4]</td>";
                                        echo "<td>$arreglo[5]</td>";
                                        echo "<td>$arreglo[6]</td>";
                                        echo "<td><a href='actualizar_productos.php?id=$arreglo[0]'><img src='../../images/actualizar.png' class='img-rounded'></a></td>";
                                        echo "<td><a href='index2.php?id=$arreglo[0]&idborrar=2'><img src='../../images/eliminar.png' class='img-rounded'/></a></td>";
                                        echo "</tr>";

                                    }
                                    echo "</table>";

                                    if (isset($_GET['idborrar']) && $_GET['idborrar'] == 2) {
                                        $id = $_GET['id'];
                                        $sqlborrar = "DELETE FROM sedes WHERE id=$id";
                                        $resborrar = mysqli_query($mysqli, $sqlborrar);

                                        if ($resborrar) {
                                            echo '<script>alert("REGISTRO ELIMINADO");</script>';
                                            echo '<script>location.href="sedes.php";</script>';
                                            exit();
                                        } else {
                                            $error_message = mysqli_error($mysqli);
                                            echo '<script>alert("Error al eliminar el artículo: ' . $error_message . '. Inténtelo de nuevo.");</script>';
                                            echo '<script>location.href="sedes.php";</script>';
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

</body>
</html>

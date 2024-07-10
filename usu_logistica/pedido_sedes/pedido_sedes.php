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

// Configurar la zona horaria a Colombia
date_default_timezone_set('America/Bogota');

// Conectar a la base de datos
require("../../connect_db.php");

// Obtener todos los días de pedido
$sql = "SELECT dias_pedido FROM inventario_sedes WHERE dias_pedido IS NOT NULL";
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
    <link rel="stylesheet" href="../../css/estilos_pedido_sedes.css" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <img class="logo-adm" src="../../images/logo-adm.png" alt="logo">
        <ul class="nav pull-right">
            <li>
                <form method="post" action="../../desconectar.php">
                    <button  class="cerrar_sesion">CERRAR SESIÓN</button>
                </form>
            </li>
            <li class="Usuario">USUARIO: <strong><?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
        </ul>
    </nav>
    <!-- Fin Navbar -->
     <div class="container">
        <form method="post" action="../index2.php">
            <button  class="btn_atras"><= ATRAS</button>
        </form>  
        <form method="post" action="sedes.php">
            <button  class="btn_sedes">SEDES</button>
        </form> 
     </div>

    <div class="container">
        <div class="sidebar">
            <form method="post" action="asignar_productos.php">
                <button type="submit" class="btn_ing_art">ASIGNAR PRODUCTOS</button>
            </form>
            <form method="post" action="#">
                <button type="submit" class="btn_ped_sed">PEDIDO POR SEDES</button>
            </form>
            <form method="post" action="#">
                <button type="submit" class="btn_proveedores">GENERAR PEDIDO</button>
            </form>
            <form method="post" action="#">
                <button type="submit" class="btn_gen_rep">CANCELAR PEDIDO</button>
            </form>
        </div>

        <div class="main-content">
            <fieldset>
                <legend style="font-size: 18pt"><b>ADMINISTRACIÓN DE INVENTARIO</b></legend>
                <div class="well">
                    <div class="row">
                        <div class="col-xs-12">
                            <?php
                            $sql = "SELECT * FROM inventario_sedes";
                            $query = mysqli_query($mysqli, $sql);

                            echo "<table class='table table-hover'>";
                            echo "<tr class='warning'>";
                            echo "<td>Id</td>";
                            echo "<td>SEDE</td>";
                            echo "<td>CODIGO ARTICULO</td>";
                            echo "<td>NOMBRE</td>";
                            echo "<td>DESCRIPCCION</td>";
                            echo "<td>CANTIDAD EN STOCK</td>";
                            echo "<td>CANTIDAD STOCK MINIMO</td>";
                            echo "<td>DIAS DE PEDIDO</td>";
                            echo "<td>CANTIDAD NUEVO PEDIDO</td>";
                            echo "<td>Editar</td>";
                            echo "<td>Borrar</td>";
                            echo "</tr>";

                            while ($arreglo = mysqli_fetch_array($query)) {
                                echo "<tr class='success'>";
                                echo "<td>{$arreglo['id']}</td>"; 
                                echo "<td>{$arreglo['sede']}</td>";
                                echo "<td>{$arreglo['codigo_art']}</td>";
                                echo "<td>{$arreglo['nombre_art']}</td>";
                                echo "<td>{$arreglo['descrip']}</td>";
                                echo "<td>{$arreglo['cantidad']}</td>";
                                echo "<td>{$arreglo['cantidad_stock_minimo']}</td>";
                                echo "<td><input type='date' name='dias_pedido' value='{$arreglo['dias_pedido']}'></td>";
                                echo "<td>{$arreglo['cantidad_nvo_ped']}</td>";
                                echo "<td><a href='actualizar_productos.php?id={$arreglo['id']}'><img src='../../images/actualizar.png' class='img-rounded'></a></td>";
                                echo "<td><a href='pedido_sedes.php?id={$arreglo['id']}&idborrar=2'><img src='../../images/eliminar.png' class='img-rounded'/></a></td>";
                                echo "</tr>";
                            }
                            echo "</table>";

                            if (isset($_GET['idborrar']) && $_GET['idborrar'] == 2) {
                                $id_borrar = $_GET['id'];
                                $sql_borrar = "DELETE FROM inventario_sedes WHERE id='$id_borrar'";
                                $query_borrar = mysqli_query($mysqli, $sql_borrar);
                                echo '<script>alert("REGISTRO ELIMINADO")</script>';
                                echo "<script>location.href='pedido_sedes.php'</script>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</body>
</html>

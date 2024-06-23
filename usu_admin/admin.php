<!DOCTYPE html>
<?php
session_start();
if (@!$_SESSION['user']) {
    header("<Location:usu_admin>index.php");
} elseif ($_SESSION['rol'] == 2) {
    header("Location:../index2.php");
}
?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO DIAGNOSTICA</title>
    <link rel="stylesheet" href="../css/estilos_adm.css" />
</head>

<body>
    <div class="container">
        <!-- Navbar -->
        <nav class="navbar">
                <img class="logo-adm"src="../images/logo-adm.png" alt="logo">
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

        <!-- Cuerpo del documento -->
        <div class="row">
            <div class="container_btn">
                <form method="post" action="crear_usuario.php">
                    <button type="submit" class="btn_crear_usu">CREAR USUARIO</button>
                </form> 
                <form method="post" action="#">
                    <button type="submit" class="btn_reportes_adm">REPORTES</button>
                </form> 
            </div>
            <div class="col-xs-12">
                <div class="caption">
                    <fieldset>
                    <legend  style="font-size: 18pt"><b>ADMINISTRACIÓN DE USUARIOS</b></legend>
                    <div class="well">
                           <div class="row">
                               <div class="col-xs-12">
                                   <?php
                                        require("../connect_db.php");
                                            $sql = "SELECT * FROM login";
                                            $query = mysqli_query($mysqli, $sql);

                                            echo "<table class='table table-hover'>";
                                            echo "<tr class='warning'>";
                                            echo "<td>Id</td>";
                                            echo "<td>Usuario</td>";
                                            echo "<td>Password</td>";
                                            echo "<td>Correo</td>";
                                            echo "<td>rol del usuario</td>";
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
                                            echo "<td><a href='actualizar.php?id=$arreglo[0]'><img src='../images/actualizar.png' class='img-rounded'></a></td>";
                                            echo "<td><a href='admin.php?id=$arreglo[0]&idborrar=2'><img src='../images/eliminar.png' class='img-rounded'/></a></td>";
                                            echo "</tr>";
                                            }
                                            echo "</table>";
                                            extract($_GET);
                                            if (@$idborrar == 2) {
                                            $sqlborrar = "DELETE FROM login WHERE id=$id";
                                            $resborrar = mysqli_query($mysqli, $sqlborrar);
                                            echo '<script>alert("REGISTRO ELIMINADO")</script> ';
                                            echo "<script>location.href='admin.php'</script>";
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

<!DOCTYPE html>
<?php
session_start();
if (@!$_SESSION['user']) {
    header("Location:usu_admin>index.php");
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
            <img class="logo-adm" src="../images/logo-adm.png" alt="logo">
            <ul class="nav pull-right">
                <li>
                    <form method="post" action="../desconectar.php">
                        <button type="submit" class="cerrar_sesion">CERRAR SESIÓN</button>
                    </form>
                </li>
                <nav>
                    <li class="Usuario">USUARIO: <strong><?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
                    <li class="rol">ROL: <strong><?php echo htmlspecialchars($_SESSION['rol'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
                </nav>
            </ul>
        </nav>
        <!-- Fin Navbar -->

        <!-- Menú responsive -->
        <div class="dropdown">
            <button class="dropdown-btn" onclick="toggleDropdown()"><img src='../images/menu3.png' class='img-menu' ></button>
            <div class="dropdown-content">
                <a href="crear_usuario.php">CREAR USUARIO</a>
                <a href="#">REPORTES</a>
            </div>
        </div>

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

            <div class="table-container">
                <fieldset>
                    <table class="table-usuarios">
                        <legend style="font-size: 18pt"><b>ADMINISTRACIÓN DE USUARIOS</b></legend>
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
                                        echo "<td>sede</td>";
                                        echo "<td>Editar</td>";
                                        echo "<td>Borrar</td>";
                                        echo "</tr>";

                                        while ($arreglo = mysqli_fetch_array($query)) {
                                            echo "<tr class='success'>";
                                            echo "<td>{$arreglo[0]}</td>";
                                            echo "<td>{$arreglo[1]}</td>";
                                            echo "<td>{$arreglo[2]}</td>";
                                            echo "<td>{$arreglo[3]}</td>";
                                            echo "<td>{$arreglo[4]}</td>";
                                            echo "<td>{$arreglo[5]}</td>";
                                            echo "<td><a href='actualizar.php?id={$arreglo[0]}'><img src='../images/actualizar.png' class='img-rounded'></a></td>";
                                            echo "<td><a href='usuarios_admin.php?id={$arreglo[0]}&idborrar=2'><img src='../images/eliminar.png' class='img-rounded'/></a></td>";
                                            echo "</tr>";
                                        }

                                        echo "</table>";

                                        if (isset($_GET['idborrar']) && $_GET['idborrar'] == 2) {
                                            $sqlborrar = "DELETE FROM login WHERE id=" . $_GET['id'];
                                            $resborrar = mysqli_query($mysqli, $sqlborrar);
                                            echo '<script>alert("REGISTRO ELIMINADO")</script>';
                                            echo "<script>location.href='usuarios_admin.php'</script>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </table>
                </fieldset>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            var dropdown = document.querySelector('.dropdown');
            dropdown.classList.toggle('show');
        }
    </script>
</body>
</html>

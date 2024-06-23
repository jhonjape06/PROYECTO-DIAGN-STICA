<!DOCTYPE html>
<?php
session_start();
if (!$_SESSION['user']) {
    header("Location:../index.php");
    exit(); // Finaliza el script para evitar ejecución adicional
}
?>		
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO DIAGNOSTICA</title>
    <link rel="stylesheet" href="../css/estilos_actualizar.css" />
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
        <div class="row">	
            <form method="post" action="admin.php">
                <button type="submit" class="btn_crear_usu"><= ATRAS</button>
            </form> 
            <div class="row-fluid">
                <fieldset>
                    <legend style="font-size: 18pt"><b>EDICIÓN DE USUARIOS</b></legend>
                    <?php
                        extract($_GET);
                        require("../connect_db.php");
                        $sql = "SELECT * FROM login WHERE id=$id";
                        $ressql = mysqli_query($mysqli, $sql);
                        while ($row = mysqli_fetch_row($ressql)) {
                            $id = $row[0];
                            $user = $row[1];
                            $pass = $row[2];
                            $email = $row[3];
                            $rol = $row[4];
                        }
                    ?>
                    <form action="ejecutaactualizar.php" method="post">
                        ID<br> 
                        <input type="text" name="id" value="<?php echo $id ?>" readonly="readonly"><br><br>
                        
                        USUARIO<br> 
                        <input type="text" name="user" value="<?php echo $user ?>"><br><br>
                        
                        CONTRASEÑA USUARIO<br> 
                        <input type="text" name="pass" value="<?php echo $pass ?>"><br><br>
                        
                        CORREO USUARIO<br> 
                        <input type="text" name="email" value="<?php echo $email ?>"><br><br>
                        
                        ROL DEL USUARIO<br> 
                        <select name="rol" class="form-control" required>
                            <option value="administrador" <?php if ($rol == 'administrador') echo 'selected'; ?>>Administrador</option>
                            <option value="logistica" <?php if ($rol == 'logistica') echo 'selected'; ?>>Logística</option>
                            <option value="sede" <?php if ($rol == 'sede') echo 'selected'; ?>>Sede</option>
                            <!-- Añadir más opciones según los roles disponibles -->
                        </select><br><br>
                        
                        <input type="submit" value="GUARDAR" class="btn btn-success btn-primary">
                    </form>
                </fieldset>	
            </div>
            <!-- Fin del cuerpo del documento -->
        </div>
    </div>
    <!-- JavaScript al final para mejorar la velocidad de carga -->
    <script src="../bootstrap/js/jquery-1.8.3.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

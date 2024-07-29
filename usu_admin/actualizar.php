<!DOCTYPE html>
<?php
session_start();
if (!$_SESSION['user']) {
    header("Location:../index.php");
    exit(); // Finaliza el script para evitar ejecución adicional
}

// Conectar a la base de datos
require("../connect_db.php");

// Obtener las sedes
$sql_sedes = "SELECT nombre_sede FROM sedes";
$result_sedes = $mysqli->query($sql_sedes);
$sedes = [];
if ($result_sedes->num_rows > 0) {
    while ($row_sede = $result_sedes->fetch_assoc()) {
        $sedes[] = $row_sede;
    }
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
                <nav>
                    <li class="Usuario">USUARIO: <strong><?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
                    <li class="rol">ROL: <strong><?php echo htmlspecialchars($_SESSION['rol'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
                </nav>
            </ul>
        </nav>
        <div class="row">    
            <form method="post" action="admin.php">
                <button type="submit" class="btn_atras"><= ATRAS</button>
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
                            $nombre_sede = $row[5];
                        }
                    ?>
                    <form action="ejecutaactualizar.php" method="post">
                        ID<br> 
                        <input type="text" name="id" value="<?php echo $id ?>" readonly="readonly"><br><br>
                        
                        USUARIO<br> 
                        <input type="text" name="user" value="<?php echo htmlspecialchars($user, ENT_QUOTES, 'UTF-8'); ?>"><br><br>
                        
                        CONTRASEÑA USUARIO<br> 
                        <input type="text" name="pass" value="<?php echo htmlspecialchars($pass, ENT_QUOTES, 'UTF-8'); ?>"><br><br>
                        
                        CORREO USUARIO<br> 
                        <input type="text" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>"><br><br>
                        
                        ROL DEL USUARIO<br> 
                        <select name="rol" class="form-control" required>
                            <option value="administrador" <?php if ($rol == 'administrador') echo 'selected'; ?>>Administrador</option>
                            <option value="logistica" <?php if ($rol == 'logistica') echo 'selected'; ?>>Logística</option>
                            <option value="sede" <?php if ($rol == 'sede') echo 'selected'; ?>>Sede</option>
                            <!-- Añadir más opciones según los roles disponibles -->
                        </select><br><br>

                        SEDE<br> 
                        <select id="nombre_sede" name="nombre_sede" class="form-control" required>
                            <option value="">Selecciona una sede</option>
                            <option value="NO APLICA" <?php if ($nombre_sede == 'NO APLICA') echo 'selected'; ?>>NO APLICA</option>
                            <?php foreach ($sedes as $sede): ?>
                                <option value="<?php echo htmlspecialchars($sede['nombre_sede'], ENT_QUOTES, 'UTF-8'); ?>" <?php if ($sede['nombre_sede'] == $nombre_sede) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($sede['nombre_sede'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
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

<!DOCTYPE html>
<?php
session_start();
if (@!$_SESSION['user']) {
    header("Location:../index.php");
}
?>      
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO DIAGNOSTICA</title>
    <link rel="stylesheet" href="../css/estilos_actualizar.css" />
    <script>registrar_art.php</script>
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
                <li class="Usuario">USUARIO: <strong><?php echo $_SESSION['user']; ?></strong></li>
            </ul>
        </nav>
        <div class="row">  
            <form method="post" action="index2.php">
                <button type="submit" class="btn_crear_usu"><= ATRAS</button>
            </form> 
            <div class="row-fluid">
                <fieldset>
                    <legend style="font-size: 18pt"><b>EDICIÓN DE USUARIOS</b></legend>
                    <?php
                        extract($_GET);
                        require("../connect_db.php");
                        $sql="SELECT * FROM inventario WHERE id=$id";
                        //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
                        $ressql=mysqli_query($mysqli,$sql);
                        while ($row=mysqli_fetch_row ($ressql)){
                            $id=$row[0];
                            $codigo_art=$row[2];
                            $nombre_art=$row[3];
                            $proveedor=$row[4];
                            $descrip=$row[5];
                            $valor_art=$row[6];
                            $cantidad=$row[7];
                            $cantidad_stock_minimo=$row[9];
                            $dias_pedido=$row[10];
                            $cantidad_nvo_ped=$row[11];
                            $articulo_descontinuado=$row[12];
                        }
                    ?>
                    <form action="ejecutar_actualizar_prod.php" method="post">
                        ID<br> <input type="text" name="id" value= "<?php echo $id ?>" readonly="readonly"><br><br>
                        CODIGO ARTICULO<br> <input type="text" name="codigo_art" value= "<?php echo $codigo_art ?>" oninput="toUpperCaseField(this)"><br><br>
                        NOMBRE<br> <input type="text" name="nombre_art" value="<?php echo $nombre_art?>" oninput="toUpperCaseField(this)"><br><br>
                        PROVEEDOR<br> <input type="text" name="proveedor" value="<?php echo $proveedor?>" oninput="toUpperCaseField(this)"><br><br>
                        DESCRIPCION<br> <input type="text" name="descrip" value="<?php echo $descrip?>" oninput="toUpperCaseField(this)"><br><br>
                        VALOR POR ARTICULO<br> <input type="text" name="valor_art" value="<?php echo $valor_art?>"><br><br>
                        CANTIDAD EN STOCK<br> <input type="text" name="cantidad" value="<?php echo $cantidad?>"><br><br>
                        CANTIDAD STOCK MINIMO<br> <input type="text" name="cantidad_stock_minimo" value="<?php echo $cantidad_stock_minimo?>"><br><br>
                        DIAS DE PEDIDO<br> <input type="date" name="dias_pedido" value="<?php echo $dias_pedido ?>"><br><br>
                        CANTIDAD NUEVO PEDIDO<br> <input type="text" name="cantidad_nvo_ped" value="<?php echo $cantidad_nvo_ped?>"><br><br>
                        ARTICULO DESCONTINUADO<br> 
                        <select name="articulo_descontinuado" class="articulo_descontinuado">
                            <option value="Sí" <?php if($articulo_descontinuado == 'Sí') echo 'selected'; ?>>Sí</option>
                            <option value="No" <?php if($articulo_descontinuado == 'No') echo 'selected'; ?>>No</option>
                        </select><br><br>
                        <input type="submit" value="GUARDAR" class="btn btn-success btn-primary">
                    </form>
                </fieldset>    
            </div>  
            <!--///////////////////////////////////////////////////Termina cuerpo del documento interno////////////////////////////////////////////-->
        </div>
    </div>
    <!-- JavaScript al final para mejorar la velocidad de carga -->
    <script src="../bootstrap/js/jquery-1.8.3.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<script>
    // Obtener la fecha actual en formato YYYY-MM-DD
    var currentDate = new Date().toISOString().slice(0,10);

    // Obtener la fecha de pedido del input
    var fechaPedido = document.getElementsByName("dias_pedido")[0].value;

    // Si la fecha de pedido coincide con la fecha actual, mostrar una alerta
    if (fechaPedido === currentDate) {
        alert("¡Hoy es el día del pedido!");
    }
</script>

</body>
</html>

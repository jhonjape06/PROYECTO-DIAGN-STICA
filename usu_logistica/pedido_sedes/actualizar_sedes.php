<!DOCTYPE html>
<?php
session_start();
if (@!$_SESSION['user']) {
	header("Location:../../index.php");
}
?>		
<html lang="en">
    <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>PROYECTO DIAGNOSTICA</title>
       <link rel="stylesheet" href="../../css/estilos_actualizar_sedes.css" />
	   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Convertir a mayúsculas al momento de entrada
            $('input[type="text"]').on('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
    </script>
   </head>
   <body>
        <div class="container">
           <!-- Navbar -->
           <nav class="navbar">
               <img class="logo-adm"src="../../images/logo-adm.png" alt="logo">
               <ul class="nav pull-right">
                   <li>
                       <form method="post" action="../../desconectar.php">
                           <button type="submit" class="cerrar_sesion">CERRAR SESIÓN</button>
                       </form>
                   </li>
                <nav>
                <li class="Usuario">USUARIO: <strong><?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
                <li class="Usuario">ROL: <strong><?php echo htmlspecialchars($_SESSION['rol'], ENT_QUOTES, 'UTF-8'); ?></strong></li>
                </nav>
               </ul>
           </nav>
           <div class="row">	
               <form method="post" action="sedes.php">
                   <button type="submit" class="btn_atras"><= ATRAS</button>
               </form> 
		        <div class="row-fluid">
					<fieldset>
						<legend  style="font-size: 18pt"><b>EDICIÓN DE SEDES</b></legend>
		                <?php
		                    extract($_GET);
		                    require("../../connect_db.php");
		                    $sql="SELECT * FROM sedes WHERE id=$id";
	                        //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
		                    $ressql=mysqli_query($mysqli,$sql);
		                    while ($row=mysqli_fetch_row ($ressql)){
		    	            $id=$row[0];
		    	            $nombre_sede=$row[1];
		    	            $direccion=$row[2];
		    	            $barrio=$row[3];
		    	            $ciudad=$row[4];
		    	            $coordinador=$row[5];
							$telefono=$row[6];
		                    }
		                ?>
		                <form action="ejecutar_actualizar_sedes.php" method="post">
				            ID<br> <input type="text" name="id" value= "<?php echo $id ?>" readonly="readonly"><br>
							<br>
				            NOMBRE SEDE<br> <input type="text" name="nombre_sede" value="<?php echo $nombre_sede?>"><br>
							<br>
				            DIRECCIÓN<br> <input type="text" name="direccion" value="<?php echo $direccion?>"><br>
							<br>
				            BARRIO<br> <input type="text" name="barrio" value="<?php echo $barrio?>"><br>
							<br>
				            CIUDAD<br> <input type="text" name="ciudad" value="<?php echo $ciudad?>"><br>
							<br>
							COORDINADOR<br> <input type="text" name="coordinador" value="<?php echo $coordinador?>"><br>
                            <br>
							TELEFONO<br> <input type="text" name="telefono" value="<?php echo $telefono?>"><br>
							<br>
				            <br>
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
    </body>
</html>
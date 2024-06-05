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
       <link rel="stylesheet" href="../../css/estilos_actualizar_proveedores.css" />
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
                   <li class="Usuario">USUARIO: <strong><?php echo $_SESSION['user']; ?></strong></li>
               </ul>
           </nav>
           <div class="row">	
               <form method="post" action="proveedores.php">
                   <button type="submit" class="btn_atras"><= ATRAS</button>
               </form> 
		        <div class="row-fluid">
					<fieldset>
						<legend  style="font-size: 18pt"><b>EDICIÓN DE PROVEEDORES</b></legend>
		                <?php
		                    extract($_GET);
		                    require("../../connect_db.php");
		                    $sql="SELECT * FROM proveedores WHERE id=$id";
	                        //la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
		                    $ressql=mysqli_query($mysqli,$sql);
		                    while ($row=mysqli_fetch_row ($ressql)){
		    	            $id=$row[0];
		    	            $nit=$row[1];
		    	            $empresa=$row[2];
		    	            $contacto=$row[3];
		    	            $telefono=$row[4];
		    	            $direccion=$row[5];
							$ciudad=$row[6];
                            $correo=$row[7];
		                    }
		                ?>
		                <form action="ejecutar_actualizar_proveedor.php" method="post">
				            ID<br> <input type="text" name="id" value= "<?php echo $id ?>" readonly="readonly"><br>
							<br>
				            NIT<br> <input style="" type="text" name="nit" value="<?php echo $nit?>"><br>
							<br>
				            EMPRESA<br> <input type="text" name="empresa" value="<?php echo $empresa?>"><br>
							<br>
				            CONTACTO<br> <input type="text" name="contacto" value="<?php echo $contacto?>"><br>
							<br>
				            TELEFONO<br> <input type="text" name="telefono" value="<?php echo $telefono?>"><br>
							<br>
							DIRECCIÓN<br> <input type="text" name="direccion" value="<?php echo $direccion?>"><br>
                            <br>
							CIUDAD<br> <input type="text" name="ciudad" value="<?php echo $ciudad?>"><br>
							<br>
							CORREO<br> <input type="text" name="correo" value="<?php echo $correo?>">
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
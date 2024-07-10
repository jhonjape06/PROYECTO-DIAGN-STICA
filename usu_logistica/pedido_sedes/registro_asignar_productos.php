<?php

	$nombre_sede=$_POST['nombre_sede'];
	$direccion=$_POST['direccion'];
	$barrio= $_POST['barrio'];
	$ciudad=$_POST['ciudad'];
	$coordinador= $_POST['coordinador'];
    $telefono= $_POST['telefono'];

	require("../../connect_db.php");
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
	$checkemail=mysqli_query($mysqli,"SELECT * FROM inventario_sedes WHERE nombre_sede='$nombre_sede'");
	$check_mail=mysqli_num_rows($checkemail);
			if($check_mail>0){
				echo ' <script language="javascript">alert("Atencion, ya está registrada la sede, verifique los datos");</script> ';
                echo "<script>location.href='crear_sede.php'</script>";
			}else{
				
				require("../../connect_db.php");
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
				mysqli_query($mysqli,"INSERT INTO sedes VALUES('','$nombre_sede','$direccion','$barrio','$ciudad','$coordinador','$telefono')");
				//echo 'Se ha registrado con exito';
				echo ' <script language="javascript">alert("Sede registrada con éxito");</script> ';
				echo "<script>location.href='sedes.php'</script>";
			}

?>

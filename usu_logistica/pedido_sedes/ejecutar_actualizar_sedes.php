<?php


extract($_POST);	//extraer todos los valores del metodo post del formulario de actualizar
	require("../../connect_db.php");
	$sentencia="update sedes set nombre_sede='$nombre_sede', direccion='$direccion', barrio='$barrio', ciudad='$ciudad', coordinador='$coordinador' , telefono='$telefono' where id='$id'";
	//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
	$resent=mysqli_query($mysqli,$sentencia);
	if ($resent==null) {
		echo "Error de procesamieno no se han actuaizado los datos";
		echo '<script>alert("ERROR EN PROCESAMIENTO NO SE ACTUALIZARON LOS DATOS")</script> ';
		header("location: actualizar_sedes.php");
		
		echo "<script>location.href='sedes.php'</script>";
	}else {
		echo '<script>alert("REGISTRO ACTUALIZADO")</script> ';
		
		echo "<script>location.href='sedes.php'</script>";

		
	}
?>
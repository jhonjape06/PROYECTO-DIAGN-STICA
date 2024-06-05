<?php


extract($_POST);	//extraer todos los valores del metodo post del formulario de actualizar
	require("../../connect_db.php");
	$sentencia="update proveedores set nit='$nit', empresa='$empresa', contacto='$contacto', telefono='$telefono', direccion='$direccion' , ciudad='$ciudad' , correo='$correo' where id='$id'";
	//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
	$resent=mysqli_query($mysqli,$sentencia);
	if ($resent==null) {
		echo "Error de procesamieno no se han actuaizado los datos";
		echo '<script>alert("ERROR EN PROCESAMIENTO NO SE ACTUALIZARON LOS DATOS")</script> ';
		header("location: actualizar_proveedor.php");
		
		echo "<script>location.href='proveedores.php'</script>";
	}else {
		echo '<script>alert("REGISTRO ACTUALIZADO")</script> ';
		
		echo "<script>location.href='proveedores.php'</script>";

		
	}
?>
<?php

	$nit=$_POST['nit'];
	$empresa=$_POST['empresa'];
	$contacto= $_POST['contacto'];
	$telefono=$_POST['telefono'];
	$direccion= $_POST['direccion'];
    $ciudad= $_POST['ciudad'];
    $correo= $_POST['correo'];

	require("../../connect_db.php");
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
	$checkemail=mysqli_query($mysqli,"SELECT * FROM proveedores WHERE nit='$nit'");
	$check_mail=mysqli_num_rows($checkemail);
			if($check_mail>0){
				echo ' <script language="javascript">alert("Atencion, ya está registrado el nit, verifique los datos");</script> ';
                echo "<script>location.href='crear_proveedor.php'</script>";
			}else{
				
				//require("../../connect_db.php");
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
				mysqli_query($mysqli,"INSERT INTO proveedores VALUES('','$nit','$empresa','$contacto','$telefono','$direccion','$ciudad','$correo')");
				//echo 'Se ha registrado con exito';
				echo ' <script language="javascript">alert("Proveedor registrado con éxito");</script> ';
				echo "<script>location.href='proveedores.php'</script>";
			}


?>
<script>
function validarFormulario() {
    var nit = document.getElementById('nit').value.trim();
    var empresa = document.getElementById('empresa').value.trim();
    var contacto = document.getElementById('contacto').value.trim();
    var telefono = document.getElementById('telefono').value.trim();
    var direccion = document.getElementById('direccion').value.trim();
    var ciudad = document.getElementById('ciudad').value.trim();
    var correo = document.getElementById('correo').value.trim();

    if (nit === '' || empresa === '' || contacto === '' || telefono === '' || direccion === '' ciudad === '' correo === '') {
        alert('Por favor, complete todos los campos.');
        return false;
    }


    // Validación de correo electrónico simple
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(correo)) {
        alert('Por favor, ingrese un correo electrónico válido.');
        return false;
    }

    return true; // Si todo está bien, se envía el formulario
}
</script>

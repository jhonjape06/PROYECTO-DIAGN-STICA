<?php

	$realname=$_POST['realname'];
	$mail=$_POST['nick'];
	$pass= $_POST['pass'];
	$rpass=$_POST['rpass'];
	$rol= $_POST['rol'];

	require("../connect_db.php");
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
	$checkemail=mysqli_query($mysqli,"SELECT * FROM login WHERE email='$mail'");
	$check_mail=mysqli_num_rows($checkemail);
		if($pass==$rpass){
			if($check_mail>0){
				echo ' <script language="javascript">alert("Atencion, ya existe el mail designado para un usuario, verifique sus datos");</script> ';
			}else{
				
				//require("connect_db.php");
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
				mysqli_query($mysqli,"INSERT INTO login VALUES('','$realname','$pass','$mail','$rol')");
				//echo 'Se ha registrado con exito';
				echo ' <script language="javascript">alert("Usuario registrado con éxito");</script> ';
				echo "<script>location.href='admin.php'</script>";
			}
			
		}else{
			echo 'Las contraseñas son incorrectas';
			echo "<script>location.href='crear_usuario.php'</script>";
		}


?>
<script>
function validarFormulario() {
    var realname = document.getElementById('realname').value.trim();
    var mail = document.getElementById('nick').value.trim();
    var pass = document.getElementById('pass').value.trim();
    var rpass = document.getElementById('rpass').value.trim();
    var rol = document.getElementById('rol').value.trim();

    if (realname === '' || mail === '' || pass === '' || rpass === '' || rol === '') {
        alert('Por favor, complete todos los campos.');
        return false;
    }

    if (pass !== rpass) {
        alert('Las contraseñas no coinciden.');
        return false;
    }

    // Validación de correo electrónico simple
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(mail)) {
        alert('Por favor, ingrese un correo electrónico válido.');
        return false;
    }

    return true; // Si todo está bien, se envía el formulario
}
</script>

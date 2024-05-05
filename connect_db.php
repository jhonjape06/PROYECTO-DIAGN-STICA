<?php


$mysqli = new MySQLi("localhost", "root", "", "bd-diagnostica-ips");
if ($mysqli->connect_errno) {
    die("Fallo la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

		else
			//echo "Conexión exitossa!";

//	$link =mysqli_connect("localhost","root","");
//	if($link){
//		mysqli_select_db($link,"bd-diagnostica-ips");
//	}
?>
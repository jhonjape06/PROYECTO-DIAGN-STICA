<?php
extract($_POST); // Extraer todos los valores del método POST del formulario de actualizar

require("../connect_db.php");

// Obtener el valor actual del artículo
$query = "SELECT valor_art FROM inventario WHERE id='$id'";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
$valor_art = isset($valor_art) ? $valor_art : $row['valor_art'];

// Calcular el nuevo valor total
$valor_total = $cantidad * $valor_art;

$sentencia = "UPDATE inventario 
              SET codigo_art='$codigo_art', 
                  nombre_art='$nombre_art', 
                  proveedor='$proveedor', 
                  descrip='$descrip', 
                  valor_art='$valor_art', 
                  cantidad='$cantidad', 
                  valor_total='$valor_total', 
                  cantidad_stock_minimo='$cantidad_stock_minimo', 
                  dias_pedido='$dias_pedido', 
                  cantidad_nvo_ped='$cantidad_nvo_ped', 
                  articulo_descontinuado='$articulo_descontinuado'  
              WHERE id='$id'";

// La variable $mysqli viene de connect_db que lo traigo con el require("connect_db.php")
$resent = mysqli_query($mysqli, $sentencia);

if ($resent == null) {
    echo "Error de procesamiento, no se han actualizado los datos";
    echo '<script>alert("ERROR EN PROCESAMIENTO, NO SE ACTUALIZARON LOS DATOS")</script>';
    echo "<script>location.href='index2.php'</script>";
} else {
    echo '<script>alert("REGISTRO ACTUALIZADO")</script>';
    echo "<script>location.href='index2.php'</script>";
}
?>

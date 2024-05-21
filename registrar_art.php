<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location:index.php");
    exit();
} elseif ($_SESSION['rol'] == 1) {
    header("Location:admin.php");
    exit();
}

// Conectar a la base de datos
require("connect_db.php");

// Obtener valores del formulario y sanitizarlos
$codigo_art = isset($_POST['codigo_art']) ? mysqli_real_escape_string($mysqli, $_POST['codigo_art']) : '';
$nombre_art = isset($_POST['nombre_art']) ? mysqli_real_escape_string($mysqli, $_POST['nombre_art']) : '';
$proveedor = isset($_POST['proveedor']) ? mysqli_real_escape_string($mysqli, $_POST['proveedor']) : '';
$descrip = isset($_POST['descrip']) ? mysqli_real_escape_string($mysqli, $_POST['descrip']) : '';
$valor_art = isset($_POST['valor_art']) ? mysqli_real_escape_string($mysqli, $_POST['valor_art']) : '';
$cantidad = isset($_POST['cantidad']) ? (int) $_POST['cantidad'] : 0;

// Asegurarse de que todos los campos estén completos
if (empty($codigo_art) || empty($nombre_art) || empty($proveedor) || empty($descrip) || empty($valor_art) || $cantidad <= 0) {
    echo '<script language="javascript">alert("Por favor, complete todos los campos.");</script>';
    echo "<script>location.href='ingresar_articulos.php'</script>";
    exit();
}

// Comprobar si el artículo ya existe por su código
$checkArt = mysqli_query($mysqli, "SELECT * FROM inventario WHERE codigo_art='$codigo_art'");
$check_art_count = mysqli_num_rows($checkArt);

if ($check_art_count > 0) {
    // El artículo existe con este código, comprobar si otros campos coinciden
    while ($row = mysqli_fetch_assoc($checkArt)) {
        if ($nombre_art === $row['nombre_art'] && $proveedor === $row['proveedor'] && $descrip === $row['descrip'] && $valor_art === $row['valor_art']) {
            // Todos los campos coinciden, actualizar solo la cantidad
            $nueva_cantidad = $row['cantidad'] + $cantidad;
            $update_query = "UPDATE inventario SET cantidad='$nueva_cantidad' WHERE id='{$row['id']}'";
            $update_result = mysqli_query($mysqli, $update_query);

            if ($update_result) {
                echo '<script language="javascript">alert("Registro actualizado exitosamente.");</script>';
                echo "<script>location.href='ing_art_mte.php'</script>";
                exit();
            } else {
                echo '<script language="javascript">alert("Error al actualizar el registro. Inténtelo de nuevo.");</script>';
                echo "<script>location.href='ingresar_articulos.php'</script>";
                exit();
            }
        }
    }
}

// Si llegamos aquí, significa que no se encontró un artículo existente con los mismos campos, entonces insertamos uno nuevo
$insert_query = "INSERT INTO inventario (codigo_art, nombre_art, proveedor, descrip, valor_art, cantidad) VALUES ('$codigo_art', '$nombre_art', '$proveedor', '$descrip', '$valor_art', '$cantidad')";
$insert_result = mysqli_query($mysqli, $insert_query);

if ($insert_result) {
    echo '<script language="javascript">alert("Artículo registrado con éxito");</script>';
    echo "<script>location.href='ing_art_mte.php'</script>";
} else {
    echo '<script language="javascript">alert("Error al registrar el artículo. Inténtelo de nuevo.");</script>';
    echo "<script>location.href='ingresar_articulos.php'</script>";
}
?>

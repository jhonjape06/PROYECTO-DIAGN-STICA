<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location:../index.php");
    exit();
} elseif ($_SESSION['rol'] == 1) {
    header("Location:../usu_admin/admin.php");
    exit();
}

// Conectar a la base de datos
require("../connect_db.php");

// Obtener valores del formulario y sanitizarlos
$codigo_art = isset($_POST['codigo_art']) ? mysqli_real_escape_string($mysqli, $_POST['codigo_art']) : '';
$nombre_art = isset($_POST['nombre_art']) ? mysqli_real_escape_string($mysqli, $_POST['nombre_art']) : '';
$proveedor = isset($_POST['proveedor']) ? mysqli_real_escape_string($mysqli, $_POST['proveedor']) : '';
$descrip = isset($_POST['descrip']) ? mysqli_real_escape_string($mysqli, $_POST['descrip']) : '';
$valor_art = isset($_POST['valor_art']) ? (float) mysqli_real_escape_string($mysqli, $_POST['valor_art']) : 0;
$cantidad = isset($_POST['cantidad']) ? (int) $_POST['cantidad'] : 0;
$cantidad_stock_minimo = isset($_POST['cantidad_stock_minimo']) ? (int) $_POST['cantidad_stock_minimo'] : 0;
$articulo_descontinuado = isset($_POST['articulo_descontinuado']) ? mysqli_real_escape_string($mysqli, $_POST['articulo_descontinuado']) : '';

// Asegurarse de que todos los campos estén completos
if (empty($codigo_art) || empty($nombre_art) || empty($proveedor) || empty($descrip) || $valor_art <= 0 || $cantidad == 0) {
    echo '<script language="javascript">alert("Por favor, complete todos los campos.");</script>';
    echo "<script>location.href='ingresar_articulos.php'</script>";
    exit();
}

// Comprobar si el artículo ya existe por su código
$checkArt = mysqli_query($mysqli, "SELECT * FROM inventario WHERE codigo_art='$codigo_art'");
$check_art_count = mysqli_num_rows($checkArt);

if ($check_art_count > 0) {
    // El artículo existe con este código, actualizar la cantidad y el valor total
    while ($row = mysqli_fetch_assoc($checkArt)) {
        $nueva_cantidad = $row['cantidad'] + $cantidad;
        $nuevo_valor_total = $nueva_cantidad * $valor_art;

        // Verificar si el artículo debe eliminarse
        if ($nueva_cantidad <= 0 && strtolower($articulo_descontinuado) === "si") {
            $delete_query = "DELETE FROM inventario WHERE id='{$row['id']}'";
            $delete_result = mysqli_query($mysqli, $delete_query);

            if ($delete_result) {
                echo '<script language="javascript">alert("Artículo eliminado automáticamente debido a la cantidad en stock igual a 0.");</script>';
                echo "<script>location.href='ing_art_mte.php'</script>";
                exit();
            } else {
                $error_message = mysqli_error($mysqli);
                echo '<script language="javascript">alert("Error al eliminar el artículo: ' . $error_message . '. Inténtelo de nuevo.");</script>';
                echo "<script>location.href='ingresar_articulos.php'</script>";
                exit();
            }
        }

        if ($nueva_cantidad > 0) {
            $update_query = "UPDATE inventario SET cantidad='$nueva_cantidad', valor_total='$nuevo_valor_total' WHERE id='{$row['id']}'";
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
} else {
    // Insertar un nuevo artículo
    $valor_total = $valor_art * $cantidad;
    $insert_query = "INSERT INTO inventario (codigo_art, nombre_art, proveedor, descrip, valor_art, cantidad, valor_total, cantidad_stock_minimo, articulo_descontinuado) VALUES ('$codigo_art', '$nombre_art', '$proveedor', '$descrip', '$valor_art', '$cantidad', '$valor_total', '$cantidad_stock_minimo', '$articulo_descontinuado')";
    $insert_result = mysqli_query($mysqli, $insert_query);

    if ($insert_result) {
        echo '<script language="javascript">alert("Artículo registrado con éxito");</script>';
        echo "<script>location.href='ing_art_mte.php'</script>";
    } else {
        $error_message = mysqli_error($mysqli);
        echo '<script language="javascript">alert("Error al registrar el artículo: ' . $error_message . '. Inténtelo de nuevo.");</script>';
        echo "<script>location.href='ingresar_articulos.php'</script>";
    }
}
?>

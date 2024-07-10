<?php
// Inicio de la sesión PHP
session_start();

// Requerir el archivo de conexión
require("../../connect_db.php");

// Verificar si se recibió el formulario de asignación de productos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario y asegurar que sean enteros
    $productos = json_decode($_POST['productos'], true);

    $productos_sin_stock = []; // Array para almacenar productos sin suficiente stock

    foreach ($productos as $producto) {
        $nombre_sede_id = (int)$producto['sedeId'];
        $producto_nombre = $mysqli->real_escape_string($producto['productoNombre']);
        $cantidad = (int)$producto['cantidad'];

        // Obtener el nombre completo de la sede desde la tabla sedes
        $sql_nombre_sede = "SELECT nombre_sede FROM sedes WHERE id = ?";
        $stmt_nombre_sede = $mysqli->prepare($sql_nombre_sede);
        if (!$stmt_nombre_sede) {
            echo ' <script language="javascript">alert("Error al consultar la sede.");</script> ';
            echo "<script>location.href='asignar_productos.php'</script>";
            exit();
        }
        $stmt_nombre_sede->bind_param("i", $nombre_sede_id);
        $stmt_nombre_sede->execute();
        $stmt_nombre_sede->bind_result($nombre_sede_completo);
        $stmt_nombre_sede->fetch();
        $stmt_nombre_sede->close();

        // Si no se encontró el nombre completo de la sede, mostrar error y salir
        if (empty($nombre_sede_completo)) {
            echo ' <script language="javascript">alert("No se encontró el nombre completo de la sede.");</script> ';
            echo "<script>location.href='asignar_productos.php'</script>";
            exit();
        }

        // Obtener la cantidad actual en stock del producto en inventario
        $sql_select_inventario = "SELECT cantidad FROM inventario WHERE nombre_art = ?";
        $stmt_select = $mysqli->prepare($sql_select_inventario);
        if (!$stmt_select) {
            echo ' <script language="javascript">alert("Error al obtener la cantidad actual en stock del producto en inventario.");</script> ';
            echo "<script>location.href='asignar_productos.php'</script>";
            exit();
        }
        $stmt_select->bind_param("s", $producto_nombre);
        $stmt_select->execute();
        $stmt_select->bind_result($cantidad_inventario);
        $stmt_select->fetch();
        $stmt_select->close();

        // Verificar que haya suficiente stock
        if ($cantidad_inventario < $cantidad) {
            // Añadir producto a la lista de productos sin suficiente stock
            $productos_sin_stock[] = [
                'producto' => $producto_nombre,
                'cantidad_disponible' => $cantidad_inventario,
                'cantidad_requerida' => $cantidad
            ];
        }
    }

    // Si hay productos sin suficiente stock, mostrar mensaje de error y lista de productos
    if (!empty($productos_sin_stock)) {
        $mensaje_error = "No hay suficiente stock para los siguientes productos:\\n";
        foreach ($productos_sin_stock as $producto) {
            $mensaje_error .= "- Producto: " . $producto['producto'] . ", Stock disponible: " . $producto['cantidad_disponible'] . ", Cantidad requerida: " . $producto['cantidad_requerida'] . "\\n";
        }
        echo ' <script language="javascript">alert("' . $mensaje_error . '");</script> ';
        echo "<script>location.href='asignar_productos.php'</script>";
        exit();
    }

    // Si todos los productos tienen suficiente stock, proceder con las operaciones de asignación
    foreach ($productos as $producto) {
        $nombre_sede_id = (int)$producto['sedeId'];
        $producto_nombre = $mysqli->real_escape_string($producto['productoNombre']);
        $cantidad = (int)$producto['cantidad'];

        // Obtener el nombre completo de la sede desde la tabla sedes
        $sql_nombre_sede = "SELECT nombre_sede FROM sedes WHERE id = ?";
        $stmt_nombre_sede = $mysqli->prepare($sql_nombre_sede);
        if (!$stmt_nombre_sede) {
            echo ' <script language="javascript">alert("Error al consultar la sede.");</script> ';
            echo "<script>location.href='asignar_productos.php'</script>";
            exit();
        }
        $stmt_nombre_sede->bind_param("i", $nombre_sede_id);
        $stmt_nombre_sede->execute();
        $stmt_nombre_sede->bind_result($nombre_sede_completo);
        $stmt_nombre_sede->fetch();
        $stmt_nombre_sede->close();

        // Obtener la cantidad actual en stock del producto en inventario
        $sql_select_inventario = "SELECT cantidad FROM inventario WHERE nombre_art = ?";
        $stmt_select = $mysqli->prepare($sql_select_inventario);
        if (!$stmt_select) {
            echo ' <script language="javascript">alert("Error al obtener la cantidad actual en stock del producto en inventario.");</script> ';
            echo "<script>location.href='asignar_productos.php'</script>";
            exit();
        }
        $stmt_select->bind_param("s", $producto_nombre);
        $stmt_select->execute();
        $stmt_select->bind_result($cantidad_inventario);
        $stmt_select->fetch();
        $stmt_select->close();

        // Calcular la nueva cantidad en stock en inventario
        $nueva_cantidad_inventario = $cantidad_inventario - $cantidad;

        // Actualizar la cantidad en stock del producto en inventario
        $sql_update_inventario = "UPDATE inventario SET cantidad = ? WHERE nombre_art = ?";
        $stmt_update = $mysqli->prepare($sql_update_inventario);
        if (!$stmt_update) {
            echo ' <script language="javascript">alert("Error al actualizar la cantidad en stock del producto en inventario.");</script> ';
            echo "<script>location.href='asignar_productos.php'</script>";
            exit();
        }
        $stmt_update->bind_param("is", $nueva_cantidad_inventario, $producto_nombre);
        if (!$stmt_update->execute()) {
            echo ' <script language="javascript">alert("Error al ejecutar la actualización de inventario.");</script> ';
            echo "<script>location.href='asignar_productos.php'</script>";
            exit();
        }
        $stmt_update->close();

        // Verificar si el producto ya está asignado a la sede en inventario_sedes
        $sql_check = "SELECT cantidad FROM inventario_sedes WHERE sede = ? AND nombre_art = ?";
        $stmt_check = $mysqli->prepare($sql_check);
        if (!$stmt_check) {
            echo ' <script language="javascript">alert("Error al verificar si el producto ya está asignado a la sede.");</script> ';
            echo "<script>location.href='asignar_productos.php'</script>";
            exit();
        }
        $stmt_check->bind_param("ss", $nombre_sede_completo, $producto_nombre);
        $stmt_check->execute();
        $stmt_check->bind_result($cantidad_sedes);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($cantidad_sedes !== null) {
            // Si el producto ya está asignado, actualizar la cantidad en inventario_sedes
            $sql_update_sedes = "UPDATE inventario_sedes SET cantidad = cantidad + ? WHERE sede = ? AND nombre_art = ?";
            $stmt_update_sedes = $mysqli->prepare($sql_update_sedes);
            if (!$stmt_update_sedes) {
                echo ' <script language="javascript">alert("Error al actualizar la cantidad en inventario.");</script> ';
                echo "<script>location.href='asignar_productos.php'</script>";
                exit();
            }
            $stmt_update_sedes->bind_param("iss", $cantidad, $nombre_sede_completo, $producto_nombre);
            if (!$stmt_update_sedes->execute()) {
                echo ' <script language="javascript">alert("Error al ejecutar la actualización en inventario.");</script> ';
                echo "<script>location.href='asignar_productos.php'</script>";
                exit();
            }
            $stmt_update_sedes->close();
        } else {
            // Si el producto no está asignado, insertar un nuevo registro en inventario_sedes
            $sql_insert_sedes = "INSERT INTO inventario_sedes (sede, codigo_art, nombre_art, descrip, cantidad)
                                 SELECT ?, codigo_art, nombre_art, descrip, ?
                                 FROM inventario
                                 WHERE nombre_art = ?";
            $stmt_insert = $mysqli->prepare($sql_insert_sedes);
            if (!$stmt_insert) {
                echo ' <script language="javascript">alert("Error al insertar un nuevo registro en inventario.");</script> ';
                echo "<script>location.href='asignar_productos.php'</script>";
                exit();
            }
            $stmt_insert->bind_param("sis", $nombre_sede_completo, $cantidad, $producto_nombre);
            if (!$stmt_insert->execute()) {
                echo ' <script language="javascript">alert("Error al ejecutar la inserción en inventario.");</script> ';
                echo "<script>location.href='asignar_productos.php'</script>";
                exit();
            }
            $stmt_insert->close();
        }
    }

    echo "Asignación de productos realizada correctamente.";
    echo "<script>location.href='asignar_productos.php'</script>";

    // Cerrar la conexión
    $mysqli->close();
}
?>

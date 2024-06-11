<?php
// Include the database connection file
require("../connect_db.php");

if (isset($_POST['proveedor_id'])) {
    $proveedorId = $_POST['proveedor_id'];
    $sql = "SELECT empresa FROM proveedores WHERE id = $proveedorId";
    $query = mysqli_query($mysqli, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $proveedor = mysqli_fetch_assoc($query);
        echo json_encode(array('success' => true, 'proveedor' => $proveedor['empresa'])); // Cambio aquí
    } else {
        echo json_encode(array('success' => false, 'error' => 'Proveedor no encontrado.'));
    }
} else {
    echo json_encode(array('success' => false, 'error' => 'ID de proveedor no proporcionado.'));
}
?>

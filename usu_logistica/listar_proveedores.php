<?php
// Include the database connection file
require("../connect_db.php");

$sql = "SELECT id, empresa FROM proveedores";
$query = mysqli_query($mysqli, $sql);

if ($query) {
    $proveedores = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $proveedores[] = array(
            'id' => $row['empresa'],
            'empresa' => $row['empresa']
        );
    }
    
    echo json_encode(array('success' => true, 'proveedores' => $proveedores));
} else {
    echo json_encode(array('success' => false, 'error' => 'Error al obtener proveedores.'));
}
?>

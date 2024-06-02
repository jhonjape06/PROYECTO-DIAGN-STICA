<?php
require("../connect_db.php");

if (isset($_POST['codigo_producto'])) {
    $codigo_producto = mysqli_real_escape_string($mysqli, $_POST['codigo_producto']);
    $query = "SELECT * FROM inventario WHERE codigo_art='$codigo_producto'";
    $result = mysqli_query($mysqli, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No encontrado']);
    }
}
?>

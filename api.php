<?php
header("Content-Type: application/json");
require 'connect_db.php';

$method = $_SERVER['REQUEST_METHOD'];
$response = [];

switch ($method) {
    case 'GET':
        $sql = "SELECT * FROM login";
        $result = $mysqli->query($sql);
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        $response = $users;
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['user']) && isset($data['password']) && isset($data['email']) && isset($data['rol'])) {
            $user = $data['user'];
            $password = $data['password'];
            $email = $data['email'];
            $rol = $data['rol'];
            $sql = "INSERT INTO login (user, password, email, rol) VALUES ('$user', '$password', '$email', '$rol')";
            if ($mysqli->query($sql) === TRUE) {
                $response = ["message" => "Usuario creado con éxito"];
            } else {
                $response = ["error" => "Error al crear usuario: " . $mysqli->error];
            }
        } else {
            $response = ["error" => "Datos no válidos"];
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id']) && isset($data['user']) && isset($data['password']) && isset($data['email']) && isset($data['rol'])) {
            $id = $data['id'];
            $user = $data['user'];
            $password = $data['password'];
            $email = $data['email'];
            $rol = $data['rol'];
            $sql = "UPDATE login SET user='$user', password='$password', email='$email', rol='$rol' WHERE id='$id'";
            if ($mysqli->query($sql) === TRUE) {
                $response = ["message" => "Usuario actualizado con éxito"];
            } else {
                $response = ["error" => "Error al actualizar usuario: " . $mysqli->error];
            }
        } else {
            $response = ["error" => "Datos no válidos"];
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id'])) {
            $id = $data['id'];
            $sql = "DELETE FROM login WHERE id='$id'";
            if ($mysqli->query($sql) === TRUE) {
                $response = ["message" => "Usuario eliminado exitosamente"];
            } else {
                $response = ["error" => "Error al eliminar usuario: " . $mysqli->error];
            }
        } else {
            $response = ["error" => "Datos no válidos"];
        }
        break;

    default:
        $response = ["error" => "Solicitud no válido"];
        break;
}

echo json_encode($response);
$mysqli->close();
?>

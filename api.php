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

        if (isset($data['user']) && isset($data['password']) && isset($data['rol'])) {
            $user = $data['user'];
            $password = $data['password'];
            $rol = $data['rol'];
            $sql = "INSERT INTO login (user, password, rol) VALUES ('$user', '$password', '$rol')";
            if ($mysqli->query($sql) === TRUE) {
                $response = ["message" => "User created successfully"];
            } else {
                $response = ["error" => "Error creating user: " . $mysqli->error];
            }
        } else {
            $response = ["error" => "Invalid input data"];
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id']) && isset($data['user']) && isset($data['password']) && isset($data['rol'])) {
            $id = $data['id'];
            $user = $data['user'];
            $password = $data['password'];
            $rol = $data['rol'];
            $sql = "UPDATE login SET user='$user', password='$password', rol='$rol' WHERE id='$id'";
            if ($mysqli->query($sql) === TRUE) {
                $response = ["message" => "User updated successfully"];
            } else {
                $response = ["error" => "Error updating user: " . $mysqli->error];
            }
        } else {
            $response = ["error" => "Invalid input data"];
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id'])) {
            $id = $data['id'];
            $sql = "DELETE FROM login WHERE id='$id'";
            if ($mysqli->query($sql) === TRUE) {
                $response = ["message" => "User deleted successfully"];
            } else {
                $response = ["error" => "Error deleting user: " . $mysqli->error];
            }
        } else {
            $response = ["error" => "Invalid input data"];
        }
        break;

    default:
        $response = ["error" => "Invalid request method"];
        break;
}

echo json_encode($response);
$mysqli->close();
?>

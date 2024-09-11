<?php
require_once 'conexion.php';

header('Content-Type: application/json');

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($nombre) || empty($username) || empty($correo) || empty($password)) {
        $response['status'] = 'error';
        $response['message'] = 'Todos los campos son obligatorios.';
        echo json_encode($response);
        exit();
    }

    $password_hash = hash('sha256', $password);

    $sql = "SELECT * FROM usuario WHERE username = ? OR correo = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $username, $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['status'] = 'error';
        $response['message'] = 'El usuario ya existe.';
        echo json_encode($response);
        exit();
    }

    $sql = "INSERT INTO usuario (nombre, username, correo, password) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssss', $nombre, $username, $correo, $password_hash);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Registro exitoso.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error en el registro: ' . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}

echo json_encode($response);
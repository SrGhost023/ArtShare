<?php
require_once 'conexion.php';

$username = $_POST['username'];
$password = $_POST['password'];

$password_hash = hash('sha256', $password);

$sql = "SELECT password FROM usuario WHERE username = ? OR correo = ?";

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param('ss', $username, $username);
    $stmt->execute();
    $stmt->bind_result($stored_hash);
    $stmt->fetch();

    if ($stored_hash === $password_hash) {
        echo "Inicio de sesión exitoso.";
    } else {
        echo "Nombre de usuario o contraseña incorrectos.";
    }

    $stmt->close();
} else {
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
<?php
$host = 'localhost';
$usuario = 'root';
$contraseña = '';
$base_datos = 'ArtShareDB'; 

$mysqli = new mysqli($host, $usuario, $contraseña, $base_datos);

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

<?php
$host = "localhost";
$user = "root"; // Cambia si tienes otro usuario en tu base de datos
$password = ""; // Cambia si tu base de datos tiene contraseña
$database = "muebleria"; // Asegúrate de que el nombre de la BD sea correcto

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>

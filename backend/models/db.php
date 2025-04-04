<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$host = 'localhost';
$user = 'root';
$password = ''; 
$database = 'muebleria'; 

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}
?>


<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../config/database.php';

$conexion = new mysqli($host, $usuario, $password, $base_datos);

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

$query = "SELECT id_mueble, nombre, precio FROM muebles";
$result = $conexion->query($query);

$muebles = [];
while ($fila = $result->fetch_assoc()) {
    $muebles[] = $fila;
}

echo json_encode($muebles);

$conexion->close();
?>

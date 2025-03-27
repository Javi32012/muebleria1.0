<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../config/database.php';

$conexion = new mysqli($host, $usuario, $password, $base_datos);

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

$query = "SELECT id_cliente, nombre FROM clientes";
$result = $conexion->query($query);

$clientes = [];
while ($fila = $result->fetch_assoc()) {
    $clientes[] = $fila;
}

echo json_encode($clientes);

$conexion->close();
?>

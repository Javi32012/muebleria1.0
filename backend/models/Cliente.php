<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
$conexion = new mysqli("localhost", "root", "", "muebleria");
$resultado = $conexion->query("SELECT * FROM clientes");
$clientes = [];
while ($fila = $resultado->fetch_assoc()) {
    $clientes[] = $fila;
}
echo json_encode($clientes);
?>
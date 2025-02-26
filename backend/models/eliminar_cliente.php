<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
$conexion = new mysqli("localhost", "root", "", "muebleria");
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$conexion->query("DELETE FROM clientes WHERE id_cliente = $id");
?>
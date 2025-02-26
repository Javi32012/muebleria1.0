<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$conexion = new mysqli("localhost", "root", "", "muebleria");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["error" => "No se recibieron datos"]);
    exit;
}

$nombre = $data['nombre'] ?? '';
$email = $data['email'] ?? '';
$telefono = $data['telefono'] ?? '';
$direccion = $data['direccion'] ?? '';

if (empty($nombre) || empty($email) || empty($telefono) || empty($direccion)) {
    echo json_encode(["error" => "Faltan datos obligatorios"]);
    exit;
}

$query = $conexion->prepare("INSERT INTO clientes (nombre, email, telefono, direccion) VALUES (?, ?, ?, ?)");
$query->bind_param("ssss", $nombre, $email, $telefono, $direccion);

if ($query->execute()) {
    echo json_encode(["message" => "Cliente agregado correctamente"]);
} else {
    echo json_encode(["error" => "Error al agregar cliente"]);
}
?>

<?php
// Habilitar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Responder a preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Conexión a la base de datos
include 'db.php';
$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode(["mensaje" => "Error de conexión: " . $conexion->connect_error]);
    exit;
}

// Leer datos JSON del cuerpo de la solicitud
$datos = json_decode(file_get_contents("php://input"), true);

if (!isset($datos['id'])) {
    http_response_code(400);
    echo json_encode(["mensaje" => "ID de cliente no proporcionado"]);
    exit;
}

$id_cliente = intval($datos['id']);

// Eliminar órdenes asociadas al cliente
$stmt = $conexion->prepare("DELETE FROM ordenes WHERE id_cliente = ?");
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$stmt->close();

// Eliminar cliente
$stmt = $conexion->prepare("DELETE FROM clientes WHERE id_cliente = ?");
$stmt->bind_param("i", $id_cliente);

if ($stmt->execute()) {
    echo json_encode(["mensaje" => "Cliente y sus órdenes eliminados correctamente"]);
} else {
    http_response_code(500);
    echo json_encode(["mensaje" => "Error al eliminar cliente: " . $stmt->error]);
}

$stmt->close();
$conexion->close();
?>
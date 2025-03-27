<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$conexion = new mysqli($host, $usuario, $password, $base_datos);

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

// Recibir datos JSON
$datos = json_decode(file_get_contents("php://input"), true);

if (!isset($datos['id_orden'])) {
    die(json_encode(["error" => "ID de orden no proporcionado"]));
}

$id_orden = $datos['id_orden'];

// Eliminar primero los detalles de la orden
$queryDetalles = "DELETE FROM detalles_orden WHERE id_orden = ?";
$stmt = $conexion->prepare($queryDetalles);
$stmt->bind_param("i", $id_orden);
if (!$stmt->execute()) {
    die(json_encode(["error" => "Error al eliminar detalles de la orden: " . $stmt->error]));
}

// Luego, eliminar la orden principal
$queryOrden = "DELETE FROM ordenes WHERE id_orden = ?";
$stmtOrden = $conexion->prepare($queryOrden);
$stmtOrden->bind_param("i", $id_orden);
if (!$stmtOrden->execute()) {
    die(json_encode(["error" => "Error al eliminar la orden: " . $stmtOrden->error]));
}

echo json_encode(["mensaje" => "Orden eliminada correctamente"]);

$conexion->close();
?>

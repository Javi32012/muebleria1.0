<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

if (!isset($_GET['id_orden'])) {
    die(json_encode(["error" => "ID de orden no especificado"]));
}

$id_orden = intval($_GET['id_orden']);

$query = "SELECT d.id_mueble, m.nombre AS mueble, d.cantidad, d.subtotal 
          FROM detalles_orden d
          JOIN muebles m ON d.id_mueble = m.id_mueble
          WHERE d.id_orden = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_orden);
$stmt->execute();
$result = $stmt->get_result();

$detalles = [];
while ($row = $result->fetch_assoc()) {
    $row['subtotal'] = floatval($row['subtotal']); // Asegurar que subtotal sea numérico
    $detalles[] = $row;
}

echo json_encode($detalles);

$conexion->close();
?>

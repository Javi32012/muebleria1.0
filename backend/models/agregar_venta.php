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

if (!isset($datos['id_cliente'], $datos['muebles']) || !is_array($datos['muebles'])) {
    die(json_encode(["error" => "Datos incompletos"]));
}

$id_cliente = $datos['id_cliente'];
$muebles = $datos['muebles'];
$total = 0;

// Calcular total de la orden
foreach ($muebles as $mueble) {
    if (!isset($mueble['id_mueble'], $mueble['cantidad'], $mueble['subtotal'])) {
        die(json_encode(["error" => "Datos de muebles incorrectos"]));
    }
    $total += $mueble['subtotal'];
}

// Insertar en la tabla `ordenes`
$query = "INSERT INTO ordenes (id_cliente, fecha, total) VALUES (?, NOW(), ?)";
$stmt = $conexion->prepare($query);
$stmt->bind_param("id", $id_cliente, $total);
if (!$stmt->execute()) {
    die(json_encode(["error" => "Error al agregar orden: " . $stmt->error]));
}

// Obtener el ID de la orden creada
$id_orden = $stmt->insert_id;

// Insertar detalles en `detalles_orden`
$queryDetalle = "INSERT INTO detalles_orden (id_orden, id_mueble, cantidad, subtotal) VALUES (?, ?, ?, ?)";
$stmtDetalle = $conexion->prepare($queryDetalle);

foreach ($muebles as $mueble) {
    $stmtDetalle->bind_param("iiid", $id_orden, $mueble['id_mueble'], $mueble['cantidad'], $mueble['subtotal']);
    if (!$stmtDetalle->execute()) {
        die(json_encode(["error" => "Error al agregar detalles: " . $stmtDetalle->error]));
    }
}

echo json_encode(["mensaje" => "Venta registrada correctamente", "id_orden" => $id_orden]);

$conexion->close();
?>

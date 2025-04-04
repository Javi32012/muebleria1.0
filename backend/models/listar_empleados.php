<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

$query = "SELECT * FROM empleados";
$result = $conexion->query($query);

if (!$result) {
    die(json_encode(["error" => "Error en la consulta: " . $conexion->error]));
}

$empleados = [];
while ($row = $result->fetch_assoc()) {
    $empleados[] = $row;
}

// **Forzar salida limpia**
die(json_encode($empleados, JSON_UNESCAPED_UNICODE));

?>

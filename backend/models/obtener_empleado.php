<?php
// Encabezados para CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
include 'db.php';

$conexion = new mysqli($host, $user, $password, $database);
if ($conexion->connect_error) {
    echo json_encode(['error' => 'Error de conexión: ' . $conexion->connect_error]);
    exit;
}

// Validar y obtener el ID del empleado
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo json_encode(['error' => 'ID de empleado no válido']);
    exit;
}

// Consultar empleado
$sql = "SELECT * FROM empleados WHERE id_empleado = ?";
$stmt = $conexion->prepare($sql);

if (!$stmt) {
    echo json_encode(['error' => 'Error al preparar la consulta: ' . $conexion->error]);
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Empleado no encontrado']);
    exit;
}

$empleado = $result->fetch_assoc();
echo json_encode($empleado, JSON_UNESCAPED_UNICODE);

$stmt->close();
$conexion->close();

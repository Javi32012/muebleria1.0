<?php
// Encabezados para permitir CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a base de datos
include 'db.php';

// Obtener los datos del formulario
$id_empleado = $_POST['id_empleado'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$puesto = $_POST['puesto'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$email = $_POST['email'] ?? '';

// Validación básica
if (empty($id_empleado) || empty($nombre)) {
    echo json_encode(['mensaje' => 'Faltan datos requeridos']);
    exit;
}

// Preparar y ejecutar la consulta
$sql = "UPDATE empleados SET nombre = ?, puesto = ?, telefono = ?, email = ? WHERE id_empleado = ?";
$stmt = $conexion->prepare($sql);

if (!$stmt) {
    echo json_encode(['mensaje' => 'Error al preparar la consulta: ' . $conexion->error]);
    exit;
}

$stmt->bind_param("ssssi", $nombre, $puesto, $telefono, $email, $id_empleado);

if ($stmt->execute()) {
    echo json_encode(['mensaje' => 'Empleado actualizado correctamente']);
} else {
    echo json_encode(['mensaje' => 'Error al actualizar empleado: ' . $stmt->error]);
}

$stmt->close();
$conexion->close();

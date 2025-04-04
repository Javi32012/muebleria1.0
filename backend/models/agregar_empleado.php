<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';

$nombre = $_POST['nombre'] ?? '';
$puesto = $_POST['puesto'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$email = $_POST['email'] ?? '';

if ($nombre === '') {
    echo json_encode(['mensaje' => 'El nombre es obligatorio']);
    exit;
}

$sql = "INSERT INTO empleados (nombre, puesto, telefono, email) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssss", $nombre, $puesto, $telefono, $email);

if ($stmt->execute()) {
    echo json_encode(['mensaje' => 'Empleado agregado correctamente']);
} else {
    echo json_encode(['mensaje' => 'Error al agregar empleado: ' . $stmt->error]);
}

$stmt->close();
$conexion->close();
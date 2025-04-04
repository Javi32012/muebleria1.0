<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die(json_encode(["mensaje" => "Error de conexión: " . $conexion->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id_empleado']) ? intval($_POST['id_empleado']) : 0;

    if ($id > 0) {
        $stmt = $conexion->prepare("DELETE FROM empleados WHERE id_empleado = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["mensaje" => "Empleado eliminado correctamente"]);
        } else {
            echo json_encode(["mensaje" => "Error al eliminar empleado"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["mensaje" => "ID inválido"]);
    }
} else {
    echo json_encode(["mensaje" => "Método no permitido"]);
}

$conexion->close();
?>
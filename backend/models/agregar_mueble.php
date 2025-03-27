<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204);
    exit();
}

include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["nombre"]) && !empty($data["descripcion"]) && !empty($data["precio"]) && !empty($data["stock"])) {
    $nombre = $conexion->real_escape_string($data["nombre"]);
    $descripcion = $conexion->real_escape_string($data["descripcion"]);
    $precio = (float)$data["precio"];
    $stock = (int)$data["stock"];

    $sql = "INSERT INTO muebles (nombre, descripcion, precio, stock) VALUES ('$nombre', '$descripcion', $precio, $stock)";

    if ($conexion->query($sql) === TRUE) {
        echo json_encode(["mensaje" => "Mueble agregado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al agregar el mueble: " . $conexion->error]);
    }
} else {
    echo json_encode(["error" => "Todos los campos son obligatorios"]);
}

$conexion->close();
?>

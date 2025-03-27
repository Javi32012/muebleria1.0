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

if (!empty($data["id"])) {
    $id = intval($data["id"]);

    // Verifica el nombre correcto de la columna
    $sql = "DELETE FROM muebles WHERE id_mueble = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(["mensaje" => "Mueble eliminado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al eliminar el mueble: " . $stmt->error]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["error" => "ID no proporcionado"]);
}

$conexion->close();
?>

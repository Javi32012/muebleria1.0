<?php
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'])) {
    $sql = "DELETE FROM empleados WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $data['id']);
    if ($stmt->execute()) {
        echo json_encode(['mensaje' => 'Empleado eliminado con éxito']);
    } else {
        echo json_encode(['error' => 'Error al eliminar empleado']);
    }
} else {
    echo json_encode(['error' => 'ID no proporcionado']);
}
?>

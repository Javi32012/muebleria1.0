<?php
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'], $data['nombre'], $data['puesto'], $data['salario'])) {
    $sql = "UPDATE empleados SET nombre = :nombre, puesto = :puesto, salario = :salario WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $data['id']);
    $stmt->bindParam(':nombre', $data['nombre']);
    $stmt->bindParam(':puesto', $data['puesto']);
    $stmt->bindParam(':salario', $data['salario']);
    if ($stmt->execute()) {
        echo json_encode(['mensaje' => 'Empleado actualizado con éxito']);
    } else {
        echo json_encode(['error' => 'Error al actualizar empleado']);
    }
} else {
    echo json_encode(['error' => 'Datos incompletos']);
}
?>

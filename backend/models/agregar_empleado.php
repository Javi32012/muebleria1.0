<?php
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['nombre'], $data['puesto'], $data['salario'])) {
    $sql = "INSERT INTO empleados (nombre, puesto, salario) VALUES (:nombre, :puesto, :salario)";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombre', $data['nombre']);
    $stmt->bindParam(':puesto', $data['puesto']);
    $stmt->bindParam(':salario', $data['salario']);
    if ($stmt->execute()) {
        echo json_encode(['mensaje' => 'Empleado agregado con éxito']);
    } else {
        echo json_encode(['error' => 'Error al agregar empleado']);
    }
} else {
    echo json_encode(['error' => 'Datos incompletos']);
}
?>

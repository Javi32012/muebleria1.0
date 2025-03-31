<?php
include 'conexion.php';

$sql = "SELECT * FROM empleados";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($empleados);
?>

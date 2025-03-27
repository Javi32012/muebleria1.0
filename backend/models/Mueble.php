<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'db.php';

$sql = "SELECT * FROM muebles";
$result = $conexion->query($sql);

$muebles = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $muebles[] = $row;
    }
}

echo json_encode($muebles);

$conexion->close();
?>

<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

// Consulta para obtener las órdenes con el nombre del cliente
$query = "
    SELECT o.id_orden, o.fecha, o.total, c.nombre AS cliente
    FROM ordenes o
    JOIN clientes c ON o.id_cliente = c.id_cliente
    ORDER BY o.fecha DESC";

$resultado = $conexion->query($query);

$ventas = [];
while ($orden = $resultado->fetch_assoc()) {
    // Obtener los detalles de cada orden
    $query_detalles = "
        SELECT d.id_mueble, m.nombre, d.cantidad, d.subtotal 
        FROM detalles_orden d
        JOIN muebles m ON d.id_mueble = m.id_mueble
        WHERE d.id_orden = " . $orden['id_orden'];

    $resultado_detalles = $conexion->query($query_detalles);
    $detalles = [];

    while ($detalle = $resultado_detalles->fetch_assoc()) {
        $detalles[] = $detalle;
    }

    $orden['detalles'] = $detalles;
    $ventas[] = $orden;
}

echo json_encode($ventas);
$conexion->close();
?>

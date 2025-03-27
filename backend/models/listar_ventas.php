<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$conexion = new mysqli($host, $usuario, $password, $base_datos);

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

// Consulta para obtener todas las órdenes con sus clientes
$query = "SELECT o.id_orden, o.fecha, o.total, 
                 COALESCE(c.nombre, 'Cliente desconocido') AS cliente
          FROM ordenes o
          LEFT JOIN clientes c ON o.id_cliente = c.id_cliente";

$resultado = $conexion->query($query);

$ordenes = [];

// Recorrer las órdenes y agregar los detalles de cada una
while ($orden = $resultado->fetch_assoc()) {
    $id_orden = $orden['id_orden'];

    // Consultar los detalles de la orden
    $queryDetalles = "SELECT d.id_mueble, m.nombre AS mueble, d.cantidad, d.subtotal
                      FROM detalles_orden d
                      JOIN muebles m ON d.id_mueble = m.id_mueble
                      WHERE d.id_orden = ?";
    
    $stmt = $conexion->prepare($queryDetalles);
    $stmt->bind_param("i", $id_orden);
    $stmt->execute();
    $resultDetalles = $stmt->get_result();

    $detalles = [];
    while ($detalle = $resultDetalles->fetch_assoc()) {
        $detalles[] = $detalle;
    }

    $orden['detalles'] = $detalles;
    $ordenes[] = $orden;
}

echo json_encode($ordenes, JSON_UNESCAPED_UNICODE);

$conexion->close();
?>

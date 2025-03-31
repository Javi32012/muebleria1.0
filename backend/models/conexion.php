<?php
$host = 'localhost';
$dbname = 'gestion_empleados';
$usuario = 'root';
$contraseña = '';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $contraseña);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
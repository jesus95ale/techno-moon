<?php
header('Content-Type: application/json');

$host = "localhost"; // Cambia esto según tu configuración
$user = "root"; // Cambia esto según tu configuración
$pass = ""; // Cambia esto según tu configuración
$db = "technomo_techno-moon"; // Cambia esto según tu configuración

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para obtener los eventos
$sql = "SELECT nombre, descripcion, fecha FROM tiempo ORDER BY fecha";
$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    // Almacenar los datos en un array
    while($row = $result->fetch_assoc()) {
        $events[] = [
            'nombre' => $row['nombre'],
            'descripcion' => $row['descripcion'],
            'fecha' => $row['fecha']
        ];
    }
}

// Cerrar conexión
$conn->close();

// Devolver los eventos en formato JSON
header('Content-Type: application/json');
echo json_encode($events);
?>
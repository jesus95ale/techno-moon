<?php
// Iniciar el buffer de salida
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json; charset=UTF-8');

$host = "localhost";
$db = "technomo_techno-moon";
$user = "root";
$pass = "";
$puerto = "3306";

// Conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $db, $puerto);
if ($conn->connect_error) {
    die(json_encode(['error' => 'Error de conexión: ' . $conn->connect_error]));
}

// Obtener tipo de consulta y idioma de la petición
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'es';

if ($tipo == 'servicios') {
    // Consulta para servicios
    $query = "SELECT nombre_$lang AS nombre, descripcion_$lang AS descripcion, imagen_url FROM servicios";
    $result = $conn->query($query);

    $servicios = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $servicios[] = $row;
        }
    }
    echo json_encode($servicios);

} elseif ($tipo == 'casos_estudio') {
    // Consulta para casos de estudio
    $query = "SELECT id, titulo_$lang AS titulo, descripcion_$lang AS descripcion, web, ubicacion, imagen_url FROM casos_estudio";
    $result = $conn->query($query);

    $casos_estudio = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $casos_estudio[] = $row;
        }
    }
    echo json_encode(['casos_estudio' => $casos_estudio]);

} else {
    echo json_encode(['error' => 'Tipo de consulta no válido']);
}

// Cerrar la conexión
$conn->close();

// Limpiar buffer de salida
ob_end_flush();

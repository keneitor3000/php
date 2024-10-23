<?php
$host = "localhost";  // Dirección del servidor MySQL
$user = "root";       // Nombre de usuario
$password = "";       // Contraseña
$dbname = "bd_proyecto_u";  // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

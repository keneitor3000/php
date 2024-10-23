<?php
include 'db_connection.php';  // Incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table_name = $_POST['table_name'];
    $fields = $_POST['fields'];
    $types = $_POST['types'];
    
    // Crear la consulta SQL para crear la tabla
    $sql = "CREATE TABLE $table_name (id INT AUTO_INCREMENT PRIMARY KEY, ";
    for ($i = 0; $i < count($fields); $i++) {
        $sql .= $fields[$i] . " " . $types[$i] . ", ";
    }
    $sql = rtrim($sql, ', ') . ");";

    // Ejecutar la consulta para crear la tabla en la base de datos
    if ($conn->query($sql) === TRUE) {
        echo "Tabla $table_name creada exitosamente.<br>";
    } else {
        echo "Error al crear la tabla: " . $conn->error . "<br>";
    }

    // Generar los archivos CRUD...
}
?>

<?php
if (isset($_POST['table_name']) && isset($_POST['field_name']) && isset($_POST['field_type'])) {
    $table_name = $_POST['table_name'];
    $field_name = $_POST['field_name'];
    $field_type = $_POST['field_type'];
    $field_length = isset($_POST['field_length']) && !empty($_POST['field_length']) ? "(" . $_POST['field_length'] . ")" : "";
    $field_attributes = $_POST['field_attributes'];

    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "bd_proyecto_u");

    if ($conn->connect_error) {
        die("Fallo la conexión: " . $conn->connect_error);
    }

    // Construir la consulta para añadir el nuevo campo
    $sql = "ALTER TABLE $table_name ADD $field_name $field_type$field_length $field_attributes";

    if ($conn->query($sql) === TRUE) {
        echo "Campo '$field_name' añadido con éxito a la tabla '$table_name'.";
    } else {
        echo "Error al añadir el campo: " . $conn->error;
    }

    // Cerrar conexión
    $conn->close();
} else {
    echo "Por favor completa todos los campos requeridos.";
}
?>

<!-- Botón para regresar al index.php -->
<br><a href="index.php" class="button-regresar">Regresar</a>

<?php
if (isset($_POST['table_name']) && isset($_POST['field_name']) && isset($_POST['new_field_name']) && isset($_POST['field_type'])) {
    $table_name = $_POST['table_name'];
    $field_name = $_POST['field_name'];
    $new_field_name = $_POST['new_field_name'];
    $field_type = $_POST['field_type'];
    $field_length = isset($_POST['field_length']) && !empty($_POST['field_length']) ? "(" . $_POST['field_length'] . ")" : "";
    $field_attributes = $_POST['field_attributes'];

    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "bd_proyecto_u");

    if ($conn->connect_error) {
        die("Fallo la conexión: " . $conn->connect_error);
    }

    // Construir la consulta SQL para modificar el campo
    $sql = "ALTER TABLE $table_name CHANGE $field_name $new_field_name $field_type$field_length $field_attributes";

    if ($conn->query($sql) === TRUE) {
        echo "El campo '$field_name' ha sido modificado a '$new_field_name' con éxito.";
    } else {
        echo "Error al modificar el campo: " . $conn->error;
    }

    // Cerrar conexión
    $conn->close();
} else {
    echo "Por favor completa todos los campos requeridos.";
}
?>

<!-- Botón para regresar al index.php -->
<br><a href="index.php" class="button-regresar">Regresar</a>

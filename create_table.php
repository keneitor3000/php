<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_name = $_POST['table_name'];
    $fields = $_POST['field_name'];
    $types = $_POST['field_type'];
    $lengths = $_POST['field_length'];
    $attributes = $_POST['field_attributes'];

    // Verificar que se haya ingresado un nombre de tabla válido
    if (empty($table_name) || preg_match('/[^a-zA-Z0-9_]/', $table_name)) {
        die("Nombre de tabla no válido.");
    }

    $sql = "CREATE TABLE `$table_name` (";

    for ($i = 0; $i < count($fields); $i++) {
        $field = $fields[$i];
        $type = $types[$i];
        $length = !empty($lengths[$i]) ? "($lengths[$i])" : "";
        $attribute = !empty($attributes[$i]) ? $attributes[$i] : "";

        // Validación de nombre de campo
        if (empty($field) || preg_match('/[^a-zA-Z0-9_]/', $field)) {
            die("Nombre de campo no válido: $field");
        }

        $sql .= "`$field` $type$length $attribute,";
    }

    $sql = rtrim($sql, ',') . ");";

    // Conexión a la base de datos MySQL
    $conn = new mysqli("localhost", "root", "", "recuperacion");

    if ($conn->connect_error) {
        die("Fallo la conexión: " . $conn->connect_error);
    }

    // Mostrar la consulta SQL para depurar
    echo "<pre>$sql</pre>";

    if ($conn->query($sql) === TRUE) {
        echo "Tabla '$table_name' creada exitosamente!";
    } else {
        echo "Error al crear la tabla: " . $conn->error;
    }

    $conn->close();
}
?>

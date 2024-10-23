<?php
include 'db_connection.php';

$table_name = $_GET['table'];

// Obtener todos los registros de la tabla seleccionada
$sql = "SELECT * FROM $table_name";
$result = $conn->query($sql);

echo "<h1>Registros de la tabla: " . htmlspecialchars($table_name) . "</h1>";
if ($result->num_rows > 0) {
    echo "<table border='1'><tr>";

    // Obtener los nombres de los campos
    $field_info = $result->fetch_fields();
    foreach ($field_info as $field) {
        echo "<th>{$field->name}</th>";
    }
    echo "<th>Acciones</th></tr>";

    // Mostrar los registros
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "<td>
                <a href='actualizar.php?table=$table_name&id={$row['id']}'>Editar</a> |
                <a href='eliminar.php?table=$table_name&id={$row['id']}'>Eliminar</a>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros en esta tabla.";
}

$conn->close();
?>

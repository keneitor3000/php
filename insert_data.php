<?php
// Conexión a la base de datos
$host = "localhost";
$username = "root"; // Ajusta según tus credenciales
$password = ""; // Ajusta según tus credenciales
$database = "bd_proyecto_u";

$conn = new mysqli($host, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la lista de tablas
$tables = $conn->query("SHOW TABLES FROM $database");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_name = $_POST['table_name'];
    $fields = $conn->query("DESCRIBE $table_name");
    
    // Preparar la consulta de inserción
    $field_names = [];
    $values = [];
    foreach ($fields as $field) {
        $field_name = $field['Field'];
        $field_value = $_POST[$field_name];
        array_push($field_names, $field_name);
        array_push($values, "'" . $conn->real_escape_string($field_value) . "'");
    }
    
    $query = "INSERT INTO $table_name (" . implode(", ", $field_names) . ") VALUES (" . implode(", ", $values) . ")";
    
    if ($conn->query($query) === TRUE) {
        echo "Datos insertados correctamente en la tabla $table_name.";
    } else {
        echo "Error al insertar los datos: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Datos en la Tabla</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Insertar Datos en una Tabla</h1>
    
    <form action="insert_data.php" method="post">
        <label for="table_name">Selecciona una tabla:</label>
        <select name="table_name" id="table_name" onchange="this.form.submit()">
            <option value="">--Selecciona una tabla--</option>
            <?php
            if ($tables->num_rows > 0) {
                while ($row = $tables->fetch_row()) {
                    echo "<option value=\"$row[0]\">$row[0]</option>";
                }
            }
            ?>
        </select>
    </form>

    <?php if (isset($_POST['table_name'])): ?>
        <form action="insert_data.php" method="post">
            <input type="hidden" name="table_name" value="<?php echo $_POST['table_name']; ?>">
            <h2>Insertar datos en la tabla: <?php echo $_POST['table_name']; ?></h2>

            <?php
            $fields = $conn->query("DESCRIBE " . $_POST['table_name']);
            if ($fields->num_rows > 0) {
                while ($field = $fields->fetch_assoc()) {
                    echo '<label for="' . $field['Field'] . '">' . $field['Field'] . ' (' . $field['Type'] . '):</label>';
                    echo '<input type="text" name="' . $field['Field'] . '" required><br>';
                }
            }
            ?>

            <input type="submit" value="Insertar Datos">
        </form>
    <?php endif; ?>

    <a href="index.php" class="button-action">Regresar al Inicio</a>
</div>
</body>
</html>

<?php
$conn->close();
?>

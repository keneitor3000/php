<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "bd_proyecto_u");

if ($conn->connect_error) {
    die("Fallo la conexión: " . $conn->connect_error);
}

// Obtener las tablas
$tables_result = $conn->query("SHOW TABLES");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Campos</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function fetchFields() {
            const tableName = document.getElementById('table_name').value;
            if (tableName) {
                window.location.href = 'modify_field.php?table=' + tableName;
            }
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Modificar Campos de una Tabla</h1>

    <form method="get" action="modify_field.php">
        <label for="table_name">Selecciona la Tabla:</label>
        <select id="table_name" name="table" onchange="fetchFields()" required>
            <option value="">-- Selecciona una Tabla --</option>
            <?php while ($table_row = $tables_result->fetch_row()) : ?>
                <option value="<?php echo $table_row[0]; ?>" <?php if (isset($_GET['table']) && $_GET['table'] === $table_row[0]) echo 'selected'; ?>>
                    <?php echo $table_row[0]; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php
    if (isset($_GET['table'])) {
        $table = $_GET['table'];

        // Obtener los campos de la tabla seleccionada
        $fields_result = $conn->query("SHOW COLUMNS FROM $table");

        if ($fields_result->num_rows > 0) {
    ?>
        <form action="process_modify_field.php" method="post">
            <input type="hidden" name="table_name" value="<?php echo $table; ?>">

            <label for="field_name">Selecciona el Campo:</label>
            <select id="field_name" name="field_name" required>
                <option value="">-- Selecciona un Campo --</option>
                <?php while ($field_row = $fields_result->fetch_assoc()) : ?>
                    <option value="<?php echo $field_row['Field']; ?>"><?php echo $field_row['Field']; ?></option>
                <?php endwhile; ?>
            </select>

            <label for="new_field_name">Nuevo Nombre del Campo:</label>
            <input type="text" id="new_field_name" name="new_field_name" required>

            <label for="field_type">Nuevo Tipo:</label>
            <select id="field_type" name="field_type" required>
                <option value="VARCHAR">VARCHAR</option>
                <option value="INT">INT</option>
                <option value="TEXT">TEXT</option>
                <option value="DATE">DATE</option>
                <option value="BOOLEAN">BOOLEAN</option>
            </select>

            <label for="field_length">Longitud/Valores:</label>
            <input type="text" id="field_length" name="field_length">

            <label for="field_attributes">Atributos:</label>
            <select id="field_attributes" name="field_attributes">
                <option value="">Ninguno</option>
                <option value="PRIMARY KEY">Clave Primaria</option>
                <option value="NOT NULL">No Nulo</option>
                <option value="NULL">Nulo</option>
                <option value="UNIQUE">Único</option>
            </select>

            <input type="submit" value="Modificar Campo">
        </form>

    <?php
        } else {
            echo "<p>No se encontraron campos en la tabla seleccionada.</p>";
        }
    }
    ?>

    <!-- Botón para regresar al index.php -->
    <a href="index.php" class="button-regresar">Regresar</a>
</div>

<?php $conn->close(); ?>
</body>
</html>

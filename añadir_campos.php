<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_proyecto_u"; // Cambia por el nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tabla_seleccionada = $_POST['tabla'];
    $nuevo_campo = $_POST['campo'];
    $tipo_dato = $_POST['tipo_dato'];

    // Query para añadir un nuevo campo
    $sql = "ALTER TABLE $tabla_seleccionada ADD $nuevo_campo $tipo_dato";

    if ($conn->query($sql) === TRUE) {
        echo "Campo añadido con éxito.";
    } else {
        echo "Error al añadir el campo: " . $conn->error;
    }
}

// Obtener las tablas de la base de datos
$sql = "SHOW TABLES";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Campos</title>
    <link rel="stylesheet" href="styles.css"> <!-- Tu archivo CSS -->
</head>
<body>
    <div class="container">
        <h1>Añadir Nuevos Campos a una Tabla</h1>

        <form method="POST" action="">
            <label for="tabla">Selecciona una tabla:</label>
            <select name="tabla" id="tabla" required>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_array()) {
                        echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                    }
                } else {
                    echo "<option>No hay tablas disponibles</option>";
                }
                ?>
            </select>

            <label for="campo">Nombre del nuevo campo:</label>
            <input type="text" name="campo" id="campo" required>

            <label for="tipo_dato">Tipo de dato:</label>
            <select name="tipo_dato" id="tipo_dato" required>
                <option value="INT">INT</option>
                <option value="VARCHAR(255)">VARCHAR(255)</option>
                <option value="TEXT">TEXT</option>
                <option value="DATE">DATE</option>
                <!-- Añade más tipos de datos si es necesario -->
            </select>

            <input type="submit" value="Añadir Campo">
        </form>

        <a href="index.php" class="button-regresar">Regresar</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>

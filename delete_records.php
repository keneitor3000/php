<?php
// delete_records.php
// Conexión a la base de datos
$host = 'localhost';
$dbname = 'bd_proyecto_u'; // Cambia al nombre de tu base de datos
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Si se ha enviado el formulario para seleccionar la tabla
if (isset($_POST['tabla'])) {
    $tablaSeleccionada = $_POST['tabla'];

    // Obtener los registros de la tabla seleccionada
    $stmt = $pdo->prepare("SELECT * FROM $tablaSeleccionada");
    $stmt->execute();
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener los nombres de las columnas
    $columnas = array_keys($registros[0]);
} else {
    // Obtener las tablas de la base de datos
    $stmt = $pdo->query("SHOW TABLES");
    $tablas = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Registros</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Eliminar Registros</h1>

    <?php if (!isset($_POST['tabla'])): ?>
        <!-- Formulario para seleccionar la tabla -->
        <form method="post" action="delete_records.php">
            <label for="tabla">Selecciona una tabla:</label>
            <select name="tabla" id="tabla" required>
                <?php foreach ($tablas as $tabla): ?>
                    <option value="<?php echo $tabla; ?>"><?php echo $tabla; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Seleccionar">
        </form>
    <?php else: ?>
        <!-- Mostrar registros de la tabla seleccionada -->
        <h2>Tabla: <?php echo $tablaSeleccionada; ?></h2>
        <form method="post" action="delete_records.php">
            <table>
                <tr>
                    <th>Seleccionar</th>
                    <?php foreach ($columnas as $columna): ?>
                        <th><?php echo $columna; ?></th>
                    <?php endforeach; ?>
                </tr>
                <?php foreach ($registros as $index => $registro): ?>
                    <tr>
                        <td><input type="checkbox" name="registros[]" value="<?php echo $index; ?>"></td>
                        <?php foreach ($registro as $valor): ?>
                            <td><?php echo $valor; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
            <input type="hidden" name="tabla" value="<?php echo $tablaSeleccionada; ?>">
            <?php
            // Pasar los registros serializados
            $registrosSerializados = serialize($registros);
            ?>
            <input type="hidden" name="registros_serializados" value='<?php echo $registrosSerializados; ?>'>
            <input type="submit" name="eliminar" value="Eliminar Seleccionados" onclick="return confirm('¿Estás seguro de que deseas eliminar los registros seleccionados?');">
        </form>
        <a href="delete_records.php" class="button-regresar">Regresar</a>
    <?php endif; ?>

    <?php
    // Procesar la eliminación de registros
    if (isset($_POST['eliminar'])) {
        $tablaSeleccionada = $_POST['tabla'];
        $indicesRegistros = $_POST['registros'];
        $registros = unserialize($_POST['registros_serializados']);

        foreach ($indicesRegistros as $indice) {
            $registro = $registros[$indice];

            // Construir la consulta de eliminación
            $condicionesArray = [];
            foreach ($registro as $campo => $valor) {
                $condicionesArray[] = "$campo = :$campo";
            }
            $sql = "DELETE FROM $tablaSeleccionada WHERE " . implode(' AND ', $condicionesArray);
            $stmt = $pdo->prepare($sql);

            // Vincular valores
            foreach ($registro as $campo => $valor) {
                $stmt->bindValue(":$campo", $valor);
            }

            $stmt->execute();
        }

        echo "<p>Registros eliminados correctamente.</p>";
        echo '<a href="delete_records.php" class="button-regresar">Regresar</a>';
    }
    ?>

    <!-- Botón para regresar al index.php -->
    <a href="index.php" class="button-regresar">Volver al Inicio</a>

</div>
</body>
</html>

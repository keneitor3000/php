<?php
// modify_records.php
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
    <title>Modificar Registros</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Modificar Registros</h1>

    <?php if (!isset($_POST['tabla'])): ?>
        <!-- Formulario para seleccionar la tabla -->
        <form method="post" action="modify_records.php">
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
        <table>
            <tr>
                <?php foreach ($columnas as $columna): ?>
                    <th><?php echo $columna; ?></th>
                <?php endforeach; ?>
                <th>Acciones</th>
            </tr>
            <?php foreach ($registros as $registro): ?>
                <tr>
                    <?php foreach ($registro as $valor): ?>
                        <td><?php echo $valor; ?></td>
                    <?php endforeach; ?>
                    <td>
                        <form method="post" action="modify_records.php">
                            <?php foreach ($registro as $key => $value): ?>
                                <input type="hidden" name="registro[<?php echo $key; ?>]" value="<?php echo $value; ?>">
                            <?php endforeach; ?>
                            <input type="hidden" name="tabla" value="<?php echo $tablaSeleccionada; ?>">
                            <input type="submit" name="editar" value="Editar">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="modify_records.php" class="button-regresar">Regresar</a>
    <?php endif; ?>

    <?php
    // Si se ha seleccionado un registro para editar
    if (isset($_POST['editar'])) {
        $registro = $_POST['registro'];
        $tablaSeleccionada = $_POST['tabla'];
        ?>

        <!-- Formulario para editar el registro -->
        <h2>Editar Registro</h2>
        <form method="post" action="modify_records.php">
            <?php foreach ($registro as $campo => $valor): ?>
                <label for="<?php echo $campo; ?>"><?php echo $campo; ?>:</label>
                <input type="text" name="nuevo_registro[<?php echo $campo; ?>]" value="<?php echo $valor; ?>" required>
            <?php endforeach; ?>
            <input type="hidden" name="tabla" value="<?php echo $tablaSeleccionada; ?>">
            <input type="hidden" name="condiciones" value='<?php echo json_encode($registro); ?>'>
            <input type="submit" name="actualizar" value="Actualizar Registro">
        </form>
        <a href="modify_records.php" class="button-regresar">Cancelar</a>

        <?php
    }

    // Procesar la actualización del registro
    if (isset($_POST['actualizar'])) {
        $tablaSeleccionada = $_POST['tabla'];
        $nuevoRegistro = $_POST['nuevo_registro'];
        $condiciones = json_decode($_POST['condiciones'], true);

        // Construir la consulta de actualización
        $camposActualizar = [];
        foreach ($nuevoRegistro as $campo => $valor) {
            $camposActualizar[] = "$campo = :$campo";
        }
        $sql = "UPDATE $tablaSeleccionada SET " . implode(', ', $camposActualizar) . " WHERE ";

        // Condiciones para identificar el registro
        $condicionesArray = [];
        foreach ($condiciones as $campo => $valor) {
            $condicionesArray[] = "$campo = :cond_$campo";
        }
        $sql .= implode(' AND ', $condicionesArray);

        $stmt = $pdo->prepare($sql);

        // Vincular nuevos valores
        foreach ($nuevoRegistro as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }

        // Vincular condiciones
        foreach ($condiciones as $campo => $valor) {
            $stmt->bindValue(":cond_$campo", $valor);
        }

        if ($stmt->execute()) {
            echo "<p>Registro actualizado correctamente.</p>";
        } else {
            echo "<p>Error al actualizar el registro.</p>";
        }

        echo '<a href="modify_records.php" class="button-regresar">Regresar</a>';
    }
    ?>
    
    <!-- Botón para regresar al index.php -->
    <a href="index.php" class="button-regresar">Volver al Inicio</a>

</div>
</body>
</html>

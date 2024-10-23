<?php
if (isset($_GET['table'])) {
    $table = $_GET['table'];

    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "bd_proyecto_u");

    if ($conn->connect_error) {
        die("Fallo la conexión: " . $conn->connect_error);
    }

    // Obtener los datos de la tabla
    $result = $conn->query("SELECT * FROM $table");
    $columns = $conn->query("SHOW COLUMNS FROM $table");

    if ($result && $columns) {
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Datos de la Tabla</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Datos de la Tabla: <?php echo $table; ?></h1>
        <table>
            <thead>
                <tr>
                    <?php while ($col = $columns->fetch_assoc()) : ?>
                        <th><?php echo $col['Field']; ?></th>
                    <?php endwhile; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <?php foreach ($row as $data) : ?>
                            <td><?php echo $data; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Botón para regresar al index.php -->
        <a href="index.php" class="button-regresar">Regresar</a>
    </div>
</body>
</html>

<?php
    } else {
        echo "No se pudo obtener los datos de la tabla.";
    }

    $conn->close();
} else {
    echo "No se especificó ninguna tabla.";
}
?>

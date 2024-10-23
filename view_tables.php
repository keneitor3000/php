<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "bd_proyecto_u");

if ($conn->connect_error) {
    die("Fallo la conexión: " . $conn->connect_error);
}

// Obtener todas las tablas
$result = $conn->query("SHOW TABLES");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Tablas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Tablas en la Base de Datos</h1>
        <table>
            <thead>
                <tr>
                    <th>Nombre de la Tabla</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_row()) : ?>
                    <tr>
                        <td><?php echo $row[0]; ?></td>
                        <td>
                            <a href="view_table.php?table=<?php echo $row[0]; ?>">Ver Datos</a>
                            <form action="delete_table.php" method="post" style="display:inline;">
                                <input type="hidden" name="table_name" value="<?php echo $row[0]; ?>">
                                <input type="submit" value="Eliminar Tabla" onclick="return confirm('¿Seguro que deseas eliminar la tabla <?php echo $row[0]; ?>? Esta acción no se puede deshacer.')">
                            </form>
                        </td>
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
$conn->close();
?>

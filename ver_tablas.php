<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Tablas Creadas</title>
    <style>
        /* Tus estilos CSS aquí */
    </style>
</head>
<body>
    <div class="container">
        <?php
        include 'db_connecion.php'; // Conexión a la base de datos

        // Verificar la conexión antes de ejecutar la consulta
        if ($conexion->connect_error) {
            die("Error en la conexión a la base de datos: " . $conexion->connect_error);
        }

        // Consultar las tablas de la base de datos
        $sql = "SHOW TABLES";
        $resultado = $conexion->query($sql);

        // Manejo de errores
        if ($resultado === FALSE) {
            echo "Error en la consulta: " . $conexion->error;
        } elseif ($resultado->num_rows > 0) {
            echo "<h1>Tablas en la Base de Datos</h1>";
            echo "<ul>";
            while ($fila = $resultado->fetch_assoc()) {
                $nombre_tabla = $fila[array_keys($fila)[0]]; // Obtiene el nombre de la tabla
                echo "<li>" . $nombre_tabla . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<h1>No hay tablas en la base de datos.</h1>";
        }

        $conexion->close();
        ?>
        <button onclick="window.location.href='index.php'">Volver al Generador</button>
    </div>
</body>
</html>

<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "bd_proyecto_u");

if ($conn->connect_error) {
    die("Fallo la conexión: " . $conn->connect_error);
}

// Obtener la lista de tablas de la base de datos
$tables_result = $conn->query("SHOW TABLES");
if (!$tables_result) {
    die("Error al obtener las tablas: " . $conn->error);
}

$tables = [];
if ($tables_result) {
    while ($row = $tables_result->fetch_array()) {
        $tables[] = $row[0];
    }
}

// Procesar la eliminación de la tabla completa
if (isset($_POST['delete_table'])) {
    $table = $_POST['table_name'];

    if (!empty($table)) {
        $sql = "DROP TABLE IF EXISTS `$table`";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='success-msg'>Tabla '$table' eliminada con éxito.</div><br>";
        } else {
            echo "<div class='error-msg'>Error al eliminar la tabla: " . $conn->error . "</div><br>";
        }
    } else {
        echo "<div class='error-msg'>No se especificó ninguna tabla para eliminar.</div><br>";
    }
}

// Procesar la eliminación del campo
if (isset($_POST['delete_field'])) {
    $table = $_POST['table_name'];
    $field = $_POST['field_name'];

    if (!empty($table) && !empty($field)) {
        // Verificar cuántas columnas tiene la tabla
        $check_columns_sql = "SHOW COLUMNS FROM `$table`";
        $columns_result = $conn->query($check_columns_sql);

        if ($columns_result && $columns_result->num_rows > 1) {
            // Si la tabla tiene más de una columna, se puede eliminar el campo
            $sql = "ALTER TABLE `$table` DROP COLUMN `$field`";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='success-msg'>Campo '$field' eliminado con éxito de la tabla '$table'.</div><br>";
            } else {
                echo "<div class='error-msg'>Error al eliminar el campo: " . $conn->error . "</div><br>";
            }
        } else {
            // Si la tabla solo tiene una columna, no se puede eliminar el campo
            echo "<div class='error-msg'>No puedes eliminar el único campo de una tabla. Elimina la tabla completa si es necesario.</div><br>";
        }
    } else {
        echo "<div class='error-msg'>Debe especificar una tabla y un campo para eliminar.</div><br>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Tablas y Campos</title>
    <style>
        /* Aquí están tus estilos previos */
    </style>
</head>
<body>
    <h2>Eliminar Tabla Completa</h2>
    <form action="delete_table.php" method="post">
        <label for="table_name">Seleccione la tabla a eliminar:</label>
        <select name="table_name" id="table_name" required>
            <option value="">Seleccione una tabla</option>
            <?php
            foreach ($tables as $table) {
                echo "<option value=\"$table\">$table</option>";
            }
            ?>
        </select>
        <input type="hidden" name="delete_table" value="true">
        <input type="submit" value="Eliminar Tabla">
    </form>

    <hr>

    <h2>Eliminar Campo de una Tabla</h2>
    <form action="delete_table.php" method="post">
        <label for="table_select">Seleccione la tabla:</label>
        <select name="table_name" id="table_select" required>
            <option value="">Seleccione una tabla</option>
            <?php
            foreach ($tables as $table) {
                echo "<option value=\"$table\">$table</option>";
            }
            ?>
        </select>
        <br><br>
        
        <label for="field_name">Escriba el nombre del campo a eliminar:</label>
        <input type="text" name="field_name" id="field_name" placeholder="Nombre del campo" required>

        <input type="hidden" name="delete_field" value="true">
        <input type="submit" value="Eliminar Campo">
    </form>

    <hr>

    <!-- Botón para regresar al index.php -->
    <a href="index.php" class="button-regresar">Regresar al Inicio</a>

    <script>
        // No es necesario el script fetchFields en este caso
    </script>
</body>
</html>

<style>
    /* Estilos para el archivo delete_table.php */

    /* Contenedor principal */
    .container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        max-width: 800px;
        margin: 0 auto;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        text-align: center; /* Centrar el contenido */
        font-family: Arial, sans-serif; /* Tipo de letra de index.php */
    }

    /* Título principal */
    h1, h2 {
        color: #333;
        text-align: center;
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    /* Estilos de formulario */
    form {
        display: inline-block;
        margin: 20px 0;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 60%;
        text-align: left; /* Alinear el contenido del formulario a la izquierda */
    }

    /* Estilos de los inputs y selects */
    input[type="text"], select {
        padding: 10px;
        margin: 10px 0;
        display: block;
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input[type="submit"], .button-action {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease-in-out;
        width: 100%; /* Para que el botón tenga el mismo ancho que los inputs */
    }

    input[type="submit"]:hover, .button-action:hover {
        background-color: #45a049;
    }

    /* Mensajes de éxito y error */
    .success-msg, .error-msg {
        padding: 15px;
        border-radius: 5px;
        margin: 10px 0;
        text-align: center; /* Centrar los mensajes */
    }

    .success-msg {
        background-color: #d4edda;
        color: #155724;
    }

    .error-msg {
        background-color: #f8d7da;
        color: #721c24;
    }

    /* Separador */
    hr {
        margin: 40px 0;
    }

    /* Botón de regreso */
    .button-regresar {
        background-color: #008CBA; /* Azul claro */
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        margin-top: 20px;
    }

    .button-regresar:hover {
        background-color: #007bb5;
    }

    /* Centrado de todo el contenido en la página */
    body {
        font-family: Arial, sans-serif; /* Cambia la fuente al estilo de index.php */
        background-color: #f4f4f4;
        padding: 20px;
        text-align: center; /* Centrar el contenido del cuerpo */
    }
</style>

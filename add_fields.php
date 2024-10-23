<?php
// Conexión a la base de datos
$host = "localhost";
$username = "root"; // Ajusta según tus credenciales
$password = ""; // Ajusta según tus credenciales
$database = "recuperacion";

$conn = new mysqli($host, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'];
    $field_name = $_POST['field_name'];
    $field_type = $_POST['field_type'];

    // Consulta SQL para añadir un nuevo campo
    $sql = "ALTER TABLE $table ADD $field_name $field_type";
    if (mysqli_query($conn, $sql)) {
        echo "<p class='success-message'>Campo añadido correctamente.</p>";
    } else {
        echo "<p class='error-message'>Error al añadir el campo: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevos Campos</title>
    <style>
        /* Contenedor principal */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        select, input[type="text"], input[type="submit"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #009688;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #00796b;
        }

        .success-message, .error-message {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .success-message {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Añadir Nuevos Campos</h1>
    <form method="POST" action="">
        <label for="table">Selecciona la Tabla:</label>
        <select name="table" id="table">
            <?php
            // Obtener tablas de la base de datos
            $result = mysqli_query($conn, "SHOW TABLES");
            while ($row = mysqli_fetch_row($result)) {
                echo "<option value='$row[0]'>$row[0]</option>";
            }
            ?>
        </select>

        <label for="field_name">Nombre del Nuevo Campo:</label>
        <input type="text" name="field_name" required>

        <label for="field_type">Tipo de Campo:</label>
        <select name="field_type">
            <option value="VARCHAR(255)">VARCHAR(255)</option>
            <option value="INT">INT</option>
            <option value="TEXT">TEXT</option>
            <!-- Añade más tipos según sea necesario -->
        </select>

        <input type="submit" value="Añadir Campo">
    </form>
</div>

</body>
</html>

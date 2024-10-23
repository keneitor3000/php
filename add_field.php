<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Campo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Añadir Nuevo Campo a una Tabla</h1>
    <form action="process_add_field.php" method="post">
        <label for="table_name">Nombre de la Tabla:</label>
        <input type="text" id="table_name" name="table_name" required>

        <label for="field_name">Nombre del Nuevo Campo:</label>
        <input type="text" id="field_name" name="field_name" required>

        <label for="field_type">Tipo:</label>
        <select id="field_type" name="field_type">
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

        <input type="submit" value="Añadir Campo">
    </form>

    <!-- Botón para regresar al index.php -->
    <a href="index.php" class="button-regresar">Regresar</a>
</div>

</body>
</html>

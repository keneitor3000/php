<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Tablas - Base de Datos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Gestor de Tablas y Campos - Base de Datos "recuperacion"</h1>

    <!-- Formulario para Crear Tabla -->
    <form action="create_table.php" method="post" class="form-table">
        <h2>Crear una nueva tabla</h2>
        <label for="table_name">Nombre de la tabla:</label>
        <input type="text" id="table_name" name="table_name" required>

        <div id="fields_container">
            <div class="field">
                <label for="field_name[]">Nombre del Campo:</label>
                <input type="text" name="field_name[]" required>

                <label for="field_type[]">Tipo de Dato:</label>
                <select name="field_type[]" required>
                    <option value="VARCHAR">VARCHAR</option>
                    <option value="INT">INT</option>
                    <option value="TEXT">TEXT</option>
                    <option value="DATE">DATE</option>
                    <option value="BOOLEAN">BOOLEAN</option>
                </select>

                <label for="field_length[]">Longitud/Valores:</label>
                <input type="text" name="field_length[]">

                <label for="field_attributes[]">Atributos:</label>
                <select name="field_attributes[]">
                    <option value="">Ninguno</option>
                    <option value="PRIMARY KEY">Clave Primaria</option>
                    <option value="NOT NULL">No Nulo</option>
                    <option value="NULL">Nulo</option>
                    <option value="UNIQUE">Único</option>
                </select>
            </div>
        </div>

        <button type="button" onclick="addField()">Añadir Campo</button>
        <input type="submit" value="Crear Tabla">
    </form>

    <!-- Tarjetas con Botones de Funciones -->
    <div class="card-container">
        <!-- Crear Tabla -->
        <div class="card">
            <h2>Crear Tabla</h2>
            <p>Genera nuevas tablas con los campos y tipos de datos que elijas.</p>
            <a href="#crear-tabla" class="button-action">Crear Tabla</a>
        </div>

        <!-- Ver Tablas -->
        <div class="card">
            <h2>Ver Tablas</h2>
            <p>Consulta las tablas existentes en tu base de datos.</p>
            <a href="view_tables.php" class="button-action">Ver Tablas</a>
        </div>

        <!-- Eliminar Tabla -->
        <div class="card">
            <h2>Eliminar Tabla</h2>
            <p>Selecciona una tabla para eliminarla por completo.</p>
            <a href="delete_table.php" class="button-action">Eliminar Tabla</a>
        </div>

        <!-- Modificar Campo -->
        <div class="card card-modify">
            <h2>Modificar Campo</h2>
            <p>Selecciona una tabla y edita los nombres, tipos y atributos de sus campos.</p>
            <a href="modify_field.php" class="button-action">Modificar Campo</a>
        </div>

        <!-- Insertar Datos -->
        <div class="card card-insert">
            <h2>Insertar Datos</h2>
            <p>Ingresa nuevos datos en los campos de una tabla.</p>
            <a href="insert_data.php" class="button-action">Insertar Datos</a>
        </div>
        
        <!-- Añadir Campos -->
        <div class="card card-add-fields">
            <h2>Añadir Nuevos Campos</h2>
            <p>Selecciona una tabla y añade nuevos campos a la estructura de la misma.</p>
            <a href="add_fields.php" class="button-action">Añadir Campos</a>
        </div>

        <!-- Modificar Registros -->
        <div class="card card-modify-records">
            <h2>Modificar Registros</h2>
            <p>Selecciona una tabla y edita los registros existentes.</p>
            <a href="modify_records.php" class="button-action">Modificar Registros</a>
        </div>

        <!-- Eliminar Registros -->
        <div class="card card-delete-records">
            <h2>Eliminar Registros</h2>
            <p>Selecciona una tabla y elimina los registros que desees.</p>
            <a href="delete_records.php" class="button-action">Eliminar Registros</a>
        </div>

    </div>
</div>

<script>
    function addField() {
        var container = document.getElementById("fields_container");
        var fieldHTML = `<div class="field">
                            <label for="field_name[]">Nombre del Campo:</label>
                            <input type="text" name="field_name[]" required>
                            <label for="field_type[]">Tipo de Dato:</label>
                            <select name="field_type[]" required>
                                <option value="VARCHAR">VARCHAR</option>
                                <option value="INT">INT</option>
                                <option value="TEXT">TEXT</option>
                                <option value="DATE">DATE</option>
                                <option value="BOOLEAN">BOOLEAN</option>
                            </select>
                            <label for="field_length[]">Longitud/Valores:</label>
                            <input type="text" name="field_length[]">
                            <label for="field_attributes[]">Atributos:</label>
                            <select name="field_attributes[]">
                                <option value="">Ninguno</option>
                                <option value="PRIMARY KEY">Clave Primaria</option>
                                <option value="NOT NULL">No Nulo</option>
                                <option value="NULL">Nulo</option>
                                <option value="UNIQUE">Único</option>
                            </select>
                         </div>`;
        container.insertAdjacentHTML('beforeend', fieldHTML);
    }
</script>

</body>
</html>

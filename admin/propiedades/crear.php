<?php
// Base de datos
require '../../includes/config/database.php';
$db = conectarDB();

// Arreglo con mesajes de errores


// Ejecutar el codigo despues de que el usuario envie el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $parqueadero = $_POST['parqueadero'];
    $vendedores_id = $_POST['vendedores_id'];

   

    // Insertar en la base de datos
    $query = "INSERT INTO propiedades (titulo, precio, descripcion,habitaciones, wc, parqueadero,
   vendedores_id) VALUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$parqueadero',
   '$vendedores_id')";

    // Insertar query en la base de datos

    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        echo "Insertado correctamente";
    }
}

require '../../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear propiedad</h1>
    <a href="/admin/" class="boton boton-verde">Volver</a>

    <form class="formulario " method="POST" action="/admin/propiedades/crear.php">
        <fieldset>
            <legend>Informacion general</legend>

            <label for="titulo">Titulo</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" />

            <label for="precio">Precio</label>
            <input type="number" id="precio" name="precio" placeholder="Precio propiedad" />

            <label for="imagen">Imagen</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png " />

            <label for="descripcion">Descripcion</label>
            <textarea id="descripcion" name="descripcion"></textarea>
        </fieldset>

        <fieldset>
            <legend>Informacion propiedad</legend>
            <label for="habitaciones">Habitaciones</label>
            <input type="number" id="Habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" />

            <label for="wc">Baños</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 2" min="1" max="9" />

            <label for="parquedero">Parqueaderos</label>
            <input type="number" id="parqueadero" name="parqueadero" placeholder="Ej: 2" min="1" max="9" />
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedores_id">
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="1">Juan</option>
                <option value="2">Pedro</option>
                <option value="3">Maria</option>
        </fieldset>

        <input type="submit" value="Crear propiedad" class="boton boton-verde" />

    </form>
</main>

<?php incluirTemplate('footer'); ?>
<?php

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id) {
    header('Location: /admin');
}

// Base de datos
require '../../includes/config/database.php';
$db = conectarDB();

// Consultar la propiedad
$consulta = "SELECT * FROM propiedades WHERE id = ${id}";
$resultado = mysqli_query($db, $consulta);
$propiedad = mysqli_fetch_assoc($resultado);


//Consultar la base de datos para obtener los vendedores

$consulta= "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

// Arreglo con mesajes de errores
$errores = [];

// Obtener los datos de la propiedad
    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $parqueadero = $propiedad['parqueadero'];
    $vendedores_id = $propiedad['vendedores_id'];
    $imagen = $propiedad['imagen'];

    
// Ejecutar el codigo despues de que el usuario envie el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
//
   // echo "<pre>";
   // var_dump($_FILES);
   // echo "</pre>";

    // Sanitizar los datos
    $titulo = mysqli_real_escape_string( $db, $_POST['titulo'] );           
    $precio = mysqli_real_escape_string( $db,$_POST['precio'] );
    $descripcion = mysqli_real_escape_string( $db,$_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string( $db,$_POST['habitaciones']);
    $wc = mysqli_real_escape_string( $db,$_POST['wc']);
    $parqueadero = mysqli_real_escape_string( $db,$_POST['parqueadero']);
    $vendedores_id = mysqli_real_escape_string( $db,$_POST['vendedores_id']);
    $creado = date('y/m/d'); 

    // Asignar files a una variable
    $imagen = $_FILES['imagen'];

  
    // Validar que no haya campos vacios
    if (!$habitaciones) {
        $errores[] = "El numero de habitaciones es obligatorio";
    }
    if (!$titulo) {
        $errores[] = "Debes añadir un titulo";
    }

    if (!$precio) {
        $errores[] = "El precio es obligatorio";
    }

    if (strlen($descripcion) < 50) {
        $errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
    }

    if (!$habitaciones) {
        $errores[] = "El numero de habitaciones es obligatorio";
    }

    if (!$wc) {
        $errores[] = "El numero de baños es obligatorio";
    }

    if (!$parqueadero) {
        $errores[] = "El numero de parqueaderos es obligatorio";
    }

    if (!$vendedores_id) {
        $errores[] = "Elige un vendedor";
    }

    

    // Validar el tamaño de la imagen (1mb maximo)
    $medida = 1000 * 1000;

    if ($imagen['size'] > $medida) {
        $errores[] = "La imagen es muy pesada, debe pesar menos de 100kb";
    }

    //echo "<pre>";
    //var_dump($errores);
    //echo "</pre>";

    // Revisar que el arreglo de errores este vacio
    if (empty($errores)) {
         
        // Crear una carpeta
        $carpetaImagenes = '../../imagenes/';
  
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
       }

        /**SUBIDA DE ARCHIVOS */
      
        if ($imagen['name']) {
           //eliminar la imagen anterior
           unlink($carpetaImagenes . $propiedad['imagen']);
                   // Crear un nombre unico para la imagen
           $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

           //Subir la imagen
           move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );
        } else {
            $nombreImagen = $propiedad['imagen'];
        }

        // Actualizar en la base de datos
        $query = "UPDATE propiedades SET titulo = '$titulo', precio = '$precio', imagen = '$nombreImagen', descripcion = '$descripcion',habitaciones = '$habitaciones', wc = '$wc', parqueadero = '$parqueadero', creado = '$creado',
        vendedores_id = '$vendedores_id' WHERE id = $id";

        // Insertar query en la base de datos

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            //Redireccionar al usuario
            header('Location: /admin?resultado=2');
        }
    }
}

require '../../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar propiedad</h1>
    <a href="/admin/" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>    

    <form class="formulario " method="POST" enctype="multipart/form-data"> 
        <fieldset>
            <legend>Informacion general</legend>

            <label for="titulo">Titulo</label>
            <input type="text"
                   id="titulo"
                   name="titulo"
                   placeholder="Titulo propiedad"
                   value="<?php echo $titulo; ?>" />

            <label for="precio">Precio</label>
            <input type="number"
                   id="precio" 
                   name="precio" 
                   placeholder="Precio propiedad" 
                   value="<?php echo $precio; ?>" />

            <label for="imagen">Imagen</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png " name="imagen" />

            <img src="/imagenes/<?php echo $imagen; ?>" alt="Imagen propiedad" class="imagen-propiedad">

            <label for="descripcion">Descripcion</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Informacion propiedad</legend>
            <label for="habitaciones">Habitaciones</label>
            <input type="number"
                    id="Habitaciones"
                    name="habitaciones" 
                    placeholder="Ej: 3"
                    min="1" max="9" 
                    value="<?php echo $habitaciones; ?>" />

            <label for="wc">Baños</label>
            <input type="number"
                   id="wc" name="wc"
                   placeholder="Ej: 2"
                   min="1" max="9"
                   value="<?php echo $wc; ?>"   />

            <label for="parquedero">Parqueaderos</label>
            <input type="number"
                   id="parqueadero"
                   name="parqueadero"
                   placeholder="Ej: 2"
                   min="1" max="9"
                   value="<?php echo $parqueadero; ?>" />
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedores_id">
                <option value="">-- Seleccione --</option>
                <?php while ($vendedor = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>">
                        <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?>   
                    </option>
                <?php endwhile; ?>
               
        </fieldset>

        <input type="submit" value="Actualizar propiedad" class="boton boton-verde" />

    </form>
</main>

<?php incluirTemplate('footer'); ?>
<?php
require 'includes/funciones.php';
 incluirTemplate('header');
?>

<?php 
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id) {
    header('Location: /');
}
// Importar conexion
require 'includes/config/database.php';
$db = conectarDB();

//Consultar
$consulta = "SELECT * FROM propiedades WHERE id = ${id}";

// Mostrar resultados
$resultado = mysqli_query($db, $consulta);
if($resultado->num_rows) {
    $propiedad = mysqli_fetch_assoc($resultado);
} else {
    header('Location: /');
}

?>


    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad['titulo']; ?></h1>
            <img loading="lazy" src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="imagen de la propiedad">
        <div class="resumen-propiedad">
            <p class="precio">$<?php echo $propiedad['precio']; ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad['wc']; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad['parqueadero']; ?></p>
                </li>
                <li>
                    <img class="icono"  loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad['habitaciones']; ?></p>
                </li>
            </ul>

            <?php echo $propiedad['descripcion']; ?>

        </div>
       
    </main>

   <?php
     mysqli_close($db);
     incluirTemplate('footer');
    ?>
    
<?php 
// Importar conexion
require 'includes/config/database.php';
$db = conectarDB();

//Consultar
$consulta = "SELECT * FROM propiedades LIMIT ${limite}";

// Mostrar resultados
$resultado = mysqli_query($db, $consulta);

?>


<div class="contenedor-anuncios">
    <?php while($propiedad = mysqli_fetch_assoc($resultado)) : ?>
            <div class="anuncio">
                <picture style="border-radius: inherit; overflow: hidden; display: block;">
                    <img loading="lazy" src="../imagenes/<?php echo $propiedad['imagen']; ?>" alt="anuncio" style="width: 100%; height: 100%; object-fit: cover;">
                </picture>

                <div class="contenido-anuncio">
                    <h3><?php echo $propiedad['titulo']; ?></h3>
                    <p><?php echo $propiedad['descripcion']; ?></p>
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
                            <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                            <p><?php echo $propiedad['habitaciones']; ?></p>
                        </li>
                    </ul>

                    <a href="anuncio.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">
                        Ver Propiedad
                    </a>
                </div><!--.contenido-anuncio-->
            </div><!--anuncio-->
    <?php endwhile; ?>
        </div> <!--.contenedor-anuncios-->

        <?php
        // Cerrar la conexion
        mysqli_close($db);
        ?>
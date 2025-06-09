<?php

// Importar la conexion
require '../includes/config/database.php';
$db = conectarDB();

//Escribir el query
$query = "SELECT * FROM propiedades";

//Consultar la base de datos
$resultadoConsulta = mysqli_query($db, $query);

// muestra mensaje condicional 
$resultado = $_GET['resultado'] ?? null ;

// Incluye un template
require '../includes/funciones.php';
 incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>

        <?php if ( intval($resultado) === 1): ?>
            <p class="alerta exito">Propiedad Creada Correctamente</p>
        <?php endif; ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>

      <table class="propiedades">
        <thead>
            <tr>
                <th>Id</th>
                <th>Titulo</th>
                <th>imagen</th>
                <th>precio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody> <!-- Mostrar resultados -->  
            <?php while ($propiedad = mysqli_fetch_assoc($resultadoConsulta)) : ?>
            <tr>
                <td><?php echo $propiedad['id']; ?></td>
                <td><?php echo $propiedad['titulo']; ?></td>
                <td><img src="/imagenes/<?php echo $propiedad['imagen']; ?>" class="imagen-tabla" alt="propiedad"></td>
                <td>$<?php echo $propiedad['precio']; ?></td>
                <td>
                    <a href="#" class="boton-rojo-block">Eliminar</a>
                    <a href="#" class="boton-amarillo-block">Actualizar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
      </table>
    </main>
     
    <!-- cerrar la conexion-->
    <?php mysqli_close($db); ?>
  

     <?php 
         incluirTemplate('footer');
      ?>
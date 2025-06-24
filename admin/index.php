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

// Eliminar propiedad
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $id = $_POST['id'];
   $id = filter_var($id, FILTER_VALIDATE_INT);

   if($id) {
       
    //Eliminar archivo
    $query = "SELECT imagen FROM propiedades WHERE id = ${id}";
    $resultado = mysqli_query($db, $query);
    $propiedad = mysqli_fetch_assoc($resultado);
    unlink('../imagenes/' . $propiedad['imagen']);
    
    //Eliminar propiedad
    $query = "DELETE FROM propiedades WHERE id = ${id}";
    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        header('Location: /admin?resultado=3');
    }
   }  
}



// Incluye un template
require '../includes/funciones.php';
$inicio = false; // Para que no muestre la barra
incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>

        <?php if ( intval($resultado) === 1): ?>
            <p class="alerta exito">Propiedad Creada Correctamente</p>
    
        <?php elseif ( intval($resultado) === 2): ?>
            <p class="alerta exito">Propiedad Actualizada Correctamente</p>
        <?php endif; ?>

        <?php if ( intval($resultado) === 3): ?>
            <p class="alerta exito">Propiedad Eliminada Correctamente</p>
        <?php endif; ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>

      <div class="contenedor-tabla">
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!--Mostrar los resultados-->
                <?php while ($propiedad = mysqli_fetch_assoc($resultadoConsulta)) : ?>
                <tr>
                    <td data-label="ID"><?php echo $propiedad['id']; ?></td>
                    <td data-label="Título"><?php echo $propiedad['titulo']; ?></td>
                    <td data-label="Imagen">
                        <img src="/imagenes/<?php echo $propiedad['imagen']; ?>" class="imagen-tabla" alt="<?php echo $propiedad['titulo']; ?>">
                    </td>
                    <td data-label="Precio">$<?php echo number_format($propiedad['precio']); ?></td>
                    <td data-label="Acciones">
                        <div class="botones-accion">
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-accion boton-amarillo-block">Actualizar</a>
                            <form method="POST" class="form-accion">
                                <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">
                                <input type="submit" class="boton-accion boton-rojo-block" value="Eliminar" name="eliminar">
                            </form>
                           
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
      </div>
    </main>
     
    <!-- cerrar la conexion-->
    <?php mysqli_close($db); ?>
  

     <?php 
         incluirTemplate('footer');
      ?>
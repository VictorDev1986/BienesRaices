<?php
require 'includes/config/database.php';
$db = conectarDB();

// Autenticar usuario

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";

    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));



    $contraseña = $_POST['contraseña'];
}



// Incluye Header
 require 'includes/funciones.php';
 incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
       <h1>Iniciar seccion</h1>

       <form method="POST" class = "formulario">
       <fieldset>
                <legend>Email y Contraseña</legend>

                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Tu Email" id="email">

                <label for="contraseña">Contraseña</label>
                <input type="password" name="contraseña" placeholder="Tu Contraseña" id="contraseña">

            </fieldset>
            <input type="submit" value="Iniciar seccion" class="boton boton-verde">
       </form>
</main>

<?php
 incluirTemplate('footer');
?>
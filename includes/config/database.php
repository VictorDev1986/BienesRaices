

<?php

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost:3308', 'root', 'admin', 'bienesraices_crud');

    if (!$db) {
        echo "Error no se pudo conectar a la base de datos";
        exit;
    } 

    return $db;
}








<?php

// importar la conexion
require 'includes/config/database.php';
$db = conectarDB();

//Crear un email y contraseña

$email = "victordev1986@gmail.com";
$contraseña = "123456";

$contraseñaHash = password_hash($contraseña, PASSWORD_BCRYPT);

// Query para crear el usuario
$query = "INSERT INTO usuarios (email, contraseña) VALUES ('${email}', '${contraseñaHash}')";

//echo $query;

// Agregarlo a la base de datos
mysqli_query($db, $query);






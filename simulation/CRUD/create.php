<?php
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
/* Este archivo debe manejar la lógica para crear un usuario como admin */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* Se asignan las variables con la informacion que entrega el admin */
    $paises = array("Angola","Sudáfrica","Canadá","Estados Unidos","Chile","Australia","India","Corea del Sur","Rusia","Suiza");
    $nombre = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $apellido = filter_var($_POST["surname"], FILTER_SANITIZE_STRING);
    $correo = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
    $contrasena = $_POST["pwd"];
    $pais = $paises[intval($_POST["country"])-1];
    /* Se establece el costo de hash de las contraseñas */
    $opciones = array('cost'=>12);
    $contrasena_hasheada = password_hash($contrasena, PASSWORD_BCRYPT, $opciones);
    /* Se inserta toda la informacion ingresada por el admin a la tabla usuarios */
    $sql = 'INSERT INTO Usuario (nombre,apellido,correo,contra,pais) VALUES ($1,$2,$3,$4,$5)';
    if(pg_query_params($dbconn, $sql, array($nombre,$apellido,$correo,$contrasena_hasheada,$pais)) !== FALSE ){
        pg_close($dbconn);
        header('location: /admin/users/all.html');
    }
}
?>
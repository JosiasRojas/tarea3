<?php
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
session_start();
/* Este archivo debe manejar la lógica de actualizar los datos de un usuario como admin */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* Se obtiene todo lo entregado por el administrador y se envia a la BD, muy parecido al proceso realizado
    en create.php y signup.php */
    $paises = array("Angola","Sudáfrica","Canadá","Estados Unidos","Chile","Australia","India","Corea del Sur","Rusia","Suiza");
    $nombre = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $apellido = filter_var($_POST["surname"], FILTER_SANITIZE_STRING);
    $correo = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
    $contrasena = $_POST["pwd"];
    $pais = $paises[intval($_POST["country"])-1];
    $opciones = array('cost'=>12);
    $contrasena_hasheada = password_hash($contrasena, PASSWORD_BCRYPT, $opciones);
    /* Se actualizan los datos del usuario a traves de la consulta sql UPDATE si y solo si el id del
    usuario seleccionado coincide con la correspondiente en la BD */
    $sql = 'UPDATE Usuario SET nombre=$1,apellido=$2,correo=$3,contra=$4,pais=$5 WHERE id_usuario = $6';
    if(pg_query_params($dbconn, $sql, array($nombre,$apellido,$correo,$contrasena_hasheada,$pais,$_SESSION['id_update'])) !== FALSE ) {
        pg_close($dbconn);
        header('Location: /admin/users/all.html');
    }
}
?>
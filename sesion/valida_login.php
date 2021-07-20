<?php 
/* Este archivo debe manejar la lógica de iniciar sesión */
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
/* Aqui se recibe el correo ingresado por el usuario y se aplica un FILTER_SANITIZE_STRING para filtrar 
el string y eliminar ciertos elementos como los espacios */
$correo_entregado = filter_var($_POST["correo"], FILTER_SANITIZE_STRING);
$contra_entregado = $_POST["contra"];

// Comparar contraseñas de BD con entregadas
$sql =  'SELECT * FROM Usuario WHERE correo=$1';
/* Se selecciona toda la informacion correspondiente al usuario si y solo si, el correo coincide */
/* SE PODRIA SOLO SELECCIONAR id_usuario e is_admin!!! */
$result = pg_query_params($dbconn, $sql, array($correo_entregado));
if(pg_num_rows($result) == 1) {
    while($row = pg_fetch_assoc($result)){
        if(password_verify($contra_entregado,$row['contra'])){
            /* Se revisa la contraseña ingresada con la que se encuentra hasheada y almacenada en la base de
            datos para acreditar la identidad del usuario */
            echo "Sesion iniciada correctamente <br>";
            session_start();
            $_SESSION["id_usuario"] = $row['id_usuario'];
            $_SESSION["is_admin"] = $row['is_admin'];
            header('location: /index.html');
        }
        else{
            echo "Error al iniciar sesion";
        }
    }
    pg_close($dbconn);
    }
else {
    echo "Error al iniciar sesion";
    pg_close($dbconn);
}
?>
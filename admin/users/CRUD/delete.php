<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
/* Este archivo debe manejar la lógica de borrar un usuario (y los registros relacionados) como admin */
/* Se borran los datos del usuario si coinciden con la id seleccionada en la pagina, notar que esto
borrara en cascada sus datos en billetera */
$sql='DELETE FROM Usuario
        WHERE Usuario.id_usuario = $1';
pg_query_params($dbconn, $sql, array($_GET['id']));
/* Se cierra la conexion y se redirige al administrador a la seccion donde se ven todos los usuarios*/
pg_close($dbconn);
header('location: /admin/users/all.html');
?>
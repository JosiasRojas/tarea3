<?php
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
/* Este archivo debe manejar la lógica para obtener la información del perfil */
/* Se realiza una consulta sql donde se encuentren las sgte informacion si y solo si el id de la sesion 
iniciada coincide con al correspondiente en la BD */
$sql = 'SELECT nombre,apellido,correo,pais,fecha_ingreso FROM Usuario WHERE id_usuario = $1';
$result = pg_query_params($dbconn, $sql, array($_SESSION["id_usuario"]));
if(pg_num_rows($result) == 1) {
    while($row = pg_fetch_assoc($result)){
        /* Lo sgte es lo que se manifiesta en el HTML 
        Se muestra el nombre completo, correo, etc */
        echo '<p>Nombre Completo: '.$row['nombre'].' '.$row['apellido'].'</p>
        <p>Correo: '.$row['correo'].'</p>
        <p>País: '.$row['pais'].'</p>
        <p>Fecha de Ingreso: '.$row['fecha_ingreso'].'</p>';
    }
}
pg_close($dbconn);        
?>
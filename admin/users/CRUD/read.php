<?php
/* Se crea un arreglo con los paises */
$paises = array("Angola","Sudáfrica","Canadá","Estados Unidos","Chile","Australia","India","Corea del Sur","Rusia","Suiza");
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
/* se crea un variable $usuario */
$usuario = NULL;
if(isset($_SESSION["id_usuario"]) && $_SESSION["is_admin"] == 't'){
    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])){
        /* a traves de la consulta sql, se seleccionaran los sgtes datos del usuario, si y solo si
        la id entregada a traves de la eleccion del admin coincida con la correspondiente en la BD*/
        $sql = 'SELECT id_usuario,nombre,apellido,correo,pais,fecha_ingreso FROM Usuario WHERE id_usuario = $1';
        $result = pg_query_params($dbconn, $sql, array($_GET["id"]));
        if(pg_num_rows($result) > 0){
            while($row = pg_fetch_assoc($result)){
                $usuario = $row;
                /* a traves de id_update, nos permite saber si el administrador desea
                modificar el usuario escogido */
                $_SESSION['id_update'] = $_GET['id'];
                $usuario['cod_pais']=array_search($usuario['pais'], $paises)+1;
            }
        }
        else{
            pg_close($dbconn);
            header('location: /admin/users/all.html');
        }
    }
}
pg_close($dbconn);
/* Este archivo debe manejar la lógica de obtener los datos de un determinado usuario */
?>
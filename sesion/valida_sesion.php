<?php
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}
session_start();
$uri = $_SERVER['REQUEST_URI'];
/* Se revisa que este iniciada la sesion y el usuario no sea admin */
/* Esto hara que el usuario no admin no pueda ver las paginas que le brindan las funciones propias de admin */
if(isset($_SESSION["id_usuario"]) && $_SESSION["is_admin"] == 'f'){
   if($uri == '/admin/users/all.html' || startsWith($uri,'/admin/users/create.html') || startsWith($uri,'/admin/users/delete.html')
   || startsWith($uri,'/admin/users/update.html') || startsWith($uri,'/admin/users/read.html')
   || startsWith($uri,'/simulation')){
      /* En caso de intentar acceder, se redirige a la pagina de inicio */
      header('location: /index.html');
   }
   else{
      /* Se realiza una consulta sql para revisar que el usuario posea dinero */
      /* Esto nos ayudara a determinar si debe aparecer la opcion billetera dentro de la interfaz
      del usuario no administrador */
      $sql = 'SELECT 1 FROM Billetera WHERE id_usuario = $1';
      $result = pg_query_params($dbconn, $sql, array($_SESSION['id_usuario']));
      if(pg_num_rows($result) > 0) {
         $_SESSION['tiene_moneda'] = 1;
      }
      else{
         $_SESSION['tiene_moneda'] = 0;
      }
   }
}
/* Si no se ha iniciado sesion, se limitara todo intento de acceder de manera que solo se permitira
acceder a la pagina de index */
if(isset($_SESSION["id_usuario"]) == FALSE){
   if($uri != '/index.html' && $uri != '/sesion/log-in.html' && $uri !='/sesion/sign-up.html'){
      header('location: /index.html');
   }
}
/* Si se ha iniciado sesion y el usuario es admin, por efectos de la tarea, este no podra acceder a biletera,
no asi a las funciones aportadas a traves de la pagina de usuarios */
if(isset($_SESSION["id_usuario"]) && $_SESSION["is_admin"] == 't'){
   if($uri == '/user/wallet.html'){
      header('location: /index.html'); 
   }
}



/* Este archivo debe usarse para comprobar si existe una sesión válida 
   Considerar qué pasa cuando la sesión es válida/inválida para cada página:
   - Página principal
   - Mi perfil
   - Mi billetera
   - Administración de usuarios y todo el CRUD
   - Iniciar Sesión
   - Registrarse
*/
?>
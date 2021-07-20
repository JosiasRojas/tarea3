<?php
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
/* Este archivo debe validar los datos de registro y manejar la lógica de crear un usuario desde el formulario de registro */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* se crean las sgtes variables y se asignan segun lo que se ha ingresado en el formulario de 
    registro */
    $paises = array("Angola","Sudáfrica","Canadá","Estados Unidos","Chile","Australia","India","Corea del Sur","Rusia","Suiza");
    $nombre = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $apellido = filter_var($_POST["surname"], FILTER_SANITIZE_STRING);
    $correo = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
    $contrasena = $_POST["pwd"];
    $contrasena2 = $_POST["pwd2"];
    $pais = $paises[intval($_POST["country"])-1]; 
    /* Se revisa que la contraseña y la contraseña ingresada por 2da vez coincidan */
    /* Si coinciden, Se establece el costo de hash y se envia a la BD la contraseña hasheada */
    if ($contrasena == $contrasena2) {
        $opciones = array('cost'=>12);
        $contrasena_hasheada = password_hash($contrasena, PASSWORD_BCRYPT, $opciones);
        $sql = 'INSERT INTO Usuario (nombre,apellido,correo,contra,pais) VALUES ($1,$2,$3,$4,$5)';
        if(pg_query_params($dbconn, $sql, array($nombre,$apellido,$correo,$contrasena_hasheada,$pais)) !== FALSE ) {
            echo "Dato ingresado correctamente <br>";
            pg_close($dbconn);
            header('Location: /sesion/log-in.html');
        } else {
            echo "Hubo un error al ingresar el dato";
            pg_close($dbconn);
        }
      }
    else {
        echo "Contraseña erronea, intente nuevamente";
    }
}
?>
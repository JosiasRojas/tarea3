<?php
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
include 'restricciones.php';


if($_SERVER["REQUEST_METHOD"] == "POST" &&  isset($_GET['table'])){
    $table = $_GET['table'];
    $api_url = "http://localhost:5000/api/$table";
    $data_array = $_POST;

    // Si existe contraseña se guarda hasheada
    if(isset($data_array['contraseña'])){
        /* Se establece el costo de hash de las contraseñas */
        $contrasena = $data_array["contraseña"];
        $opciones = array('cost'=>12);
        $contrasena_hasheada = password_hash($contrasena, PASSWORD_BCRYPT, $opciones);
        $data_array["contraseña"] = $contrasena_hasheada;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-type: application/json"));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_array));
    curl_exec($ch);
    curl_close($ch);
    header('location: /simulation/CRUD.html?table='.$table);
}


function getForm($table){

    $paises = getFormPaises();

    $forms = array(
        "pais" => array("cod_pais" => "1","nombre" => "chile"),
        "usuario" => array("nombre" => "Juan","apellido" => "perez","correo" => "juan.perez@usm.cl","contraseña"=> "contraseña","pais" => "1"),
        "cuenta_bancaria" => array("id_usuario" => "1","balance" => "1000"),
        "moneda" => array("sigla" => "CLP","nombre" => "Peso chileno"),
        "precio_moneda" => array("id_moneda" => "1","valor" => "120"),
        "usuario_tiene_moneda" => array("balance" => "1200","id_usuario" => "1","id_moneda" => "1")
    );

    return array("form" => $forms[$table], "paises" => $paises);
}
?>
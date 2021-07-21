<?php
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';


if($_SERVER["REQUEST_METHOD"] == "POST" &&  isset($_GET['table'])){
    $table = $_GET['table'];
    $api_url = "http://localhost:5000/api/$table";
    $data_array = $_POST;

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
    $forms = array(
        "pais" => array("cod_pais","nombre"),
        "usuario" => array("nombre","apellido","correo","contraseña","pais"),
        "cuenta_bancaria" => array("id_usuario","balance"),
        "moneda" => array("sigla","nombre"),
        "precio_moneda" => array("id_moneda","valor"),
        "usuario_tiene_moneda" => array("balance","id_usuario","id_moneda")
    );

    return $forms[$table];
}
?>
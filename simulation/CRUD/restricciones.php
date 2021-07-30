<?php

function isRestricted($table,$val){
    $restricciones = array(
        "pais" => array("cod_pais"),
        "usuario" => array("id","fecha_registro","contraseña"),
        "cuenta_bancaria" => array("numero_cuenta","id_usuario"),
        "usuario_tiene_moneda" => array("id_usuario","id_moneda"),
        "moneda" => array("id"),
        "precio_moneda" => array("id_moneda","fecha")
    );

    foreach($restricciones[$table] as $key){
        if($key == $val){
            return true;
        }
    }
    return false;
}

function getFormPaises(){
    $api_url = "localhost:5000/api/pais";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $data = json_decode($output,true);
    
    $data = $data["pais"];
    curl_close($ch);
    return $data;
}

?>
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

?>
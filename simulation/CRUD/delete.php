<?php

$table = $_GET['table'];
$id = $_GET['id'];

$api_url = "http://localhost:5000/api/$table/$id";
if($table == "usuario_tiene_moneda"){
    $api_url = $api_url."/".$_GET['id2'];
}else if($table == "precio_moneda"){
    $fecha = urldecode($_GET['fecha']);
    $data_array = array("fecha"=>$fecha);
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
if($table == "precio_moneda"){
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_array));
}
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_exec($ch);
curl_close($ch);
header('location: /simulation/CRUD.html?table='.$table);

?>
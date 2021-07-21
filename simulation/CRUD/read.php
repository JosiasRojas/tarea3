<?php

include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';

/* se crea un variable $usuario */
$usuario = NULL;
$table = NULL;
// Solo se aceptan usuarios administradores
if(isset($_SESSION["id_usuario"]) && $_SESSION["is_admin"] == 't'){
    // id= es valor de la id; id_name=nombre del campo del id; table = tabla a la cual se esta accediendo
    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) &&  isset($_GET['table'])){
        $table = $_GET['table'];
        $id = $_GET['id'];
        $api_url = "http://localhost:5000/api/$table";
        // $data_array = array("id"=>$id);

        if($table == "usuario_tiene_moneda"){
            $data_array = array("id"=>$id,"id2"=>$_GET['id2']);
        }else if($table == "precio_moneda"){
            $fecha = urldecode($_GET['fecha']);
            $data_array = array("id"=>$id,"fecha"=>$fecha);
        }else{
            $data_array = array("id"=>$id);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-type: application/json"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_array));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        $data = json_decode($output,true);
        $data = $data[$table];
        curl_close($ch);
    }
}
?>
<?php 
    $consultas_info = array(
        "c1" => array(
            "descripcion" => "algo",
            "form" => array("Año","20xx","number"), // Label, Placeholder, tipo
            "body" => "year"
        ),
        "c2" => array(
            "descripcion" => "algo",
            "form" => array("Balance","1000","number"),
            "body" => "balance"
        ),
        "c3" => array(
            "descripcion" => "algo",
            "form" => array("Pais","1","number"),
            "body" => "pais"
        ),
        "c4" => array(
            "descripcion" => "algo",
            "form" => array("Moneda","1","number"),
            "body" => "moneda"
        ),
        "c5" => array(
            "descripcion" => "algo",
            "form" => array("Moneda","1","number"),
            "body" => "moneda"
        ),
        "c6" => array(
            "descripcion" => "algo",
        ),
        "c7" => array(
            "descripcion" => "algo",
            "form" => array("Fecha","20XX-XX","text") // año-mes
        ),
        "c8" => array(
            "descripcion" => "algo",
            "form" => array("Usuario","1","text")
        )
    );   
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $cod = $_GET['c'];
        $consulta = $cod[1];
        if(isset($_POST['data'])){
            $data = $_POST['data'];
        }

        $api_url = "http://localhost:5000/api/consultas/$consulta";

        $ch = curl_init();
        if($cod == 'c1' || $cod == 'c2' || $cod == 'c3' || $cod == 'c4' || $cod == 'c5'){
            curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-type: application/json"));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array($consultas_info[$cod]['body'] => $data))); 
        }else if($cod != 'c6'){
            $api_url .= "/$data";
        }
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        $data = json_decode($output,true);
        
        $data = $data['data'];

        curl_close($ch);

        session_start();
        $_SESSION["data"] = $data;
        
        header('location: /simulation/CONS/show.html');
    }
?>
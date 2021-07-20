<?php

    $ids = array("pais"=>"cod_pais",
                 "usuario"=>"id",
                 "precio_moneda"=>"id_moneda",
                 "moneda"=>"id",
                 "cuenta_bancaria"=>"numero_cuenta");
    $table = $_GET['table'];
    $api_url = "http://localhost:5000/api/$table";
    // Read JSON file
    $json_data = file_get_contents($api_url);

    // Decode JSON data into PHP array
    $response_data = json_decode($json_data,true);
    
    if(count($response_data["$table"]) > 0){
        echo "
        <thead>
            <tr>
        ";
        foreach($response_data["$table"][0] as $key => $val){
            echo "<th>$key</th>";
        }
        echo "
            </tr>
        </thead>
        <tbody>
        ";
    
        foreach($response_data["$table"] as $res){
            echo "<tr>";
            foreach($res as $values){
                echo "<td>$values</td>";
            }
            if($table == "usuario_tiene_moneda"){
                echo "
                <td><a href='/simulation/read.html?id=".$res['id_usuario']."&id2=".$res['id_moneda']."&table=".$table."' class='btn c-btn-primary'>Ver <i
                        class='fas fa-search'></i></a>
                    <a href='/simulation/update.html?id=".$res['id_usuario']."&id2=".$res['id_moneda']."&table=".$table."' class='btn c-btn-warning'>Editar <i
                        class='fas fa-edit'></i></a>
                    <a href='/simulation/CRUD/delete.php?id=".$res['id_usuario']."&id2=".$res['id_moneda']."&table=".$table."' class='btn c-btn-danger'>Borrar <i
                        class='fas fa-trash-alt'></i></a>
                </td>
                ";
                echo "</tr>";
            }else if($table == "precio_moneda"){
                echo "
                <td><a href='/simulation/read.html?id=".$res['id_moneda']."&fecha=".$res['fecha']."&table=".$table."' class='btn c-btn-primary'>Ver <i
                        class='fas fa-search'></i></a>
                    <a href='/simulation/update.html?id=".$res['id_moneda']."&fecha=".$res['fecha']."&table=".$table."' class='btn c-btn-warning'>Editar <i
                        class='fas fa-edit'></i></a>
                    <a href='/simulation/CRUD/delete.php?id=".$res['id_moneda']."&fecha=".$res['fecha']."&table=".$table."' class='btn c-btn-danger'>Borrar <i
                        class='fas fa-trash-alt'></i></a>
                </td>
                ";
            }
            else{
                echo "
                <td><a href='/simulation/read.html?id=".$res[$ids[$table]]."&table=".$table."' class='btn c-btn-primary'>Ver <i
                        class='fas fa-search'></i></a>
                    <a href='/simulation/update.html?id=".$res[$ids[$table]]."&table=".$table."' class='btn c-btn-warning'>Editar <i
                        class='fas fa-edit'></i></a>
                    <a href='/simulation/CRUD/delete.php?id=".$res[$ids[$table]]."&table=".$table."' class='btn c-btn-danger'>Borrar <i
                        class='fas fa-trash-alt'></i></a>
                </td>";
                echo "</tr>";
            }
        }
        echo "</tbody>";
    }else{
        echo "Vacia";
    }
?>
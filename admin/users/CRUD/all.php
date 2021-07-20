<?php
/* Este archivo debe manejar la lógica de obtener los datos de todos los usuarios */
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
/* seleccionamos ciertas columnas de datos de la tabla Usuario */
$sql = 'SELECT id_usuario,nombre,apellido,correo FROM Usuario';
$result = pg_query_params($dbconn, $sql, array());
if(pg_num_rows($result) > 0 ) {
    while($row = pg_fetch_assoc($result)) {
        /* aca echo imprime la sgte estructura en el html, asi se va mostrando la informacion de los 
        usuarios */
        echo
        "<tr>
        <td>" . $row["id_usuario"] . "</td>
        <td>" . $row["nombre"] . "</td>
        <td>" . $row["apellido"] . "</td>
        <td>" . $row["correo"] . "</td>
        <td><a href='/admin/users/read.html?id=".$row["id_usuario"]."' class='btn c-btn-primary'>Ver <i
                    class='fas fa-search'></i></a>
            <a href='/admin/users/update.html?id=".$row["id_usuario"]."' class='btn c-btn-warning'>Editar <i
                    class='fas fa-edit'></i></a>
            <a href='/admin/users/CRUD/delete.php?id=".$row["id_usuario"]."' class='btn c-btn-danger'>Borrar <i
                    class='fas fa-trash-alt'></i></a>
        </td>
    </tr>";
    }
    pg_close($dbconn);
} else {
    echo "Hubo un error al solicitar los datos";
    pg_close($dbconn);
}

?>
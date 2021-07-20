<?php
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
/* Este archivo debe manejar la lógica para obtener la información de la billetera */
/* Se realizan 2 Inner join de Billetera, Moneda y Usuario */
/* De aqui se busca el id de la sesion con su correspondiente en la tabla de Usuarios 
y se busca a su vez, el correspondiente en Billetera */
/* Si existen registros de dinero del usuario, entonces se busca el codigo de la moneda y la informacion
pertinente en Moneda */
$sql = 'SELECT 	Billetera.codigo,Moneda.nombre,Billetera.cantidad,Moneda.valor_actual,
				Billetera.cantidad*Moneda.valor_actual AS total	
		FROM Billetera 
			INNER JOIN Usuario 
				ON Billetera.id_usuario = usuario.id_usuario
			INNER JOIN Moneda 
				ON Billetera.codigo = Moneda.cod
		WHERE Usuario.id_usuario = $1';
$result = pg_query_params($dbconn, $sql, array($_SESSION['id_usuario']));
if(pg_num_rows($result) == 0){
	header('location: /index.html');
	pg_close($dbconn);
}
?>

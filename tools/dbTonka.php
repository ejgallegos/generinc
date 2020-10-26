<?php

function query_log_tonka($sql, $datos=array()) {
	$db_tonka = "tonka.prod";
    $conexion = "mysql:host=". DB_HOST .";dbname=". $db_tonka .";charset=utf8";
    $opciones = array(PDO::ATTR_PERSISTENT=>true);
    $conn = new PDO($conexion, "adm_tonka", "Londres.18", $opciones);

    $query = $conn->prepare($sql);

    foreach($datos as $i=>$dato) $query->bindParam($i+1, $datos[$i]);

    $query->execute();

    $id_ingresado = $conn->lastInsertId();
    $registros_leidos = $query->fetchAll(PDO::FETCH_ASSOC);

    return ($registros_leidos) ? $registros_leidos : $id_ingresado;
}

?>
<?php 
header('Content-Type: application/json; charset=utf-8');
    include_once("../configuracion.php");
    
    $datos = data_submitted();
    $objEvento = new AbmEvento();

    $colInfo = $objEvento->obtenerEventos();
    echo json_encode($colInfo);
    
 

?>
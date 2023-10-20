<?php
/* header('Content-Type: application/json; charset=utf-8'); */
include_once("../configuracion.php");
$datos = data_submitted();
$objEvento = new AbmEvento();
$objEvento->modificacion($datos);
/* echo json_encode($objEvento); */
?>
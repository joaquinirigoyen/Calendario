<?php
include_once("../configuracion.php");
$metodos = data_submitted();
$objEvento = new AbmEvento();
$objEvento->baja($metodos);

?>
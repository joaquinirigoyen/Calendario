<?php

include_once("../configuracion.php");
$datos = data_submitted();



$objEvento = new AbmEvento();
/* $objEvento =$datos;  */
/* $datos=$_POST; */
$objEvento->alta($datos);


?>
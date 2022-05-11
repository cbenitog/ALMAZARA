<?php 

include_once("../basico.php");
include_once("../bbdd.php");
include_once("plantilla.php");
include_once("seguridad.php");
include_once("usuario.php");

	$backoffice = 1;
	
	conectar_bbdd();
	
	$usuario = new usuario();
	
	$plantilla = new plantilla();
	echo $plantilla->cabecera();
	echo $plantilla->principal();
	echo $plantilla->pie();
	
	cerrar_bbdd();


?>

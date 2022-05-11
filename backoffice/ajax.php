<?php

	header('Content-Type: text/html; charset=iso-8859-1');
//	header('HTTP-EQUIV="Pragma" CONTENT="no-cache"');

	include_once("../basico.php");
	include_once("../bbdd.php");
	include_once("plantilla.php");
	include_once("seguridad.php");
	include_once("usuario.php");
	
	
	$backoffice = 1;
	
		// Lo primero es comprobar si los objetos y funcions que nos pasen son válidos
	
	$objeto_get = $_REQUEST["objeto"];
	$funcion = $_REQUEST["funcion"];
	
	if (!objeto_valido($objeto_get, $funcion)) {
		echo error("AJAX: Acceso restringido: $objeto_get - $funcion");
		return;
	}
	
	conectar_bbdd();
	
	$usuario = new usuario();
	
	if (!$GLOBALS["usuario"]->id_usuario) {
		echo error("AJAX: Acceso restringido");
		return;
	}
	
	if (($objeto_get == "texto")) {
		$directorio = "../";
	} 

	include_once($directorio . $objeto_get . ".php");
	
	
	$objeto = new $objeto_get();
	
	if (($objeto_get == "empleado")) {
		$objeto->validar = 1;
	}
	
	
	$objeto->admin = 1;
	$return = $objeto->$funcion();

	
	echo $return;
	
	
	mysql_close();
	

	
	
	
	

?>
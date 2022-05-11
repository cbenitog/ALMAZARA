<?php

	header('Content-Type: text/html; charset=iso-8859-1');
//	header("HTTP-EQUIV='Pragma' CONTENT='no-cache'");

	include_once("basico.php");
	include_once("bbdd.php");
	include_once("imagen.php");
	include_once("plantilla.php");
	include_once("seguridad.php");
	include_once("texto.php");
	include_once("lib/mail/Mail.php");
	include_once("lib/mail/mime.php");
	include_once("lib/mail/mimePart.php");
//	require_once 'lib/pear/PEAR.php';
//	require_once 'PEAR.php';
	
		// Lo primero es comprobar si los objetos y funcions que nos pasen son válidos
	
	$objeto_get = $_REQUEST["objeto"];
	$funcion = $_REQUEST["funcion"];
	
	if (!objeto_valido($objeto_get, $funcion)) {
		echo error("AJAX: Acceso restringido $objeto_get, $funcion");
		return;
	}
	
	
	conectar_bbdd();
	
	include_once($objeto_get . ".php");
	
	$objeto = new $objeto_get();
	$return = $objeto->$funcion();
	echo $return;
	
	mysql_close();

?>
<?php
	
	include_once("basico.php");
	include_once("bbdd.php");
	include_once("imagen.php");
	include_once("plantilla.php");
	include_once("seguridad.php");
	include_once("texto.php");
	include_once("lib/mail/Mail.php");
	include_once("lib/mail/mime.php");
	include_once("lib/mail/mimePart.php");
	
	conectar_bbdd();
	

	$plantilla = new plantilla();
	$o .= $plantilla->cabecera_html();
		
	$modulo = $_REQUEST["modulo"];
	$funcion = $_REQUEST["funcion"];
	
	if ($modulo || $funcion) {
		if (!objeto_valido($modulo,$funcion)) {
			echo acceso_restringido();
			return;
		}
	}
	
	$seccion = $_REQUEST["s"];
	$sub = $_REQUEST["sub"];
		
	$secciones["hotel"] = "HOTEL";
	$secciones["habitaciones"] = "HABITACIONES";
	$secciones["tarifas"] = "TARIFAS";
	$secciones["ofertas"] = "OFERTAS";
	$secciones["como_llegar"] = "COMO LLEGAR";
	
	$subsecciones["hotel"]["interiores"] = "Interiores";
	$subsecciones["hotel"]["exteriores"] = "Exteriores";
	$subsecciones["hotel"]["actividades"] = "Actividades";
	
	
	if (!$secciones[$seccion]) {
		$seccion = "hotel";
	}
	
	if ($seccion == "hotel") {
		if (!$subsecciones[$seccion][$sub]) {
			$sub = "principal";
		}
	}
		
	
	$o .= $plantilla->principal();
	
	echo $o;
	
	cerrar_bbdd();
	


?>

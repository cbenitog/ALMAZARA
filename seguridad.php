<?php


	function objeto_valido($objeto,$funcion) {

		$objetos["contacto"]["reservar"] = 1;
		
		$objetos["habitacion"]["foto"] = 1;
		
		$objetos["plantilla"]["habitaciones"] = 1;
		$objetos["plantilla"]["ofertas"] = 1;
		$objetos["plantilla"]["seccion"] = 1;
		
		if ($objetos[$objeto][$funcion]) {
			return 1;
		} else {
			return 0;
		}
		
		
	}
	
	
	


?>
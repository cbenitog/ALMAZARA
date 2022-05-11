<?php

$base_de_datos = "almazaraxx";
$raiz = "http://www.laalmazaradevaldeverdeja.com/";

	function conectar_bbdd() {
 		$id_conexion = mysql_connect("localhost","myalm948","95R6FGV5");

		if ($id_conexion == 0) {
			die("Ha habido un error conectando con la base de datos\n");
		}
		else  {
			mysql_select_db ($GLOBALS["base_de_datos"]) or die("No pudo seleccionarse la BB.DD\n");
	    }
	
	    return $id_conexion;  
	}


	function cerrar_bbdd() {
		
		mysql_close();
		
	}
	


?>

<?php

$base_de_datos = "almazaraxx";
$raiz = "http://www.laalmazaradevaldeverdeja.com/";
$mysqli = null;

	function conectar_bbdd() {
		global $mysqli;
		global $base_de_datos;

		$mysqli = new mysqli('localhost', 'myalm948', '95R6FGV5', $base_de_datos);
		
		//$res = $mysqli->set_charset("utf8");
 		

		if ($mysqli->connect_errno) {
			die("Ha habido un error conectando con la base de datos\n");
		}
		
	
	    return  $mysqli;  
	}


	function cerrar_bbdd() {
		global $mysqli;
		
		$mysqli->close();
		
	}
	

	function mysqli_result($res,$row=0,$col=0){ 
		$numrows = mysqli_num_rows($res); 
		if ($numrows && $row <= ($numrows-1) && $row >=0){
			mysqli_data_seek($res,$row);
			$resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
			if (isset($resrow[$col])){
				return $resrow[$col];
			}
		}
		return false;
	}

?>

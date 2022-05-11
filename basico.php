<?php


					// EStas son variables globales del usuario
	$test = 1;
	$num_fichas = 0;
	$window_ancho = 0;



	function acceso_restringido() {
		$o = error("Acceso restringido");
		return $o;
	}
	
	
	
	
	

	
	function ceros_izquierda($texto,$ancho) {
		
		$cuenta = strlen($texto);
		
		for ($i=$cuenta; $i<$ancho;$i++) {
			$texto = "0" . $texto;
		}
		
		return $texto;
	}
	
	
	
	
	
	
	function error($texto) {
		return "<font color='red'>$texto</font>";
	}

	

	
	
	function euro($euro) {
		$euro = redondear($euro);
		$euro = number_format($euro,2,'.','');
		if ($euro) {
			$euro .= "&euro;";
		} else {
			$euro = "";
		}
		return $euro;
	}
	
	
	

	// Si tiene formato de mysql, le da la vuelta

	function fecha($fecha) {
	
		$guion = substr($fecha,4,1);
		
		if ($guion == "-") {
			$dia = substr($fecha,8,2);
			$mes = substr($fecha,5,2);
			$anyo = substr($fecha,0,4);
			
			$fecha = "$dia/$mes/$anyo";
		}
		
		return $fecha;
		
	}	
		
	
	
	
	
	
	// log
	//		Permite loggear las acciones de los usuarios y admins
	
	
	function loggear($texto) {
		
		if ($GLOBALS["usuario"]) {
			$id_usuario = $GLOBALS["usuario"]->id_usuario;
		} else {
			$id_usuario = func_get_arg(2); 
		}
	
		$fecha = fecha_hoy() . " " . hora_ahora();
		
		$consulta = "INSERT INTO log (id_usuario, texto, fecha)
						VALUES ($id_usuario, '$texto', '$fecha')";
		mysql_query($consulta);
		
	}
	
	
	
	
	
	
	
	
	function precio($precio) {
		
				// Quitamos la parte decimal
		$precio = round($precio,2);
		$valores = split('\.', $precio);
		if ($valores[1]) {
			$o = "," . $valores[1];
		}
		
		$precio = floor($precio);
		
		$queda = floor($precio / 1000);  // cyberk
		if ($queda) {
			$resto = ceros_izquierda($precio % 1000,3);
		} else {
			$resto = $precio % 1000;
		}
		$o = $resto . $o;
		$valor = $queda;
		
		if ($queda) {
			$o = "." . $o;
		}
		
		while ($queda) {
			$queda = floor($valor / 1000);
			if ($queda) {
				$resto = ceros_izquierda($valor % 1000,3);
				$o = "." . $resto . $o;
				$valor = $queda;
			} else {
				$resto = $valor % 1000;
				$o = $resto . $o;
			}
		}
		
		return $o;
		
	}
	

	
	
	function redondear($cantidad) {
		$cantidad =  round($cantidad,2);
		return $cantidad;
	}
	
	
	function texto_form($texto) {
		return htmlspecialchars($texto, ENT_QUOTES);
	}


	function texto_input($texto) {
		return htmlentities(stripslashes($texto), ENT_QUOTES);
	}
	
		
	
	
	
	
		
	
	
	
	
	


function edad($fecha) {
	$fecha_hoy = fecha_hoy();
	
	$fecha = explode('-',$fecha);
	$fecha_hoy = explode('-',$fecha_hoy);
	
	$edad = $fecha_hoy[0] - $fecha[0];
	
	if ($fecha_hoy[1] < $fecha[1]) {
		$edad = $edad - 1;
		
	} else if ($fecha_hoy[1] == $fecha[1]) {
		if ($fecha_hoy[2] < $fecha[2]) {
			$edad = $edad - 1;
		}
	}
	
	return $edad;
}







function hora_valida ($hora) {                      // separa la hora y comprueba su validez
    if ($hora) {
        $hora_stamp = strtotime($hora);
        $hora_array = getdate($hora_stamp);
        if (($hora_array["hours"] < 0) || ($hora_array["hours"] > 23) || !(is_numeric($hora_array["hours"]))) {
            die("error en la hora " . $hora);
        }
        if (($hora_array["minutes"] < 0) || ($hora_array["minutes"] > 59) || !(is_numeric($hora_array["minutes"]))) {
            die("error en la hora " . $hora);
        }
    }
	return 1;
}



	function fecha_bbdd($fecha) {
		$array = explode('/',$fecha);
		$fecha = "$array[2]-$array[1]-$array[0]";
		return $fecha;
	}	


	function fecha_hoy () {
		return date("Y-m-d");
	}
	
	
	function fecha_valida ($fecha) {                    // separa la fecha y comprueba su validez
	     if ($fecha) {
	        $fecha_stamp = strtotime($fecha);
			if ($fecha_stamp == -1) {
				return 0;
			}
				
	        $fecha_array = getdate($fecha_stamp);
	
	        if (!(checkdate($fecha_array["mon"], $fecha_array["mday"], $fecha_array["year"]))) {
	            die("error en la fecha " . $fecha);
			}
	    }
		return 1;
	}







function fecha_restar($fecha,$intervalo)	{

   $fecha_array = split ("-", $fecha);
	
	$fecha = mktime(0,0,0,$fecha_array[1],$fecha_array[2], $fecha_array[0]);

	$fecha = strtotime("$intervalo day",$fecha);
	
	$fecha = strftime("%Y-%m-%d", $fecha);
	
	return $fecha;
}

	
function fecha_texto($fecha) {
	$mes[1] = "enero";
	$mes[2] = "febrero";
	$mes[3] = "marzo";
	$mes[4] = "abril";
	$mes[5] = "mayo";
	$mes[6] = "junio";
	$mes[7] = "julio";
	$mes[8] = "agosto";
	$mes[9] = "septiembre";
	$mes[10] = "octubre";
	$mes[11] = "noviembre";
	$mes[12] = "diciembre";
	
	$fecha_array[0] = substr($fecha,0,4);
	$fecha_array[1] = substr($fecha,4,2);
	$fecha_array[2] = substr($fecha,6,2);
	
	$mes_num = intval($fecha_array[1]);
	
	$mes_texto = $mes[$mes_num];
	
	$fecha_texto = $fecha_array[2] . " de " . $mes_texto . " de " . $fecha_array[0];
	
	return $fecha_texto;
	
}




	function hora_ahora () {
	 	return date("H:i:s");
	}

	
	

	
	function checkbox() {
	
		$argumentos = func_get_args();
		$valor = $argumentos[0];
		$name = $argumentos[1];
		
		if (!$name) {
			$name = "checkbox";
		}
		
		$select = "	<input type='checkbox' name='$name' value='1' />";
						
		if ($valor) {
	        $select = str_replace("value='1' />", "value='1' checked />", $select);
	    }
	
		return $select;
		
	}



	
	
	
	
	
    function movil() {
    	
    	$array = array (
    		'android' => '/Android/',
    		'iphone' => '/iPhone/',
    		'ipod' => '/iPhone/',
    		'ipad' => '/iPad/'
    	);
    	
    	foreach ($array as $navegador => $exp) {
    		if (preg_match($exp,$_SERVER['HTTP_USER_AGENT'])) {
    			return 1;
    		}
    	}
    	
    	return 0;
    	
    }  
	
	
	




// Si el password no es válido devuelve el error, si no, no devuelve nada. 

// De momento los criterios para que no sea válido son: 
//	- difiere de su validación.
//	- es demasiado corto (menos de 6 caracteres).
//	- es numérico. 

function password_valido ($password, $validacion) {
	
	if (is_numeric($password)) {
		$error = "El password no puede ser numérico";
		return $error;
	}
	
	if (strlen($password) < 6) {
		$error = "El password ha de tener al menos 6 caracteres";
		return $error;
	}
	
	if (strcmp($password,$validacion) <> 0) {
		$error = "El password y su validación no son iguales";
		return $error;
	}
	
	return;
	
}



//	Lo que hace es revisar todos los parámetros recibidos en el POST
// 		y aquellos que tengan valor los coloca en una cadena lista para PRE

// El primer parámetro serán aquellas variables que queremos añadir a PRE
// 	y el segundo las qeu no queremosq ue se incluyan de las que van en POST. 

function post_to_pre() {
	$parametros = func_get_args();
	$queremos = $parametros[0];
	$no_queremos = $parametros[1];
	
	
	$keys = array_keys($_POST);
	
	$i = 0;
	$no_inicio = 0;
	while ($key = $keys[$i]) {
		if ($_POST[$key]) {
			if ($no_inicio) {
				$return .= "&";
			}
			
				// tenemos que hacer las comparaciones con lo que no queremos
			$j = 0;
			$no_coincide = 1;
			while (($no_queremos[$j]) && ($no_coincide == 1)) {
				if ($no_queremos[$j] == $key) {
					$no_coincide = 0;
				}
				$j += 1;
			}
			
			if ($no_coincide) {
				$return .= $key . "=" . $_POST[$key];
			}
			$no_inicio = 1;
		}
		
		$i += 1;
	}
	
			// Ahora añadimos las que queremos
	$i = 0;
	while($queremos[$i]) {
		if ($no_inicio) {
			$return .= "&";
		}
		$return .= $queremos[$i];
		$no_inicio = 1;
		$i += 1;
	}
	
	return $return;
}






	function radio($name, $valores, $textos) {
	
		$argumentos = func_get_args();
		$defecto = $argumentos[3];
		
		$i = 0;
		$return = "";
		
		while ($textos[$i]) {
			
			$return .= "
						<input type='radio' name='$name' value='" . $valores[$i] . "'>" . $textos[$i];
			$i += 1;
		}
	
		if (isset($defecto)) {
	        $return = str_replace("value='$defecto'>", "value='$defecto' checked>", $return);
	    }
		
		return $return;
	}







function radio_boolean() {

	$argumentos = func_get_args();
	$valor = $argumentos[0];
	$name = $argumentos[1];
	
	if (!$name) {
		$name = "boolean";
	}
	
	$select = "	<input type='radio' name='$name' value='0'>No
					&nbsp;
				<input type='radio' name='$name' value='1'>Sí
				";
					
	if (isset($valor)) {
        $select = str_replace("value='$valor'>", "value='$valor' checked>", $select);
    }

	return $select;
	
}








function select() {
	$argumentos = func_get_args();
	$name = $argumentos[0];
	$valores = $argumentos[1];
	$textos = $argumentos[2];
	$defecto = $argumentos[3];
	
	$i = 0;
	$return = "";
	
	$return = "<select id='$name' name='$name'><option value=''></option>";
	while ($textos[$i]) {
		
		$return .= "
					<option value='" . $valores[$i] . "'>" . $textos[$i] . "</option>";
		$i += 1;
	}
	$return .=	"</select>";

	if (isset($defecto)) {
        $return = str_replace("value='$defecto'>", "value='$defecto' selected>", $return);
    }
	
	return $return;
	
}










function select_dia() {
	$argumentos = func_get_args();
	$dia_seleccionado = $argumentos[0];
	$name = $argumentos[1];
	
	if (!$name) {
		$name = "dia";
	}
	
	$select = "<select name='$name'><option value=''>";
	
	for ($i=1; $i<32; $i++) {
		if (strlen($i) == 1){
			$dia = "0" . $i;
		} else {
			$dia = $i;
		}
		$select .= "<option value='$dia'>$dia</option>";
	}
	
					
	$select .=	"</select>";
	
    if ($dia_seleccionado) {
        $select = str_replace("<option value='$dia_seleccionado'>", "<option value='$dia_seleccionado' selected>", $select);
    }

	
	
	return $select;
}





function select_mes() {
	$argumentos = func_get_args();
	$mes = $argumentos[0];
	$name = $argumentos[1];
	
	if (!$name) {
		$name = "mes";
	}
	
	$select = "<select name='$name'>
					<option value=''></option>
					<option value='01'>Enero</option>
					<option value='02'>Febrero</option>
					<option value='03'>Marzo</option>
					<option value='04'>Abril</option>
					<option value='05'>Mayo</option>
					<option value='06'>Junio</option>
					<option value='07'>Julio</option>
					<option value='08'>Agosto</option>
					<option value='09'>Septiembre</option>
					<option value='10'>Octubre</option>
					<option value='11'>Noviembre</option>
					<option value='12'>Diciembre</option>
			</select>";
	
    if ($mes) {
        $select = str_replace("<option value='$mes'>", "<option value='$mes' selected>", $select);
    }

	
	
	return $select;
}









function select_anyo() {
	$argumentos = func_get_args();
	$anyo = $argumentos[0];
	$name = $argumentos[1];
	$corto = $argumentos[2];
	$orden = $argumentos[3];
	
	if (!$name) {
		$name = "anyo";
	}
	
	if ($corto) {
		$inicio = "2008";
	} else {
		$inicio = "1930";
	}
	
	if (!$orden) {
		$orden = 0;
	}
	
	$select = "<select name='$name'><option value=''>";
	
	if ($orden == 0) {
		for ($i=$inicio; $i<2012; $i++) {
			$select .= "<option value='$i'>$i</option>";
		}
		
	} else {
		for ($i=2011;$i>=$inicio; $i--) {
			$select .= "<option value='$i'>$i</option>";
		}
	}
	
					
	$select .=	"</select>";
	
    if ($anyo) {
        $select = str_replace("<option value='$anyo'>", "<option value='$anyo' selected>", $select);
    }

	
	
	return $select;
}







function select_provincia($nombre, $valor) {

				// Recuperamos los grupos de la base de datos
	$consulta = "SELECT id_provincia, nombre	
						FROM provincia
						ORDER BY nombre
						";
	$resultado = mysql_query($consulta);
		
	$select = "
			<select id='$nombre' name='$nombre' onchange='poblacion_elegir();'>
					<option value=''></option>
					";
		
	if (mysql_num_rows($resultado)) {
		while ($fila = mysql_fetch_array($resultado)) {
			$select .= "
				<option value='$fila[0]'>" . stripslashes($fila[1]) . "</option>";
		}
	}
		
	$select .= '</select>';
		
	if (isset($valor)) {
	       $select = str_replace("value='$valor'>", "value='$valor' selected>", $select);
	}
	    

	return $select;		
		
}






function select_puntero($total,$numero,$seleccionado) {
	
	$parametros = func_get_args();
	
	if ($parametros[3]) {
		$nombre = $parametros[3];
	} else {
		$nombre = "puntero";
	}
	
	$select = "<select name='$nombre'>";
	
	$i = 0;
	while ($i < $total) {
		$select .= "<option value='$i'>Ficha " . ($i+1) . "</option>";
		$i += $numero;
	}
	
					
	$select .=	"</select>";
	
    if ($seleccionado) {
        $select = str_replace("<option value='$seleccionado'>", "<option value='$seleccionado' selected>", $select);
    }

	return $select;
}






	function tabla_par($i) {
		
		if (($i%2) ==0) {
			$o = "tabla_par";
		} else {
			$o = "tabla_impar";
		}
		
		return $o;
		
	}






function tratar_variables(&$variables) {

	$i = 0;

	$keys = array_keys($variables);
	$i = current($keys);
	
	while ($variables[$i][0]) {
		$var = $variables[$i][0];
		
		$valor = $_REQUEST["$var"];

		if ($variables[$i][2] == 1) {
			$error_obligatorio = 0;
			if (($variables[$i][1] == "string") && ($valor == "")) {
				$error_obligatorio = 1; 
			} else if (($variables[$i][1]== "int") && ($valor == 0)) {
							// apaño cutre
				if (($var == "coche")) {
					$error_obligatorio = 0;
				} else {
					$error_obligatorio = 1;
				}
			}
			if ($error_obligatorio == 1) {
				$variables[$i][3] = "";
				$variables[$i][4] = 1;
				$error = "Para continuar es necesario responder $var";
			} else {
				$variables[$i][3] = $valor;
			}
			
		} else if ((isset($valor) && ($valor<>"")) || ($variables[$i][2] == 0)) {
			if ($variables[$i][1] == "string") {
				
				if ($valor) {
					$variables[$i][3] = $valor;
				} else {
					$variables[$i][3] = "";
				}
				
				
			} else if ($variables[$i][1] == "int") {
				if (is_numeric($valor)) {
					$variables[$i][3] = $valor;
				} else if (($valor == "")) {    
					$variables[$i][3] = "";
				} else {
					$variables[$i][3] = "";
					$variables[$i][4] = 1;
					$error = "Valor no válido en $var";
				}
				
				
			} else if ($variables[$i][1] == "boolean") {
				
				if ($valor == "on") {
					$variables[$i][3] = "'t'";
				} else if (($valor == 1) || ($valor == 'true')) {				
					$variables[$i][3] = "'t'";
				} else if (($valor == 0) || ($valor == "")) {
					$variables[$i][3] = "'f'";
				} else {
					$variables[$i][3] = "";
					$variables[$i][4] = 1;
					$error = "Valor no válido en $var";
				}
				
				
			} else if ($variables[$i][1] == "date") {
				if (fecha_valida($valor) || ($valor == "")) {
					if ($valor) {
						$variables[$i][3] = $valor;
					} else {
						$variables[$i][3] = "";
					}
				} else {
					$variables[$i][3] = "";
					$variables[$i][4] = 1;
					$error = "Fecha no válida en $var";
				}
					
			
			} else if ($variables[$i][1] == "sexo") {
				if (($valor == 'H') || ($valor == 'M')) {
					$variables[$i][3] = $valor;
				} else if ($valor == "") {
					$variables[$i][3] = $valor;
				} else {
					$variables[$i][3] = "";
					$variables[$i][4] = 1;
					$error = "Valor no válido en $var";
				}
					
			
			} else if ($variables[$i][1] == "tlf") {
				if (is_numeric($valor) || ($valor == "")) {
					if ($valor) {
						$variables[$i][3] = $valor;
					} else {
						$variables[$i][3] = "";
					}
				} else {
					$variables[$i][3] = "";
					$variables[$i][4] = 1;
					$error = "Valor no válido en $var";
				}
					
			}

			
						
		} else {
			$variables[$i][3] = "";
			$variables[$i][4] = 1;
			$error = "Para continuar es necesario responder $var";
		}
		

	
	
		$i = next($keys);
	}

	return $error;

	

}





?>
